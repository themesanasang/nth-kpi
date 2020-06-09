<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\DiseaseGroup;
use App\Logs;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use View;
use Redirect;
use Validator;
use DB;
use Crypt;

class DiseaseGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     
            $diseasegroup = DiseaseGroup::orderby('disease', 'asc')->paginate(25);               	
                        
            return View::make( 'diseasegroup.listdisgroup', array('diseasegroup' => $diseasegroup) );
        }
        else{
            return Redirect::to('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){                    
            return View::make( 'diseasegroup.adddisgroup' );
        }
        else{
            return Redirect::to('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input(); 
        
        $messages = [
            'disease.required'    => 'กรุณากรอก:',
        ];

        $rules = [
            'disease'    => 'required', 
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('diseasegroup.create')->withInput()->withErrors($validator);
        }else{
            $count = DiseaseGroup::where('disease', '=', $data['disease'])->count();
            
            if( $count == 0 ){
                $diseasegroup = new DiseaseGroup;
                $diseasegroup->disease     = $data['disease'];
                $diseasegroup->detail      = $data['detail'];
                
                DB::transaction(function() use ($diseasegroup) {
                    $diseasegroup->save();  
                }); 

                Logs::createlog(Session::get('username'), 'create diseasegroup name = '.$data['disease'] );
            }
            else{
                Session::flash('error_diseasegroup_no', 'มีชื่อกลุ่ม โรค นี้แล้ว');
                return Redirect::route('diseasegroup.create');
            }
            
            return Redirect::to('diseasegroup');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            try {
                $id = Crypt::decrypt($id);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }

            $diseasegroup  = DiseaseGroup::find($id);
            
            return view::make( 'diseasegroup.viewdisgroup', array('diseasegroup' => $diseasegroup ) );
        }
        else{
            return Redirect::to('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            try {
                $id = Crypt::decrypt($id);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }
                  
            $diseasegroup  = DiseaseGroup::find($id);
            
            return view::make( 'diseasegroup.editdisgroup', array('diseasegroup' => $diseasegroup ) );
        }
        else{
            return Redirect::to('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id); 
        $data = $request->input(); 
        
        $messages = [
            'disease.required'    => 'กรุณากรอก:',
        ];

        $rules = [
            'disease'    => 'required', 
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('diseasegroup.edit', Crypt::encrypt($id) )->withInput()->withErrors($validator);
        }else{
            $diseasegroup = DiseaseGroup::find( e($id) );
            $diseasegroup->disease      = $data['disease'];
            $diseasegroup->detail      = $data['detail'];
            
            DB::transaction(function() use ($diseasegroup) {
                $diseasegroup->save();  
            }); 

            Logs::createlog(Session::get('username'), 'update disease id = '.$id );
        
            return Redirect::to('diseasegroup');
        }
    }

    /**
    *
    * Delete DiseaseGroup
    */
    public function deleteDiseaseGroup(Request $request)
    {
        if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            $data = $request->input(); 
            
            $c = count($data['keydel']); 
            for ($i=0; $i < $c; $i++) { 
                $id = $data['keydel'][$i];
                $diseasegroup = DiseaseGroup::find( $id );
                
                DB::transaction(function() use ($diseasegroup, $id) {  
                    Logs::createlog(Session::get('username'), ' delete diseasegroup name='.$diseasegroup->disease.' id='.$id );
                    $diseasegroup->delete();
                }); 
            }

            return 'success';
        }
        else{
            return Redirect::to('login');
        }      
    }




     /**
   *
   * Search KpiGroup
   */
   public function search(Request $request)
   {
       if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            
            $data = $request->input(); 	  
            $search  = $data['search'];  	

            if($search == ''){
                return Redirect::to('diseasegroup');
            }	 

			$diseasegroup = DB::table( 'disease_group' )     
	         ->where( 'disease', 'like', "%$search%" )	     
	         ->orderBy( 'disease', 'asc')
             ->paginate( 25 );	 
	     
		    return view::make( 'diseasegroup.listdisgroup',  array( 'diseasegroup' => $diseasegroup ) );	
        }
        else{
            return Redirect::to('login');
        }
   }

}
