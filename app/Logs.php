<?php 
namespace App;
use DB;


class Logs{



	/**
	 * [createlog description]
	 * @return [type] [description]
	 */
	public static function createlog($created_by, $action)
	{
		DB::transaction(function() use ($created_by, $action) {
             DB::table('logs')->insert([
			    'created_by' 	=> $created_by,
			    'created_date'  => date('Y-m-d H:i:s'),
			    'action'		=> $action		  
			]);
        }); 
	}




}