<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\User;
use App\Models\Department;
use App\Logs;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use View;
use Redirect;
use Validator;
use Hash;
use Crypt;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                    
            $user = User::orderby('fullname', 'asc')->paginate(25);  
                        
            return View::make( 'user.listuser', array('user' => $user) );
        }
        else
        {
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
        if(  Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {           
            $dep = DB::table( 'department' )->select( DB::raw('id, dep_name') )->get();
            $dep_name=[];
            foreach ($dep as $key => $value) {                    
                $dep_name[$value->id] = $value->dep_name;
            }  

            return View::make( 'user.adduser', array('dep'=>$dep_name) );
        }
        else
        {
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
            'username.required'    => 'กรุณากรอก:',
            'password.required'    => 'กรุณากรอก:',
            'fullname.required'    => 'กรุณากรอก:', 
            //'phone.required'       => 'กรุณากรอก:', 
        ];

        $rules = [
            'username'    => 'required', 
            'password'    => 'required', 
            'fullname'    => 'required', 
            //'phone'       => 'required',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('user.create')->withInput()->withErrors($validator);
        }else{
            $count = User::where('username', '=', $data['username'])->count();
            
            if( $count == 0 ){
                $user = new User;
                $user->username      = $data['username'];
                $user->password      = Hash::make($data['password']);
                $user->fullname      = $data['fullname'];
                $user->phone         = $data['phone'];
                $user->email         = $data['email'];
                $user->dep_id        = $data['dep_id'];
                $user->team          = $data['team'];
                $user->level         = $data['level'];
                $user->status        = $data['status'];
                $user->created_by    = Session::get('username');
                
                DB::transaction(function() use ($user) {
                    $user->save();  
                }); 

                Logs::createlog(Session::get('username'), 'create user name = '.$data['username'] );
            }
            else{
                Session::flash('error_dep_no', 'มีชื่อผู้ใช้งานนี้แล้ว');
                return Redirect::route('user.create');
            }
            
            return Redirect::to('user');
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
        if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            try {
                $id = Crypt::decrypt($id);        
            } catch (DecryptException $e) {
                return view::make('errors.404');
            }

            $user = User::find($id);
            $dep = Department::find($user->dep_id); 
            
            return view::make( 'user.viewuser', array('user' => $user, 'dep' => $dep ) );
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

            $user  = User::find($id);
            $dep = DB::table( 'department' )->select( DB::raw('id, dep_name') )->get();
            $dep_name=[];
            foreach ($dep as $key => $value) {                    
                $dep_name[$value->id] = $value->dep_name;
            }   
            
            return view::make( 'user.edituser', array('user' => $user, 'dep' => $dep_name ) );
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
            'fullname.required'    => 'กรุณากรอก:', 
            //'phone.required'       => 'กรุณากรอก:', 
        ];

        $rules = [
            'fullname'    => 'required', 
            //'phone'       => 'required',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {               
            return Redirect::route('user.edit', Crypt::encrypt($id) )->withInput()->withErrors($validator);
        }else{
            
            $user = User::find( e($id) );
            if($data['password'] != ""){
                $user->password      = Hash::make($data['password']);
            }
            $user->fullname      = $data['fullname'];         
            $user->phone         = $data['phone'];
            $user->email         = $data['email'];
            $user->dep_id        = $data['dep_id'];
            $user->team          = $data['team'];
            $user->level         = $data['level'];
            $user->status        = $data['status'];
            $user->created_by    = Session::get('username');
            
            DB::transaction(function() use ($user) {
                $user->save();  
            }); 

            Logs::createlog(Session::get('username'), 'update user id = '.$id );
        
            return Redirect::to('user');
        }
    }






    /**
    *
    * Delete User
    */
    public function deleteUser(Request $request)
    {
        if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            $data = $request->input(); 
            
            $c = count($data['keydel']); 
            for ($i=0; $i < $c; $i++) { 
                $id = $data['keydel'][$i];
                $user = User::find( $id );
                
                DB::transaction(function() use ($user, $id) {  
                    Logs::createlog(Session::get('username'), ' delete user name='.$user->username.' id='.$id );
                    $user->delete();
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
   * Search User
   */
   public function search(Request $request)
   {
       if( Session::get('level') == '1'  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){   
            
            $data = $request->input(); 	  
            $search  = $data['search'];  	

            if($search == ''){
                return Redirect::to('user');
            }	    

			$user = DB::table( 'user' )     
	         ->where( 'username', 'like', "%$search%" )
	         ->orWhere( 'fullname', 'like', "%$search%" )
             ->orWhere( 'phone', 'like', "%$search%" )	
             ->orWhere( 'team', 'like', "%$search%" )	 	 	     
	         ->orderBy( 'username', 'asc')
	         ->paginate( 25 );	 		    
	     
		    return view::make( 'user.listuser',  array( 'user' => $user ) );	
        }
        else{
            return Redirect::to('login');
        }
   }





  
}
