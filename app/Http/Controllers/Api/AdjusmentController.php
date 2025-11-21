<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\AdjusmentTransformer;
use App\Models\Adjustment;
use Illuminate\Http\Request;

class AdjusmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Adjustment::class);

        $pemasukan = Adjustment::with('asset');
        // dd($pemasukan);

            $status = $request->input('status');

            if ($status == 'Deleted') {
                $pemasukan->onlyTrashed();
            } elseif ($status == 'All') {
                $pemasukan->withTrashed();
            }

        $allowed_columns =
        [
            'assets_id',
            'tanggal_pelaksanaan',
            'kode_dokumen',
            'nomor_dokumen',
            'tanggal_dokumen',
            'kode_barang',
            'nama_barang',
            'kategori_barang',
            'satuan_barang',
            'jumlah_barang',
            'harga_total_barang',
            'keterangan',
        ];

        // dd($pemasukan);

        // if ($request->filled('name')) {
        //     $pemasukan->where('assets.name', '=', $request->input('name'));
        // }

        if ($request->filled('kode_dokumen')) {
            $pemasukan->where('kode_dokumen', '=', $request->input('kode_dokumen'));
        }

        if ($request->filled('nomor_dokumen')) {
            $pemasukan->where('nomor_dokumen', '=', $request->input('nomor_dokumen'));
        }

        // Filter berdasarkan rentang tanggal_pelaksanaan
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $pemasukan->whereBetween('tanggal_pelaksanaan', [
                $request->input('tanggal_mulai'),
                $request->input('tanggal_akhir')
            ]);
        } elseif ($request->filled('tanggal_pelaksanaan')) {
            $pemasukan->whereDate('tanggal_pelaksanaan', $request->input('tanggal_pelaksanaan'));
        }

        // Filter berdasarkan tanggal_dokumen
        if ($request->filled('tanggal_dokumen')) {
            $pemasukan->where('tanggal_dokumen', '=', $request->input('tanggal_dokumen'));
        }

        // Filter berdasarkan kode_barang
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
        
        if ($request->filled('harga_total_barang')) {
            $pemasukan->where('harga_total_barang', '=', $request->input('harga_total_barang'));
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
        return (new AdjusmentTransformer)->transformAdjusments($pemasukan, $total);

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
