<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'namalokasi' => 'required',
        ]);

        $lokasi = Lokasi::create([
            'namalokasi' => $request->namalokasi,
        ]);

        return response()->json($lokasi);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:lokasi,id',
        ]);

        Lokasi::destroy($request->id);

        return response()->json(['message' => 'Lokasi berhasil dihapus.']);
    }
}
