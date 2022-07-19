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

        $fbms_names = [];

        $bell_names = \DB::table('users')
          ->whereIn('users.id', $user_ids)
          ->select('users.name')
          ->get(['name'])
          ->pluck('name')
          ->toArray();

        if (count($device_tokens) > 0) {
            $cloud_message = CloudMessage::new()->withNotification([
                'title'         => $title_onbar,
                'body'          => $message
            ])->withData([
                'image'         => url('assets/media/logos/jm-logo.png'),
                "id"            => $data_onbell['target_id'],
                "type"          => $data_onbell['target_type'],
                "sound"         => "default",
                "click_action"  => "FLUTTER_NOTIFICATION_CLICK"
            ]);

            $messaging = app('firebase.messaging');
            $messaging->sendMulticast($cloud_message, $device_tokens);

            $fbms_names = \DB::table('users')
              ->join('user_devices', 'user_devices.user_id', '=', 'users.id')
              ->whereIn('user_devices.token', $device_tokens)
              ->whereIn('user_devices.user_id', $user_ids)
              ->select('users.name')
              ->get(['name'])
              ->pluck('name')
              ->toArray();
        }
        \App\Models\SysLog::write("Notifikasi melalui Lonceng [". implode(", ", $bell_names) ."], melalui Firebase.Messaging [". implode(", ", $fbms_names) ."] message: ". $message);
    }

    public static function notifyOvertime($overtime) {
/*

array:1 [▼
  "Jasamarga Transjawa Tol" => array:3 [▼
    "no_tikets" => array:2 [▼
      12 => "KA01220005"
      11 => "KE01220002"
    ]
    "user_names" => array:1 [▼
      15 => "Regional JTT"
    ]
    "user_ids" => array:1 [▼
      0 => 15
    ]
  ]
]

*/
        foreach ($overtime as $regional_name => $regional_data) {
            foreach ($regional_data['no_tikets'] as $id => $no_tiket) {
                $data = \App\Models\KeluhanPelanggan::find($id);
                $status = MasterStatus::where('id', $data['status_id'])->value('code');
                $data_onbell = ['unit_id' => $data->unit_id*1, 'target_id' => $data->id, 'target_type' => $data->filesMorphClass() ];
                $user_ids = $regional_data['user_ids'];
                $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                \App\Models\SysLog::write("Notifikasi Overtime ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");

                if (count($user_ids) > 0) {
                    $message = "Keluhan dengan No Tiket (".$no_tiket.") sudah Overtime!";
                    $device_tokens = UserDevice::whereIn('user_id', $user_ids)->get(['token'])->pluck('token')->toArray();
                    self::notifier($user_ids, $device_tokens, "Keluhan ".$no_tiket, $data_onbell, "JMACT Notification", $message);
                }
            }
        }
    }

    public static function notify($data) {
        // \App\Models\SysLog::write("notify with data ". json_encode($data));

        if ((! isset($data['no_tiket'])) || (! isset($data['status_id']))) return false;

        $no_tiket = $data['no_tiket'];
        $master_status = MasterStatus::where('id', $data['status_id'])->first(['code']);

        $user_name = auth()->user()->name ?? (auth()->user()->username ?? "User ID #".auth()->user()->id);
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

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Supervisor JMTC")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        if (is_numeric($data['no_telepon'])) {
                            \App\Models\Blast::create([
                                'no_telepon'  =>  $data['no_telepon'],
                                'nama'        =>  $data['nama_cust'],
                                'no_tiket'    =>  $data['no_tiket'],
                                'attributes'  =>  json_encode(['status'=>"created"])
                            ]);
                        }

                        $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Supervisor JMTC [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '02':
                        // 02 Tiket diteruskan => Service Provider dengan unit yang sesuai dengan bidang keluhan, dan Regional sesuai dengan ruas
                        // JMACT – Keluhan dengan No Tiket (XXXXX) Diteruskan Oleh (Nama User – Nama Role)
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") Diteruskan".$by_processor;

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

                        $user_ids_names1 = \App\Models\User::whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                        $user_ids_names2 = \App\Models\User::whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Service Provider dengan unit yang sesuai dengan bidang keluhan [". implode(", ", $user_ids_names1) . "], dan Regional sesuai dengan Ruas [". implode(", ", $user_ids_names2) . "]");
                        break;

                    case '03':
                        // 03 On Progress => Regional sesuai dengan ruas
                        // JMACT – Keluhan dengan No Tiket (XXXXX) sedang diproses Oleh (Nama User – Nama Role) – Estimasti Pengerjaan dalam (waktu SLA) hari
                        $sla = \App\Models\MasterBk::where('id', $data['bidang_id'])->value('sla');
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") sedang diproses".$by_processor." - Estimasti Pengerjaan dalam ".(is_null($sla) ? '?' : $sla/24)." hari";

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

                        $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '04':
                        // 04 Submit Report => Regional sesuai dengan ruas
                        // JMACT – (Nama User – Nama Role) telah submit report pengerjaan Keluhan dengan No Tiket (XXXXX)
                        $message = $processor." telah submit report pengerjaan Keluhan dengan No Tiket (".$no_tiket.")";

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

                        $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '05':
                        // 05 Konfirmasi Pelanggan => Regional sesuai dengan ruas, dan Inputer pembuat laporan keluhan
                        // JMACT – Keluhan dengan No Tiket (XXXXX) telah mendapat konfirmasi Pelanggan
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") telah mendapat konfirmasi Pelanggan";

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

                        if (is_numeric($data['no_telepon'])) {
                            $url = url("feedback.php?".$data['no_tiket'].":".substr(strtoupper(MD5($data['no_tiket'])), -4));
                            \App\Models\Blast::create([
                                'no_telepon'  =>  $data['no_telepon'],
                                'nama'        =>  $data['nama_cust'],
                                'no_tiket'    =>  $data['no_tiket'],
                                'attributes'  =>  json_encode(['status'=>"feedback", 'url'=>$url])
                            ]);
                        }

                        $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        $creator_name = \App\Models\User::where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."], dan Inputer pembuat laporan keluhan [". implode(", ", $creator_name) ."]");
                        $user_ids[] = $data->created_by;  // the inputer?
                        break;

                    case '06':
                        // unimplemented
                        break;

                    case '07':
                        // 07 Closed => Regional sesuai dengan ruas, Supervisor JMTC, Inputer Pembuat Laporan, Service Provider sesuai dengan bidang keluhan
                        // JMACT – Keluhan dengan No Tiket (XXXXX) Closed.
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") Closed";

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
                          ->where('master_type.type', "Supervisor JMTC")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

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

                        if (is_numeric($data['no_telepon'])) {
                            \App\Models\Blast::create([
                                'no_telepon'  =>  $data['no_telepon'],
                                'nama'        =>  $data['nama_cust'],
                                'no_tiket'    =>  $data['no_tiket'],
                                'attributes'  =>  json_encode(['status'=>"closed"])
                            ]);
                        }

                        $user_ids_names1 = \App\Models\User::whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                        $user_ids_names2 = \App\Models\User::whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                        $user_ids_names3 = \App\Models\User::whereIn('id', $user_ids3)->get('name')->pluck('name')->toArray();
                        $creator_name = \App\Models\User::where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names1) . "], Supervisor JMTC [". implode(", ", $user_ids_names2) . "], Inputer Pembuat Laporan [". implode(", ", $creator_name) . "], Service Provider sesuai dengan bidang keluhan [". implode(", ", $user_ids_names3) . "]");
                        $user_ids[] = $data->created_by;  // the inputer?
                        break;

                    case '08':
                        // 08 Overtime => Regional sesuai dengan ruas
                        // JMACT – Keluhan dengan No Tiket (XXXXX) melewati batas estimasi pengerjaan oleh (Nama User – Nama Role)
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") melewati batas estimasi pengerjaan".$by_processor;

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

                        $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        break;
                }
                if (count($user_ids) > 0) {
                  $device_tokens = UserDevice::whereIn('user_id', $user_ids)->get(['token'])->pluck('token')->toArray();
                  self::notifier($user_ids, $device_tokens, "Keluhan ".$no_tiket, $data_onbell, "JMACT Notification", $message);
                }
            } else if ($no_tiket[0] == 'C') {
                $is_project = ($data->penyelesaian === 'proyek');
                switch ($status) {
                    case '01':
                        // 01 Tiket diinput => Manager Area
                        // JMACT – Klaim dengan No Tiket (XXXXX) Diinput Oleh (Nama User – Nama Role)
                        $message = "Klaim dengan No Tiket (".$no_tiket.") Diinput".$by_processor;

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Manager Area")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        if (is_numeric($data['no_telepon'])) {
                            $url = url("feedback.php?".$data->no_tiket.":".substr(strtoupper(MD5($data->no_tiket)), -4));
                            \App\Models\Blast::create([
                                'no_telepon'  =>  $data['no_telepon'],
                                'nama'        =>  $data['nama_pelanggan'],
                                'no_tiket'    =>  $data['no_tiket'],
                                'attributes'  =>  json_encode(['status'=>"created"])
                            ]);
                        }

                        $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Manager Area [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '02':
                        // 02 Approve => Representative Office sesuai dengan ruas
                        // JMACT – Klaim dengan No Tiket (XXXXX) Approved Oleh (Nama User – Nama Role)
                        $message = "Klaim dengan No Tiket (".$no_tiket.") Approved".$by_processor;

                        $ro_id = \DB::table('master_ruas')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_ruas.ro_id');

                        $user_ids = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Representative Office")
                          ->where('roles.ro_id', $ro_id)
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Representative Office sesuai dengan Ruasnya [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '03':
                        // 03 Rejected => JMTO Area pembuat laporan Claim
                        // JMACT – Klaim dengan No Tiket (XXXXX) Rejected Oleh (Nama User – Nama Role)
                        $message = "Klaim dengan No Tiket (".$no_tiket.") Rejected".$by_processor;

                        $user_ids = [$data->created_by];  // JMTO Area ~ the inputer?
                        $creator_name = \App\Models\User::where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => JMTO Area pembuat laporan Claim [". implode(", ", $creator_name) . "]");
                        break;

                    case '04':
                        // 04 Tiket diteruskan => Service Provider sesuai bidang claim dan Regional sesuai dengan ruas
                        // JMACT – Claim dengan No Tiket (XXXXX) Diteruskan Oleh (Nama User – Nama Role
                        $message = "Klaim dengan No Tiket (".$no_tiket.") Diteruskan".$by_processor;

                        $unit_id = \App\Models\MasterJenisClaim::where('id', $data->jenis_claim_id)->value('unit_id');
                        $user_ids1 = \DB::table('users')
                            ->join('role_users', 'role_users.user_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                            ->where('master_type.type', "Service Provider")
                            ->where('users.unit_id', $unit_id)
                            ->select('users.id')
                            ->get(['id'])
                            ->pluck('id')
                            ->toArray();
                        
                        \App\Models\SysLog::write("DEBUG '.$no_tiket.' >> unit_id ".$unit_id." data->jenis_claim_id ".$data->jenis_claim_id." user_ids1 [". implode(", ", $user_ids1) . "]");

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

                        $user_ids_names1 = \App\Models\User::whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                        $user_ids_names2 = \App\Models\User::whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Service Provider sesuai bidang claim [". implode(", ", $user_ids_names1) . "], dan Regional sesuai dengan Ruas [". implode(", ", $user_ids_names2) . "]");
                        break;

                    case '05':
                        // 05 Monitoring RO (Proyek) => Regional sesuai dengan ruas
                        // JMACT – Klaim dengan No Tiket (XXXXX) dalam Monitoring RO (Proyek) Oleh (Nama User – Nama Role)
                        $message = "Klaim dengan No Tiket (".$no_tiket.") dalam Monitoring RO (Proyek)".$by_processor;

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

                        $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                        \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        break;

                    case '06':
                        // 06 Klarifikasi dan Negosiasi
                        // Proyek:            => Regional sesuai dengan ruas
                        // Service Provider:  => Regional dan Representative Office sesuai dengan ruas
                        // JMACT – Klaim dengan No Tiket (XXXXX) tahap Klarifikasi dan Negosiasi telah selesai Oleh (Nama User – Nama Role)
                        $message = "Klaim dengan No Tiket (".$no_tiket.") tahap Klarifikasi dan Negosiasi telah selesai".$by_processor;

                        $ro_id = \DB::table('master_ruas')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_ruas.ro_id');

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

                        if (! $is_project) {
                            $user_ids1 = $user_ids;
                            $user_ids2 = \DB::table('role_users')
                              ->join('roles', 'roles.id', '=', 'role_users.role_id')
                              ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                              ->where('master_type.type', "Representative Office")
                              ->where('roles.ro_id', $ro_id)
                              ->select('role_users.*')
                              ->get(['user_id'])
                              ->pluck('user_id')
                              ->toArray();
                            $user_ids = array_merge($user_ids1, $user_ids2);
                        }

                        if ($is_project) {
                            $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                            \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        } else {
                            $user_ids_names1 = \App\Models\User::whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                            $user_ids_names2 = \App\Models\User::whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                            \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional [". implode(", ", $user_ids_names1) ."] dan Representative Office sesuai dengan Ruas [". implode(", ", $user_ids_names2) ."]");
                        }
                        break;

                    case '07':
                        // 07 Proses Pembayaran
                        // Proyek:            => Regional sesuai dengan ruas
                        // Service Provider:  => Regional dan Representative Office sesuai dengan ruas
                        // JMACT – Klaim dengan No Tiket (XXXXX) tahap Proses Pembayaran Oleh (Nama User – Nama Role)
                        $message = "Klaim dengan No Tiket (".$no_tiket.") tahap Proses Pembayaran".$by_processor;

                        $ro_id = \DB::table('master_ruas')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_ruas.ro_id');

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

                        if (! $is_project) {
                            $user_ids1 = $user_ids;
                            $user_ids2 = \DB::table('role_users')
                              ->join('roles', 'roles.id', '=', 'role_users.role_id')
                              ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                              ->where('master_type.type', "Representative Office")
                              ->where('roles.ro_id', $ro_id)
                              ->select('role_users.*')
                              ->get(['user_id'])
                              ->pluck('user_id')
                              ->toArray();
                            $user_ids = array_merge($user_ids1, $user_ids2);
                        }

                        if ($is_project) {
                            $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                            \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        } else {
                            $user_ids_names1 = \App\Models\User::whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                            $user_ids_names2 = \App\Models\User::whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                            \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional [". implode(", ", $user_ids_names1) ."] dan Representative Office sesuai dengan Ruas [". implode(", ", $user_ids_names2) ."]");
                        }
                        break;

                    case '08':
                        // 08 Pembayaran Selesai
                        // Proyek:            => Regional sesuai dengan ruas
                        // Service Provider:  => Regional dan Representative Office sesuai dengan ruas
                        // JMACT – Klaim dengan No Tiket (XXXXX) tahap Pembayaran telah selesai Oleh (Nama User – Nama Role)
                        $message = "Klaim dengan No Tiket (".$no_tiket.") tahap Pembayaran telah selesai".$by_processor;

                        $ro_id = \DB::table('master_ruas')
                            ->where('master_ruas.id', $data->ruas_id)
                            ->value('master_ruas.ro_id');

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

                        if (! $is_project) {
                            $user_ids1 = $user_ids;
                            $user_ids2 = \DB::table('role_users')
                              ->join('roles', 'roles.id', '=', 'role_users.role_id')
                              ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                              ->where('master_type.type', "Representative Office")
                              ->where('roles.ro_id', $ro_id)
                              ->select('role_users.*')
                              ->get(['user_id'])
                              ->pluck('user_id')
                              ->toArray();
                            $user_ids = array_merge($user_ids1, $user_ids2);
                        }

                        if (is_numeric($data['no_telepon'])) {
                            $url = url("feedback.php?".$data['no_tiket'].":".substr(strtoupper(MD5($data['no_tiket'])), -4));
                            \App\Models\Blast::create([
                                'no_telepon'  =>  $data['no_telepon'],
                                'nama'        =>  $data['nama_pelanggan'],
                                'no_tiket'    =>  $data['no_tiket'],
                                'attributes'  =>  json_encode(['status'=>"feedback", 'url'=>$url])
                            ]);
                        }

                        if ($is_project) {
                            $user_ids_names = \App\Models\User::whereIn('id', $user_ids)->get('name')->pluck('name')->toArray();
                            \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional sesuai dengan Ruas [". implode(", ", $user_ids_names) ."]");
                        } else {
                            $user_ids_names1 = \App\Models\User::whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                            $user_ids_names2 = \App\Models\User::whereIn('id', $user_ids2)->get('name')->pluck('name')->toArray();
                            \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Regional [". implode(", ", $user_ids_names1) ."] dan Representative Office sesuai dengan Ruas [". implode(", ", $user_ids_names2) ."]");
                        }
                        break;

                    case '09':
                        // unimplemented
                        break;

                    case '10':
                        // 10 Closed
                        // Proyek:            => Manager Area, JMTO Area pembuat claim, Representative Office dan Regional sesuai dengan ruas
                        // Service Provider:  => Manager Area, JMTO Area pembuat claim, Representative Office, Regional sesuai dengan ruas dan Service Provider sesuai unit di jenis claim
                        // JMACT – Klaim dengan No Tiket (XXXXX) Closed.
                        $message = "Klaim dengan No Tiket (".$no_tiket.") Closed.";

                        $user_ids1 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Manager Area")
                          ->select('role_users.*')
                          ->get(['user_id'])
                          ->pluck('user_id')
                          ->toArray();

                        $user_ids2 = [$data->created_by];  // JMTO Area ~ the inputer?

                        $ro_id = \DB::table('master_ruas')
                          ->where('master_ruas.id', $data->ruas_id)
                          ->value('master_ruas.ro_id');

                        $regional_id = \DB::table('master_ruas')
                          ->join('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
                          ->join('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
                          ->where('master_ruas.id', $data->ruas_id)
                          ->value('master_regional.id');

                        $user_ids3 = \DB::table('role_users')
                          ->join('roles', 'roles.id', '=', 'role_users.role_id')
                          ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                          ->where('master_type.type', "Representative Office")
                          ->where('roles.ro_id', $ro_id)
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

                        if (is_numeric($data['no_telepon'])) {
                            \App\Models\Blast::create([
                                'no_telepon'  =>  $data['no_telepon'],
                                'nama'        =>  $data['nama_pelanggan'],
                                'no_tiket'    =>  $data['no_tiket'],
                                'attributes'  =>  json_encode(['status'=>"closed"])
                            ]);
                        }

                        if ($is_project) {
                            $user_ids = array_merge($user_ids1, $user_ids2, $user_ids3, $user_ids4);
                            $user_ids_names1 = \App\Models\User::whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                            $user_ids_names3 = \App\Models\User::whereIn('id', $user_ids3)->get('name')->pluck('name')->toArray();
                            $user_ids_names4 = \App\Models\User::whereIn('id', $user_ids4)->get('name')->pluck('name')->toArray();
                            $creator_name = \App\Models\User::where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                            \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Manager Area [". implode(", ", $user_ids_names1) . "], JMTO Area pembuat claim [". implode(", ", $creator_name) . "], Representative Office [". implode(", ", $user_ids_names3) . "], Regional sesuai Ruas [". implode(", ", $user_ids_names4) . "]");
                        } else {
                            $unit_id = \App\Models\MasterJenisClaim::find($data->jenis_claim_id)->value('unit_id');
                            $user_ids5 = \DB::table('users')
                                ->join('role_users', 'role_users.user_id', '=', 'users.id')
                                ->join('roles', 'roles.id', '=', 'role_users.role_id')
                                ->join('master_type', 'master_type.id', '=', 'roles.type_id')
                                ->where('master_type.type', "Service Provider")
                                ->where('users.unit_id', $unit_id)
                                ->select('users.id')
                                ->get(['id'])
                                ->pluck('id')
                                ->toArray();
                            $user_ids = array_merge($user_ids1, $user_ids2, $user_ids3, $user_ids4, $user_ids5);
                            $user_ids_names1 = \App\Models\User::whereIn('id', $user_ids1)->get('name')->pluck('name')->toArray();
                            $user_ids_names3 = \App\Models\User::whereIn('id', $user_ids3)->get('name')->pluck('name')->toArray();
                            $user_ids_names4 = \App\Models\User::whereIn('id', $user_ids4)->get('name')->pluck('name')->toArray();
                            $user_ids_names5 = \App\Models\User::whereIn('id', $user_ids5)->get('name')->pluck('name')->toArray();
                            $creator_name = \App\Models\User::where('id', $data->created_by)->get('name')->pluck('name')->toArray();
                            \App\Models\SysLog::write("Notifikasi ".$no_tiket." Status ".$status." => Manager Area [". implode(", ", $user_ids_names1) . "], JMTO Area pembuat claim [". implode(", ", $creator_name) . "], Representative Office [". implode(", ", $user_ids_names3) . "], Regional sesuai Ruas [". implode(", ", $user_ids_names4) . "] dan Service Provider sesuai unit di jenis claim [". implode(", ", $user_ids_names5) . "]");
                        }
                        break;
                }
                if (count($user_ids) > 0) {
                  $device_tokens = UserDevice::whereIn('user_id', $user_ids)->get(['token'])->pluck('token')->toArray();
                  self::notifier($user_ids, $device_tokens, "Klaim ".$no_tiket, $data_onbell, "JMACT Notification", $message);
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

    public static function updateData($data, $db, $id){
        $firestore = app('firebase.firestore');
        $dbFire = $firestore->database();
        $collection = $dbFire->collection($db);
        $documents = $collection->document($id);
        $documents->update($data);

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

    public static function collection($db, $id){
      $firestore = app('firebase.firestore');
      $dbFire = $firestore->database();
      $collection = $dbFire->collection($db);
      $snapshot = $collection->where('user_id','=',(int)$id)->orderBy('created_at','DESC')->documents();
      if(count($snapshot->rows()) > 0){
        return $snapshot->rows();
      }
    }

}
