<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\DepKpi;
use App\Models\Kpi;
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


class DepKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     
            $kpigroup = DB::table( 'kpigroup' )->select( DB::raw('id, group_name') )->get();
            $group_name=[];
            foreach ($kpigroup as $key => $value) {                    
                $group_name[$value->id] = $value->group_name;
            }    

            $dep = DB::table( 'department' )->select( DB::raw('id, dep_name') )->get();
            $dep_name=[];
            foreach ($dep as $key => $value) {                    
                $dep_name[$value->id] = $value->dep_name;
            }         	
                        
            return View::make( 'depkpi.kpitodep', array('kpigroup' => $group_name, 'dep' => $dep_name));
        }
        else{
            return Redirect::to('login');
        }
    }

    


    /**
    *
    * ดึง kpi ตามกลุ่มที่เลือก
    */
    public function getkpilist($id){
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     
            $group_id = e($id);
            $kpi = Kpi::where('group_id', $group_id)->get();

            if(count($kpi) > 0){
                return View::make( 'depkpi.listkpitodep', array('kpi' => $kpi));
            }else{
                return 'NoData';
            }            
        }
        else{
            return Redirect::to('login');
        }
    }




    /**
    *
    * ดึง kpi ตามแผนกที่เลือก
    */
    public function getkpitodeplist($id)
    {
       if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     
            $dep_id = e($id);

            $data = DB::table( 'department_kpi' )  
             ->leftjoin('kpi', 'kpi.id', '=', 'department_kpi.kpi_id')
	         ->where( 'department_kpi.dep_id', $dep_id )	 
             ->select('department_kpi.id', 'kpi.code')   
	         ->orderBy( 'kpi.code', 'asc')
	         ->get();	 		    
	    
            if(count($data) > 0){               
                return View::make( 'depkpi.depshowkpi', array('data' => $data));
            }else{
                return 'NoData';
            }            
        }
        else{
            return Redirect::to('login');
        }
    }




    /**
    *
    * บันทึก จัดสรร
    */
    public function addkpitodep(Request $request)
    {
         if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            $data = $request->input(); 

            $dep_id = $data['depid'];
            
            $c = count($data['keyadd']);   

            for ($i=0; $i < $c; $i++) { 
                $id = $data['keyadd'][$i];              
                
                $depkpi = new DepKpi;
                $depkpi->dep_id        = $dep_id;
                $depkpi->kpi_id        = $id;
                $depkpi->created_by    = Session::get('username');
                
                DB::transaction(function() use ($depkpi, $dep_id, $id) {  
                    $depkpi->save();  
                    Logs::createlog(Session::get('username'), ' create Kpitodep depid='.$dep_id.' kpiid='.$id );
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
    * ลบ จัดสรร
    */
    public function delkpitodep(Request $request){
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     
            $data = $request->input(); 

            try {
                $id = Crypt::decrypt($data['id']);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }

            $depkpi = DepKpi::find( $id );
                
            DB::transaction(function() use ($depkpi, $id) {  
                Logs::createlog(Session::get('username'), ' delete Kpitodep id='.$id );
                $depkpi->delete();
            }); 

            return 'success';
        }
        else{
            return Redirect::to('login');
        }
    }


}
