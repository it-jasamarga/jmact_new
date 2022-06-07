<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

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

// Route::get('/test', function(Request $request) {
// 	$description = $request->input('description');
// 	if ($description) {
// 		$ret = \App\Models\TicketCounter::reserve($description, 'K', 'A', '01');
// 		if ($ret['result']) {
// 			$no_tiket = $ret['data']['no_tiket'];
// 			dd('no_tiket: '.$no_tiket);
// 		} else {
// 			dd('error', $ret);
// 		}
// 	} else {
// 		dd('Required parameter: description');
// 	}
// });




Route::post('forgot-password', 'Auth\ForgotPasswordController@store');
Route::post('reset-password', 'Auth\ResetPasswordController@store');
Route::get('forgot-password', 'Auth\ForgotPasswordController@index');
Route::get('reset-password/{token}', 'Auth\ResetPasswordController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::post('histori-tiket/{ticket}', function (Request $request, $ticket) {
        if (substr($ticket, 0, 1) == 'K') {
            $model = \App\Models\KeluhanPelanggan::where('no_tiket', $ticket)->with(['history' => function ($query) {
                $query->with('status');
            }])->first();
        } else {
            $model = \App\Models\ClaimPelanggan::where('no_tiket', $ticket)->with(['history' => function ($query) {
                $query->with('status');
            }])->first();
        }
        return $model ? response()->json([
            'status' => 'ok',
            'data' => $model->toArray(),
        ]) : response()->json([
            'status' => 'error'
        ]);
    });

    Route::group(['namespace' => 'Backend'], function () {

        Route::get('/list', 'LookupController@list')->name('lookup.list');

        Route::post('lookup/area/{category}', 'LookupController@area')->name('lookup.area');

        Route::post('lookup/data/chart/{name}', 'LookupController@dataChart')->name('lookup.data-chart');

        Route::get('/', 'DashboardController@index');
        Route::get('/', 'DashboardController@list');
        Route::post('dashboard/chart-1', 'DashboardController@chart1')->name('dashboard.chart1');
        Route::resource('/', 'DashboardController');

        Route::group(['namespace' => 'Ajax', 'prefix' => 'option'], function () {
            Route::get('ro/{id}', 'OptionController@ro');
            Route::get('ruas/{id}', 'OptionController@ruas');
        });

        Route::group(['namespace' => 'PencarianTiket'], function () {
            // Route::group(['middleware' => ['role:Superadmin', 'permission:pencarian-tiket.detail|pencarian-tiket.expand']], function () {
                Route::get('pencarian-tiket/list', 'PencarianTiketController@list')->name('pencarian-tiket.list');
                Route::resource('pencarian-tiket', 'PencarianTiketController');
            // });
        });

        Route::group(['namespace' => 'Feedback'], function () {
            // Route::group(['middleware' => ['role:Superadmin', 'permission:feedback-pelanggan.contact|feedback-pelanggan.detail']], function () {
                Route::get('feedback-pelanggan/list', 'FeedbackController@list')->name('feedback-pelanggan.list');
                Route::get('feedback-pelanggan/contact/{no_tiket}', 'FeedbackController@contact')->name('feedback-pelanggan.contact');
                Route::get('feedback-pelanggan/detail/{no_tiket}', 'FeedbackController@detail')->name('feedback-pelanggan.detail');
                Route::resource('feedback-pelanggan', 'FeedbackController');
            // });
        });

        Route::group(['namespace' => 'Laporan'], function () {
            // Route::group(['middleware' => ['role:Superadmin', 'permission:keluhan.create|keluhan.detail|keluhan.forward|keluhan.sla']], function () {
                Route::put('keluhan/sla/{id}', 'KeluhanController@prosesSla')->name('keluhan.prosesSla');
                Route::get('keluhan/sla/{id}', 'KeluhanController@sla')->name('keluhan.sla');
                Route::put('keluhan/sla/report/{id}', 'KeluhanController@prosesReportSla')->name('keluhan.prosesReportSla');
                Route::get('keluhan/sla/report/{id}', 'KeluhanController@reportSla')->name('keluhan.reportSla');
                Route::put('keluhan/sla/konfirmasi/{id}', 'KeluhanController@prosesKonfirmasiPelanggan')->name('keluhan.prosesKonfirmasiPelanggan');
                Route::get('keluhan/sla/konfirmasi/{id}', 'KeluhanController@konfirmasiPelanggan')->name('keluhan.konfirmasiPelanggan');

                Route::put('keluhan/teruskan/{id}', 'KeluhanController@history')->name('keluhan.history');
                Route::delete('keluhan/removeMulti', 'KeluhanController@removeMulti')->name('keluhan.removeMulti');
                Route::get('keluhan/list', 'KeluhanController@list')->name('keluhan.list');
                Route::resource('keluhan', 'KeluhanController');

                Route::get('keluhan/show-attachment/{id}', 'KeluhanController@showAttachment')->name('keluhan.showAttachment');
            // });

            // Route::group(['middleware' => ['role:Superadmin', 'permission:claim.create|claim.detail|claim.forward|claim.stage']], function () {
                Route::put('claim/teruskan/{id}', 'ClaimController@history')->name('claim.history');
                Route::get('claim/{id}/edit-stage', 'ClaimController@editStage')->name('claim.editStage');
                Route::put('claim/tahapan/{id}', 'ClaimController@historyStage')->name('claim.historyStage');
                Route::get('claim/reject/{id}', 'ClaimController@claimReject')->name('claim.claimReject');
                Route::put('claim/detail/{id}', 'ClaimController@claimDetail')->name('claim.claimDetail');
                Route::get('claim/list', 'ClaimController@list')->name('claim.list');
                Route::resource('claim', 'ClaimController');

                Route::get('claim/show-attachment/{id}', 'ClaimController@showAttachment')->name('claim.showAttachment');
            // });
        });

        Route::group(['namespace' => 'LogHistory'], function () {
            // Route::group(['middleware' => ['role:Superadmin', 'permission:bug-report.delete']], function () {
                Route::delete('bug-report/removeMulti', 'BugReportController@removeMulti')->name('bug-report.removeMulti');
                Route::get('bug-report/list', 'BugReportController@list')->name('bug-report.list');
                Route::resource('bug-report', 'BugReportController');
            // });

            // Route::group(['middleware' => ['role:Superadmin', 'permission:log-audit.index']], function () {
                Route::delete('log-audit/removeMulti', 'LogAuditController@removeMulti')->name('log-audit.removeMulti');
                Route::get('log-audit/list', 'LogAuditController@list')->name('log-audit.list');
                Route::resource('log-audit', 'LogAuditController');
            // });

            // Route::group(['middleware' => ['role:Superadmin', 'permission:log-auth.index']], function () {
                Route::delete('log-auth/removeMulti', 'LogAuthController@removeMulti')->name('log-auth.removeMulti');
                Route::get('log-auth/list', 'LogAuthController@list')->name('log-auth.list');
                Route::resource('log-auth', 'LogAuthController');
            // });
        });

        Route::group(['namespace' => 'Settings'], function () {
            Route::post('user-account/device', 'UserController@device')->name('user-account.device');
            // Route::group(['middleware' => ['role:Superadmin', 'permission:user-account.create|user-account.edit']], function () {
                Route::delete('user-account/removeMulti', 'UserController@removeMulti')->name('user-account.removeMulti');
                Route::get('user-account/list', 'UserController@list')->name('user-account.list');
                Route::resource('user-account', 'UserController');
            // });

            // Route::group(['middleware' => ['role:Superadmin', 'permission:role.create|role.edit']], function () {
                Route::delete('role/removeMulti', 'RoleController@removeMulti')->name('role.removeMulti');
                Route::post('role/permission', 'RoleController@storePermission')->name('role.storePermission');
                Route::get('role/permission/{id}', 'RoleController@permission')->name('role.permission');
                Route::get('role/list', 'RoleController@list')->name('role.list');
                Route::resource('role', 'RoleController');
            // });

            Route::delete('permission/removeMulti', 'PermissionController@removeMulti')->name('permission.removeMulti');
            Route::get('permission/list', 'PermissionController@list')->name('permission.list');
            Route::resource('permission', 'PermissionController');
        });

        Route::group(['namespace' => 'Master'], function () {
            // Master BK
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-bk.create|master-bk.edit']], function () {
                Route::delete('master-bk/removeMulti', 'MasterBkController@removeMulti')->name('master-bk.removeMulti');
                Route::get('master-bk/list', 'MasterBkController@list')->name('master-bk.list');
                Route::resource('master-bk', 'MasterBkController');
            // });

            // Master Golken
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-golken.create|master-golken.edit']], function () {
                Route::delete('master-golken/removeMulti', 'MasterGolkenController@removeMulti')->name('master-golken.removeMulti');
                Route::get('master-golken/list', 'MasterGolkenController@list')->name('master-golken.list');
                Route::resource('master-golken', 'MasterGolkenController');
            // });

            // Master Regional
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-regional.create|master-regional.edit']], function () {
                Route::delete('master-regional/removeMulti', 'MasterRegionalController@removeMulti')->name('master-regional.removeMulti');
                Route::get('master-regional/list', 'MasterRegionalController@list')->name('master-regional.list');
                Route::resource('master-regional', 'MasterRegionalController');
            // });

            // Master Regional
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-ro.create|master-ro.edit']], function () {
                Route::delete('master-ro/removeMulti', 'MasterRoController@removeMulti')->name('master-ro.removeMulti');
                Route::get('master-ro/list', 'MasterRoController@list')->name('master-ro.list');
                Route::resource('master-ro', 'MasterRoController');
            // });

            // Master Ruas
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-ruas.create|master-ruas.edit']], function () {
                Route::delete('master-ruas/removeMulti', 'MasterRuasController@removeMulti')->name('master-ruas.removeMulti');
                Route::get('master-ruas/list', 'MasterRuasController@list')->name('master-ruas.list');
                Route::resource('master-ruas', 'MasterRuasController');
            // });

            // Master Status
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-status.create|master-status.edit']], function () {
                Route::delete('master-status/removeMulti', 'MasterStatusController@removeMulti')->name('master-status.removeMulti');
                Route::get('master-status/list', 'MasterStatusController@list')->name('master-status.list');
                Route::resource('master-status', 'MasterStatusController');
            // });

            // Master Sumber
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-sumber.create|master-sumber.edit']], function () {
                Route::delete('master-sumber/removeMulti', 'MasterSumberController@removeMulti')->name('master-sumber.removeMulti');
                Route::get('master-sumber/list', 'MasterSumberController@list')->name('master-sumber.list');
                Route::resource('master-sumber', 'MasterSumberController');
            // });

            // Master Unit
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-unit.create|master-unit.edit']], function () {
                Route::delete('master-unit/removeMulti', 'MasterUnitController@removeMulti')->name('master-unit.removeMulti');
                Route::get('master-unit/list', 'MasterUnitController@list')->name('master-unit.list');
                Route::resource('master-unit', 'MasterUnitController');
            // });

            // Master Jenis Claim
            // Route::group(['middleware' => ['role:Superadmin', 'permission:master-claim.create|master-claim.edit']], function () {
                Route::delete('master-claim/removeMulti', 'MasterJenisClaimController@removeMulti')->name('master-claim.removeMulti');
                Route::get('master-claim/list', 'MasterJenisClaimController@list')->name('master-claim.list');
                Route::resource('master-claim', 'MasterJenisClaimController');
            // });
        });
    });
});

Auth::routes([
    'verify' => true
]);
