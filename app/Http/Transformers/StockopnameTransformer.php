<?php

namespace App\Http\Transformers;

use App\Models\StockOpname;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class StockopnameTransformer
{
    public function transformStockopnames(Collection $pengeluaran, $total)
    {
        $array = [];
        foreach ($pengeluaran as $peng) {
            $array[] = self::transformStockopname($peng);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }
    

    public function transformStockopname(StockOpname $stockopname = null)
    {
        if($stockopname->status_kirim == 'B'){
            $statusSending = 'Belum Selesai';
        }else{
            $statusSending = 'Selesai';
        }
        $array = [
            'id' => (int) $stockopname->id,
            'nomor_dokumen_kegiatan' => e($stockopname->nomor_dokumen_kegiatan),
            'nama_entitas_transaksi' => e($stockopname->nama_entitas_transaksi),
            'tanggal_pelaksanaan' => e($stockopname->tanggal_pelaksanaan),
            'kode_barang' => e($stockopname->kode_barang),
            'kategori_barang' => e($stockopname->kategori_barang),
            'nama_barang' => e($stockopname->nama_barang),
            'satuan_barang' => e($stockopname->satuan_barang),
            'jumlah_barang' => e($stockopname->jumlah_barang),
            'harga_satuan_barang' => e($stockopname->harga_satuan_barang),
            'harga_total_barang' => e($stockopname->harga_total_barang),
            'kode_dokumen_pabean' => e($stockopname->kode_dokumen_pabean) . '-' . e($stockopname->nama_dokumen_pabean),
            'nomor_dokumen_pabean' => e($stockopname->nomor_dokumen_pabean),
            'tanggal_dokumen_pabean' => $stockopname->tanggal_dokumen_pabean,
            'jumlah_barang_sebelumnya' => e($stockopname->jumlah_barang_sebelumnya),
            'selisih_barang' => e($stockopname->selisih_barang),
            'status_sending' => $statusSending,
            'lampiran_display' => $stockopname->lampiran_display ?? '-',

        ];

        if(Auth::user()->isSuperUser() || Auth::user()->isAdmin()){
            if($stockopname->status_penyesuaian == 'B' && $stockopname->status_kirim == 'B'){
                $permissions_array['available_actions'] = [
                    'update' => Gate::allows('update', StockOpname::class),
                    'delete' => Gate::allows('delete', StockOpname::class),
                ];      
            }else{
                $permissions_array['available_actions'] = [
                    'update' => false,
                    'delete' => Gate::allows('delete', StockOpname::class),
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
