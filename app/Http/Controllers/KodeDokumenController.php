<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\KodeDokumen;
use App\Models\Perusahaan;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class KodeDokumenController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kode_dokumen,kode',
            'label' => 'required'
        ]);

        $dokumen = \App\Models\KodeDokumen::create([
            'kode' => $request->kode,
            'label' => $request->label
        ]);

        return response()->json($dokumen);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'kode' => 'required|exists:kode_dokumen,kode',
        ]);

        KodeDokumen::where('kode', $request->kode)->delete();

        return response()->json(['success' => true]);
    }
    

}
