<?php

namespace App\Models;

use App\Models\Traits\Acceptable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Adjustment extends Model
{
    protected $presenter = \App\Presenters\AdjusmentPresenter::class;
    use HasFactory, Requestable, Presentable, ValidatingTrait;
    use Acceptable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $injectUniqueIdentifier = true;
    protected $table = 'adjusment';
    
    protected $fillable = [
        'tanggal_pelaksanaan',
        'kode_barang',
        'kategori_barang',
        'nama_barang',
        'satuan_barang',
        'jumlah_barang',
        'harga_total_barang',
        'saldo_awal',
        'jumlah_pemasukan_barang',
        'jumlah_pengeluaran_barang',
        'penyesuaian',
        'saldo_akhir',
        'hasil_pencacah',
        'jumlah_selisih',
        'keterangan',
        'status_kirim',
        'kode_dokumen',
        'nama_dokumen',
        'nomor_dokumen',
        'tanggal_dokumen',
        'lampiran',
    ];
    
    public function getLampiranDisplayAttribute()
    {
        if (!$this->lampiran) {
            return '-';
        }
    
        $links = '';
        foreach (explode(',', $this->lampiran) as $path) {
            $filename = basename($path);
            // $url = asset($path);
            $url = url('/' . ltrim(str_replace('public/', '', $path), '/'));
            $links .= "<a href='{$url}' target='_blank' class='btn btn-sm btn-outline-primary mb-1'>{$filename}</a><br>";
        }
    
        return $links;
    }

    protected $guarded = [
        'assets_id'
    ];

    protected $rules = [
        // 'nomor_dokumen_kegiatan' => 'required|unique:adjusment,nomor_dokumen_kegiatan|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_dokumen_kegiatan' => 'required|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'tanggal_pelaksanaan'    => 'required|date|date_format:Y-m-d',
        'nama_entitas_transaksi' => 'required|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kode_barang'            => 'required|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'keterangan'             => 'required|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kategori_barang'        => 'required',
        'jumlah_barang'          => 'required|integer',
        'harga_satuan_barang'    => 'required|integer',
        'harga_total_barang'     => 'required|integer',
        'nama_barang'            => 'required|min:1|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'satuan_barang'          => 'required',
        // 'nomor_dokumen'          => 'required|unique:adjusment,nomor_dokumen|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_dokumen'          => 'required|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kode_dokumen'           => 'required',
        'tanggal_dokumen'        => 'required',
    ];


    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

}
