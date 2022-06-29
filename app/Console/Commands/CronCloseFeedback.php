<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronCloseFeedback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:close:feedback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set every open feedback that overdue to status CLOSED, Keluhan 05->07, Claim 08->10';

    // Keluhan: Status 05 Konfirmasi Pelanggan & updated_at+7 > now() set status 07 closed
    // Klaim:   Status 08 Pembayaran Selesai & updated_at+7 > now() set status 10 closed

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $from_where = "
FROM	keluhan
		LEFT JOIN master_status ON master_status.id = keluhan.status_id
WHERE	DATE_ADD(keluhan.updated_at, INTERVAL 7 DAY) < NOW()
		AND master_status.status = 'Konfirmasi Pelanggan'
";
        $select_info = "SELECT keluhan.no_tiket, keluhan.updated_at, DATE_ADD(keluhan.updated_at, INTERVAL 7 DAY) AS feedback_expired";
        $select_id = "SELECT keluhan.id";

        $query_info = json_encode(\DB::select($select_info.$from_where));
        $query_ids = \Collect(\DB::select($select_id.$from_where))->pluck('id')->toArray();

        $keluhan_closed = \App\Models\MasterStatus::where('status', 'Closed')->where('type', 1)->value('id');
        \App\Models\KeluhanPelanggan::whereIn('id', $query_ids)->update(['status_id' => $keluhan_closed]);

        \App\Models\SysLog::write('Auto Close Feedbacks Keluhan '. $query_info);

        $from_where = "
FROM	claim
        LEFT JOIN master_status ON master_status.id = claim.status_id
WHERE	DATE_ADD(claim.updated_at, INTERVAL 7 DAY) < NOW()
        AND master_status.status = 'Pembayaran Selesai'
";
        $select_info = "SELECT claim.no_tiket, claim.updated_at, DATE_ADD(claim.updated_at, INTERVAL 7 DAY) AS feedback_expired";
        $select_id = "SELECT claim.id";

        $query_info = json_encode(\DB::select($select_info.$from_where));
        $query_ids = \Collect(\DB::select($select_id.$from_where))->pluck('id')->toArray();

        $claim_closed = \App\Models\MasterStatus::where('status', 'Closed')->where('type', 2)->value('id');
        \App\Models\ClaimPelanggan::whereIn('id', $query_ids)->update(['status_id' => $claim_closed]);

        \App\Models\SysLog::write('Auto Close Feedbacks Claim '. $query_info);

        // dd($keluhan_overdue, $keluhan_closed, $claim_overdue, $claim_closed);

        return 0;
    }
}
