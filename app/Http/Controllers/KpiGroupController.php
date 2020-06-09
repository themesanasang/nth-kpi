<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\KpiGroup;
use App\Logs;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use View;
use Redirect;
use Validator;
use DB;
use Crypt;


class KpiGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     
            $kpigroup = KpiGroup::orderby('group_name', 'asc')->paginate(25);               	
                        
            return View::make( 'kpigroup.listkpigroup', array('kpigroup' => $kpigroup) );
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
            return View::make( 'kpigroup.addkpigroup' );
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
            'group_name.required'    => 'กรุณากรอก:',
        ];

        $rules = [
            'group_name'    => 'required', 
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('kpigroup.create')->withInput()->withErrors($validator);
        }else{
            $count = KpiGroup::where('group_name', '=', $data['group_name'])->count();
            
            if( $count == 0 ){
                $kpigroup = new KpiGroup;
                $kpigroup->group_name      = $data['group_name'];
                
                DB::transaction(function() use ($kpigroup) {
                    $kpigroup->save();  
                }); 

                Logs::createlog(Session::get('username'), 'create kpigroup name = '.$data['group_name'] );
            }
            else{
                Session::flash('error_kpigroup_no', 'มีชื่อกลุ่ม KPI นี้แล้ว');
                return Redirect::route('kpigroup.create');
            }
            
            return Redirect::to('kpigroup');
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

            $kpigroup  = KpiGroup::find($id);
            
            return view::make( 'kpigroup.viewkpigroup', array('kpigroup' => $kpigroup ) );
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
                  
            $kpigroup  = KpiGroup::find($id);
            
            return view::make( 'kpigroup.editkpigroup', array('kpigroup' => $kpigroup ) );
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
            'group_name.required'    => 'กรุณากรอก:',
        ];

        $rules = [
            'group_name'    => 'required', 
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('kpigroup.edit', Crypt::encrypt($id) )->withInput()->withErrors($validator);
        }else{
            $kpigroup = KpiGroup::find( e($id) );
            $kpigroup->group_name      = $data['group_name'];
            
            DB::transaction(function() use ($kpigroup) {
                $kpigroup->save();  
            }); 

            Logs::createlog(Session::get('username'), 'update kpigroup id = '.$id );
        
            return Redirect::to('kpigroup');
        }
    }






    /**
    *
    * Delete KpiGroup
    */
    public function deleteKpiGroup(Request $request)
    {
        if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            $data = $request->input(); 
            
            $c = count($data['keydel']); 
            for ($i=0; $i < $c; $i++) { 
                $id = $data['keydel'][$i];
                $kpigroup = KpiGroup::find( $id );
                
                DB::transaction(function() use ($kpigroup, $id) {  
                    Logs::createlog(Session::get('username'), ' delete KpiGroup name='.$kpigroup->group_name.' id='.$id );
                    $kpigroup->delete();
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
                return Redirect::to('kpigroup');
            }	    

			$kpigroup = DB::table( 'kpigroup' )     
	         ->where( 'group_name', 'like', "%$search%" )	     
	         ->orderBy( 'group_name', 'asc')
	         ->paginate( 25 );	 		    
	     
		    return view::make( 'kpigroup.listkpigroup',  array( 'kpigroup' => $kpigroup ) );	
        }
        else{
            return Redirect::to('login');
        }
   }




}
