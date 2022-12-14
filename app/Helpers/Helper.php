<?php

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Carbon\Carbon;

function sendMail($view, $subject, $email, $record = [], $users = [])
{
    Mail::to($email)->send(new SendMail($view, $subject, $email, $record, $users));
}

function sendMailQueue($view, $subject, $email, $record = [], $users = [])
{
    Mail::to($email)->queue(new SendMail($view, $subject, $email, $record, $users));
}

function existUrl($path = null)
{
    $paths = asset('storage/' . $path);
    if (@getimagesize($paths) || file_exists($paths)) {
        $thumbnail = $paths;
    } else {
        $thumbnail = asset('no-images.png');
    }
    return $thumbnail;
}


function moneyFormat($money)
{
    return 'Rp. ' . number_format((int)$money, 2, ",", ".");
}


function textarea($text)
{
    $new = '';

    $new = str_replace("\n", "<br>", $text);

    return $new;
}


function readMoreText($value, $maxLength = 150)
{
    $return = textarea($value);
    if (strlen($value) > $maxLength) {
        $return = substr(textarea($value), 0, $maxLength);
        $readmore = substr(textarea($value), $maxLength);

        $return .= '<a href="javascript: void(0)" class="read-more" onclick="$(this).parent().find(\'.read-more-cage\').show(); $(this).hide()" style="color: #009245">&nbsp;&nbsp; Selengkapnya... </a>';

        $readless = '<a href="javascript: void(0)" class="read-less" onclick="$(this).parent().parent().find(\'.read-more\').show(); $(this).parent().hide()" style="color: #009245">&nbsp;&nbsp; Kecilkan... </a>';

        $return = "<span>{$return}<span style='display: none' class='read-more-cage'>{$readmore} {$readless}</span></span>";
    }
    return $return;
}

function makeButton($params = [])
{
    $settings = [
        'id'    => '',
        'class'    => 'blue',
        'label'    => 'Button',
        'tooltip'  => '',
        'target'   => url('/'),
        'disabled' => '',
        'url' => '',
        'value' => '',
    ];

    $btn = '';
    $datas = '';
    $attrs = '';

    if (isset($params['datas'])) {
        foreach ($params['datas'] as $k => $v) {
            $datas .= " data-{$k}=\"{$v}\"";
        }
    }

    if (isset($params['attributes'])) {
        foreach ($params['attributes'] as $k => $v) {
            $attrs .= " {$k}=\"{$v}\"";
        }
    }

    switch ($params['type']) {
        case "deleteAll":

            $settings['class']   = 'removeAll checkbox-select';
            $settings['label']   = 'checkbox checkbox-outline checkbox-outline-2x checkbox-primary';
            $settings['tooltip'] = 'Hapus Data';
            $settings['disabled'] = '';

            $params  = array_merge($settings, $params);
            $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";
            $btn = "<label class='{$params['label']}'>
                    <input type=\"checkbox\" name=\"id[]\" value='{$params['value']}' class='{$params['class']}' {$datas}{$attrs}{$extends}/>
                    <span></span>
                </label>\n";
            break;

        case "delete":
            $settings['class']   = 'm-l btn btn-icon btn-danger btn-sm delete-data btn-hover-light';
            $settings['label']   = '<i class="flaticon-delete-1 "></i>';
            $settings['tooltip'] = 'Hapus Data';
            $settings['disabled'] = '';

            $params  = array_merge($settings, $params);
            $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";
            $btn = "<a href=\"#\" {$datas}{$attrs}{$extends} class='{$params['class']} " . ($params['disabled'] ? 'disabled' : '') . "' data-toggle=\"tooltip\" data-theme=\"dark\" title=\"{$params['tooltip']}\">
        {$params['label']}
        </a>\n";
            break;

        case "modal":
            $settings['onClick'] = '';
            $settings['class']   = 'btn btn-icon btn-warning btn-sm btn-hover-light custome-modal';
            $settings['label']   = '<i class="flaticon-edit-1"></i>';
            $settings['tooltip'] = 'Ubah Data';
            $settings['modal'] = '#largeModal';

            $params  = array_merge($settings, $params);
            $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

            $btn = "<button type='button' {$datas}{$attrs}{$extends}
        class='{$params['class']} " . ($params['disabled'] ? 'disabled' : '') . "'
        onclick='{$params['onClick']}'
        data-toggle=\"tooltip\"
        data-theme=\"dark\"
        data-modal=\"{$params['modal']}\"
        data-url=\"{$params['url']}\"
        title=\"{$params['tooltip']}\"
        {$params['disabled']}
        >
        {$params['label']}
        </button>\n";
            break;
        case "url":
        default:
            $settings['onClick'] = '';
            $settings['class']   = 'btn btn-icon btn-warning btn-sm btn-hover-light';
            $settings['label']   = '<i class="flaticon-edit-1 "></i>';
            $settings['tooltip'] = 'Ubah Data';

            $params  = array_merge($settings, $params);
            $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

            $btn = "<a href=\"{$params['url']}\" {$datas}{$attrs}{$extends}
        class='{$params['class']}'
        onclick='{$params['onClick']}'
        data-toggle=\"tooltip\"
        data-theme=\"dark\"
        title=\"{$params['tooltip']}\"
        {$params['disabled']}
        >
        {$params['label']}
        </a>\n";
            break;
    }

    return $btn;
}

function ButtonSED($data, $route_type, $permission_type)
{
    $button = '';
    // $button = ' <a class="btn btn-icon btn-light btn-sm btn-hover-warning" href="'.  route($route_type.'.show',Crypt::encrypt($data->id)) .'" data-toggle="tooltip"  data-theme="dark" title="Show">
    // '. Metronic::getSVGController("media/svg/icons/General/Settings-1.svg", "svg-icon-md svg-icon-warning") .'
    // </a>';
    if (auth()->user()->can($permission_type . '.edit')) {
        $button .= ' <a class="btn btn-icon btn-light btn-sm btn-hover-primary" href="' .  route($route_type . '.edit', Crypt::encrypt($data->id)) . '" data-toggle="tooltip"  data-theme="dark" title="Edit">
        ' . Metronic::getSVGController("media/svg/icons/Communication/Write.svg", "svg-icon-md svg-icon-primary") . '
        </a>';
    }
    if (auth()->user()->can($permission_type . '.delete')) {
        $button .= ' <button class="btn btn-icon btn-light btn-sm btn-delete btn-hover-danger" data-remote="' . route($route_type . '.destroy', Crypt::encrypt($data->id)) . '" data-toggle="tooltip"  data-theme="dark" title="Delete">
        ' . Metronic::getSVGController("media/svg/icons/General/Trash.svg", "svg-icon-md svg-icon-danger") . '
        </button>';
    }

    return $button;
}

function eventType($type)
{
    $return = "";
    switch ($type) {
        case 'created':
            $return = '<span class="label label-success label-pill label-inline mr-2">' . $type . '</span>';
            break;

        case 'updated':
            $return = '<span class="label label-warning label-pill label-inline mr-2">' . $type . '</span>';
            break;

        case 'deleted':
            $return = '<span class="label label-danger label-pill label-inline mr-2">' . $type . '</span>';
            break;
        default:
            # code...
            break;
    }

    return $return;
}

function createdAt($created)
{
    return "<b>" . date('Y-m-d H:i:s', strtotime($created)) . "</b><br> " . Carbon::parse($created)->diffForHumans() . " ";
}

function getActive($record)
{
    $result = 'Non-Active';
    if ($record == true) {
        $result = 'Active';
    }

    return $result;
}

function getTiket($record = null)
{
    $noTiket = '-';
    if ($record) {
        $sumber = ($record->sumber) ? $record->sumber->code : null;
        $unit = ($record->user->unit) ? $record->user->unit->code : null;
        // $count = App\Models\KeluhanPelanggan::where('sumber_id', $record->sumber_id)
        //     ->where('unit_id',$record->unit_id)->count() + 1;
        //$noTiket = $sumber.$unit.$count;
        $ret = \App\Models\TicketCounter::reserve($record->keterangan_keluhan, 'K', $sumber, $unit);
        if ($ret['result']) {
            $noTiket = $ret['data']['no_tiket'];
            // dd('no_tiket: '.$noTiket);
        } else {
            dd('error', $ret);
        }
    }

    return $noTiket;
}

function getTiketClaim($record = null)
{
    $noTiket = '-';
    if ($record) {
        $sumber = ($record->sumber) ? $record->sumber->code : null;
        $unit = ($record->user->unit) ? $record->user->unit->code : null;
        // $count = App\Models\ClaimPelanggan::where('unit_id',$record->unit_id)->count() + 1;
        // $noTiket = $unit.$count;
        $ret = \App\Models\TicketCounter::reserve($record->keterangan_claim, 'C', $sumber, $unit);
        if ($ret['result']) {
            $noTiket = $ret['data']['no_tiket'];
            // dd('no_tiket: '.$noTiket);
        } else {
            dd('error', $ret);
        }
    }

    return $noTiket;
}

function stringToArray($data)
{
    $result = '-';
    if ($data) {
        $result = explode('\\', $data);
        $result = end($result);
    }
    return $result;
}

function getRoute()
{
    return (@\Route::getCurrentRoute()->controller->route) ? \Route::getCurrentRoute()->controller->route : null;
}



function getRouteMid()
{
    $route = (@\Route::getCurrentRoute()->controller->route) ? \Route::getCurrentRoute()->controller->route : null;
    $data = [$route . ".index", $route . ".create", $route . ".edit", $route . ".show", $route . ".delete", $route . ".download", $route . ".approval", $route . ".detail", $route . ".forward", $route . ".sla", $route . ".stage", $route . ".expand", $route . ".contact"];

    return $data;
}

function changenamePermission($data)
{
    $result = $data;
    if ($data == "index") {
        $result = "";
    } else if ($data == "expand") {
        $result = "histori_tiket";
    } else if ($data == "sla") {
        $result = "pengerjaan_keluhan";
    } else if ($data == "stage") {
        $result = "tahapan";
    } else if ($data == "Claim") {
        $result = "Klaim";
    } else if ($data == "Jenis Claim") {
        $result = "Jenis Klaim";
    }

    return $result;
}
