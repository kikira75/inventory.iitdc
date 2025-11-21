<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Acceptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Presenters\Presentable;
use Illuminate\Support\Facades\Gate;
use Watson\Validating\ValidatingTrait;

class Pemasukan extends Model
{
    protected $presenter = \App\Presenters\PemasukanPresenter::class;
    use HasFactory, Requestable, Presentable, ValidatingTrait;
    use Acceptable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $injectUniqueIdentifier = true;

    protected $table = 'pemasukan';

    protected $fillable = [
        'nomor_daftar',
        'tanggal_daftar',
        'nomor_pemasukan',
        'tanggal_pemasukan',
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
        'serial_barang',
        'mata_uang',
        'keterangan_pemasukan',
        'lokasi_asset',
        'detail_lokasi_asset',
        'status_pemasukan_mgpa',
        'site',
        'event',
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
    


    // public $regex = '~^[^<!>?:;\[\]\{\}]+$~';

    protected $guarded = [
        'nama_dokumen_pabean',
    ];

    protected $rules = [
        // 'nomor_daftar'  => "required|unique:pemasukan,nomor_daftar|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~",
        'nomor_daftar'  => "required|max:6|regex:~^[^<!>?:;\[\]\{\}]+$~",
        'tanggal_daftar'=> 'required|date_format:Y-m-d',
        'keterangan_pemasukan'=>'required|string',
        // 'nomor_pemasukan' => 'required|unique:pemasukan,nomor_pemasukan|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_pemasukan' => 'required|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'tanggal_pemasukan' => 'required|date_format:Y-m-d',
        'nama_pengirim' => 'required|min:1|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kode_barang' => 'required|min:1|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kategori_barang' => 'required|min:1',
        'nama_barang' => 'required|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'jumlah_barang' => 'required|integer|min:1',
        'mata_uang' => 'required',
        'satuan_barang' => 'required',
        'harga_satuan_barang' => 'required|integer',
        'harga_total_barang' => 'required|integer',
        // 'nomor_dokumen_pabean' => 'required|unique:pemasukan,nomor_dokumen_pabean|min:1|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'nomor_dokumen_pabean' => 'required|max:255|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'kode_dokumen_pabean' => 'required',
        'tanggal_dokumen_pabean' => 'required|date_format:Y-m-d',
        'serial_barang' => 'required|unique:pemasukan,serial_barang|min:1|regex:~^[^<!>?:;\[\]\{\}]+$~',
        'lokasi_asset' => 'nullable',
        'detail_lokasi_asset' => 'nullable',
        'nama_company' => 'required',
        'status_pemasukan_mgpa'=>'required',
        'site'=>'required',
        'event'=>'required',
    ];

    use Searchable;

    protected $searchableAttributes = ['nama_barang', 'nomor_daftar', 'nama_pengirim', 'nama_company', 'serial_barang', 'kode_barang'];

    // protected $searchableRelations = [
    //     'assets'        => ['name'],
    // ];

    public function assets()
    {
        return $this->belongsTo(Asset::class, 'id', 'assets_id');
    }

}
