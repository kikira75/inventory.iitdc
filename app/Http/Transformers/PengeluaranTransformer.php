<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\License;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class PengeluaranTransformer
{
    public function transformPengeluarans(Collection $pengeluaran, $total)
    {
        $array = [];
        foreach ($pengeluaran as $peng) {
            $array[] = self::transformPengeluaran($peng);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformPengeluaran(Pengeluaran $pengeluaran = null)
    {
        if($pengeluaran->status_sending == 'a'){
            $statusSending = 'Belum Selesai';
        }else{
            $statusSending = 'Selesai';
        }
        $array = [
            'id' => (int) $pengeluaran->id,
            'nomor_daftar' => e($pengeluaran->nomor_daftar),
            'tanggal_daftar' => Helper::getFormattedDateObject($pengeluaran->tanggal_daftar, 'date'),
            'nomor_pengeluaran' => e($pengeluaran->nomor_pengeluaran),
            'tanggal_pengeluaran' => Helper::getFormattedDateObject($pengeluaran->tanggal_pengeluaran, 'date'),
            'nama_pengirim' => e($pengeluaran->nama_pengirim),
            'jenis_pengeluaran' => e($pengeluaran->jenis_pengeluaran),
            'statuspeng' => e($pengeluaran->statuspeng),
            'kode_barang' => e($pengeluaran->kode_barang),
            'nama_barang' => e($pengeluaran->nama_barang),
            'kategori_barang' => e($pengeluaran->kategori_barang),
            'jumlah_barang' => e($pengeluaran->jumlah_barang),
            'satuan_barang' => e($pengeluaran->satuan_barang),
            'harga_satuan_barang' => e($pengeluaran->harga_satuan_barang),
            'harga_total_barang' => e($pengeluaran->harga_total_barang),
            'kode_dokumen_pabean' => e($pengeluaran->kode_dokumen_pabean) . '-' . e($pengeluaran->nama_dokumen_pabean),
            'nomor_dokumen_pabean' => e($pengeluaran->nomor_dokumen_pabean),
            'tanggal_dokumen_pabean' => e($pengeluaran->tanggal_dokumen_pabean),
            'created_at' => Helper::getFormattedDateObject($pengeluaran->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($pengeluaran->updated_at, 'datetime'),
            'status_sending' => $statusSending,
            'lampiran_display' => $pengeluaran->lampiran_display ?? '-',
            

        ];

        if(Auth::user()->isSuperUser() || Auth::user()->isAdmin()){
            if($pengeluaran->status_penyesuaian == 'B' && $pengeluaran->status_sending == 'a'){
                $permissions_array['available_actions'] = [
                    'update' => Gate::allows('update', Pengeluaran::class),
                    'delete' => (Gate::allows('delete', Pengeluaran::class)),
                ];      
            }else{
                $permissions_array['available_actions'] = [
                    'update' => false,
                    'delete' => (Gate::allows('delete', Pengeluaran::class)),
                ];      
            }
        }else if(Auth::user()->isLogistik() || Auth::user()->isAdminInputData() || Auth::user()->isAdminView()){
            $permissions_array['available_actions'] = [
                'update' => false,
                'delete' => false,
            ];
        }

        // $permissions_array['available_actions'] = [
        //     'update' => Gate::allows('update', Pengeluaran::class),
        //     'delete' => (Gate::allows('delete', Pengeluaran::class)) ,
        // ];

        $array += $permissions_array;

        return $array;
    }

    public function transformAssetsDatatable($peng)
    {
        return (new DatatablesTransformer)->transformDatatables($peng);
    }



}
