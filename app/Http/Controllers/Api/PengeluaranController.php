<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\PengeluaranTransformer;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Pengeluaran::class);

        $pemasukan = Pengeluaran::with('asset')->with('user');
        
        $status = $request->input('status');

        if ($status == 'Deleted') {
            $pemasukan->onlyTrashed();
        } elseif ($status == 'All') {
            $pemasukan->withTrashed();
        }

        $allowed_columns =
        [
            'id',
            'asset_id',
            'nomor_daftar',
            'tanggal_daftar',
            'nomor_pengeluaran',
            'tanggal_pengeluaran',
            'nama_pengirim',
            'kode_barang',
            'kategori_barang',
            'nama_barang',
            'satuan_barang',
            'jumlah_barang',
            'harga_satuan_barang',
            'harga_total_barang',
            'nomor_dokumen_pabean',
            'kode_dokumen_pabean',
            'tanggal_dokumen_pabean',
            'user.first_name',
            'user.last_name'
        ];

        // dd($pemasukan);

        // if ($request->filled('name')) {
        //     $pemasukan->where('assets.name', '=', $request->input('name'));
        // }

        if ($request->filled('tipe_dokument')) {
            $pemasukan->where('tipe_dokument', '=', $request->input('tipe_dokument'));
        }

        if ($request->filled('nomor_daftar')) {
            $pemasukan->where('nomor_daftar', '=', $request->input('nomor_daftar'));
        }

        if ($request->filled('tanggal_daftar')) {
            $pemasukan->where('tanggal_daftar', '=', $request->input('tanggal_daftar'));
        }
        
        if ($request->filled('nomor_pengeluaran')) {
            $pemasukan->where('nomor_pengeluaran', '=', $request->input('nomor_pengeluaran'));
        }

        // Filter berdasarkan rentang tanggal_pengeluaran
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $pemasukan->whereBetween('tanggal_pengeluaran', [
                $request->input('tanggal_mulai'),
                $request->input('tanggal_akhir')
            ]);
        } elseif ($request->filled('tanggal_pengeluaran')) {
            $pemasukan->whereDate('tanggal_pengeluaran', $request->input('tanggal_pengeluaran'));
        }
        
        // Filter berdasarkan kode_barang
        if ($request->filled('kode_barang')) {
            $pemasukan->where('kode_barang', $request->input('kode_barang'));
        }

        if ($request->filled('nama_pengirim')) {
            $pemasukan->where('nama_pengirim', '=', $request->input('nama_pengirim'));
        }

        if ($request->filled('kode_barang')) {
            $pemasukan->where('kode_barang', '=', $request->input('kode_barang'));
        }

        if ($request->filled('nama_barang')) {
            $pemasukan->where('nama_barang', '=', $request->input('nama_barang'));
        }
        
        if ($request->filled('kategori_barang')) {
            $pemasukan->where('kategori_barang', '=', $request->input('kategori_barang'));
        }
        
        if ($request->filled('jumlah_barang')) {
            $pemasukan->where('jumlah_barang', '=', $request->input('jumlah_barang'));
        }
        
        if ($request->filled('satuan_barang')) {
            $pemasukan->where('satuan_barang', '=', $request->input('satuan_barang'));
        }

        if ($request->filled('search')) {
            $pemasukan = $pemasukan->TextSearch($request->input('search'));
        }

        // if ($request->input('deleted')=='true') {
        //     $pemasukan->onlyTrashed();
        // }

        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $pemasukan->count()) ? $pemasukan->count() : app('api_offset_value');
        $limit = app('api_limit_value');

        
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'nama_barang';
        // dd($sort);
        $pemasukan->orderBy($sort, $order);

        $total = $pemasukan->count();
        $pemasukan = $pemasukan->skip($offset)->take($limit)->get();
        return (new PengeluaranTransformer)->transformPengeluarans($pemasukan, $total);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
