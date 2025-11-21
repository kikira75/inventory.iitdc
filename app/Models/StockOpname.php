<?php

namespace App\Models;

use App\Models\Traits\Acceptable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class StockOpname extends Model
{
    protected $presenter = \App\Presenters\StockopnamePresenter::class;
    use HasFactory, Requestable, Presentable, ValidatingTrait;
    use Acceptable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $injectUniqueIdentifier = true;
    protected $table = 'stock_opname';
    
    protected $fillable = [
        'assets_id',
        'nomor_dokumen_kegiatan',
        'nama_entitas_transaksi',
        'tanggal_pelaksanaan',
        'kode_barang',
        'nama_barang',
        'kategori_barang',
        'nomor_kategori_barang',
        'satuan_barang',
        'jumlah_barang',
        'harga_satuan_barang',
        'harga_total_barang',
        'status_kirim',
        'kode_dokumen_pabean',
        'nama_dokumen_pabean',
        'nomor_dokumen_pabean',
        'tanggal_dokumen_pabean',
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
        // 'nomor_dokumen_kegiatan'  => 'required|unique:stock_opname,nomor_dokumen_kegiatan|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_dokumen_kegiatan'  => 'required|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'tanggal_pelaksanaan'=> 'required|date_format:Y-m-d',
        'nama_entitas_transaksi' => 'required|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kode_barang' => 'required',
        'kategori_barang' => 'required',
        'nama_barang' => 'required',
        'satuan_barang' => 'required',
        'jumlah_barang' => 'required|integer|min:1',
        'harga_satuan_barang' => 'required|integer',
        'harga_total_barang' => 'required|integer',
        // 'nomor_dokumen_pabean' => 'required|unique:stock_opname,nomor_dokumen_pabean|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_dokumen_pabean' => 'required|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kode_dokumen_pabean' => 'required',
        'tanggal_dokumen_pabean' => 'required',
    ];

    public function asset()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }
}
