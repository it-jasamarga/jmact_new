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

use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class HelperFirestore
{
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
          'image' => url('jmact.png'),
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
        
        $Notification = Notification::create($array);

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
          'image' => url('jmact.png'),
        ])->withData([
          'image' => url('jmact.png'),
          "id" => $data->id,
          "type" => $data->filesMorphClass(),
          "click_action" => "FLUTTER_NOTIFICATION_CLICK",
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
