<?php

namespace App\Http\Controllers;

use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    function index() 
    {
        return view('dashboard.profile.index');
    }

    function update(Request $request)
    {
        $request->validate([
            '_foto'=>'mimes:png,jpg,jpeg,gif',
            '_email'=>'required|email'
        ],[
            '_foto.mimes'=>'Foto yang dimasukkan hanya diperbolehkan berekstensi JPEG, JPG, PNG, dan GIF',
            '_email.required'=>'Email wajib diisi',
            '_email.email'=>'Format email yang dimasukkan tidak valid'
        ]);

        if ($request->hasfile('_foto')) {
            $foto_file = $request->file('_foto');
            $foto_ekstensi = $foto_file->extension();
            $foto_baru = date('ymdhis') . ".$foto_ekstensi";
            $foto_file->move(public_path('foto'), $foto_baru);
            // Jika ada update foto
            $foto_lama = get_meta_value('_foto');
            File::delete(public_path('foto') . "/" . $foto_lama);

            Metadata::updateOrCreate(['meta_key' => '_foto'], ['meta_value' => $foto_baru]);
        }

        Metadata::updateOrCreate(['meta_key' => '_email'], ['meta_value' => $request->_email]);
        Metadata::updateOrCreate(['meta_key' => '_kota'], ['meta_value' => $request->_kota]);
        Metadata::updateOrCreate(['meta_key' => '_provinsi'], ['meta_value' => $request->_provinsi]);
        Metadata::updateOrCreate(['meta_key' => '_nohp'], ['meta_value' => $request->_nohp]);

        Metadata::updateOrCreate(['meta_key' => '_facebook'], ['meta_value' => $request->_facebook]);
        Metadata::updateOrCreate(['meta_key' => '_twitter'], ['meta_value' => $request->_twitter]);
        Metadata::updateOrCreate(['meta_key' => '_linkedin'], ['meta_value' => $request->_linkedin]);
        Metadata::updateOrCreate(['meta_key' => '_github'], ['meta_value' => $request->_github]);

        return redirect()->route('profile.index')->with('success', 'Berhasil melakukan update data profile');
    }
}
