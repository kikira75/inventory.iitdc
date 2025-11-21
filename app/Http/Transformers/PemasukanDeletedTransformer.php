<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Pemasukan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class PemasukanDeletedTransformer
{   
    protected $statusSending;
    protected $statusPenyesuaian;
    public function transformPemasukans(Collection $pemasukan, $total)
    {
        $array = [];
        foreach ($pemasukan as $pemasuk) {
            $array[] = self::transformPemasukan($pemasuk);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }
    
    // public function transformPemasukans($items, $total = 0)
    // {
    //     return [
    //         'total' => $total,
    //         'rows' => $items->map(function ($item) {
    //             return $this->transformPemasukan($item);
    //         }),
    //     ];
    // }

    public function transformPemasukan(Pemasukan $pemasukan = null)
    {
        if($pemasukan->status_sending == 'a'){
            $this->statusSending = 'Belum Selesai';
        }else{
            $this->statusSending = 'Selesai';
        }
        $array = [
            'ids' => (int) $pemasukan->id,
            'id' => (int) $pemasukan->id,
            'nomor_daftar' => e($pemasukan->nomor_daftar),
            'tanggal_daftar' => Helper::getFormattedDateObject($pemasukan->tanggal_daftar, 'date'),
            'nomor_pemasukan' => e($pemasukan->nomor_pemasukan),
            'tanggal_pemasukan' => Helper::getFormattedDateObject($pemasukan->tanggal_pemasukan, 'date'),
            'nama_pengirim' => e($pemasukan->nama_pengirim),
            'serial_barang' => e($pemasukan->serial_barang),
            'lokasi_asset' => e($pemasukan->lokasi_asset),
            'detail_lokasi_asset' => e($pemasukan->detail_lokasi_asset),
            'kode_barang' => e($pemasukan->kode_barang),
            'nama_barang' => e($pemasukan->nama_barang),
            'kategori_barang' => e($pemasukan->kategori_barang),
            'jumlah_barang' => e($pemasukan->jumlah_barang),
            'satuan_barang' => e($pemasukan->satuan_barang),
            'mata_uang' => e($pemasukan->mata_uang),
            'harga_satuan_barang' => e($pemasukan->harga_satuan_barang),
            'harga_total_barang' => e($pemasukan->harga_total_barang),
            'kode_dokumen_pabean' => e($pemasukan->kode_dokumen_pabean) . '-' . e($pemasukan->nama_dokumen_pabean),
            'nomor_dokumen_pabean' => e($pemasukan->nomor_dokumen_pabean),
            'nama_company' => e($pemasukan->nama_company),
            'tanggal_dokumen_pabean' => e($pemasukan->tanggal_dokumen_pabean),
            'created_at' => Helper::getFormattedDateObject($pemasukan->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($pemasukan->updated_at, 'datetime'),
            'status_sending' => $this->statusSending,
            'keterangan_pemasukan' => e($pemasukan->keterangan_pemasukan),
            'departemen' => e($pemasukan->departemen),
            'metode_pengadaan'=> e($pemasukan->metode_pengadaan),
            'status_pemasukan_mgpa'=> e($pemasukan->status_pemasukan_mgpa),
            'owner'=> e($pemasukan->owner),
            'site'=> e($pemasukan->site),
            'event'=> e($pemasukan->event),
            'lampiran_display' => $pemasukan->lampiran_display ?? '-',
            // 'user_can_checkout' => (bool) ($pemasukan->free_seats_count > 0),

        ];

        if(Auth::user()->isSuperUser() || Auth::user()->isAdmin()){
            if($pemasukan->status_penyesuaian == 'B' && $pemasukan->status_sending == 'a'){
                $permissions_array['available_actions'] = [
                    'update' => Gate::allows('update', Pemasukan::class),
                    'delete' => Gate::allows('delete', Pemasukan::class),
                ];      
            }else{
                $permissions_array['available_actions'] = [
                    'update' => false,
                    'delete' => Gate::allows('delete', Pemasukan::class),
                ];
            }
        }else if(Auth::user()->isLogistik() || Auth::user()->isAdminInputData() || Auth::user()->isAdminView()){
            $permissions_array['available_actions'] = [
                'update' => false,
                'delete' => false,
            ];
        }

        // $permissions_array['available_actions'] = [
        //     'update' => Gate::allows('update', Pemasukan::class),
        //     'delete' => (Gate::allows('delete', Pemasukan::class)) ,
        // ];

        $array += $permissions_array;

        return $array;
    }

    public function transformAssetsDatatable($pemasuk)
    {
        return (new DatatablesTransformer)->transformDatatables($pemasuk);
    }



}
