<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Perusahaan;
use App\Models\StockOpname;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockOpnameController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->authorize('view', StockOpname::class);
        $status = $request->get('status');

        if ($status === 'Deleted') {
            $stockopname = StockOpname::onlyTrashed()->orderBy('id', 'desc')->paginate(20);
        } else {
            $stockopname = StockOpname::orderBy('id', 'desc')->paginate(20);
        }

        return view('stockopname/index', compact('stockopname', 'status'));
    }

    // private function convertDokumen($kodeDokumen){

    //     $arrayDokumen = Helper::kodeDokumen();

    //     $arraySearch = array_key_exists($kodeDokumen, $arrayDokumen);

    //     if($arraySearch != false){
    //         $namaDokumen = $arrayDokumen[$kodeDokumen];
    //     }else{
    //         $namaDokumen = '';
    //     }

    //     return $namaDokumen;
    // }
    private function convertDokumen($kodeDokumen)
    {
        $data = \App\Models\KodeDokumen::pluck('label', 'kode')->toArray();

        return array_key_exists($kodeDokumen, $data) ? $data[$kodeDokumen] : '';
    }

    public function edit($stockopnameId){
        if (!$item = StockOpname::with('asset')->find($stockopnameId)) {
            // Redirect to the asset management page with error
            return redirect()->route('stockopname.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize($item);

        // dd($item);
        return view('stockopname/edit', compact('item'))
            ->with('kodeDokumen', Helper::kodeDokumen())
            ->with('category', Helper::kategoriBarang())
            ->with('satuan', Helper::satuanBarang());
    }

    public function update(Request $request){
        $stockopnameId = $request->input('id');
        
        if (!$opname = StockOpname::find($stockopnameId)) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        
        $this->authorize($opname);
        
        $rules = [];
        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'nullable|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);

        $kodeDokumen = $request->input('kode_dokumen');
        $namaDokumen = $this->convertDokumen($kodeDokumen);

        $asset = Asset::find($opname['asset_id']);

        $pemasuakSeb = intval($asset->pemasukan);
        $pengeluaranSeb = intval($asset->pengeluaran);
        $penyesuaianSeb = intval($asset->penyesuaian);
        $saldoAwalSeb   = intval($asset->saldo_awal);
        $saldoBukuSeb   = intval($asset->saldo_buku);
        
        $stockOpnameUpd      = intval($request->input('jumlah_barang_opname'));
        $stockOpnameAssetSeb = intval($asset->stock_opname);
        $stockOpnameSeb      = intval($opname->jumlah_barang);
        $totalOpnameSeb      = $stockOpnameAssetSeb - $stockOpnameSeb;
        $totalOpnameUpd      = $totalOpnameSeb + $stockOpnameUpd;

        $selisih = $totalOpnameUpd - $saldoBukuSeb - $penyesuaianSeb;

        // $dat = [
        //     'stockOpnameUpd' => $stockOpnameUpd,
        //     'stockOpnameAssetSeb' => $stockOpnameAssetSeb,
        //     'stockOpnameSeb' => $stockOpnameSeb,
        //     'totalOpnameSeb' => $totalOpnameSeb,
        //     'totalOpnameUpd' => $totalOpnameUpd,
        //     'saldoBukuSeb' => $saldoBukuSeb,
        //     'penyesuaianSeb' => $penyesuaianSeb,
        //     'selisih' => $selisih,
        // ];
        
        // dd($dat);

        $opname->nomor_dokumen_kegiatan = $request->input('nomor_dokumen_kegiatan');
        $opname->nama_entitas_transaksi = $request->input('nama_entitas_transaksi');
        $opname->tanggal_pelaksanaan = $request->input('tanggal_pelaksanaan');
        $opname->kode_barang = $request->input('kode_barang');
        $opname->nama_barang = $request->input('nama_barang');
        
        $opname->kategori_barang = $request->input('kategori_barang');
        $opname->nomor_kategori_barang = $request->input('nomor_kategori_barang');
        $opname->satuan_barang = $request->input('satuan_barang');
        
        $jumlahBarangSeb = $request->input('jumlah_barang');
        $jumlahBarangOpname = $request->input('jumlah_barang_opname');

        $selisih = $jumlahBarangOpname - $jumlahBarangSeb;

        $opname->jumlah_barang = $jumlahBarangOpname;
        $opname->jumlah_barang_sebelumnya = $jumlahBarangSeb;
        $opname->selisih_barang = $selisih;
        $opname->harga_satuan_barang = request('harga_satuan_barang', '');
        $opname->harga_total_barang = request('harga_total_barang', '');
        $opname->kode_dokumen_pabean = $kodeDokumen;
        $opname->nama_dokumen_pabean = $namaDokumen;
        $opname->nomor_dokumen_pabean = request('nomor_dokumen', '');
        $opname->tanggal_dokumen_pabean = request('tanggal_dokumen', '');
        $opname->status_kirim = 'B';
        $opname->status_penyesuaian = 'B';
        
        $opname->harga_total_barang = $request->input('harga_total_barang');
        
        $lampiranPaths = [];

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '-' . str_replace(' ', '_', $file->getClientOriginalName());
                    $folder = 'uploads/dokumen_stockopname';
                    $path = $folder . '/' . $filename;
        
                    $file->move(public_path($folder), $filename);
                    $lampiranPaths[] = $path;
                }
            }
        
            // Gabungkan file lama + file baru
            $existingLampiran = $opname->lampiran ? explode(',', $opname->lampiran) : [];
            $opname->lampiran = implode(',', array_merge($existingLampiran, $lampiranPaths));
        }

        $upd = $opname->update();

        if($upd){
            $asset->stock_opname = $totalOpnameUpd;
            $asset->selisih      = $selisih;
            $asset->update();
            
            \Log::debug(e($opname->kode_barang));
            return redirect()->route('stockopname.index')
                ->with('success-unescaped', trans('admin/hardware/message.create.success_linked'));
        }else{
            return redirect()->back()->withInput()->withErrors($opname->getErrors());
        }
        return redirect()->back()->withInput()->withErrors($opname->getErrors());
    }

    public function destroy($stockopnameId){
        if (is_null($stockopname = StockOpname::find($stockopnameId))) {
            return redirect()->route('stockopname.index')
                ->with('error', trans('Data Stockopname Todak Di Temukan'));
        }

        $asset = Asset::find($stockopname->asset_id);
        $totalsaatinistck       = $asset->jumlah_baris_stockopname ;
        $jstockopnameasset       = $asset->stock_opname ;
        $jstockopnamebarang = $stockopname->jumlah_barang;
        $totalstockopname = intval($jstockopnameasset)-intval($jstockopnamebarang);
        $totalminussatustck      = intval($totalsaatinistck) - 1;

        $dataUpdAsset       = [
            // 'owner'             => $newOwner,
            'stock_opname' => '$totalstockopname',
            'jumlah_baris_stockopname' => $totalminussatustck,
        ];

        DB::table('assets')
                ->where('id', $stockopname->asset_id)
                ->update($dataUpdAsset);


        $del = $stockopname->delete();

        if($del){
            return redirect()->route('stockopname.index')
            ->with('success', trans('Data Stockopname Berhasil Di Hapus'));
        }else{
             return redirect()->route('stockopname.index')
            ->with('error', trans('Data Gagal Dihapus'));
        }

    }

    public function deleted()
    {
        $pengeluaran = StockOpname::onlyTrashed()->get();
        return view('StockOpname.deleted', compact('pengeluaran'));
    }
    

    public function restore($id)
    {
        $item = StockOpname::onlyTrashed()->find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau belum terhapus.');
        }

        $item->restore();

        return redirect()->back()->with('success', 'Data berhasil dipulihkan.');
    }

    public function bulkActions(Request $request)
    {
        $action = $request->action;
        
        $ids = $request->input('ids');
        // dd($request->ids);
        // dd($ids);
        

        if (!$ids || !$action) {
            return back()->withErrors('Tidak ada aksi atau data dipilih');
        }

        if ($action === 'delete') {

            // Ambil semua pemasukan berdasarkan array ids[]
            $stockopnames = StockOpname::whereIn('id', $ids)->get();
            
            
            foreach ($stockopnames as $stockopname) {
                
                // Ambil asset terkait
                $asset = Asset::find($stockopname->asset_id);

                if ($asset) {
                    // Hitung ulang data
                    $totalBarisSaatIni = intval($asset->jumlah_baris_stockopname);
                    $barisstockopnameminus = $totalBarisSaatIni - 1;
                    $JumlahstockopnameAsset = intval($asset->stock_opname);
                    $jumlahbarangstockOpname = intval($stockopname->jumlah_barang);
                    $Selisihseb = intval($asset->selisih);
                    $Selisih = $Selisihseb-$jumlahbarangstockOpname;
                    

                    $totalStockopnameBaru = $JumlahstockopnameAsset - $jumlahbarangstockOpname;
                    
                    
                    // Update asset
                    $asset->update([
                        'selisih'=> $Selisih,
                        'jumlah_baris_stockopname' => $barisstockopnameminus,
                        'stock_opname'         => $totalStockopnameBaru,
                    ]);
                }
            }
        
            // Setelah update asset → baru soft delete pemasukan
            StockOpname::whereIn('id', $ids)->delete();
        
            return back()->with('success', 'Data berhasil dihapus dan asset diperbarui.');
        }

        if ($action == 'restore') {

            $stockopnames = StockOpname::onlyTrashed()->whereIn('id', $ids)->get();
            
            foreach ($stockopnames as $stockopname) {
                // dd(555555);
                // Ambil asset terkait
                $asset = Asset::find($stockopname->asset_id);
        
                if ($asset) {
                    // Hitung ulang data
                    $totalBarisSaatIni = intval($asset->jumlah_baris_stockopname);
                    $barisstockopnameminus = $totalBarisSaatIni + 1;
                    $JumlahstockopnameAsset = intval($asset->stock_opname);
                    $jumlahbarangstockOpname = intval($stockopname->jumlah_barang);
                    $Selisihseb = intval($asset->selisih);
                    $Selisih = $Selisihseb+$jumlahbarangstockOpname;

                    $totalStockopnameBaru = $JumlahstockopnameAsset + $jumlahbarangstockOpname;
                    
                    
                    // Update asset
                    $asset->update([
                        'selisih'=> $Selisih,
                        'jumlah_baris_stockopname' => $barisstockopnameminus,
                        'stock_opname'         => $totalStockopnameBaru,
                    ]);
                }
            }
        
            StockOpname::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        if ($action == 'force_delete') {
            StockOpname::withTrashed()->whereIn('id', $ids)->forceDelete();
        }

        return back()->with('success', 'Aksi berhasil');
    }
    
    public function deleteLampiran($id, $index)
    {
        $stockopname = StockOpname::findOrFail($id);
        $this->authorize($stockopname);
    
        $lampiranList = explode(',', $stockopname->lampiran);
        
        if (isset($lampiranList[$index])) {
            $filePath = public_path($lampiranList[$index]);
    
            // Hapus file fisik kalau ada
            if (file_exists($filePath)) {
                unlink($filePath);
            }
    
            // Hapus dari array
            unset($lampiranList[$index]);
    
            // Update database
            $stockopname->lampiran = implode(',', array_values($lampiranList)); // reindex
            $stockopname->save();
        }
    
        return redirect()->back()->with('success', 'Lampiran berhasil dihapus.');
    }

    public function sendApiStock(){
        $client = new Client();
        $url = 'https://api.insw.go.id/api-prod/inventory/temp/transaksi';

        // $dataSend = StockOpname::all()->where('status_kirim', 'B');
        $dataSend = StockOpname::where('status_kirim', 'B')
                            ->where('departemen', 'OPERATION')
                            ->get();
        // dd($dataSend);

        if($dataSend != ""){

            try {
                $dt = Carbon::now();
    
                $dataKirim = [];
                $dataHead = []; 
                $dataKet = [];
                // $data = [];
                $dataResult = [];
                $dataResultError = [];
                $dokumen = [];
                $no = 0;

                $dataPerusahaan = Perusahaan::find(1);

                foreach ($dataSend as $key => $d) {
                    $no++;
                    $row = [];
                    
        
                    $data["data"] = [
                    [
                        "kdKegiatan" => "32",
                        "npwp" => (String) $dataPerusahaan->perusahaan_npwp,
                        "nib" => (String) $dataPerusahaan->perusahaan_nib,
                        "dokumenKegiatan" => [
                            [
                            "nomorDokKegiatan" =>  (String) $d['nomor_dokumen_kegiatan'],
                            "tanggalKegiatan" =>  $d['tanggal_pelaksanaan'],
                            "namaEntitas" =>  (String) $d['nama_entitas_transaksi'],
                            "barangTransaksi" =>  [
                                        [
                                            "kdKategoriBarang" => (String) $d['nomor_kategori_barang'],
                                            "kdBarang" => (String) $d['kode_barang'],
                                            "uraianBarang" => (String) $d['nama_barang'],
                                            "jumlah" => (int) $d['jumlah_barang'],
                                            "kdSatuan" => (String) $d['satuan_barang'],
                                            "nilai" => intval($d["harga_total_barang"]),
                                            "dokumen" => [
                                                [
                                                    "kodeDokumen" => $d['kode_dokumen_pabean'],
                                                    "nomorDokumen" => $d['nomor_dokumen_pabean'],
                                                    "tanggalDokumen" => $d['tanggal_dokumen_pabean'],
                                                ]
                                            ]
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ];
        
                    $request = $client->post($url, [
                        'headers' => [
                            'accept' => 'application/json',
                            'x-insw-key' => 'pZ66hobzPpXBn2bMHVPTz0wG1pxuWQdo',
                            'x-unique-key' => '0862fbfe75bc4cbb1d18c278b720a40549f3d6b226470318dd927054e0b89ed0'
                        ],
                        'json' => $data
                    ]);
                    $response = json_decode($request->getBody(), true);
        
                    if($response['code'] === '01'){
                        $dataResult[$no] = [
                            "status" => $response['code'],
                            "nomor_dokumen_kegiatan" => $d['nomor_dokumen_kegiatan'],
                            "kode" => $d['id'],
                        ];
                    }else{
                        $dataResultError[$no] = "Status Data = " . $response['code'] . " nomor Adjusment = " . $d['nomor_dokumen_kegiatan'];
                    }
                }
        
                for ($i=1; $i <= count($dataResult); $i++) { 
                    $dataUpdate = [
                        'status_kirim' => 'S'
                    ];
                    DB::table('stock_opname')
                        ->where('id', $dataResult[$i]['kode'])
                        ->update($dataUpdate);
                }
        
                return redirect()->route('stockopname.index')
                ->with('success-unescaped', 'Berhasil Mengirimkan stock opnameData Ke INSW dengan ' .count($dataResult) . ' data berhasil, dan ' . count($dataResultError) . ' data error  -- ' . now());

            } catch (\Throwable $e) {
                
                $error = $e->getResponse()->getBody()->getContents();
                if($error != null){
                    $errorDecode = json_decode($error, true);
                    $pesanError = 'Kode Status = ' . $errorDecode['code'] . ', Pesan = ' . $errorDecode['message'];
                }else{
                    $pesanError = $e->getMessage();
                }
                Log::error('Pengiriman Data Api Stockopname Error : ' . $e->getMessage());
                return redirect()->route('stockopname.index')->with('error', $pesanError . ' -- Pada Data Stockopname Ke = ' . $no . ' -- ' . now());
            }
        }else{
            return redirect()->route('stockopname.index')
            ->with('success-unescaped', 'Berhasil Mengirimkan Data stock opname Ke INSW dengan jumlah data = 0 - ' . now());

        }
    }
}
