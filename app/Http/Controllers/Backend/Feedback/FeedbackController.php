<?php

namespace App\Http\Controllers\Backend\Feedback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    // private $route = 'feedback-pelanggan';

    private $kepuasan = [
      1 => "sangat tidak puas",
      2 => "tidak puas",
      3 => "cukup puas",
      4 => "puas",
      5 => "sangat puas",
    ];

    public $breadcrumbs = [
        ['name' => "Feedback Pelanggan"],
        ['link' => "#", 'name' => "Feedback Pelanggan"],
        ['link' => "feedback-pelanggan", 'name' => "Feedback Pelanggan"]
    ];

    public function __construct(Request $request)
    {
    //   $this->middleware(function ($request, $next) {
    //     $can_feedback = auth()->user()->hasPermissionTo('feedback-pelanggan.detail') || auth()->user()->hasPermissionTo('feedback-pelanggan.contact');
    //     try { if (! auth()->user()->hasPermissionTo($request->route()->getName())) abort(403); }
    //     catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) { if (! $can_feedback) abort(403); }
    //     return $next($request);
    //   });

      // $this->middleware('auth');
      $this->route = 'feedback-pelanggan';
      setlocale(LC_TIME, 'ID_id');
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
        'kepuasan' => $this->kepuasan,
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
      $statuses = \App\Models\MasterStatus::where('type', '=', $IS_KELUHAN ? 1 : 2)
        // ->where('status', 'LIKE', "%Feedback%")
        // ->orWhere('status', 'LIKE', $IS_KELUHAN ? "%Konfirmasi%" : "%Pembayaran%")
        // ->where('status', '=', $IS_KELUHAN ? "Konfirmasi Pelanggan" : "Pembayaran Selesai")
        ->whereIn('status', $IS_KELUHAN ? ["Konfirmasi Pelanggan", "Follow Up Feedback Pelanggan"] : ["Pembayaran Selesai", "Follow Up Feedback Pelanggan"])
        ->get(['id'])->pluck(['id'])->toArray();
      $model = $IS_KELUHAN ? "\\App\\Models\\KeluhanPelanggan" : "\\App\\Models\\ClaimPelanggan";
      $query = $model::where('no_tiket', $no_tiket)->whereIn('status_id', $statuses)->first();
      if ($query) {
        \App\Models\FeedbackContactTracker::create([
          'no_tiket' => $no_tiket,
          'last_contact_at' => now(),
          'last_contact_by' => auth()->user()->id
        ]);
        if (in_array($query->status->status, ["Konfirmasi Pelanggan", "Pembayaran Selesai"])) {
          $status_id = $query->status->id +1;
          $history = [
            'unit_id' => $query->unit_id,
            'status_id' => $status_id,
            'created_by' => auth()->user()->id
          ];
          $history[$IS_KELUHAN ? 'keluhan_id' : 'claim_id'] = $query->id;
          \App\Models\DetailHistory::create($history);
          $query->update(['status_id' => $status_id]);
        }

      }
      return redirect()->back();
    }

    public function list(Request $request) {  // FeedbackFilter $request
      // dd($request->input('no_tiket'), $request->input('status'));
        $keluhan = DB::table('keluhan')
          ->select(
              'keluhan.status_id',
              'keluhan.no_tiket', 'keluhan.nama_cust AS nama_pelanggan',
              'keluhan.no_telepon', 'keluhan.sosial_media',
              // DB::raw('CONCAT(keluhan.no_telepon, "/", keluhan.sosial_media) AS no_telepon_sosial_media'),
              'feedback_contact_trackers.last_contact_at', 'users.username AS last_contact_by', 'feedback.id',
              'feedback.saran_masukan', 'feedback.created_at AS feedback_at', 'feedback.no_telepon_sosial_media AS feedback_ntsm',
              'feedback.rating', 'feedback.ketidakpuasan'
          )
          ->leftJoin(DB::raw("(SELECT no_tiket, MAX(id) AS last_id FROM feedback_contact_trackers GROUP BY no_tiket) link"), 'link.no_tiket', '=', 'keluhan.no_tiket')
          ->leftJoin('feedback_contact_trackers', 'feedback_contact_trackers.id', '=', 'link.last_id')
          ->leftJoin('users', 'users.id', '=', 'feedback_contact_trackers.last_contact_by')
          ->leftJoin('feedback', 'feedback.no_tiket', '=', 'keluhan.no_tiket');
        if (! is_null($request->input('no_tiket'))) {
          $keluhan = $keluhan->where('keluhan.no_tiket', 'LIKE', "%".$request->input('no_tiket')."%");
        }
        if (! is_null($request->input('status'))) {
          switch($request->input('status')) {
            case "outstanding":
              $statuses = \App\Models\MasterStatus::where('type', '=', 1)
                // ->where('status', 'LIKE', "%Konfirmasi%")
                // ->orWhere('status', 'LIKE', "%Feedback%")
                // ->where('status', '=', "Konfirmasi Pelanggan")
                ->whereIn('status', ["Konfirmasi Pelanggan", "Follow Up Feedback Pelanggan"])
                ->get(['id'])->pluck(['id'])->toArray();
              $keluhan = $keluhan->whereIn('keluhan.status_id', $statuses);
              break;
            case "closed":
              $keluhan = $keluhan->where('keluhan.status_id', '=', DB::raw('(SELECT id FROM master_status WHERE status = "Closed" AND type=1 LIMIT 1)'));
              break;
          }
        } else {
          $keluhan = $keluhan->where('keluhan.status_id', '>=', DB::raw('(SELECT id FROM master_status WHERE status LIKE "%Konfirmasi%" AND type=1 LIMIT 1)'));
        }

        $claim = DB::table('claim')
          ->select(
              'claim.status_id',
              'claim.no_tiket', 'claim.nama_pelanggan',
              'claim.no_telepon', 'claim.sosial_media',
              // DB::raw('CONCAT(claim.no_telepon, "/", claim.sosial_media) AS no_telepon_sosial_media'),
              'feedback_contact_trackers.last_contact_at', 'users.username AS last_contact_by', 'feedback.id',
              'feedback.saran_masukan', 'feedback.created_at AS feedback_at', 'feedback.no_telepon_sosial_media AS feedback_ntsm',
              'feedback.rating', 'feedback.ketidakpuasan'
          )
          ->leftJoin(DB::raw("(SELECT no_tiket, MAX(id) AS last_id FROM feedback_contact_trackers GROUP BY no_tiket) link"), 'link.no_tiket', '=', 'claim.no_tiket')
          ->leftJoin('feedback_contact_trackers', 'feedback_contact_trackers.id', '=', 'link.last_id')
          ->leftJoin('users', 'users.id', '=', 'feedback_contact_trackers.last_contact_by')
          ->leftJoin('feedback', 'feedback.no_tiket', '=', 'claim.no_tiket');
        if (! is_null($request->input('no_tiket'))) {
          $claim = $claim->where('claim.no_tiket', 'LIKE', "%".$request->input('no_tiket')."%");
        }
        if (! is_null($request->input('status'))) {
          switch($request->input('status')) {
            case "outstanding":
              $statuses = \App\Models\MasterStatus::where('type', '=', 2)
                // ->where('status', 'LIKE', "%Pembayaran%")
                // ->orWhere('status', 'LIKE', "%Feedback%")
                // ->where('status', '=', "Pembayaran Selesai")
                ->whereIn('status', ["Pembayaran Selesai", "Follow Up Feedback Pelanggan"])
                ->get(['id'])->pluck(['id'])->toArray();
              $claim = $claim->whereIn('claim.status_id', $statuses);
              break;
            case "closed":
              $claim = $claim->where('claim.status_id', '=', DB::raw('(SELECT id FROM master_status WHERE status = "Closed" AND type=2 LIMIT 1)'));
              break;
          }
        } else {
          $claim = $claim->where('claim.status_id', '>=', DB::raw('(SELECT id FROM master_status WHERE status LIKE "%Pembayaran%" AND type=2 LIMIT 1)'));
        }

        $data = $keluhan->union($claim)->get();

        return datatables()->of($data)
        ->addColumn('ketidakpuasan', function ($data) use ($request) {
          $ktp = json_decode($data->ketidakpuasan);
          return is_array($ktp) ? implode(", ", $ktp) : "";
        })
        ->addColumn('rating', function ($data) use ($request) {
          return is_null($data->rating) ? "" : $this->kepuasan[$data->rating];
        })
        ->addColumn('no_telepon_sosial_media', function ($data) use ($request) {
          return ($data->no_telepon ?? "-") .'/'. ($data->sosial_media ?? "-");
        })
        ->addColumn('url_feedback', function ($data) use ($request) {
          $pair = substr(strtoupper(MD5($data->no_tiket)), -4);
          return "feedback.php?".$data->no_tiket.":".$pair;
        })
        ->addColumn('last_contact', function ($data) use ($request) {
          return is_null($data->id) ? (is_null($data->last_contact_at) ? "belum pernah" : $this->humanDateDiff($data->last_contact_at) .' oleh '. $data->last_contact_by) : "feedback selesai";
        })
        ->addColumn('last_contact_date', function ($data) use ($request) {
          return $data->last_contact_at;
        })
        ->addColumn('action', function($data) {
            $buttons = "";
            $status = \App\Models\MasterStatus::find($data->status_id);
            if(auth()->user()->can('feedback-pelanggan.contact') && is_null($data->id) && (in_array($status->status, ["Konfirmasi Pelanggan", "Follow Up Feedback Pelanggan", "Pembayaran Selesai", "Follow Up Feedback Pelanggan"]))) {
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
