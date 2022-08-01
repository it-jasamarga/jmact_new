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

        try {
            $criterias = json_decode($request->getContent());
            if (! is_null($criterias)) {
                $query = \App\Models\Blast::where('id', '>', 0);
                foreach ($criterias as $name => $criteria) {
                    if (is_array($criteria)) {
                        $query = $query->whereIn($name, $criteria);
                    } else {
                        $query = $query->where($name, $criteria);
                    }
                }
                $query = $query->get();
            } else {
                $query = \App\Models\Blast::where('blast_state', 0)->get();
            }

            foreach ($query as $record) {
                $attr = json_decode($record['attributes']);
                $attr->blast = [
                    'state' => $record['blast_state'],
                    'text'  => $record['blast_text']
                ];
                $data[] = [
                    'id'            => $record->id,
                    'no_telepon'    => $record['no_telepon'],
                    'nama'          => $record['nama'],
                    'no_tiket'      => $record['no_tiket'],
                    'type'          => ($record['no_tiket'][0] == 'K' ? 'keluhan' : 'klaim'),
                    'attributes'    => $attr
                ];
            }
        } catch (\Exception $ex) {
            \App\Models\SysLog::write("getZeroBlast Exception [". $ex->getMessage() ."]");
        };

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
                $state = ($item->state ?? 0) *1;
                $record->update(['blast_state' => $state]);
                $succeed[$item->id] = $state;
            } else {
                $failed[] = $item->id;
            }
        }
        $retr = ['succeed' => $succeed, 'failed' => $failed];

        return response()->json($retr);
    }

    public function setBlastText(Request $request)
    {
        $succeed = [];
        $failed = [];
        $data = json_decode($request->getContent());
        foreach ($data as $item) {
            $record = \App\Models\Blast::where('id', $item->id)->first();
            if ($record) {
                $text = $item->text ?? null;
                $record->update(['blast_text' => $item->text]);
                $succeed[$item->id] = $text;
            } else {
                $failed[] = $item->id;
            }
        }
        $retr = ['succeed' => $succeed, 'failed' => $failed];

        return response()->json($retr);
    }
}
