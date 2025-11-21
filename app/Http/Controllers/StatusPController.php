<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statusp;

class StatusPController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required',
        ]);

        $status = \App\Models\Statusp::create([
            'nama_status' => $request->nama_status,
        ]);

        return response()->json($status);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:statusp,id',
        ]);

        \App\Models\Statusp::destroy($request->id);

        return response()->json(['message' => 'Status berhasil dihapus.']);
    }
}
