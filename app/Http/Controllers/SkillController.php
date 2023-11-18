<?php

namespace App\Http\Controllers;

use App\Models\Metadata;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skill_url = public_path('admin/devicon.json');
        $skill_data = file_get_contents($skill_url);
        $skill_data = json_decode($skill_data, true);
        $skill = array_column($skill_data, 'name');
        $skill = "'".implode("','", $skill)."'";

        return view('dashboard.skill.index')->with(['skill' => $skill]);
    }

    public function update(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                '_language'=>'required',
                '_workflow'=>'required'
            ], [
                '_laguange.required'=>'Silahkan masukkan bahasa pemrograman yang di kuasai',
                '_workflow.required'=>'Silahkan masukkan workflow yang di kuasai'
            ]);

            Metadata::updateOrCreate(['meta_key' => '_language'], ['meta_value' => $request->_language]);
            Metadata::updateOrCreate(['meta_key' => '_workflow'], ['meta_value' => $request->_workflow]);
    
            return redirect()->route('skill.index')->with('success', 'Berhasil melakukan update data skill');
        }
    }
}
