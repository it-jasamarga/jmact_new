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

/* Notification by kode Status

Keluhan:
01 Tiket diinput				      => Supervisor JMTC
                                 JMACT – Keluhan dengan No Tiket (XXXXX) Diinput Oleh (Nama User – Nama Role)
02 Tiket diteruskan			      => Service Provider dengan unit yang sesuai dengan bidang keluhan dan Regional sesuai dengan Ruas
                                 JMACT – Keluhan dengan No Tiket (XXXXX) Diteruskan Oleh (Nama User – Nama Role)
03 On Progress					      => Regional sesuai dengan Ruas
                                 JMACT – Keluhan dengan No Tiket (XXXXX) sedang diproses Oleh (Nama User – Nama Role) – Estimasti Pengerjaan dalam (waktu SLA) hari
04 Submit Report				      => Regional sesuai dengan Ruas
                                 JMACT – (Nama User – Nama Role) telah submit report pengerjaan Keluhan dengan No Tiket (XXXXX)
05 Konfirmasi Pelanggan	      => Regional sesuai dengan Ruas dan Inputer pembuat laporan keluhan
                                 JMACT – Keluhan dengan No Tiket (XXXXX) telah mendapat konfirmasi Pelanggan
07 Closed						          => Regional sesuai dengan Ruas, Supervisor JMTC, Inputer Pembuat Laporan , Service Provider sesuai dengan bidang keluhan
                                 JMACT – Keluhan dengan No Tiket (XXXXX) Closed.
08 Overtime						        => Regional sesuai dengan Ruas
                                 JMACT – Keluhan dengan No Tiket (XXXXX) melewati batas estimasi pengerjaan oleh (Nama User – Nama Role)

Claim:
01 Tiket diinput				      => Supervisor JMTO
                                 JMACT – Claim dengan No Tiket (XXXXX) Diinput Oleh (Nama User – Nama Role)
02 Approve						        => Representative Office sesuai dengan Ruasnya
                                 JMACT – Claim dengan No Tiket (XXXXX) Approved Oleh (Nama User – Nama Role)
03 Rejected						        => Customer Service JMTO pembuat laporan Claim
                                 JMACT – Claim dengan No Tiket (XXXXX) Rejected Oleh (Nama User – Nama Role)
04 Tiket diteruskan			      => Service Provider sesuai bidang claim dan Regional sesuai dengan Ruas
                                 JMACT – Claim dengan No Tiket (XXXXX) Diteruskan Oleh (Nama User – Nama Role
05 Klarifikasi dan Negosiasi	=> Regional sesuai dengan Ruas
                                 JMACT – Claim dengan No Tiket (XXXXX) tahap Klarifikasi dan Negosiasi telah selesai Oleh (Nama User – Nama Role)
06 Pembayaran Selesai			    => Regional dan Representative Office sesuai dengan Ruas
                                 JMACT – Claim dengan No Tiket (XXXXX) tahap Pembayaran telah selesai Oleh (Nama User – Nama Role)
08 Closed						          => Supervisor JMTO, Customer Service JMTO pembuat claim, Representative Office, Regional sesuai Ruas dan Service Provider.
                                 JMACT – Claim dengan No Tiket (XXXXX) Closed.

*/
        if ((! isset($data['no_tiket'])) || (! isset($data['status_id']))) return false;

        $no_tiket = $data['no_tiket'];
        $master_status = MasterStatus::where('id', $data['status_id'])->first(['code']);

        $user_name = auth()->user()->name ?? auth()->user()->username;
        $user_role = auth()->user()->roles()->first()->name;

        $data_onbell = ['unit_id' => $data->unit_id*1, 'target_id' => $data->id, 'target_type' => $data->filesMorphClass() ];

        if ($master_status) {
            $status = $master_status['code'];
            if ($no_tiket[0] == 'K') {
                switch ($status) {
                    case '01':
                        $user_ids = User::role('Supervisor JMTC')->get(['id'])->pluck('id')->toArray();
                        $device_tokens = UserDevice::whereIn('user_id', $user_ids)->get(['token'])->pluck('token')->toArray();
                        $message = "Keluhan dengan No Tiket (".$no_tiket.") Diinput oleh (".$user_name." – ".$user_role.")";
                        self::notifier($user_ids, $device_tokens, "Keluhan ".$no_tiket, $data_onbell, "JMACT Notification for Supervisor JMTC", $message);
                        break;

                    case '02':
                        // $user_ids = User::role('Service Provider')->get(['id'])->pluck('id')->toArray();
                        // roles()->first()->ro_id
                        // $device_tokens = UserDevice::whereIn('user_id', $user_ids)->get(['token'])->pluck('token')->toArray();
                        // $message = "Keluhan dengan No Tiket (".$no_tiket.") Diteruskan oleh (".$user_name." – ".$user_role.")";
                        // self::notifier($user_ids, $device_tokens, "Keluhan ".$no_tiket, $data_onbell, "JMACT Notification for Service Provider", $message);
                        break;

                    case '03':
                        break;
                    case '04':
                        break;
                    case '05':
                        break;
                    case '06':
                        break;
                    case '07':
                        break;
                    case '08':
                        break;
                }
            } else if ($no_tiket[0] == 'C') {
                switch ($status) {
                    case '01':
                        $user_ids = User::role('Supervisor JMTO')->get(['id'])->pluck('id')->toArray();
                        $device_tokens = UserDevice::whereIn('user_id', $user_ids)->get(['token'])->pluck('token')->toArray();
                        $message = "Claim dengan No Tiket (".$no_tiket.") Diinput oleh (".$user_name." – ".$user_role.")";
                        self::notifier($user_ids, $device_tokens, "Claim ".$no_tiket, $data_onbell, "JMACT Notification for Supervisor JMTO", $message);
                        break;

                    case '02':
                        break;
                    case '03':
                        break;
                    case '04':
                        break;
                    case '05':
                        break;
                    case '06':
                        break;
                    case '07':
                        break;
                    case '08':
                        break;
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
