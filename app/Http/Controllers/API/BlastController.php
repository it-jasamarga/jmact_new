<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlastController extends Controller
{
    public function __construct(Request $request)
    {
        $secret = "JMACT:WA-BLAST";
        if ($request->header('api-secret') !== $secret) return abort(403);
    }

    public function getZeroBlast(Request $request)
    {
        $data = [];
        $query = \App\Models\Blast::where('blast_state', 0)->get(['id', 'no_telepon', 'nama', 'no_tiket', 'attributes']);
        foreach ($query as $record) {
            $data[] = [
                'id'            => $record->id,
                'no_telepon'    => $record['no_telepon'],
                'nama'          => $record['nama'],
                'no_tiket'      => $record['no_tiket'],
                'type'          => ($record['no_tiket'][0] == 'K' ? 'keluhan' : 'klaim'),
                'attributes'    => json_decode($record['attributes'])
            ];
        }

        return response()->json($data);
    }

    public function setBlastState(Request $request)
    {
        $succeed = [];
        $failed = [];
        $data = json_decode($request->getContent());
        foreach ($data as $item) {
            $record = \App\Models\Blast::where('id', $item->id)->first();
            if ($record) {
                $state = $item->blast*1;
                $record->update(['blast_state' => $state]);
                $succeed[$item->id] = $state;
            } else {
                $failed[] = $item->id;
            }
        }
        $retr = ['succeed' => $succeed, 'failed' => $failed];

        return response()->json($retr);
    }
}
