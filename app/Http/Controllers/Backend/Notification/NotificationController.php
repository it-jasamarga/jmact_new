<?php

namespace App\Http\Controllers\Backend\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Helpers\HelperFirestore;

use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class NotificationController extends Controller
{
    public $breadcrumbs = [
        ['name' => "Notifikasi"],
        ['link' => "#", 'name' => "Notifikasi"],
        ['link' => "notifikasi", 'name' => "Notifikasi"]
    ];

    public function __construct()
    {
        $this->route = 'notification';
        $this->firebase = new HelperFirestore();
    }

    public function index()
    {
        $notif = $this->firebase->collection('notifications', auth()->user()->id);
        $paginate = $this->paginate(collect($notif));
        // dd($paginate);
        // $data  = Notification::whereHas('unit', function ($q) {
        //     $q->where('user_id', auth()->user()->id);
        // })->orderByDesc('created_at')->paginate(10);

        return view('backend.notification.index', [
            'record' => $paginate
        ]);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function updateStatus()
    {
        // $notif = $this->firebase->updateData([
        //     'status' => 'Read'
        // ],
        // 'notifications',
        // request()->firebaseId
        // );
        // dd($notif);
        // $record = Notification::find(request()->id);
        if (true) {
            $record->status = 'Read';
            $record->save();
            return response([
                'status' => true,
                'message' => 'success',
            ]);
        } else {
            return response([
                'status' => false,
                'message' => 'failed',
            ], 500);
        }
    }
}
