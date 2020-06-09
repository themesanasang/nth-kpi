<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Kpi;
use App\Models\KpiGroup;
use App\Models\Around;
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

class KpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     
            $kpi = kpi::orderby('code', 'asc')->paginate(25);               	
                        
            return View::make( 'kpi.listkpi', array('kpi' => $kpi) );
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
            
            $kpigroup = DB::table( 'kpigroup' )->select( DB::raw('id, group_name') )->get();
            $group_name=[];
            foreach ($kpigroup as $key => $value) {                    
                $group_name[$value->id] = $value->group_name;
            }  

            $around = DB::table( 'around' )->select( DB::raw('id, around_name') )->get();
            $around_name=[];
            foreach ($around as $key => $value) {                    
                $around_name[$value->id] = $value->around_name;
            } 
            
            $disgroup = DB::table( 'disease_group' )->select( DB::raw('id, disease') )->get();
            $disgroup_name=[];
            foreach ($disgroup as $key => $value) {                    
                $disgroup_name[$value->id] = $value->disease;
            } 

            return View::make( 'kpi.addkpi', array('kpigroup'=>$group_name, 'around' => $around_name, 'disease' => $disgroup_name) );
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
            'group_id.required'         => 'กรุณากรอก:',
            'code.required'         => 'กรุณากรอก:',
            'kpi_name_th.required'  => 'กรุณากรอก:',
        ];

        $rules = [
            'group_id'          => 'required', 
            'code'          => 'required', 
            'kpi_name_th'   => 'required', 
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('kpi.create')->withInput()->withErrors($validator);
        }else{
            $count = Kpi::where('code', '=', $data['code'])->count();
            
            if( $count == 0 ){
                $kpi = new Kpi;
                $kpi->group_id      = $data['group_id'];
                $kpi->code          = $data['code'];
                $kpi->kpi_name_th   = $data['kpi_name_th'];
                $kpi->kpi_name_en   = $data['kpi_name_en'];
                $kpi->meta          = $data['meta'];
                $kpi->objective     = $data['objective'];
                $kpi->around_id     = $data['around_id'];
                $kpi->has_section   = $data['has_section'];
                $kpi->multiply      = $data['multiply'];
                $kpi->disease_group = $data['disease_group'];
                $kpi->zi            = $data['zi'];
                $kpi->status        = $data['status'];
                $kpi->created_by    = Session::get('username');
                
                DB::transaction(function() use ($kpi) {
                    $kpi->save();  
                }); 

                Logs::createlog(Session::get('username'), 'create kpi code = '.$data['code'] );
            }
            else{
                Session::flash('error_kpi_no', 'มีชื่อ KPI นี้แล้ว');
                return Redirect::route('kpi.create');
            }
            
            return Redirect::to('kpi');
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
            $kpi = Kpi::find($id);
            $kpigroup = KpiGroup::find($kpi->group_id); 
            $around = Around::find($kpi->around_id); 
            $diseasegroup = DiseaseGroup::find($kpi->disease_group); 
            
            return view::make( 'kpi.viewkpi', array('kpi' => $kpi, 'kpigroup' => $kpigroup, 'around' => $around, 'diseasegroup' => $diseasegroup  ) );
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
            $kpi  = Kpi::find($id);

            $kpigroup = DB::table( 'kpigroup' )->select( DB::raw('id, group_name') )->get();
            $group_name=[];
            foreach ($kpigroup as $key => $value) {                    
                $group_name[$value->id] = $value->group_name;
            }   

            $around = DB::table( 'around' )->select( DB::raw('id, around_name') )->get();
            $around_name=[];
            foreach ($around as $key => $value) {                    
                $around_name[$value->id] = $value->around_name;
            }   

            $disgroup = DB::table( 'disease_group' )->select( DB::raw('id, disease') )->get();
            $disgroup_name=[];
            foreach ($disgroup as $key => $value) {                    
                $disgroup_name[$value->id] = $value->disease;
            } 

            
            return view::make( 'kpi.editkpi', array('kpi' => $kpi, 'kpigroup' => $group_name, 'around' => $around_name, 'disease' => $disgroup_name ) );
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
        try {
            $id = Crypt::decrypt($id);        
        } catch (DecryptException $e) {
            return view::make('errors.404');
        } 
        $data = $request->input(); 
        
        $messages = [
            'group_id.required'         => 'กรุณากรอก:',
            'code.required'         => 'กรุณากรอก:',
            'kpi_name_th.required'  => 'กรุณากรอก:',
        ];

        $rules = [
            'group_id'          => 'required', 
            'code'          => 'required', 
            'kpi_name_th'   => 'required', 
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('kpi.edit', Crypt::encrypt($id) )->withInput()->withErrors($validator);
        }else{
            $kpi = Kpi::find( e($id) );
            $kpi->group_id      = $data['group_id'];
            $kpi->code          = $data['code'];
            $kpi->kpi_name_th   = $data['kpi_name_th'];
            $kpi->kpi_name_en   = $data['kpi_name_en'];
            $kpi->meta          = $data['meta'];
            $kpi->objective     = $data['objective'];
            $kpi->around_id     = $data['around_id'];
            $kpi->has_section   = $data['has_section'];
            $kpi->multiply      = $data['multiply'];
            $kpi->disease_group = $data['disease_group'];
            $kpi->zi            = $data['zi'];
            $kpi->status        = $data['status'];
            $kpi->created_by    = Session::get('username');

            DB::transaction(function() use ($kpi) {
                $kpi->save();  
            }); 

            Logs::createlog(Session::get('username'), 'update kpi code = '.$data['code'] );
            
            return Redirect::to('kpi');
        }
    }




    /**
    *
    * Delete Kpi
    */
    public function deleteKpi(Request $request)
    {
        if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            $data = $request->input(); 
            
            $c = count($data['keydel']); 
            for ($i=0; $i < $c; $i++) { 
                $id = $data['keydel'][$i];
                $kpi = Kpi::find( $id );
                
                DB::transaction(function() use ($kpi, $id) {  
                    Logs::createlog(Session::get('username'), ' delete Kpi code='.$kpi->code.' id='.$id );
                    $kpi->delete();
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
   * Search Kpi
   */
   public function search(Request $request)
   {
       if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            
            $data = $request->input(); 	  
            $search  = $data['search'];  	

            if($search == ''){
                return Redirect::to('kpi');
            }	    

			$kpi = DB::table( 'kpi' )     
	         ->where( 'code', 'like', "%$search%" )	 
             ->orWhere( 'kpi_name_th', 'like', "%$search%" ) 
             ->orWhere( 'kpi_name_en', 'like', "%$search%" )      
	         ->orderBy( 'code', 'asc')
	         ->paginate( 25 );	 		    
	     
		    return view::make( 'kpi.listkpi',  array( 'kpi' => $kpi ) );	
        }
        else{
            return Redirect::to('login');
        }
   }


  
}
