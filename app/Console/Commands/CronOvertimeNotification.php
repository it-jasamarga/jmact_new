<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronOvertimeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:overtime:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to Regional (of Keluhan) when there is overtime process';

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

/* SQL

SELECT	keluhan.no_tiket, master_regional.id AS regional_id, master_regional.name AS regional_name, users.id AS user_id, users.name AS user_name
FROM	keluhan
		LEFT JOIN master_ruas ON master_ruas.id = keluhan.ruas_id
		LEFT JOIN master_ro ON master_ro.id = master_ruas.ro_id
		LEFT JOIN master_regional ON master_regional.id = master_ro.regional_id
		LEFT JOIN roles ON roles.regional_id = master_regional.id
		LEFT JOIN role_users ON role_users.role_id = roles.id        
		LEFT JOIN users ON users.id = role_users.user_id        
WHERE	keluhan.deadline < now()
		AND roles.type_id = (SELECT master_type.id FROM master_type WHERE master_type.type = 'Regional')
		AND keluhan.status_id IN
(
SELECT	master_status.id
FROM	master_status
WHERE	master_status.status IN ("On Progress", "Submit Report")
)
;

^([^\s]+)\sON\s([^\s]+)\s=\s([^\s]+)\s*$
->leftJoin\('\1', '\2', '=', '\3'\)

*/

        $regional_type_id = \App\Models\MasterType::where('type', "Regional")->value('id');

        $status_ids = \App\Models\MasterStatus::whereIn('status', ["On Progress", "Submit Report"])->get(['id'])->pluck('id')->toArray();

        $overtime = \DB::table('keluhan')
            ->leftJoin('master_ruas', 'master_ruas.id', '=', 'keluhan.ruas_id')
            ->leftJoin('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
            ->leftJoin('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
            ->leftJoin('roles', 'roles.regional_id', '=', 'master_regional.id')
            ->leftJoin('role_users', 'role_users.role_id', '=', 'roles.id')
            ->leftJoin('users', 'users.id', '=', 'role_users.user_id')
            ->whereRaw('keluhan.deadline < now()')
            ->where('roles.type_id', $regional_type_id)
            ->where('users.id', '<>', '""')
            ->whereIn('keluhan.status_id', $status_ids)
            ->selectRaw('keluhan.id AS keluhan_id, keluhan.no_tiket, master_regional.id AS regional_id, master_regional.name AS regional_name, users.id AS user_id, users.name AS user_name')
            ->get();
        $overtime_by_regional = $overtime->groupBy('regional_name');
        foreach($overtime_by_regional as $key => $records) {
            $no_tikets = $records->pluck('no_tiket', 'keluhan_id')->toArray();
            $user_names = $records->pluck('user_name', 'user_id')->toArray();
            $overtime_by_regional[$key] = [
                'no_tikets' => $no_tikets,
                'user_names' => $user_names,
                'user_ids' => array_keys($user_names)
            ];
        }

        \App\Helpers\HelperFirestore::notifyOvertime($overtime_by_regional->toArray());

        return 0;
    }
}
