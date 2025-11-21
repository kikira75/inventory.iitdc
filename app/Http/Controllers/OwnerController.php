<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_owner' => 'required',
        ]);

        $status = Owner::create([
            'nama_owner' => $request->nama_owner,
        ]);

        return response()->json($status);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:owner,id',
        ]);

        Owner::destroy($request->id);

        return response()->json(['message' => 'Nama Owner berhasil dihapus.']);
    }
}
