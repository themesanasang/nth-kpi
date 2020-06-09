<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Department;
use App\Logs;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use View;
use Redirect;
use Validator;
use Hash;
use DB;
use Crypt;

class DepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){     
            $dep = Department::orderby('dep_name', 'asc')->paginate(25);               	
                        
            return View::make( 'department.listdepartment', array('dep' => $dep) );
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
            return View::make( 'department.adddepartment' );
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
            'dep_name.required'    => 'กรุณากรอก:',
            //'manager.required'     => 'กรุณากรอก:',
            //'phone.required'       => 'กรุณากรอก:', 
        ];

        $rules = [
            'dep_name'    => 'required', 
            //'manager'     => 'required', 
            //'phone'       => 'required', 
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('department.create')->withInput()->withErrors($validator);
        }else{
            $count = Department::where('dep_name', '=', $data['dep_name'])->count();
            
            if( $count == 0 ){
                $dep = new Department;
                $dep->dep_name      = $data['dep_name'];
                $dep->manager       = $data['manager'];
                $dep->phone         = $data['phone'];
                $dep->created_by    = Session::get('username');
                
                DB::transaction(function() use ($dep) {
                    $dep->save();  
                }); 

                Logs::createlog(Session::get('username'), 'create department name = '.$data['dep_name'] );
            }
            else{
                Session::flash('error_dep_no', 'มีชื่อแผนกนี้แล้ว');
                return Redirect::route('department.create');
            }
            
            return Redirect::to('department');
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
            
            $dep  = Department::find($id);
            
            return view::make( 'department.viewdepartment', array('dep' => $dep ) );
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

            $dep  = Department::find($id);
            
            return view::make( 'department.editdepartment', array('dep' => $dep ) );
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
            'dep_name.required'    => 'กรุณากรอก:',
            //'manager.required'     => 'กรุณากรอก:',
            //'phone.required'       => 'กรุณากรอก:', 
        ];

        $rules = [
            'dep_name'    => 'required', 
            //'manager'     => 'required', 
            //'phone'       => 'required', 
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('department.edit', Crypt::encrypt($id) )->withInput()->withErrors($validator);
        }else{
            $dep = Department::find( e($id) );
            $dep->dep_name      = $data['dep_name'];
            $dep->manager       = $data['manager'];
            $dep->phone         = $data['phone'];
            $dep->created_by    = Session::get('username');
            
            DB::transaction(function() use ($dep) {
                $dep->save();  
            }); 

            Logs::createlog(Session::get('username'), 'update department id = '.$id );
        
            return Redirect::to('department');
        }
    }




    /**
    *
    * Delete Dep
    */
    public function deleteDep(Request $request)
    {
        if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            $data = $request->input(); 
            
            $c = count($data['keydel']); 
            for ($i=0; $i < $c; $i++) { 
                $id = $data['keydel'][$i];
                $dep = Department::find( $id );
                
                DB::transaction(function() use ($dep, $id) {  
                    Logs::createlog(Session::get('username'), ' delete department name='.$dep->dep_name.' id='.$id );
                    $dep->delete();
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
   * Search Dep
   */
   public function search(Request $request)
   {
       if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            
            $data = $request->input(); 	  
            $search  = $data['search'];  	

            if($search == ''){
                return Redirect::to('department');
            }	    

			$dep = DB::table( 'department' )     
	         ->where( 'dep_name', 'like', "%$search%" )
	         ->orWhere( 'manager', 'like', "%$search%" )
             ->orWhere( 'phone', 'like', "%$search%" )	 	     
	         ->orderBy( 'dep_name', 'asc')
	         ->paginate( 25 );	 		    
	     
		    return view::make( 'department.listdepartment',  array( 'dep' => $dep ) );	
        }
        else{
            return Redirect::to('login');
        }
   }



}
