<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    public function index(){

        
        $data = [
            'title' => 'Disposisi',
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'Disposisi', 'url' => ''],
            ],
            'disposisi' => Disposisi::with('letter')->get(),
        ];
        return view('pages.disposisi.index', $data);
    }
}
