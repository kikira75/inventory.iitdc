<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Adjustment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class AdjusmentTransformer
{
    public function transformAdjusments(Collection $pengeluaran, $total)
    {
        $array = [];
        foreach ($pengeluaran as $peng) {
            $array[] = self::transformAdjusment($peng);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAdjusment(Adjustment $adjustment = null)
    {
        if($adjustment->status_kirim == 'B'){
            $statusSending = 'Belum Selesai';
        }else{
            $statusSending = 'Selesai';
        }
        $array = [
            'id' => (int) $adjustment->id,
            'nomor_dokumen_kegiatan' => e($adjustment->nomor_dokumen_kegiatan),
            'nama_entitas_transaksi' => e($adjustment->nama_entitas_transaksi),
            'tanggal_pelaksanaan' => e($adjustment->tanggal_pelaksanaan),
            'kode_barang' => e($adjustment->kode_barang),
            'nama_barang' => e($adjustment->nama_barang),
            'satuan_barang' => e($adjustment->satuan_barang),
            'kategori_barang' => e($adjustment->kategori_barang),
            'jumlah_barang' => e($adjustment->jumlah_barang),
            'harga_satuan_barang' => e($adjustment->harga_satuan_barang),
            'harga_total_barang' => e($adjustment->harga_total_barang),
            'kode_dokumen' => e($adjustment->kode_dokumen) . '-' . e($adjustment->nama_dokumen),
            'tanggal_dokumen' => $adjustment->tanggal_dokumen,
            'nomor_dokumen' => e($adjustment->nomor_dokumen),
            'status_sending' => e($adjustment->status_kirim),
            'saldo_awal' => e($adjustment->saldo_awal),
            'jumlah_pemasukan_barang' => e($adjustment->jumlah_pemasukan_barang),
            'jumlah_pengeluaran_barang' => e($adjustment->jumlah_pengeluaran_barang),
            'penyesuaian' => e($adjustment->penyesuaian),
            'saldo_buku' => e($adjustment->saldo_buku),
            'stock_opname' => e($adjustment->stock_opname),
            'selisih' => e($adjustment->selisih),
            'hasil_pencacahan' => e($adjustment->hasil_pencacahan),
            'jumlah_selisih' => e($adjustment->jumlah_selisih),
            'keterangan' => e($adjustment->keterangan),
            'status_sending' => e($adjustment->status_kirim),
            'lampiran_display' => $adjustment->lampiran_display ?? '-',

        ];

        if(Auth::user()->isSuperUser() || Auth::user()->isAdmin()){
            if($adjustment->status_kirim == 'B'){
                $permissions_array['available_actions'] = [
                    'update' => Gate::allows('update', Adjustment::class),
                    'delete' => (Gate::allows('delete', Adjustment::class)),
                ];      
            }else{
                $permissions_array['available_actions'] = [
                    'update' => false,
                    'delete' => (Gate::allows('delete', Adjustment::class)),
                ];      
            }
        }else if(Auth::user()->isLogistik() || Auth::user()->isAdminInputData() || Auth::user()->isAdminView()){
            $permissions_array['available_actions'] = [
                'update' => false,
                'delete' => false,
            ];
        }

        $array += $permissions_array;

        return $array;
    }

    public function transformAssetsDatatable($peng)
    {
        return (new DatatablesTransformer)->transformDatatables($peng);
    }



}
