<?php

namespace App\Http\Controllers;

use App\Models\Detaillokasi;
use Illuminate\Http\Request;

class DetailLokasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'detail_lokasi' => 'required',
        ]);

        $detaillokasi = Detaillokasi::create([
            'detail_lokasi' => $request->detail_lokasi,
        ]);

        return response()->json($detaillokasi);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:detaillokasi,id',
        ]);

        Detaillokasi::destroy($request->id);

        return response()->json(['message' => 'Detail Lokasi berhasil dihapus.']);
    }
}
