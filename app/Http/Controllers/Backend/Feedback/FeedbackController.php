<?php

namespace App\Http\Controllers\Backend\Feedback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public $breadcrumbs = [
        ['name' => "Feedback Pelanggan"], 
        ['link' => "#", 'name' => "Feedback Pelanggan"],
        ['link' => "feedback-pelanggan", 'name' => "Feedback Pelanggan"]
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->route = 'feedback-pelanggan';
    }

    public function index()
    {
        $data = [
            'title' => 'Feedback Pelanggan',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
        ];
        return view('backend.feedback-pelanggan.index', $data);
    }

    public function detail(Request $request, $no_tiket)
    {
      $data = [
        'route' => $this->route,
        'kepuasan' => [
          1 => "sangat tidak puas",
          2 => "tidak puas",
          3 => "cukup puas",
          4 => "puas",
          5 => "sangat puas",
        ],
        'record' => \App\Models\Feedback::where('no_tiket', $no_tiket)->first()
      ];

      return view('backend.feedback-pelanggan.detail', $data);
    }

    private function humanDateDiff($date) {
      $diff = (new \DateTime($date))->diff(new \DateTime());
      
      $lookup = [
          'y' => 'tahun',
          'm' => 'bulan',
          'd' => 'hari',
          'h' => 'jam',
          'i' => 'menit',
      ];
      
      foreach ($lookup as $property => $word) {
          if ($diff->$property) {
              if ($property === 'd' && $diff->$property >= 7) {
                  $diff->w = (int)($diff->$property / 7);
                  $property = 'w';
                  $word = 'minggu';
              }
              $output = "{$diff->$property} $word yang lalu";
              // $output = "{$diff->$property} $word yang lalu" . ($diff->$property !== 1 ? 's' : '');
              break;
          }
      }

      return $output ?? 'beberapa detik yang lalu';      
    }

    public function contact(Request $request, $no_tiket) {
      $IS_KELUHAN = strtoupper($no_tiket[0]) == "K";
      $status = \App\Models\MasterStatus::where('status', 'LIKE', "%Feedback%")->where('type', '=', $IS_KELUHAN ? 1 : 2)->first(['id']);
      $model = $IS_KELUHAN ? "\\App\\Models\\KeluhanPelanggan" : "\\App\\Models\\Claim";
      $query = $model::where('no_tiket', $no_tiket)->where('status_id', '=', $status->id)->first();
      // dd($status->toArray(), $query->toArray());
      if ($query) {
        \App\Models\FeedbackContactTracker::create([
          'no_tiket' => $no_tiket,
          'last_contact_at' => now(),
          'last_contact_by' => auth()->user()->id
        ]);
      }
      return redirect()->back();
    }

    public function list(Request $request) {  // FeedbackFilter $request
        $keluhan = DB::table('keluhan')
          ->select(
              'keluhan.no_tiket', 'keluhan.nama_cust AS nama_pelanggan',
              DB::raw('CONCAT(keluhan.no_telepon, "/", keluhan.sosial_media) AS no_telepon_sosial_media'),
              'feedback_contact_trackers.last_contact_at', 'users.username AS last_contact_by', 'feedback.id'
          )
          ->leftJoin(DB::raw("(SELECT no_tiket, MAX(id) AS last_id FROM feedback_contact_trackers GROUP BY no_tiket) link"), 'link.no_tiket', '=', 'keluhan.no_tiket')
          ->leftJoin('feedback_contact_trackers', 'feedback_contact_trackers.id', '=', 'link.last_id')
          ->leftJoin('users', 'users.id', '=', 'feedback_contact_trackers.last_contact_by')
          ->leftJoin('feedback', 'feedback.no_tiket', '=', 'keluhan.no_tiket')
          ->where('keluhan.status_id', '=', DB::raw('(SELECT id FROM master_status WHERE status LIKE "%Feedback%" AND type=1 LIMIT 1)'));

        $claim = DB::table('claim')
          ->select(
              'claim.no_tiket', 'claim.nama_pelanggan',
              DB::raw('CONCAT(claim.no_telepon, "/", claim.sosial_media) AS no_telepon_sosial_media'),
              'feedback_contact_trackers.last_contact_at', 'users.username AS last_contact_by', 'feedback.id'
          )
          ->leftJoin(DB::raw("(SELECT no_tiket, MAX(id) AS last_id FROM feedback_contact_trackers GROUP BY no_tiket) link"), 'link.no_tiket', '=', 'claim.no_tiket')
          ->leftJoin('feedback_contact_trackers', 'feedback_contact_trackers.id', '=', 'link.last_id')
          ->leftJoin('users', 'users.id', '=', 'feedback_contact_trackers.last_contact_by')
          ->leftJoin('feedback', 'feedback.no_tiket', '=', 'claim.no_tiket')
          ->where('claim.status_id', '=', DB::raw('(SELECT id FROM master_status WHERE status LIKE "%Feedback%" AND type=2 LIMIT 1)'));
        
        $data = $keluhan->union($claim)->get();

        return datatables()->of($data)
        ->addColumn('url_feedback', function ($data) use ($request) {
          $pair = substr(strtoupper(MD5($data->no_tiket)), -4);
          return "feedback.php?".$data->no_tiket.":".$pair;
        })
        ->addColumn('last_contact', function ($data) use ($request) {
          return is_null($data->id) ? (is_null($data->last_contact_at) ? "belum pernah" : $this->humanDateDiff($data->last_contact_at) .' oleh '. $data->last_contact_by) : "feedback selesai";
        })
        ->addColumn('action', function($data) {
            $buttons = "";
            if(auth()->user()->can('feedback-pelanggan.contact') && is_null($data->id)) {
              $buttons .= makeButton([
                'type' => 'url',
                'url'   => 'feedback-pelanggan/contact/'.$data->no_tiket,
                'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light',
                'label'   => '<i class="flaticon2-phone"></i>',
                'tooltip' => 'Contact'
              ]);
            }
            
            if(auth()->user()->can('feedback-pelanggan.detail') && !is_null($data->id)) {
              $buttons .= makeButton([
                'type' => 'modal',
                'url'   => 'feedback-pelanggan/detail/'.$data->no_tiket,
                'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light custome-modal',
                'label'   => '<i class="flaticon2-list-1"></i>',
                'tooltip' => 'Detail Feedback'
              ]);
            }
            
            return $buttons;
          })
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }


}
