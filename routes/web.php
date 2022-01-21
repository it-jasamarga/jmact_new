<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('forgot-password', 'Auth\ForgotPasswordController@store');
Route::post('reset-password', 'Auth\ResetPasswordController@store');
Route::get('forgot-password', 'Auth\ForgotPasswordController@index');
Route::get('reset-password/{token}', 'Auth\ResetPasswordController@index');

Route::group(['middleware' => 'auth'], function() {
  	Route::get('/login', 'Auth\LoginController@login');
  	Route::get('/logout', 'Auth\LoginController@logout');

	Route::post('histori-tiket/{ticket}', function(Request $request, $ticket) {
		$model = \App\Models\KeluhanPelanggan::where('no_tiket', $ticket)->with(['history' => function($query){ $query->with('status'); }])->first();
		return $model ? response()->json([
			'status' => 'ok',
			'data' => $model->toArray(),
		]) : response()->json([
			'status' => 'error'
		]);
	});

	Route::group(['namespace' => 'Backend'], function() {

		Route::post('lookup/area/{category}', 'LookupController@area')->name('lookup.area');

		Route::post('lookup/data/chart/{name}', 'LookupController@dataChart')->name('lookup.data-chart');

		Route::get('/', 'DashboardController@index');
		Route::get('/', 'DashboardController@list');
		Route::post('dashboard/chart-1', 'DashboardController@chart1')->name('dashboard.chart1');
		Route::resource('/', 'DashboardController');

		Route::group(['namespace' => 'Ajax', 'prefix' => 'option'], function() {
			Route::get('ro/{id}', 'OptionController@ro');
			Route::get('ruas/{id}', 'OptionController@ruas');
		});
		
		Route::group(['namespace' => 'PencarianTiket'], function() {
			Route::get('pencarian-tiket/list', 'PencarianTiketController@list')->name('pencarian-tiket.list');
			Route::resource('pencarian-tiket', 'PencarianTiketController');
		});

		Route::group(['namespace' => 'Laporan'], function() {

			Route::put('keluhan/sla/{id}', 'KeluhanController@prosesSla')->name('keluhan.prosesSla');  
			Route::get('keluhan/sla/{id}', 'KeluhanController@sla')->name('keluhan.sla');  
			Route::put('keluhan/sla/report/{id}', 'KeluhanController@prosesReportSla')->name('keluhan.prosesReportSla');  
			Route::get('keluhan/sla/report/{id}', 'KeluhanController@reportSla')->name('keluhan.reportSla');  

  			Route::put('keluhan/teruskan/{id}', 'KeluhanController@history')->name('keluhan.history');  
			  Route::delete('keluhan/removeMulti', 'KeluhanController@removeMulti')->name('keluhan.removeMulti');
			  Route::get('keluhan/list', 'KeluhanController@list')->name('keluhan.list');
			  Route::resource('keluhan', 'KeluhanController');
			  
  			Route::put('claim/teruskan/{id}', 'ClaimController@history')->name('claim.history');
  			Route::get('claim/{id}/edit-stage', 'ClaimController@editStage')->name('claim.editStage');
  			Route::put('claim/tahapan/{id}', 'ClaimController@historyStage')->name('claim.historyStage');
			Route::get('claim/list', 'ClaimController@list')->name('claim.list');
			Route::resource('claim', 'ClaimController');

		});

		Route::group(['namespace' => 'LogHistory'], function() {

			Route::delete('bug-report/removeMulti', 'BugReportController@removeMulti')->name('bug-report.removeMulti');
			Route::get('bug-report/list', 'BugReportController@list')->name('bug-report.list');
			Route::resource('bug-report', 'BugReportController');

			Route::delete('log-audit/removeMulti', 'LogAuditController@removeMulti')->name('log-audit.removeMulti');
			Route::get('log-audit/list', 'LogAuditController@list')->name('log-audit.list');
			Route::resource('log-audit', 'LogAuditController');

			Route::delete('log-auth/removeMulti', 'LogAuthController@removeMulti')->name('log-auth.removeMulti');
			Route::get('log-auth/list', 'LogAuthController@list')->name('log-auth.list');
			Route::resource('log-auth', 'LogAuthController');

		});

		Route::group(['namespace' => 'Settings', 'prefix' => 'setting'], function() {
			Route::post('users/device', 'UserController@device')->name('users.device');
			Route::delete('users/removeMulti', 'UserController@removeMulti')->name('users.removeMulti');
			Route::get('users/list', 'UserController@list')->name('users.list');
			Route::resource('users', 'UserController');

			Route::delete('role/removeMulti', 'RoleController@removeMulti')->name('role.removeMulti');
			Route::post('role/permission', 'RoleController@storePermission')->name('role.storePermission');
			Route::get('role/permission/{id}', 'RoleController@permission')->name('role.permission');
			Route::get('role/list', 'RoleController@list')->name('role.list');
			Route::resource('role', 'RoleController');

			Route::delete('permission/removeMulti', 'PermissionController@removeMulti')->name('permission.removeMulti');
			Route::get('permission/list', 'PermissionController@list')->name('permission.list');
			Route::resource('permission', 'PermissionController');
			
			
		});

		Route::group(['namespace' => 'Master'], function() {
  			// Master BK
			Route::delete('master-bk/removeMulti', 'MasterBkController@removeMulti')->name('master-bk.removeMulti');
  			Route::get('master-bk/list', 'MasterBkController@list')->name('master-bk.list');
			Route::resource('master-bk', 'MasterBkController');

			// Master Golken
			Route::delete('master-golken/removeMulti', 'MasterGolkenController@removeMulti')->name('master-golken.removeMulti');
  			Route::get('master-golken/list', 'MasterGolkenController@list')->name('master-golken.list');
			Route::resource('master-golken', 'MasterGolkenController');

			// Master Regional
			Route::delete('master-regional/removeMulti', 'MasterRegionalController@removeMulti')->name('master-regional.removeMulti');
  			Route::get('master-regional/list', 'MasterRegionalController@list')->name('master-regional.list');
			Route::resource('master-regional', 'MasterRegionalController');

			// Master Regional
			Route::delete('master-ro/removeMulti', 'MasterRoController@removeMulti')->name('master-ro.removeMulti');
  			Route::get('master-ro/list', 'MasterRoController@list')->name('master-ro.list');
			Route::resource('master-ro', 'MasterRoController');

			// Master Ruas
			Route::delete('master-ruas/removeMulti', 'MasterRuasController@removeMulti')->name('master-ruas.removeMulti');
  			Route::get('master-ruas/list', 'MasterRuasController@list')->name('master-ruas.list');
			Route::resource('master-ruas', 'MasterRuasController');

			// Master Status
			Route::delete('master-status/removeMulti', 'MasterStatusController@removeMulti')->name('master-status.removeMulti');
  			Route::get('master-status/list', 'MasterStatusController@list')->name('master-status.list');
			Route::resource('master-status', 'MasterStatusController');

			// Master Sumber
			Route::delete('master-sumber/removeMulti', 'MasterSumberController@removeMulti')->name('master-sumber.removeMulti');
  			Route::get('master-sumber/list', 'MasterSumberController@list')->name('master-sumber.list');
			Route::resource('master-sumber', 'MasterSumberController');

			// Master Unit
			Route::delete('master-unit/removeMulti', 'MasterUnitController@removeMulti')->name('master-unit.removeMulti');
  			Route::get('master-unit/list', 'MasterUnitController@list')->name('master-unit.list');
			Route::resource('master-unit', 'MasterUnitController');

			// Master Jenis Claim
			Route::delete('master-claim/removeMulti', 'MasterJenisClaimController@removeMulti')->name('master-claim.removeMulti');
  			Route::get('master-claim/list', 'MasterJenisClaimController@list')->name('master-claim.list');
			Route::resource('master-claim', 'MasterJenisClaimController');
			
  		});

	});
});

Auth::routes([
  'verify' => true
]);