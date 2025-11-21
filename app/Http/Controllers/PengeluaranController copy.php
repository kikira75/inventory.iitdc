<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Pengeluaran;
use App\Models\Perusahaan;
use App\Models\JenisPeng;
use App\Models\Statusp;
use App\Models\TransaksiPengeluaran;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Pengeluaran::class);

        $status = $request->get('status');

        if ($status === 'Deleted') {
            $pengeluaran = Pengeluaran::onlyTrashed()->orderBy('id', 'desc')->paginate(20);
        } else {
            $pengeluaran = Pengeluaran::orderBy('id', 'desc')->paginate(20);
        }

        // return view('pengeluaran/index');
        return view('pengeluaran.index', compact('pengeluaran', 'status'));
    }

    public function edit($pengeluaranId){
        if (!$item = Pengeluaran::find($pengeluaranId)) {
            // Redirect to the asset management page with error
            return redirect()->route('pengeluaran.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize($item);
        $item = Pengeluaran::find($pengeluaranId);

        // dd($item);
        return view('pengeluaran/edit', compact('item'))
            ->with('kodeDokumen', Helper::kodeDokumen())
            ->with('item', $item)
            ->with('editlistStatusp', Helper::editlistStatusp())
            ->with('editlistjenisPeng', Helper::editlistjenisPeng())
            ->with('category', Helper::kategoriBarang())
            ->with('jenisPengeluaran', Helper::jenisPengeluaran())
            ->with('satuan', Helper::satuanBarang());
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
    private function convertStatusp($editlistStatusp)
    {
        return Statusp::where('nama_status', $editlistStatusp)->value('nama_status') ?? '';
    }
    private function convertJenisP($editlistjenisPeng)
    {
        return JenisPeng::where('nama_jenis', $editlistjenisPeng)->value('nama_jenis') ?? '';
    }

    public function update(Request $request){
        $pengeluaranId = $request->input('id');
        if (!$pengeluaran = Pengeluaran::find($pengeluaranId)) {
            // Redirect to the asset management page with error
            return redirect()->route('pemngeluaran.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize($pengeluaran);
        
        $rules = [];
        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'nullable|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);

        $kodeDokumen = $request->input('kode_dokumen');
        $namaDokumen = $this->convertDokumen($kodeDokumen);
        $jenisPengeluaran = '';
        
        $asset = Asset::find($pengeluaran['asset_id']);
        
        $jenisPengeluaranSeb = $pengeluaran->jenis_pengeluaran;
        $pemasukanSeb = intval($asset->pemasukan);
        $penyesuaianSeb = intval($asset->penyesuaian);
        $stockOpnameSeb = intval($asset->stock_opname);
        $saldoAwalSeb   = intval($asset->saldo_awal);
        $saldoBukuSeb   = intval($asset->saldo_buku);

        $pengeluaranUpd      = intval($request->input('jumlah_barang_pengeluaran'));
        $pengeluaranAssetSeb = intval($asset->pengeluaran);
        $pengeluaranSeb      = intval($pengeluaran->jumlah_barang);
        $totalPengeluaranSeb = $pengeluaranAssetSeb - $pengeluaranSeb;
        $totalPengeluaranUpd = $totalPengeluaranSeb + $pengeluaranUpd;

        $saldoBuku      = $saldoAwalSeb + $pemasukanSeb - $totalPengeluaranUpd;

        if($stockOpnameSeb == 0){
            $selisih = 0;
        }else{
            $selisih = $stockOpnameSeb - $saldoBuku - $penyesuaianSeb;
        }
        
        $jumlahBarangAsset = intval($asset->jumlah_barang);
        $totalBarangSebelumnya = intval($jumlahBarangAsset) + intval($pengeluaranSeb);
        $totalBarangSesudahupdate = intval($totalBarangSebelumnya) - intval($pengeluaranUpd);
        
        $totalHargaUpd       = $request->input('harga_total_barang');
        $totalHargaAssetSeb  = intval($asset->harga_total_barang);
        $totalHargaPengSeb   = intval($pengeluaran->harga_total_barang);
        $totalHargaSeb       = $totalHargaAssetSeb + $totalHargaPengSeb;
        $totalHargaBarang    = intval($totalHargaSeb) - intval($totalHargaUpd);
        
        if($jenisPengeluaran == 'dispose'){
            if($jenisPengeluaranSeb != "dispose"){
                $hasilPencacahanSeb = intval($asset->hasil_pencacahan);
                $hasilPencacahan = $hasilPencacahanSeb + $pengeluaranUpd;
                $status = 'a';
            }else{
                $hasilPencacahanAssetSeb = intval($asset->hasil_pencacahan);
                $hasilPencacahanPengSeb = intval($pengeluaran->jumlah_barang);
                $totalHasilPencacahanSeb = $hasilPencacahanAssetSeb - $hasilPencacahanPengSeb;
                $hasilPencacahan = $totalHasilPencacahanSeb + $pengeluaranUpd;
                $status = 'b';
            }
        }else{
            $hasilPencacahan = intval($asset->hasil_pencacahan);
            $status = 'c';
        }

        $totalJumlahSelisih = $saldoBuku - $hasilPencacahan;
        
        // $dat = [
        //     'saldoAwalSeb' => $saldoAwalSeb,
        //     'pemasukanSeb' => $pemasukanSeb,
        //     'pengeluaranAssetSeb' => $pengeluaranAssetSeb,
        //     'saldoBukuSeb' => $saldoBukuSeb,
        //     'penyesuaianSeb' => $penyesuaianSeb,
        //     'stockOpnameSeb' => $stockOpnameSeb,
        //     'pengeluaranUpd' => $pengeluaranUpd,
        //     'pengeluaranSeb' => $pengeluaranSeb,
        //     'totalPengeluaranSeb' => $totalPengeluaranSeb,
        //     'totalPengeluaranUpd' => $totalPengeluaranUpd,
        //     'saldoBuku' => $saldoBuku,
        //     'jumlahBarangAsset' => $jumlahBarangAsset,
        //     'totalBarangSebelumnya' => $totalBarangSebelumnya,
        //     'totalBarangSesudahupdate' => $totalBarangSesudahupdate,
        //     'totalHargaUpd' => $totalHargaUpd,
        //     'totalHargaAssetSeb' => $totalHargaAssetSeb,
        //     'totalHargaPengSeb' => $totalHargaPengSeb,
        //     'totalHargaSeb' => $totalHargaSeb,
        //     'totalHargaBarang' => $totalHargaBarang,
        //     'hasilPencacahan' => $hasilPencacahan,
        //     'totalJumlahSelisih' => $totalJumlahSelisih,
        //     'jenisPengeluaranSeb' => $jenisPengeluaranSeb,
        //     'jenisPengeluaran' => $jenisPengeluaran,
        //     'status' => $status,
            
        // ];
        
        // dd($dat);


        $jumlahTambahanPengeluaran = $request->input('jumlah_barang_pengeluaran');
        $jumlahSebPengeluaran = $request->input('jumlah_barang_pengeluaran_seb');
        $jumlahBarAsset = $asset->jumlah_barang;
        $totalBarangSebelumnya = intval($jumlahBarAsset) + intval($jumlahSebPengeluaran);
        $totalBarangSesudahupdate = intval($totalBarangSebelumnya) - intval($jumlahTambahanPengeluaran);
        // dd($totalBarangSesudahupdate);

        $pengeluaran->nomor_daftar           = $request->input('nomor_daftar');
        $pengeluaran->tanggal_daftar         = $request->input('tanggal_daftar');
        $pengeluaran->nomor_pengeluaran      = $request->input('nomor_pengeluaran_barang');
        $pengeluaran->tanggal_pengeluaran    = $request->input('tanggal_pengeluaran_barang');
        $pengeluaran->nama_pengirim          = $request->input('nama_pengirim');
        $pengeluaran->kode_barang            = $request->input('kode_barang');
        $pengeluaran->kategori_barang        = $request->input('kategori_barang');
        $pengeluaran->nomor_kategori_barang  = $request->input('nomor_kategori_barang');
        $pengeluaran->nama_barang            = $request->input('name');
        $pengeluaran->satuan_barang          = $request->input('satuan_barang');
        $pengeluaran->jumlah_barang          = $request->input('jumlah_barang_pengeluaran');
        $pengeluaran->harga_total_barang     = $request->input('harga_total_barang');
        $pengeluaran->nomor_dokumen_pabean   = $request->input('nomor_dokumen');
        $pengeluaran->statuspeng             = $this->convertStatusp($request->input('nama_statusp'));
        $pengeluaran->jenis_pengeluaran      = $this->convertJenisP($request->input('nama_jenis'));
        $pengeluaran->kode_dokumen_pabean    = $kodeDokumen;
        $pengeluaran->nama_dokumen_pabean    = $namaDokumen;
        $pengeluaran->tanggal_dokumen_pabean = $request->input('tanggal_dokumen');
        $pengeluaran->status_penyesuaian     = 'B';
        $pengeluaran->user_id                = request('user_id', 1);
        // dd([
        //     'status' => $this->convertStatusp($request->input('nama_statusp')),
        //     'jenis' => $this->convertJenisP($request->input('nama_jenis')),
        // ]);
        $lampiranPaths = [];

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '-' . str_replace(' ', '_', $file->getClientOriginalName());
                    $folder = 'uploads/dokumen_pengeluaran';
                    $path = $folder . '/' . $filename;
        
                    $file->move(public_path($folder), $filename);
                    $lampiranPaths[] = $path;
                }
            }
        
            // Gabungkan file lama + file baru
            $existingLampiran = $pengeluaran->lampiran ? explode(',', $pengeluaran->lampiran) : [];
            $pengeluaran->lampiran = implode(',', array_merge($existingLampiran, $lampiranPaths));
        }
        $upd = $pengeluaran->update();
        
        if($upd){
            $asset->jumlah_barang       = $totalBarangSesudahupdate;
            $asset->harga_total_barang  = $totalHargaBarang;
            $asset->pengeluaran         = $totalPengeluaranUpd;
            $asset->saldo_buku          = $saldoBuku;
            $asset->selisih             = $selisih;
            $asset->hasil_pencacahan    = $hasilPencacahan;
            $asset->jumlah_selisih      = $totalJumlahSelisih;
            $asset->update();

            return redirect()->route('pengeluaran.index')
                ->with('success', trans('admin/hardware/message.update.success'));
        }else{
            return redirect()->back()->withInput()->withErrors($pengeluaran->getErrors());
        }
    }

    public function destroy($pengeluaranId){
        if (is_null($pengeluaran = Pengeluaran::find($pengeluaranId))) {
            return redirect()->route('pengeluaran.index')
                ->with('error', trans('Data Pengeluaran Tidak Di Temukan'));
        }

        // $asset = Asset::find($pengeluaran->asset_id);
        // $totalsaatini       = $asset->jumlah_baris_pengeluaran ;
        // $jpengeluaranasset       = $asset->pengeluaran ;
        // $jpengeluaranbarang = $pengeluaran->jumlah_barang;
        // $totalpengeluaran = intval($jpengeluaranasset)-intval($jpengeluaranbarang);
        // $totalminussatu      = intval($totalsaatini) - 1;

        // $dataUpdAsset       = [
        //     'pengeluaran' => '$totalpengeluaran',
        //     'jumlah_baris_pengeluaran' => $totalminussatu,
        // ];

                $asset = Asset::find($pengeluaran->asset_id);

                if ($asset) {
                    // Hitung ulang data
                    $totalBarisSaatIni = intval($asset->jumlah_baris_pengeluaran);

                    $jumlahPengeluaranAsset = intval($asset->pengeluaran);
                    $jumlahbarangasset = intval($asset->jumlah_barang);
                    $jumlahBarangPengeluaran = intval($pengeluaran->jumlah_barang);
                    $jumlahBarangBertambah = $jumlahBarangPengeluaran + $jumlahbarangasset;

                    if(intval($asset->stock_opname)==0){
                        $selisih = 0;
                    }
                    else{
                        $selisih = intval($asset->selisih) + $jumlahPengeluaranAsset;
                    }

                    $jumlahselisihBertambah = intval($asset->jumlah_selisih) + $jumlahBarangPengeluaran ;
        
                    $barispengeluaranminus = $totalBarisSaatIni - 1;
                    
                    $totalPengeluaranBaru = $jumlahPengeluaranAsset - $jumlahBarangPengeluaran;
                    // dd($barispengeluaranminus);
                    
                    // Update asset
                    $asset->update([
                        'jumlah_barang' => $jumlahBarangBertambah,
                        'saldo_buku' => $jumlahBarangBertambah,
                        'selisih'=> $selisih,
                        'jumlah_selisih' => $jumlahselisihBertambah,
                        'jumlah_baris_pengeluaran' => $barispengeluaranminus,
                        'pengeluaran'         => $totalPengeluaranBaru,
                    ]);
                }

        // DB::table('assets')
        //         ->where('id', $pengeluaran->asset_id)
        //         ->update($dataUpdAsset);

        $del = $pengeluaran->delete();

        if($del){
            return redirect()->route('pengeluaran.index')
            ->with('success', trans('Data Pengeluaran Berhasil Di Hapus'));
        }else{
            dd($del);
             return redirect()->route('pengeluaran.index')
            ->with('error', trans('Data Gagal Dihapus'));
        }

    }

    public function deleted()
    {
        $pengeluaran = Pengeluaran::onlyTrashed()->get();
        return view('pengeluaran.deleted', compact('pengeluaran'));
    }
    

    public function restore($id)
    {
        $item = Pengeluaran::onlyTrashed()->find($id);

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
            $pengeluarans = Pengeluaran::whereIn('id', $ids)->get();
            
            
            foreach ($pengeluarans as $pengeluaran) {
                
                // Ambil asset terkait
                $asset = Asset::find($pengeluaran->asset_id);

                if ($asset) {
                    // Hitung ulang data
                    $totalBarisSaatIni = intval($asset->jumlah_baris_pengeluaran);

                    $jumlahPengeluaranAsset = intval($asset->pengeluaran);
                    $jumlahbarangasset = intval($asset->jumlah_barang);
                    $jumlahBarangPengeluaran = intval($pengeluaran->jumlah_barang);
                    $jumlahBarangBertambah = $jumlahBarangPengeluaran + $jumlahbarangasset;

                    if(intval($asset->stock_opname)==0){
                        $selisih = 0;
                    }
                    else{
                        $selisih = intval($asset->selisih) + $jumlahPengeluaranAsset;
                    }

                    $jumlahselisihBertambah = intval($asset->jumlah_selisih) + $jumlahBarangPengeluaran ;
        
                    $barispengeluaranminus = $totalBarisSaatIni - 1;
                    
                    $totalPengeluaranBaru = $jumlahPengeluaranAsset - $jumlahBarangPengeluaran;
                    // dd($barispengeluaranminus);
                    
                    // Update asset
                    $asset->update([
                        'jumlah_barang' => $jumlahBarangBertambah,
                        'saldo_buku' => $jumlahBarangBertambah,
                        'selisih'=> $selisih,
                        'jumlah_selisih' => $jumlahselisihBertambah,
                        'jumlah_baris_pengeluaran' => $barispengeluaranminus,
                        'pengeluaran'         => $totalPengeluaranBaru,
                    ]);
                }
            }
        
            // Setelah update asset → baru soft delete pemasukan
            Pengeluaran::whereIn('id', $ids)->delete();
        
            return back()->with('success', 'Data berhasil dihapus dan asset diperbarui.');
        }

        if ($action == 'restore') {

            $pengeluarans = Pengeluaran::onlyTrashed()->whereIn('id', $ids)->get();
            
            foreach ($pengeluarans as $pengeluaran) {
                // dd(555555);
                // Ambil asset terkait
                $asset = Asset::find($pengeluaran->asset_id);
        
                if ($asset) {
                    // Hitung ulang data
                    $totalBarisSaatIni = intval($asset->jumlah_baris_pengeluaran);

                    $jumlahbarangasset = intval($asset->jumlah_barang);
                    $jumlahPengeluaranAsset = intval($asset->pengeluaran);
                    $jumlahBarangPengeluaran = intval($pengeluaran->jumlah_barang);

                    $jumlahBarangBertambah = $jumlahbarangasset - $jumlahBarangPengeluaran;

                    if(intval($asset->stock_opname)==0){
                        $selisih = 0;
                    }
                    else{
                        $selisih = intval($asset->selisih) - $jumlahPengeluaranAsset;
                    }

                    $jumlahselisihBerkurang = intval($asset->jumlah_selisih) - $jumlahBarangPengeluaran ;
                    $barispengeluaranTambah = $totalBarisSaatIni + 1;
                    $totalPengeluaranBaru = $jumlahPengeluaranAsset + $jumlahBarangPengeluaran;
                    // dd($totalBarisSaatIni);
                    // Update asset
                    $asset->update([
                        'jumlah_barang' => $jumlahBarangBertambah,
                        'saldo_buku' => $jumlahBarangBertambah,
                        'selisih'=> $selisih,
                        'jumlah_selisih' => $jumlahselisihBerkurang,
                        'jumlah_baris_pengeluaran' => $barispengeluaranTambah,
                        'pengeluaran'         => $totalPengeluaranBaru,
                    ]);
                }
            }
        
            Pengeluaran::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        if ($action == 'force_delete') {
            Pengeluaran::withTrashed()->whereIn('id', $ids)->forceDelete();
        }

        return back()->with('success', 'Aksi berhasil');
    }
    
    public function deleteLampiran($id, $index)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $this->authorize($pengeluaran);
    
        $lampiranList = explode(',', $pengeluaran->lampiran);
        
        if (isset($lampiranList[$index])) {
            $filePath = public_path($lampiranList[$index]);
    
            // Hapus file fisik kalau ada
            if (file_exists($filePath)) {
                unlink($filePath);
            }
    
            // Hapus dari array
            unset($lampiranList[$index]);
    
            // Update database
            $pengeluaran->lampiran = implode(',', array_values($lampiranList)); // reindex
            $pengeluaran->save();
        }
    
        return redirect()->back()->with('success', 'Lampiran berhasil dihapus.');
    }

    public function sendApiPeng(){
        $client = new Client();
        $url = 'https://api.insw.go.id/api-prod/inventory/temp/transaksi';

        // $dataSend = Pengeluaran::all()->where('status_sending', 'a');
        $dataSend = Pengeluaran::where('status_sending', 'a')
                                    ->where('departemen', 'OPERATION')
                                    ->get();

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
                        "kdKegiatan" => (String) config('app.kode_pengeluaran'),
                        "npwp" => (String) $dataPerusahaan->perusahaan_npwp,
                        "nib" => (String) $dataPerusahaan->perusahaan_nib,
                        "dokumenKegiatan" => [
                            [
                            "nomorDokKegiatan" =>  (String) $d['nomor_pengeluaran'],
                            "tanggalKegiatan" =>  $d['tanggal_pengeluaran'],
                            "namaEntitas" =>  (String) $d['nama_pengirim'],
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
                            "nomor_pengeluaran" => $d['nomor_pengeluaran'],
                            "kode" => $d['id'],
                        ];
                    }else{
                        $dataResultError[$no] = "Status Data = " . $response['code'] . " nomor Pengeluaran = " . $d['nomor_pengeluaran'];
                    }    
                }
                
                for ($i=1; $i <= count($dataResult); $i++) { 
                    $dataUpdate = [
                        'status_sending' => 'n'
                    ];
                    DB::table('pengeluaran')
                        ->where('id', $dataResult[$i]['kode'])
                        ->update($dataUpdate);
                }

                return redirect()->route('pengeluaran.index')
                ->with('success-unescaped', 'Berhasil Mengirimkan Data Pengeluaran Ke INSW dengan  ' .count($dataResult) . 'data berhasil, dan ' . count($dataResultError) . ' data error -- ' . now());
            } catch (\Throwable $e) {
                $error = $e->getResponse()->getBody()->getContents();
                if($error != null){
                    $errorDecode = json_decode($error, true);
                    $pesanError = 'Kode Status = ' . $errorDecode['code'] . ', Pesan = ' . $errorDecode['message'];
                }else{
                    $pesanError = $e->getMessage();
                }
                Log::error('Pengiriman Data Api Pengeluaran Error : ' . $e->getMessage());
                return redirect()->route('pengeluaran.index')->with('error', $pesanError . ' -- Pada Data Pengeluaran Ke = ' . $no . ' -- ' . now());
            }
        }else{
            return redirect()->route('pengeluaran.index')
                ->with('success-unescaped', 'Data Yang Dikirim 0');
        }
        

    }

    // public function sendApiPeng(){
    //     $client = new Client();
    //     // $url = 'https://api.insw.go.id/api-prod/inventory/pemasukan/tempInsert';
    //     $url = config('app.endpoint_pengeluaran');

    //     $asset = Pengeluaran::all()->where('status_sending', 'a');
    //     $dt = Carbon::now();
    //     $data = [];
    //     $dataKet = [];
    //     foreach ($asset as $key => $a) {
    //         $row = [];
    //         if($a['tipe_dokument'] == "" || $a['tipe_dokument'] == NULL || empty($a['tipe_dokument'])){
    //             $dataDokumen = "";
    //         }else{
    //             $dataDokumen = [
    //                 "kodeDokumen" => $a['tipe_dokument'],
    //                 "nomorDokumen" => $a['nomor_daftar'],
    //                 "tanggalDokumen" => $a['tanggal_daftar'],
    //             ];
    //         }

    //         $row["kdKategoriBarang"] = (String) $a['nomor_kategori_barang'];
    //         $row["kdBarang"] = (String) $a["kode_barang"];
    //         $row["uraianBarang"] = (String) $a["nama_barang"];
    //         $row["jumlah"] = $a["jumlah_barang"];
    //         $row["kdSatuan"] = $a["satuan_barang"];
    //         $row["nilai"] = intval($a["harga_total_barang"]);
    //         $row["dokumen"] = [$dataDokumen];
    //         $data[] = $row;
    //     }

    //     $dataTransaksi = TransaksiPengeluaran::all()->last();
    //     $noTrans = (int)  $dataTransaksi->transaksi_nomor;
    //     $nomorDokKegiatan = ucwords($dataTransaksi->transaksi_ket) . intval($noTrans);

    //     $dataPerusahaan = Perusahaan::find(1);


    //     $dataKet["nomorDokKegiatan"] = (String) $nomorDokKegiatan;
    //     $dataKet["tanggalKegiatan"] = $dt->toDateString();
    //     $dataKet["namaEntitas"] = (String) $dataPerusahaan->perusahaan_nama;
    //     $dataKet["barangTransaksi"] = $data;
        
    //     $dataHead["kdKegiatan"] = (String) config('app.kode_pengeluaran'); 
    //     $dataHead["npwp"] = (String) $dataPerusahaan->perusahaan_npwp; 
    //     $dataHead["nib"] = (String) $dataPerusahaan->perusahaan_nib; 
    //     $dataHead["dokumenKegiatan"] = [$dataKet]; 

    //     try {
    //         $request = $client->post($url, [
    //             'headers' => [
    //                 'accept' => 'application/json',
    //                 'x-insw-key' => 'RqT40lH7Hy202uUybBLkFhtNnfAvxrlp'
    //             ],
    //             'json' => [
    //                 "data" => [
    //                     $dataHead
    //                 ]
                    
    //             ]
    //         ]);
    
    //         $response = json_decode($request->getBody(), true);
    //         if($response['code'] === '01'){
    //             $noTrans = (int) $noTrans + 1;
    //             $transaksi = new TransaksiPengeluaran();
    //             $transaksi->transaksi_nomor = $noTrans;
    //             $transaksi->transaksi_ket = 'Pengeluaran';
    //             $transaksi->save();

    //             foreach ($asset as $key => $d) {
    //                 $dataUpdate = [
    //                     'status_sending' => 'n'
    //                 ];
    //                 DB::table('pengeluaran')
    //                     ->where('id', $d['id'])
    //                     ->update($dataUpdate);
    //             }
    //             return response()->json($response, 200);
    //         }else{
    //             echo 'Gagal Mengirimkan Data Ke INSW' . now();
    //         }
            
    //     }catch (\Exception $e) {
    //         // Handle exceptions during the request
    //         // echo "Error: " . $e->getMessage();
    //         echo 'Error:' . $e->getMessage();
            
    //     }

    // }

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

    
}
