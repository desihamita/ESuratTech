<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;

class StatusSuratController extends Controller
{
    public function index(){
        
        $statusDikirim = Letter::with('dispositions')
        ->whereHas('dispositions', function ($query) {
            $query->where('status', 'dikirim');
        })->get();

        $statusDiterima = Letter::with('dispositions')
        ->whereHas('dispositions', function ($query) {
            $query->where('status', 'diterima');
        })->get();

        $statusDibaca = Letter::with('dispositions')
        ->whereHas('dispositions', function ($query) {
            $query->where('status', 'dibaca');
        })->get();


        $data=[
            'title'=>'Status Surat',
            'statusDikirim'=> $statusDikirim,
            'statusDiterima'=> $statusDiterima,
            'statusDibaca'=> $statusDibaca,
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'Status Surat', 'url' => ''],

        ],
    ];
        return view('pages.status_surat.index', $data);
    }
}
