<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;
use App\Models\Classification;
use Illuminate\Support\Facades\Validator;

class DisposisiController extends Controller
{
    public function index(){

        $disposisi = Disposisi::with('letter')->get();
        $klasifikasi = Classification::all();
    
        
        $data = [
            'title' => 'Disposisi',
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'Disposisi', 'url' => ''],
            ],
            'disposisi'=> $disposisi,
            'klasifikasi' => $klasifikasi,
        ];
        return view('pages.disposisi.index', $data);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'nomor_surat' => 'requirde',
            'penerima'=> 'required',
            'pengirim'=> 'required',
            'catatan'=> 'required',
            'perihal'=>'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $disposisi = new Disposisi();
            $disposisi->nomor_surat = $request->nomor_surat;
            $disposisi->penerima = $request->penerima;
            $disposisi->pengirim = $request->pengirim;
            $disposisi->catatan = $request->catatan;
            $disposisi->perihal = $request->perihal;
            $disposisi->status = $request->status;

            $disposisi->save();

            return redirect()->route('disposisi.index')->with('success','Data Berhasil Disimpan');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }

}
}