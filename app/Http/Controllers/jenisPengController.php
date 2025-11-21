<?php

namespace App\Http\Controllers;

use App\Models\JenisPeng;
use Illuminate\Http\Request;

class jenisPengController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ]);

        $jenis = JenisPeng::create([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return response()->json($jenis);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:jenispeng,id', //jenispeng ini dari nama tabel
        ]);

        JenisPeng::destroy($request->id);

        return response()->json(['message' => 'Jenis Pengeluaran berhasil dihapus.']);
    }
}
