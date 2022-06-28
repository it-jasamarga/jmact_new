<?php

namespace App\Http\Controllers\Backend\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;

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
    }

    public function index()
    {
        $data  = Notification::whereHas('unit', function ($q) {
                    $q->where('unit_id', auth()->user()->unit_id);
                })->orderByDesc('created_at')->paginate(10);

        return view('backend.notification.index', [
            'record' => $data
        ]);
    }

}
