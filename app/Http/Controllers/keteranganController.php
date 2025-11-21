<?php

namespace App\Http\Controllers;

use App\Models\Keterangan;
use Illuminate\Http\Request;

class keteranganController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'listketerangan' => 'required',
        ]);

        $keterangan = Keterangan::create([
            'listketerangan' => $request->listketerangan,
        ]);

        return response()->json($keterangan);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:keterangan,id',
        ]);

        Keterangan::destroy($request->id);

        return response()->json(['message' => 'Keterangan berhasil dihapus.']);
    }
}
