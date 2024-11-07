<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterOut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $useraktif = User::where('id', Auth::user()->id)->count();
        $countLeters_in = Letter::count();
        $countLeters_out = LetterOut::count();
        $title = 'Dashboard';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/'],
        ];

        $hour = \Carbon\Carbon::now('Asia/Jakarta')->format('H');
        $greeting = '';

        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 17) {
            $greeting = 'Selamat Siang';
        } else {
            $greeting = 'Selamat Sore';
        }

        $user = Auth::user();
        $today = \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('dddd, D MMMM YYYY');

        return view('pages.home', compact('greeting', 'user', 'today', 'title', 'breadcrumbs', 'countLeters_in', 'countLeters_out', 'useraktif'));
    }
}

