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
  	Route::get('/logout', 'Auth\LoginController@logout');

	Route::group(['namespace' => 'Backend'], function() {
		
		Route::get('/', 'DashboardController@index');

		Route::delete('crawler/removeMulti', 'CrawlerController@removeMulti')->name('crawler.removeMulti');
		Route::get('crawler/list', 'CrawlerController@list')->name('crawler.list');
		Route::resource('crawler', 'CrawlerController');

		Route::delete('comic/removeMulti', 'ComicController@removeMulti')->name('comic.removeMulti');
		Route::get('comic/list', 'ComicController@list')->name('comic.list');
		Route::resource('comic', 'ComicController');

		Route::delete('comic-detail/removeMulti', 'ComicDetailController@removeMulti')->name('comic-detail.removeMulti');
		Route::get('comic-detail/list', 'ComicDetailController@list')->name('comic-detail.list');
		Route::resource('comic-detail', 'ComicDetailController');

		Route::delete('comic-request/removeMulti', 'ComicRequestController@removeMulti')->name('comic-request.removeMulti');
		Route::get('comic-request/list', 'ComicRequestController@list')->name('comic-request.list');
		Route::resource('comic-request', 'ComicRequestController');
		
		Route::group(['namespace' => 'Content'], function() {

			Route::delete('advertisement/removeMulti', 'AdvertisementController@removeMulti')->name('advertisement.removeMulti');
			Route::get('advertisement/list', 'AdvertisementController@list')->name('advertisement.list');
			Route::resource('advertisement', 'AdvertisementController');

			Route::delete('slider/removeMulti', 'SliderController@removeMulti')->name('slider.removeMulti');
			Route::get('slider/list', 'SliderController@list')->name('slider.list');
			Route::resource('slider', 'SliderController');

			Route::delete('article/removeMulti', 'Article@removeMulti')->name('article.removeMulti');
			Route::get('article/list', 'ArticleController@list')->name('article.list');
			Route::resource('article', 'ArticleController');

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
			Route::delete('users/removeMulti', 'UserController@removeMulti')->name('users.removeMulti');
			Route::get('users/list', 'UserController@list')->name('users.list');
			Route::resource('users', 'UserController');

			Route::delete('role/removeMulti', 'RoleController@removeMulti')->name('role.removeMulti');
			Route::post('role/permission', 'RoleController@storePermission')->name('role.storePermission');
			Route::get('role/permission/{id}', 'RoleController@permission')->name('role.permission');
			Route::get('role/list', 'RoleController@list')->name('role.list');
			Route::resource('role', 'RoleController');
			
			
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

			// Master Status
			Route::delete('master-sumber/removeMulti', 'MasterSumberController@removeMulti')->name('master-sumber.removeMulti');
  			Route::get('master-sumber/list', 'MasterSumberController@list')->name('master-sumber.list');
			Route::resource('master-sumber', 'MasterSumberController');

			// Master Unit
			Route::delete('master-unit/removeMulti', 'MasterUnitController@removeMulti')->name('master-unit.removeMulti');
  			Route::get('master-unit/list', 'MasterUnitController@list')->name('master-unit.list');
			Route::resource('master-unit', 'MasterUnitController');

			
  		});

	});
});

Auth::routes([
  'verify' => true
]);