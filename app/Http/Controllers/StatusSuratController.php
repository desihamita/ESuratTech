<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;

class StatusSuratController extends Controller
{
    public function index(){
        
        $statusPending = Letter::with('dispositions')
        ->whereHas('dispositions', function ($query) {
            $query->where('status', 'Pending');
        })->get();

        $statusProses = Letter::with('dispositions')
        ->whereHas('dispositions', function ($query) {
            $query->where('status', 'Processed');
        })->get();

        $statusCompleted = Letter::with('dispositions')
        ->whereHas('dispositions', function ($query) {
            $query->where('status', 'Completed');
        })->get();

        $statusReject = Letter::with('dispositions')
        ->whereHas('dispositions', function ($query) {
            $query->where('status', 'Rejected');
        })->get();

        $data=[
            'title'=>'Status Surat',
            'statusCompleted'=> $statusCompleted,
            'statusPending'=> $statusPending,
            'statusProses'=> $statusProses,
            'statusReject'=> $statusReject,
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'Status Surat', 'url' => ''],

        ],
    ];
        return view('pages.status_surat.index', $data);
    }
}
