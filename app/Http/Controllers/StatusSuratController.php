<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusSuratController extends Controller
{
    public function index(){
        $data=[
            'title'=>'Status Surat',
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'Status Surat', 'url' => ''],

        ],
    ];
        return view('pages.status_surat.index', $data);
    }
}
