<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Config;
use Illuminate\Support\Str;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Facades\DB;

use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging\CloudMessage;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Messaging\WebPushConfig;

use App\Models\User;
use App\Models\UserDevice;
use App\Models\Notification;
use App\Models\MasterStatus;
use Carbon\Carbon;

class HelperFirestore
{
    private static function notifier($user_ids, $device_tokens, $title_onbell, $data_onbell, $title_onbar, $message) {
        $data = [
            'title'       => $title_onbell,
            'message'     => $message,
            'unit_id'     => $data_onbell['unit_id'],
            'target_id'   => $data_onbell['target_id'],
            'target_type' => $data_onbell['target_type'],
            'status'      => 'Unread',
            'created_at'  => Carbon::now()
        ];

        $notifications = app('firebase.firestore')->database()->collection('notifications');

        foreach ($user_ids as $user_id) {
            $data['user_id'] = $user_id;
            Notification::create($data);
            $notifications->add($data);
        }

        if (count($device_tokens) > 0) {
            $message = CloudMessage::new()->withNotification([
                'title'         => $title_onbar,
                'body'          => $message
            ])->withData([
                'image'         => url('assets/media/logos/jm-logo.png'),
                "id"            => $data_onbell['target_id'],
                "type"          => $data_onbell['target_type'],
                "click_action"  => "FLUTTER_NOTIFICATION_CLICK"
            ]);

            $messaging = app('firebase.messaging');
            $messaging->sendMulticast($message, $device_tokens);
        }
    }

    public static function notify($data) {
        if ((! isset($data['no_tiket'])) || (! isset($data['status_id']))) return false;

        $no_tiket = $data['no_tiket'];
        $master_status = MasterStatus::where('id', $data['status_id'])->first(['code']);

        $user_name = auth()->user()->name ?? auth()->user()->username;
        $user_role = auth()->user()->roles()->first()->name;
        $processor = " (".$user_name." – ".$user_role.")";
        $by_processor = " oleh".$processor;

        $user_ids = [];
        $data_onbell = ['unit_id' => $data->unit_id*1, 'target_id' => $data->id, 'target_type' => $data->filesMorphClass() ];

        if ($master_status) {
            $status = $master_status['code'];
            if ($no_tiket[0] == 'K') {
                switch ($status) {
                    case '01':
                        // 01 Tiket diinput => Supervisor JMTC
                        // JMACT – Keluhan dengan No Tiket (XXXXX) Diinput Oleh (Nama User – Nama Role)
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") Diinput".$by_processor;

                        // $user_ids = User::role('Supervisor JMTC')->get(['id'])->pluck('id')->toArray();
                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Supervisor JMTC")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        $user_ids_names = \App\Models\User:whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Supervisor JMTC [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '02':
                        // 02 Tiket diteruskan => Service Provider dengan unit yang sesuai dengan bidang keluhan, dan Regional sesuai dengan Ruas
                        // JMACT – Keluhan dengan No Tiket (XXXXX) Diteruskan Oleh (Nama User – Nama Role)
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") Diteruskan".$by_processor;

                        // $user_ids1 = \App\Models\User::role('Service Provider')
                        //     ->with('roles')
                        //     ->where('unit_id', $data->unit_id)
                        //     ->get(['id'])->pluck('id')->toArray();
                        $user_ids1 = \DB::table('users')
                            ->join('role_users', 'role_users.user_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                            ->where('master_type.type', "Service Provider")
                            ->where('users.unit_id', $data->unit_id)
                            ->select('users.id')
                            ->get(['id'])
                            ->pluck('id')
                            ->toArray();
                                                
                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');
                        // $user_ids2 = \App\Models\User::with('roles')
                        //     ->whereHas('roles', function ($q) use($regional_id) { $q->where('regional_id', '=', $regional_id); })
                        //     ->get(['id'])->pluck('id')->toArray();
                        $user_ids2 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();
                        
                        $user_ids = array_merge($user_ids1, $user_ids2);

                        $user_ids_names1 = \App\Models\User:whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                        $user_ids_names2 = \App\Models\User:whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Service Provider dengan unit yang sesuai dengan bidang keluhan [". implode(", ", $user_ids_names1) . "], dan Regional sesuai dengan Ruas [". implode(", ", $user_ids_names2) . "]");
                        break;

                    case '03':
                        // 03 On Progress => Regional sesuai dengan Ruas
                        // JMACT – Keluhan dengan No Tiket (XXXXX) sedang diproses Oleh (Nama User – Nama Role) – Estimasti Pengerjaan dalam (waktu SLA) hari
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") sedang diproses".$by_processor." - Estimasti Pengerjaan dalam (waktu SLA) hari";  // TODO: get SLA

                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');
                        // $user_ids = \App\Models\User::with('roles')
                        //     ->whereHas('roles', function ($q) use($regional_id) { $q->where('regional_id', '=', $regional_id); })
                        //     ->get(['id'])->pluck('id')->toArray();

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        $user_ids_names = \App\Models\User:whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '04':
                        // 04 Submit Report => Regional sesuai dengan Ruas
                        // JMACT – (Nama User – Nama Role) telah submit report pengerjaan Keluhan dengan No Tiket (XXXXX)
                        $message = $processor." telah submit report pengerjaan Keluhan dengan No Tiket (".$no_tiket.")";

                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');
                        // $user_ids = \App\Models\User::with('roles')
                        //     ->whereHas('roles', function ($q) use($regional_id) { $q->where('regional_id', '=', $regional_id); })
                        //     ->get(['id'])->pluck('id')->toArray();

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        $user_ids_names = \App\Models\User:whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '05':
                        // 05 Konfirmasi Pelanggan => Regional sesuai dengan Ruas, dan Inputer pembuat laporan keluhan
                        // JMACT – Keluhan dengan No Tiket (XXXXX) telah mendapat konfirmasi Pelanggan
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") telah mendapat konfirmasi Pelanggan";

                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');
                        // $user_ids = \App\Models\User::with('roles')
                        //     ->whereHas('roles', function ($q) use($regional_id) { $q->where('regional_id', '=', $regional_id); })
                        //     ->get(['id'])->pluck('id')->toArray();

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        $user_ids_names = \App\Models\User:whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        $creator_name = \App\Models\User:where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."], dan Inputer pembuat laporan keluhan [". implode(", ", $creator_name) ."]");
                        $user_ids[] = $data->created_by;  // the inputer?
                        break;

                    case '06':
                        break;

                    case '07':
                        // 07 Closed => Regional sesuai dengan Ruas, Supervisor JMTC, Inputer Pembuat Laporan, Service Provider sesuai dengan bidang keluhan
                        // JMACT – Keluhan dengan No Tiket (XXXXX) Closed.
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") Closed";

                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');
                        // $user_ids1 = \App\Models\User::with('roles')
                        //     ->whereHas('roles', function ($q) use($regional_id) { $q->where('regional_id', '=', $regional_id); })
                        //     ->get(['id'])->pluck('id')->toArray();

                        $user_ids1 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        // $user_ids2 = User::role('Supervisor JMTC')->get(['id'])->pluck('id')->toArray();
                        $user_ids2 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Supervisor JMTC")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        // $user_ids3 = \App\Models\User::role('Service Provider')
                        //     ->with('roles')
                        //     ->where('unit_id', $data->unit_id)
                        //     ->get(['id'])->pluck('id')->toArray();
                        $user_ids3 = \DB::table('users')
                            ->join('role_users', 'role_users.user_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                            ->where('master_type.type', "Service Provider")
                            ->where('users.unit_id', $data->unit_id)
                            ->select('users.id')
                            ->get(['id'])
                            ->pluck('id')
                            ->toArray();

                        $user_ids = array_merge($user_ids1, $user_ids2, $user_ids3);

                        $user_ids_names1 = \App\Models\User:whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                        $user_ids_names2 = \App\Models\User:whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                        $user_ids_names3 = \App\Models\User:whereIn('id', $user_ids3)->get('name')->pluck('name')->toArray();
                        $creator_name = \App\Models\User:where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names1) . "], Supervisor JMTC [". implode(", ", $user_ids_names2) . "], Inputer Pembuat Laporan [". implode(", ", $creator_name) . "], Service Provider sesuai dengan bidang keluhan [". implode(", ", $user_ids_names3) . "]");
                        $user_ids[] = $data->created_by;  // the inputer?
                        break;

                    case '08':
                        // 08 Overtime => Regional sesuai dengan Ruas
                        // JMACT – Keluhan dengan No Tiket (XXXXX) melewati batas estimasi pengerjaan oleh (Nama User – Nama Role)
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") melewati batas estimasi pengerjaan".$by_processor;

                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');
                        // $user_ids = \App\Models\User::with('roles')
                        //     ->whereHas('roles', function ($q) use($regional_id) { $q->where('regional_id', '=', $regional_id); })
                        //     ->get(['id'])->pluck('id')->toArray();

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();
                        
                        $user_ids_names = \App\Models\User:whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        break;
                }
                if (count($user_ids) > 0) {
                  $device_tokens = UserDevice::whereIn('user_id', $user_ids)->get(['token'])->pluck('token')->toArray();
                  self::notifier($user_ids, $device_tokens, "Keluhan ".$no_tiket, $data_onbell, "JMACT Notification", $message);
                }
            } else if ($no_tiket[0] == 'C') {
                switch ($status) {
                    case '01':
                        // 01 Tiket diinput => Supervisor JMTO
                        // JMACT – Claim dengan No Tiket (XXXXX) Diinput Oleh (Nama User – Nama Role)
                        $message = "Claim dengan No Tiket (".$no_tiket.") Diinput".$by_processor;

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Supervisor JMTO")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();
                        
                        $user_ids_names = \App\Models\User:whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Supervisor JMTO [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '02':
                        // 02 Approve => Representative Office sesuai dengan Ruasnya
                        // JMACT – Claim dengan No Tiket (XXXXX) Approved Oleh (Nama User – Nama Role)
                        $message = "Claim dengan No Tiket (".$no_tiket.") Approved".$by_processor;

                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Representative Office")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();
                        
                        $user_ids_names = \App\Models\User:whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Representative Office sesuai dengan Ruasnya [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '03':
                        // 03 Rejected => Customer Service JMTO pembuat laporan Claim
                        // JMACT – Claim dengan No Tiket (XXXXX) Rejected Oleh (Nama User – Nama Role)
                        $message = "Claim dengan No Tiket (".$no_tiket.") Rejected".$by_processor;

                        $user_ids = [$data->created_by];  // Customer Service JMTO ~ the inputer?
                        $creator_name = \App\Models\User:where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Customer Service JMTO pembuat laporan Claim [". implode(", ", $creator_name) . "]");
                        break;

                    case '04':
                        // 04 Tiket diteruskan => Service Provider sesuai bidang claim dan Regional sesuai dengan Ruas
                        // JMACT – Claim dengan No Tiket (XXXXX) Diteruskan Oleh (Nama User – Nama Role
                        $message = "Claim dengan No Tiket (".$no_tiket.") Diteruskan".$by_processor;

                        $user_ids1 = \DB::table('users')
                            ->join('role_users', 'role_users.user_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                            ->where('master_type.type', "Service Provider")
                            ->where('users.unit_id', $data->unit_id)
                            ->select('users.id')
                            ->get(['id'])
                            ->pluck('id')
                            ->toArray();
                        
                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');

                        $user_ids2 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        $user_ids = array_merge($user_ids1, $user_ids2);

                        $user_ids_names1 = \App\Models\User:whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                        $user_ids_names2 = \App\Models\User:whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Service Provider sesuai bidang claim [". implode(", ", $user_ids_names1) . "], dan Regional sesuai dengan Ruas [". implode(", ", $user_ids_names2) . "]");
                        break;

                    case '05':
                        // 05 Klarifikasi dan Negosiasi	=> Regional sesuai dengan Ruas
                        // JMACT – Claim dengan No Tiket (XXXXX) tahap Klarifikasi dan Negosiasi telah selesai Oleh (Nama User – Nama Role)
                        $message = "Claim dengan No Tiket (".$no_tiket.") tahap Klarifikasi dan Negosiasi telah selesai".$by_processor;

                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();
                        
                        $user_ids_names = \App\Models\User:whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '06':
                        // 06 Pembayaran Selesai => Regional dan Representative Office sesuai dengan Ruas
                        // JMACT – Claim dengan No Tiket (XXXXX) tahap Pembayaran telah selesai Oleh (Nama User – Nama Role)
                        $message = "Claim dengan No Tiket (".$no_tiket.") tahap Pembayaran telah selesai".$by_processor;

                        $regional_id = \DB::table('master_ruas')
                            ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                            ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_regional.id');

                        $user_ids1 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        $user_ids2 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Representative Office")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();
                        
                        $user_ids = array_merge($user_ids1, $user_ids2);

                        $user_ids_names1 = \App\Models\User:whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                        $user_ids_names2 = \App\Models\User:whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional [". implode(", ", $user_ids_names1) . "] dan Representative Office sesuai dengan Ruas [". implode(", ", $user_ids_names2) . "]");
                        break;

                    case '07':
                        break;

                    case '08':
                        // 08 Closed => Supervisor JMTO, Customer Service JMTO pembuat claim, Representative Office, Regional sesuai Ruas dan Service Provider.
                        // JMACT – Claim dengan No Tiket (XXXXX) Closed.
                        $message = "Claim dengan No Tiket (".$no_tiket.") Closed.";

                        $user_ids1 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Supervisor JMTO")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();
                        
                        $user_ids2 = [$data->created_by];  // Customer Service JMTO ~ the inputer?

                        $regional_id = \DB::table('master_ruas')
                          ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                          ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                          ->where('master_ruas.id', $data->ruas_id)
                          ->value('master_regional.id');

                        // TODO: Confirm if Representative Office sesuai ruas
                        $user_ids3 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Representative Office")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();
                        
                        $user_ids4 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Regional")
                          ->where('roles.regional_id', $regional_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        // TODO: Confirm if SP glued with unit_id
                        $user_ids5 = \DB::table('users')
                            ->join('role_users', 'role_users.user_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                            ->where('master_type.type', "Service Provider")
                            ->where('users.unit_id', $data->unit_id)
                            ->select('users.id')
                            ->get(['id'])
                            ->pluck('id')
                            ->toArray();

                        $user_ids = array_merge($user_ids1, $user_ids2, $user_ids3, $user_ids4, $user_ids5);

                        $user_ids_names1 = \App\Models\User:whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                        $user_ids_names3 = \App\Models\User:whereIn('id', $user_ids3)->get('name')->pluck('name')->toArray();
                        $user_ids_names4 = \App\Models\User:whereIn('id', $user_ids4)->get('name')->pluck('name')->toArray();
                        $creator_name = \App\Models\User:where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Supervisor JMTO [". implode(", ", $user_ids_names1) . "], Customer Service JMTO pembuat claim [". implode(", ", $creator_name) . "], Representative Office [". implode(", ", $user_ids_names3) . "], Regional sesuai Ruas [". implode(", ", $user_ids_names4) . "] dan Service Provider [". implode(", ", $user_ids_names5) . "]");
                        break;
                }
                if (count($user_ids) > 0) {
                  $device_tokens = UserDevice::whereIn('user_id', $user_ids)->get(['token'])->pluck('token')->toArray();
                  self::notifier($user_ids, $device_tokens, "Claim ".$no_tiket, $data_onbell, "JMACT Notification", $message);
                }
            }
        }
    }

    public static function send(
      $data = [],
      $title = 'JMACT',
      $message = 'Hello From Me'
    )
    {
        $user = User::findOrFail($data->user_id);
      
        $array = [
          'user_id' => $data->user_id,
          'title' => $title,
          'message' => $message,
          'target_id' => $data->id,
          'unit_id' => $data->unit_id,
          'target_type' => $data->filesMorphClass(),
          'status' => 'Unread',
          'created_at' => Carbon::now()
        ];
        
        $Notification = Notification::create($array);

        $firestore = app('firebase.firestore');
        $dbFire = $firestore->database();
        $collection = $dbFire->collection('notifications');
        $fireStore = $collection->add($array);

        // END FOR NOTIFICATION
        
        // FIREBASE NOTIF MESSAGE
        $messaging = app('firebase.messaging');
        $CloudMessage = CloudMessage::new()->withNotification([
          'title' => $title, 
          'body' => $message, 
        ])->withData([
          'image' => url('assets/media/logos/jm-logo.png'),
          "id" => $data->id,
          "type" => $data->filesMorphClass(),
          "click_action" => "FLUTTER_NOTIFICATION_CLICK",
        ]);
        $messaging->sendMulticast($CloudMessage,[$user->device_id]);

    }

    public static function sendGroup(
      $data = [],
      $title = 'JMACT',
      $message = 'Hello From Me'
    )
    {
        return false;

        $array = [
          'user_id' => $data->user_id,
          'title' => $title,
          'message' => $message,
          'target_id' => $data->id,
          'target_type' => $data->filesMorphClass(),
          'unit_id' => $data->unit_id,
          'status' => 'Unread',
          'created_at' => Carbon::now()
        ];
        
        // $Notification = Notification::create($array);

        $firestore = app('firebase.firestore');
        $dbFire = $firestore->database();
        $collection = $dbFire->collection('notifications');
        $fireStore = $collection->add($array);

        // END FOR NOTIFICATION
        

        // FIREBASE NOTIF MESSAGE
        // dd($data->unit->unit);
        $messaging = app('firebase.messaging');
        $CloudMessage = CloudMessage::withTarget('topic',"".$data->unit->unit."")
        ->withNotification([
          'title' => $title, 
          'body' => $message, 
          'image' => url('assets/media/logos/jm-logo.png'),
          "click_action" => "https://my-server/some-page",
        ])->withData([
          'image' => url('assets/media/logos/jm-logo.png'),
          "id" => $data->id,
          "type" => $data->filesMorphClass(),
          "click_action" => "https://my-server/some-page",
        ]);
        $messaging->send($CloudMessage);

    }

    public static function sendDB($data, $db){
      $firestore = app('firebase.firestore');
      $dbFire = $firestore->database();
      $collection = $dbFire->collection($db);

      $fireStore = $collection->add($data);
    }

    public static function sendUpdtDB($data, $db){
      $firestore = app('firebase.firestore');
      $dbFire = $firestore->database();
      $collection = $dbFire->collection($db);
      $documents = $collection->where('id','=',$data['id'])->documents();
      foreach ($documents as $document) {
        dd($document);
        $document->reference()->delete();
      }
      $fireStore = $collection->add($data);
    }

    public static function delete($id, $db){
      $firestore = app('firebase.firestore');
      $dbFire = $firestore->database();
      $collection = $dbFire->collection($db);
      $documents = $collection->where('id','=',$id)->documents();
      foreach ($documents as $document) {
        $document->reference()->delete();
      }
    }

    public static function show($id,$db){
      $firestore = app('firebase.firestore');
      $dbFire = $firestore->database();
      $collection = $dbFire->collection($db)->document($id);
      $snapshot = $collection->snapshot();
      if ($snapshot->exists()) {
        return $snapshot->data();
      } 

    }

}
