<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use App\Models\Metadata;
use Illuminate\Http\Request;

class PengaturanHalamanController extends Controller
{
    function index ()
    {
        $datahalaman = Halaman::orderBy('judul', 'asc')->get();
        return view('dashboard.pengaturanhalaman.index')->with('datahalaman', $datahalaman);
    }

    function update (Request $request)
    {
        Metadata::updateOrCreate(['meta_key'=>'_halaman_about'], ['meta_value'=>$request->_halaman_about]);
        Metadata::updateOrCreate(['meta_key'=>'_halaman_interest'], ['meta_value'=>$request->_halaman_interest]);
        Metadata::updateOrCreate(['meta_key'=>'_halaman_award'], ['meta_value'=>$request->_halaman_award]);

        return redirect()->route('pengaturanhalaman.index')->with('success', 'Berhasil update data');
    }
}
