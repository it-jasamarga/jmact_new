<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Models\StatistikKeluhan;

class StatistikKeluhanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:StatistikKeluhanCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Statistik Keluhan';

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
        // StatistikKeluhan
        // $date = Carbon::now()->format('Y-m-d');
        // $record = KeluhanPelanggan::with('mulaiSla')->whereHas('mulaiSla',function($q) use($date){
        //     $q->whereDate('date', '<', $date);
        // })->get();

        // if($record->count() > 0){
        //     foreach($record as $k => $value){
        //         // $this->firebase->sendGroup(
        //         //     $value, 
        //         //     'JMACT - Keluhan Melewati Batas SLA ', 
        //         //     'Keluhan Dengan No Tiket '.$value->no_tiket.' Telah Melewati Batas Waktu'
        //         // );
        //     }
        // }
    }
}
