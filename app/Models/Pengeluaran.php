<?php

namespace App\Models;

use App\Models\Traits\Acceptable;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Pengeluaran extends Model
{
    protected $presenter = \App\Presenters\PengeluaranPresenter::class;
    use HasFactory, Requestable, Presentable, ValidatingTrait;
    use Acceptable;
    use Searchable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'pengeluaran';
    protected $searchableAttributes = ['nomor_daftar', 'nomor_daftar', 'nama_pengirim', 'nama_barang'];

    protected $fillable = [
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
        'kode_dokumen_pabean',
        'nomor_dokumen_pabean',
        'tanggal_dokumen_pabean',
        'jenis_pengeluaran',
        'status_penyesuaian',
        'user_id',
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
        'nama_dokumen_pabean',
    ];

    protected $rules = [
        'asset_id'      => 'required',
        // 'nomor_daftar'  => 'required|unique:pengeluaran,nomor_daftar|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_daftar'  => 'required|max:6|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'tanggal_daftar'=> 'required|date_format:Y-m-d',
        // 'nomor_pengeluaran' => 'required|unique:pengeluaran,nomor_pengeluaran|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_pengeluaran' => 'required|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'tanggal_pengeluaran' => 'required|date_format:Y-m-d',
        'nama_pengirim' => 'required|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'jenis_pengeluaran' => 'required',
        'kode_barang' => 'required|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kategori_barang' => 'required|min:1|max:255',
        'nama_barang' => 'required|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'satuan_barang' => 'required|min:1|max:255',
        'jumlah_barang' => 'required|integer',
        'harga_satuan_barang' => 'required|integer',
        'harga_total_barang' => 'required|integer',
        // 'nomor_dokumen_pabean' => 'required|unique:pengeluaran,nomor_dokumen_pabean|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_dokumen_pabean' => 'required|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kode_dokumen_pabean' => 'required|min:1|max:255',
        'tanggal_dokumen_pabean' => 'required',
        'user_id' => 'required',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_tag', 'kode_barang');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function assets()
    {
        return $this->belongsTo(Asset::class, 'id', 'assets_id');
    }
}
