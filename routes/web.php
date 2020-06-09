<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::resource('/', 'LoginController', ['names' => [
    'index' => 'auth.login'
]]);
Route::resource('login', 'LoginController');
Route::get('logout', 'LoginController@logout');

Route::resource('register', 'RegisterController');




Route::resource('admin', 'AdminController');
Route::get('viewkpidep/{id}', 'AdminController@viewkpidep');
Route::get('viewkpidep/{id}/getdatakpi/{id2}/{id3}', 'AdminController@getdatakpi');
Route::post('approve', 'AdminController@approve');





Route::resource('emp', 'EmpController');
Route::get('keykpi/{id}', 'EmpController@keykpi');
Route::post('keykpi/keykpiData', 'EmpController@keykpi_save');
Route::get('profile/{id}', 'EmpController@profile');
Route::get('profileEdit/{id}', 'EmpController@profileEdit');
Route::get('viewkpi/{id}', 'EmpController@viewkpi');



Route::resource('depkpi', 'DepKpiController');
Route::get('getkpilist/{id}', 'DepKpiController@getkpilist');
Route::get('getkpitodeplist/{id}', 'DepKpiController@getkpitodeplist');
Route::post('addkpitodep', 'DepKpiController@addkpitodep');
Route::post('delkpitodep', 'DepKpiController@delkpitodep');




Route::resource('kpi', 'KpiController');
Route::post('kpi/del', 'KpiController@deleteKpi');
Route::post( 'kpi/search', array( 'uses' => 'KpiController@search' ) );



Route::resource('kpigroup', 'KpiGroupController');
Route::post('kpigroup/del', 'KpiGroupController@deleteKpiGroup');
Route::post( 'kpigroup/search', array( 'uses' => 'KpiGroupController@search' ) );




Route::resource('diseasegroup', 'DiseaseGroupController');
Route::post('diseasegroup/del', 'DiseaseGroupController@deleteDiseaseGroup');
Route::post( 'diseasegroup/search', array( 'uses' => 'DiseaseGroupController@search' ) );



Route::resource('user', 'UserController');
Route::post('user/del', 'UserController@deleteUser');
Route::post( 'user/search', array( 'uses' => 'UserController@search' ) );



Route::resource('department', 'DepController');
Route::post('department/del', 'DepController@deleteDep');
Route::post( 'department/search', array( 'uses' => 'DepController@search' ) );




Route::get('report/kpiall', 'ReportController@kpiall');
Route::post('report/kpiall', 'ReportController@getReportKpiAll');
Route::resource('report', 'ReportController');
