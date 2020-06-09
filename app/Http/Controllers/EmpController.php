<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\KpiResult;
use App\Models\Kpi;
use App\Models\KpiGroup;
use App\Models\Around;
use App\Models\User;
use App\Models\Department;
use App\Logs;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use View;
use Redirect;
use Validator;
use DB;
use Crypt;
use Hash;

class EmpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
            
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

            $data = DB::table('department_kpi')
            ->leftjoin('kpi', 'kpi.id', '=', 'department_kpi.kpi_id')
            ->where('department_kpi.dep_id', Session::get('dep_id'))
            ->orderby('kpi.around_id', 'asc')
            ->orderby('kpi.code', 'asc')
            ->select(DB::raw('department_kpi.dep_id'), DB::raw('(select count(*) from kpi_result where kpi_id=kpi.id and dep_id='.Session::get('dep_id').' and user_id='.Session::get('user_id').' and date_save between "'.$dstart.'" and "'.$dend.'" group by kpi_id ) as sumall'), 'kpi.*', DB::raw('(select around_name from around where id=kpi.around_id) as around_name'))
            ->get();

            return view::make('emp.index', array('dstart' => $dstart, 'dend' => $dend,'data' => $data));
        }else{
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
        $idold = $id;

        try {
            $id = Crypt::decrypt($id);        
        } catch (DecryptException $e) {
            return view::make('errors.404');
        }

        $data = $request->input(); 
        
        $user = User::find( e($id) );
        if($data['password'] != ""){
            $user->password      = Hash::make($data['password']);
        }
        $user->fullname      = $data['fullname'];         
        $user->phone         = $data['phone'];
        $user->email         = $data['email'];
        
        DB::transaction(function() use ($user) {
            $user->save();  
        }); 

        Logs::createlog(Session::get('username'), 'update user id = '.$id );
    
        return Redirect::to('profile/'.$idold);
    }






    /**
    *
    * กรอกข้อมูล kpi
    */
    public function keykpi($id)
    {
        if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 

             $idold = $id;

            try {
                $id = Crypt::decrypt($id);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }

             $kpi = Kpi::find($id);

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

             $kpiresult = KpiResult::where('dep_id', Session::get('dep_id'))
                                    ->where('user_id', Session::get('user_id'))
                                    ->where('kpi_id', $id)
                                    ->whereBetween('created_at', [$dstart, $dend])
                                    ->get();

            $statuskpi = DB::table('kpi_result')->where('around_id', $kpi->around_id)
                        ->where('approve', 1)
                        ->select('around')
                        ->groupby('around')
                        ->get();
            //return json_decode(json_encode($statuskpi), true);
            
            $r='';
            $txtAround='';
            if($kpi->around_id==1){
                //ทุกเดือน
                $r=12;
                $txtAround = $this->getAround1();
            }else if($kpi->around_id==2){
                //ทุก 3 เดือน
                $r=4;
                $txtAround = $this->getAround3();
            }else if($kpi->around_id==3){
                //ทุก 6 เดือน
                $r=2;
                $txtAround = $this->getAround6();
            }else{
                //ทุก 12 เดือน
                $r=1;
                $txtAround = $this->getAround12();
            }

             return view('emp.keykpi', array('idold' => $idold, 'kpi' => $kpi, 'kpiresult' => $kpiresult, 'txtAround' => $txtAround, 'r' => $r, 'statuskpi' => $statuskpi ));

        }else{
            return Redirect::to('login');
        }
    }





    /**
    *
    * บันทึกค่า kpi
    */
    public function keykpi_save(Request $request)
    {
        $data = $request->input(); 

        $c = count($data['around']); 
        for ($i=0; $i < $c; $i++) { 
            
            if($data['fraction'][$i] != '' || $data['fraction'][$i] > 0){
                
                if(isset($data['section'])){
                    if($data['multiply'] > 0){
                        $result = ($data['fraction'][$i]/$data['section'][$i])*$data['multiply'];
                    }else{
                        $result = ($data['fraction'][$i]/$data['section'][$i]);
                    }
                }else{
                    if($data['multiply'] > 0){
                        $result = $data['fraction'][$i]*$data['multiply'];
                    }else{
                        $result = $data['fraction'][$i];
                    }
                }

                $chk = KpiResult::where('dep_id', Session::get('dep_id'))
                                ->where('user_id', Session::get('user_id'))
                                ->where('around', $data['around'][$i])
                                ->where('kpi_id', $data['kpi_id'])->count();
                
               //check ซ้ำ
                if($chk == 0){
                    $kpi = new KpiResult;
                    $kpi->dep_id     = Session::get('dep_id');
                    $kpi->user_id    = Session::get('user_id');       
                    $kpi->around_id      = $data['around_id'];         
                    $kpi->around         = $data['around'][$i];
                    $kpi->kpi_id         = $data['kpi_id'];
                    $kpi->fraction       = $data['fraction'][$i];
                    $kpi->section        = ((isset($data['section']))?$data['section'][$i]:0);
                    $kpi->multiply       = $data['multiply'];
                    $kpi->result         = $result;
                    $kpi->comment        = $data['comment'][$i];
                    $kpi->date_save      = date('Y-m-d H:i:s');
                }else{
                    //update
                    $kpi = KpiResult::find($data['result_id'][$i]) ;
                    $kpi->fraction       = $data['fraction'][$i];
                    $kpi->section        = ((isset($data['section']))?$data['section'][$i]:0);
                    $kpi->result         = $result;
                    $kpi->comment        = $data['comment'][$i];
                    $kpi->date_save      = date('Y-m-d H:i:s');
                }

                DB::transaction(function() use ($kpi) {
                    $kpi->save();  
                }); 

                Logs::createlog(Session::get('username'), 'create kpi_result dep_id = '.Session::get('dep_id').' user_id = '.Session::get('user_id').' around = '. $data['around'][$i] );

            }//end if check fraction
            
        }//end for loop
    }




   
   /**
   *
   * ดึงแสดงหน้าข้อมูลส่วนตัว
   */
    public function profile($id)
    {
        if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
            try {
                $id = Crypt::decrypt($id);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }
            $user = User::find($id);
            $dep = Department::find($user->dep_id); 

            return view::make('emp.profile', array('user' => $user, 'dep' => $dep));
        }else{
            return Redirect::to('login');
        }
    }





    /**
    *
    *ดึงหน้าแก้ไขข้อมูลส่วนตัว
    */
    public function profileEdit($id)
    {
       if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
            try {
                $id = Crypt::decrypt($id);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }
            $user = User::find($id);

            return view::make('emp.profile_edit', array('user' => $user));
        }else{
            return Redirect::to('login');
        } 
    }





    /**
    *
    *แสดงรายละเอียด kpi
    */
    public function viewkpi($id)
    {
        if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            try {
                $id = Crypt::decrypt($id);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }        
            $kpi = Kpi::find($id);
            $kpigroup = KpiGroup::find($kpi->group_id); 
            $around = Around::find($kpi->around_id); 
            
            return view::make( 'emp.viewkpi', array('kpi' => $kpi, 'kpigroup' => $kpigroup, 'around' => $around ) );
        }
        else{
            return Redirect::to('login');
        }
    }






    /**
    *
    * get ค่ารอบเดือน 12
    */
    public function getAround12()
    {
        $around = array(               
                '1'     => 'ตุลาคม-กันยายน'
            ); 

        return $around;
    }





    /**
    *
    * get ค่ารอบเดือน 6
    */
    public function getAround6()
    {
        $around = array(               
                '1'     => 'ตุลาคม-มีนาคม',
                '2'     => 'เมษายน-กันยายน'
            ); 

        return $around;
    }





    /**
    *
    * get ค่ารอบเดือน 3
    */
    public function getAround3()
    {
        $around = array(               
                '1'     => 'ตุลาคม-ธันวาคม',
                '2'     => 'มกราคม-มีนาคม',
                '3'     => 'เมษายน-มิถุนายน',
                '4'     => 'กรกฎาคม-กันยายน'
            ); 

        return $around;
    }





    /**
    *
    * get ค่ารอบเดือน 1
    */
    public function getAround1()
    {
        $around = array(               
                '1'     => 'ตุลาคม',
                '2'     => 'พฤศจิกายน',
                '3'     => 'ธันวาคม',
                '4'     => 'มกราคม',
                '5'     => 'กุมภาพันธ์',
                '6'     => 'มีนาคม',
                '7'     => 'เมษายน',
                '8'     => 'พฤษภาคม',
                '9'     => 'มิถุนายน',
                '10'     => 'กรกฎาคม',
                '11'     => 'สิงหาคม',
                '12'     => 'กันยายน'
            ); 

        return $around;
    }





    






}
