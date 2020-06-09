<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\KpiResult;
use App\Models\Kpi;
use App\Models\KpiGroup;
use App\Models\Around;
use App\Models\Approve;
use App\Models\User;
use App\Models\Department;
use Session;
use View;
use Redirect;
use Hash;
use DB;
use Crypt;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     

            $y = date('Y');
            $m = date('m');

            if($m >= 10 && $m <= 12){
                $dstart = $y.'-10-01';
                $dend = ($y+1).'-09-30';
            }

            if($m >= 1 && $m <= 9){
                $dstart = ($y-1).'-10-01';
                $dend = $y.'-09-30';
            }     

            $data = DB::table('department')
                    ->join('department_kpi', 'department_kpi.dep_id', '=', 'department.id')
                    ->select('department.id', 'department.dep_name') 
                    ->groupby('department.id')
                    ->groupby('department.dep_name')
                    ->get(); 



            //check data approve
            //12
            $around12 = array(               
                '1'     => $this->checkApprove($dstart, $dend, 1, 1),
                '2'     => $this->checkApprove($dstart, $dend, 1, 2),
                '3'     => $this->checkApprove($dstart, $dend, 1, 3),
                '4'     => $this->checkApprove($dstart, $dend, 1, 4),
                '5'     => $this->checkApprove($dstart, $dend, 1, 5),
                '6'     => $this->checkApprove($dstart, $dend, 1, 6),
                '7'     => $this->checkApprove($dstart, $dend, 1, 7),
                '8'     => $this->checkApprove($dstart, $dend, 1, 8),
                '9'     => $this->checkApprove($dstart, $dend, 1, 9),
                '10'    => $this->checkApprove($dstart, $dend, 1, 10),
                '11'    => $this->checkApprove($dstart, $dend, 1, 11),
                '12'    => $this->checkApprove($dstart, $dend, 1, 12)
            ); 

            //4
            $around4 = array(               
                '1'     => $this->checkApprove($dstart, $dend, 2, 1),
                '2'     => $this->checkApprove($dstart, $dend, 2, 2),
                '3'     => $this->checkApprove($dstart, $dend, 2, 3),
                '4'     => $this->checkApprove($dstart, $dend, 2, 4)
            );

            //2
            $around2 = array(               
                '1'     => $this->checkApprove($dstart, $dend, 3, 1),
                '2'     => $this->checkApprove($dstart, $dend, 3, 2)
            );

            //1
            $around1 = array(               
                '1'     => $this->checkApprove($dstart, $dend, 4, 1)
            ); 



            if(count($data) > 0){
                return view::make('admin.index', array('data' => $data, 'dstart' => $dstart, 'dend' => $dend,
                 'around12' => $around12, 'around4' => $around4, 'around2' => $around2, 'around1' => $around1));
            }          	

            //ไปจัด kpi dep            
            return Redirect::to('depkpi');
        }
        else{
            return Redirect::to('login');
        }
    }

    


    /**
    *
    * แสดงหน้ารวม kpi แผนกที่เลือก
    */
    public function viewkpidep($id)
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     

            try {
                $oldid = $id;
                $id = Crypt::decrypt($id);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }

            $dep = Department::find($id);

            $y = DB::table('kpi_result')->select(DB::raw('year(date_save) as yearAll'))->groupby('date_save')->get();
            $y_name=[];
            if(count($y) > 0){
                $last_y='';
                foreach ($y as $key => $value) {                    
                    $y_name[$value->yearAll] = $value->yearAll+543;
                    $last_y = $value->yearAll;
                } 
                $last_y++;
                $y_name[$last_y] = $last_y+543;  
            }

            return view('admin.viewkpidep', array('oldid' => $oldid,'dep'=>$dep, 'yearAll' => $y_name));

        }
        else{
            return Redirect::to('login');
        }
    }





    public function getdatakpi($oldid, $year, $dep)
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     

           $dstart = ($year-1).'-10-01';
           $dend = $year.'-09-30';

           $data = DB::table('kpi_result')
                    ->leftjoin('kpi', 'kpi.id', '=', 'kpi_result.kpi_id')
                    ->leftjoin('around', 'around.id', '=', 'kpi_result.around_id')
                    ->whereBetween('kpi_result.created_at', [$dstart, $dend])
                    ->where('kpi_result.dep_id', $dep)
                    ->select('kpi.code', 'kpi.kpi_name_th', 'kpi_result.around', 'kpi_result.fraction', 'kpi_result.section', 'kpi_result.multiply', 'kpi_result.result', 'around.around_name')
                    ->orderby('kpi_result.around', 'asc')
                    ->get();                     

            return view('admin.kpidepdetail', array('data' => $data));

        }
        else{
            return Redirect::to('login');
        }
    }






    /**
    *
    * approve kpi
    */
    public function approve(Request $request)
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     

            $data = $request->input(); 

            $chk = KpiResult::where('around_id', '=', $data['around_id'])
                     ->where('around' , '=', $data['around'])
                     ->whereBetween('date_save', [$data['datestart'], $data['dateend']])
                     ->count();

            //end check around kpi ว่ามีการกรอกยัง
            if($chk > 0){
                $approve = new Approve();
                $approve->date_start    = $data['datestart'];
                $approve->date_end      = $data['dateend'];
                $approve->around_id     = $data['around_id'];
                $approve->around        = $data['around'];

                DB::transaction(function() use ($approve) {
                    $approve->save();  
                }); 

                DB::transaction(function() use ($data) {
                    KpiResult::where('around_id', '=', $data['around_id'])
                        ->where('around' , '=', $data['around'])
                        ->whereBetween('date_save', [$data['datestart'], $data['dateend']])
                        ->update(['approve' => 1, 'approve_date' => date('Y-m-d H:i:s')]);
                }); 
            }else{
                return 'error';
            }
        }
        else{
            return Redirect::to('login');
        }
    }





    /**
    *
    * check approve
    */
    public function checkApprove($date_start, $date_end, $around_id, $around)
    {
        $chk = Approve::where('date_start', $date_start)
            ->where('date_end', $date_end)
            ->where('around_id', $around_id)
            ->where('around', $around)
            ->count();
        
        if($chk > 0){
            return 'close';
        }else{
            return 'open';
        }
    }
    




}
