<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Asset;
// use App\Models\License;
use App\Models\Pemasukan;
use App\Models\Perusahaan;
use Carbon\Carbon;
use App\Models\Detaillokasi;
use App\Models\Keterangan;
use App\Models\Lokasi;
use App\Models\Owner;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class PemasukanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    // public function index()
    // {
    //     $this->authorize('view', Pemasukan::class);

    //     return view('pemasukan/index');
    // }
    public function index(Request $request)
{
    $this->authorize('view', Pemasukan::class);

    $status = $request->get('status');

    if ($status === 'Deleted') {
        $pemasukan = Pemasukan::onlyTrashed()->orderBy('id', 'desc')->paginate(20);
    } else {
        $pemasukan = Pemasukan::orderBy('id', 'desc')->paginate(20);
    }

    return view('pemasukan.index', compact('pemasukan', 'status'));
}



    // public function create(Request $request)
    // {
    //     $this->authorize('create', Pemasukan::class);

    //     $view = View::make('pemasukan/edit')
    //         ->with('item', new License)
    //         ->with('category', Helper::kategoriBarang())
    //         ->with('satuan', Helper::satuanBarang());


    //     return $view;
    // }

    private function getMataUang(){
        $currency = Helper::mataUang();
        $data = [];
        foreach ($currency as $key => $c) {
            $data[$key] = $c['code'] . ' - ' . $c['title'] . ' - ' . $c['symbol'];
        }

        return $data;
    }

    public function edit($pemaukanId){
        if (!$item = Pemasukan::find($pemaukanId)) {
            // Redirect to the asset management page with error
            return redirect()->route('pemasukan.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize($item);

        $dataMataUang = $this->getMataUang();
        
        return view('pemasukan/edit', compact('item'))
            ->with('kodeDokumen', Helper::kodeDokumen())
            ->with('editlistdetaillokasi', Helper::editlistdetaillokasi())
            ->with('editlistownerr', Helper::editlistownerr())
            ->with('editlistketerangan', Helper::editlistketerangan())
            ->with('editlistlokasi', Helper::editlistlokasi())
            ->with('category', Helper::kategoriBarang())
            ->with('satuan', Helper::satuanBarang())
            ->with('mataUang', $dataMataUang)
            ->with('keteranganPemasukan', Helper::keteranganPemasukan());
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
    
    private function convertDetailLokasi($listdetaillokasi)
    {
        return Detaillokasi::where('detail_lokasi', $listdetaillokasi)->value('detail_lokasi') ?? '';
    }

    private function convertLokasis($listlokasi)
    {
        return Lokasi::where('namalokasi', $listlokasi)->value('namalokasi') ?? '';
    }
    private function convertownerr2($listlokasi)
    {
        return Owner::where('nama_owner', $listlokasi)->value('nama_owner') ?? '';
    }
    private function convertKet($listketerangan)
    {
        return Keterangan::where('listketerangan', $listketerangan)->value('listketerangan') ?? '';
    }

    public function getBarangData(Request $request)
        {
            $kode_barang = $request->input('kode_barang');
            $barang = DB::table('assets')->where('asset_tag', $kode_barang)->first();

            if ($barang) {
                $owners = explode(', ', $barang->owner);
                return response()->json(['owners' => $owners]);
            }

            return response()->json(['owners' => []]);
        }

    public function getBarangDataLokasi(Request $request)
        {
            $kode_barang = $request->input('kode_barang');
            $barang = DB::table('assets')->where('asset_tag', $kode_barang)->first();

            if ($barang) {
                $lokasis = explode(', ', $barang->lokasi_asset);
                return response()->json(['lokasis' => $lokasis]);
            }

            return response()->json(['lokasis' => []]);
        }

    public function getBarangDataDetailLokasi(Request $request)
        {
            $kode_barang = $request->input('kode_barang');
            $barang = DB::table('assets')->where('asset_tag', $kode_barang)->first();

            if ($barang) {
                $detaillokasis = explode(', ', $barang->detail_lokasi_asset);
                return response()->json(['detaillokasis' => $detaillokasis]);
            }

            return response()->json(['detaillokasis' => []]);
        }

    public function getKodeBarang(Request $request)
        {
            // Ambil kode barang pertama (sesuai logika Anda)
            $kode_barang33 = $request->input('kode_barang');
            if (!$kode_barang33) {
                return response()->json(['error' => 'kode_barang tidak ditemukan']);
            }
            // $kodeBarang = DB::table('assets')->value('asset_tag', $kode_barang33 ); // Misalnya ambil kode pertama
            // $kodeBarang = DB::table('assets')->orderBy('id', 'desc')->value('asset_tag');
            $kodeBarang = DB::table('assets')->where('asset_tag',$kode_barang33)->value('asset_tag');
            return response()->json(['kode_barang' => $kodeBarang]);

              // Ganti with your condition
        }

    public function update(Request $request){
        $pemasukanId = $request->input('id');

        if (!$pemasukan = Pemasukan::find($pemasukanId)) {
            // Redirect to the asset management page with error
            return redirect()->route('pemasukan.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize($pemasukan);
        
        $rules = [];
        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);

        $kodeDokumen = $request->input('kode_dokumen');
        $namaDokumen = $this->convertDokumen($kodeDokumen);
        $keteranganPemasukan = $request->input('keterangan_pemasukan');
        
        $asset = Asset::find($pemasukan['assets_id']);
        
        $pengeluaranSeb = intval($asset->pengeluaran);
        $penyesuaianSeb = intval($asset->penyesuaian);
        $stockOpnameSeb = intval($asset->stock_opname);
        $saldoAwalSeb   = intval($asset->saldo_awal);
        $saldoBukuSeb   = intval($asset->saldo_buku);

        $pemasukanUpd      = intval($request->input('jumlah_barang_tambahan'));
        $pemasukanAssetSeb    = intval($asset->pemasukan);
        $pemasukanSeb         = intval($pemasukan->jumlah_barang);
        $totalPemasukanSeb    = $pemasukanAssetSeb - $pemasukanSeb;
        $totalPemasukanUpd = $totalPemasukanSeb + $pemasukanUpd;
        
        $saldoBuku      = $saldoAwalSeb + $totalPemasukanUpd - $pengeluaranSeb; 
        
        if($stockOpnameSeb == 0){
            $selisih = 0;
        }else{
            $selisih = $stockOpnameSeb - $saldoBuku - $penyesuaianSeb;
        }
        
        $hasilPencacahanSeb = intval($asset->hasil_pencacahan);
        $jumlahSelisih      = $saldoBuku - $hasilPencacahanSeb;

        $jumlahBarangAsset = intval($asset->jumlah_barang);
        $totalBarangSebelumnya = intval($jumlahBarangAsset) - intval($pemasukanSeb);
        $totalBarangSesudahupdate = intval($totalBarangSebelumnya) + intval($pemasukanUpd);
        
        $totalHargaUpd       = $request->input('harga_total_barang');
        $TotalHargaAssetSeb  = intval($asset->harga_total_barang);
        $TotalHargaPemSeb  = intval($pemasukan->harga_total_barang);
        $totalHargaSeb       = $TotalHargaAssetSeb - $TotalHargaPemSeb;
        $totalHargaBarang    = intval($totalHargaSeb) + intval($totalHargaUpd);
        
        $pemasukan->nomor_daftar            = $request->input('nomor_daftar');
        $pemasukan->serial_barang           = $request->input('serial_barang');
        $pemasukan->lokasi_asset            = $this->convertLokasis($request->input('namalokasi'));
        $pemasukan->detail_lokasi_asset     = $this->convertDetailLokasi($request->input('detail_lokasi'));
        $pemasukan->tanggal_daftar          = $request->input('tanggal_daftar');
        $pemasukan->nomor_pemasukan         = $request->input('nomor_penerimaan_barang');
        $pemasukan->tanggal_pemasukan       = $request->input('tanggal_penerimaan_barang');
        $pemasukan->nama_pengirim           = $request->input('nama_pengirim');
        $pemasukan->owner                   = $this->convertownerr2($request->input('nama_owner'));
        $pemasukan->kode_barang             = $request->input('kode_barang');
        $pemasukan->kategori_barang         = $request->input('kategori_barang');
        $pemasukan->nomor_kategori_barang   = $request->input('nomor_kategori_barang');
        $pemasukan->nama_barang             = $request->input('name');
        $pemasukan->satuan_barang           = $request->input('satuan_barang');
        $pemasukan->jumlah_barang           = $pemasukanUpd;
        $pemasukan->harga_total_barang      = $totalHargaUpd;
        $pemasukan->nomor_dokumen_pabean    = $request->input('nomor_dokumen');
        $pemasukan->kode_dokumen_pabean     = $kodeDokumen;
        $pemasukan->nama_dokumen_pabean     = $namaDokumen;
        $pemasukan->tanggal_dokumen_pabean  = $request->input('tanggal_dokumen');
        $pemasukan->keterangan_pemasukan    = $this->convertKet($request->input('listketerangan'));
        $lampiranPaths = [];

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '-' . str_replace(' ', '_', $file->getClientOriginalName());
                    $folder = 'uploads/dokumen_pemasukan';
                    $path = $folder . '/' . $filename;
        
                    $file->move(public_path($folder), $filename);
                    $lampiranPaths[] = $path;
                }
            }
        
            // Gabungkan file lama + file baru
            $existingLampiran = $pemasukan->lampiran ? explode(',', $pemasukan->lampiran) : [];
            $pemasukan->lampiran = implode(',', array_merge($existingLampiran, $lampiranPaths));
        }
        $pemasukan->status_penyesuaian      = 'B';
        $upd = $pemasukan->update();
        
        if($upd){
            $asset->jumlah_barang = $totalBarangSesudahupdate;
            $asset->harga_total_barang = $totalHargaBarang;
            $asset->pemasukan = $totalPemasukanUpd;
            $asset->saldo_buku = $saldoBuku;
            $asset->selisih = $selisih;
            $asset->jumlah_selisih = $jumlahSelisih;
            $asset->update();

            return redirect()->route('pemasukan.index')
                ->with('success', trans('admin/hardware/message.update.success'));
        }else{
            // dd($pemasukan);
            return redirect()->back()->withInput()->withErrors($pemasukan->getErrors());
        }
    }

    public function destroy($pemasukanId){
        if (is_null($pemasukan = Pemasukan::find($pemasukanId))) {
            return redirect()->route('pemasukan.index')
                ->with('error', trans('Data Pemasukan Tidak Di Temukan'));
        }

        $asset = Asset::find($pemasukan->assets_id);
        $totalsaatini       = $asset->jumlah_baris_kode ;
        $jpemasukanasset       = $asset->pemasukan ;
        $jpemasukanbarang = $pemasukan->jumlah_barang;
        $totalpemasukan = intval($jpemasukanasset)-intval($jpemasukanbarang);
        $totalminussatu      = intval($totalsaatini) - 1;

        $dataUpdAsset       = [
            // 'owner'             => $newOwner,
            'jumlah_baris_kode' => $totalminussatu,
        ];

        DB::table('assets')
                ->where('id', $pemasukan->assets_id)
                ->update($dataUpdAsset);

        $kodeBarang = $pemasukan->kode_barang;

        $del = $pemasukan->delete();
        
        if($del){
            Log::warning("Berhasil Menghapus Data Pemasukan Pada Menu Pemasukan Dengan Kode Barang : " . $kodeBarang);
            return redirect()->route('pemasukan.index')
            ->with('success', trans('Data Pemasukan Berhasil Di Hapus'));
        }else{
            Log::error("Gagal Menghapus Data Pemasukan Pada Menu Pemasukan Dengan Kode Barang : " . $kodeBarang );
             return redirect()->route('pemasuakan.index')
            ->with('error', trans('Data Gagal Dihapus'));
        }

    }

    public function deleted()
    {
        $pemasukan = Pemasukan::onlyTrashed()->get();
        return view('pemasukan.deleted', compact('pemasukan'));
    }
    

    public function restore($id)
    {
        $item = Pemasukan::onlyTrashed()->find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau belum terhapus.');
        }

        $item->restore();

        return redirect()->back()->with('success', 'Data berhasil dipulihkan.');
    }

    public function getData(Request $request)
    {
        $query = Pemasukan::select([
            'id',
            'status_sending',
        ]);

        return datatables()->of($query)->make(true);
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
            $pemasukans = Pemasukan::whereIn('id', $ids)->get();
            
            foreach ($pemasukans as $pemasukan) {
        
                // Ambil asset terkait
                $asset = Asset::find($pemasukan->assets_id);
        
                if ($asset) {
                    // Hitung ulang data
                    $totalPemasukanAsset = intval($asset->pemasukan);
                    $jumlahPemasukanAsset = intval($pemasukan->jumlah_barang);
                    $jumlahbarissaatini = intval($asset->jumlah_baris_kode);
                    // dd($jumlahPemasukanAsset);

                    if(intval($asset->stock_opname)==0){
                        $selisih = 0;
                    }
                    else{
                        $selisih = intval($asset->selisih) - $jumlahPemasukanAsset;
                    }
                    


                    $jumlahBarangBertambah = intval($asset->jumlah_barang) - $jumlahPemasukanAsset;
                    $jumlahselisihBertambah = intval($asset->jumlah_selisih) - $jumlahPemasukanAsset ;
                    $totalMinusSatu = $jumlahbarissaatini - 1;
                    $totalPemasukanBaru = $totalPemasukanAsset - $jumlahPemasukanAsset ;
                    // dd($totalPemasukanBaru);
        
                    // Update asset
                    $asset->update([
                        'jumlah_barang' => $jumlahBarangBertambah,
                        'saldo_buku' => $jumlahBarangBertambah,
                        'selisih'=> $selisih,
                        'jumlah_selisih' => $jumlahselisihBertambah,
                        'jumlah_baris_kode' => $totalMinusSatu,
                        'pemasukan'         => $totalPemasukanBaru,
                    ]);
                }
            }
        
            // Setelah update asset → baru soft delete pemasukan
            Pemasukan::whereIn('id', $ids)->delete();
        
            return back()->with('success', 'Data berhasil dihapus dan asset diperbarui.');
        }

        if ($action == 'restore') {

            $pemasukans = Pemasukan::onlyTrashed()->whereIn('id', $ids)->get();
            
            foreach ($pemasukans as $pemasukan) {
        
                // Ambil asset terkait
                $asset = Asset::find($pemasukan->assets_id);
        
                if ($asset) {
                    // Hitung ulang data
                    $totalPemasukanAsset = intval($asset->pemasukan);
                    $jumlahPemasukanAsset = intval($pemasukan->jumlah_barang);
                    $jumlahBarangDihapus = intval($pemasukan->jumlah_barang);
                    $jumlahbarissaatini = intval($asset->jumlah_baris_kode);
                    // dd($jumlahPemasukanAsset);

                    if(intval($asset->stock_opname)==0){
                        $selisih = 0;
                    }
                    else{
                        $selisih = intval($asset->selisih) + $jumlahPemasukanAsset;
                    }
                    


                    $jumlahBarangBertambah = intval($asset->jumlah_barang) + $jumlahPemasukanAsset;
                    $jumlahselisihBertambah = intval($asset->jumlah_selisih) + $jumlahPemasukanAsset ;
                    $totalMinusSatu = $jumlahbarissaatini + 1;
                    $totalPemasukanBaru = $jumlahPemasukanAsset + $totalPemasukanAsset;
        
                    // Update asset
                    $asset->update([
                        'jumlah_barang' => $jumlahBarangBertambah,
                        'saldo_buku' => $jumlahBarangBertambah,
                        'selisih'=> $selisih,
                        'jumlah_selisih' => $jumlahselisihBertambah,
                        'jumlah_baris_kode' => $totalMinusSatu,
                        'pemasukan'         => $totalPemasukanBaru,
                    ]);
                }
            }
            Pemasukan::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        if ($action == 'force_delete') {
            Pemasukan::withTrashed()->whereIn('id', $ids)->forceDelete();
        }

        return back()->with('success', 'Aksi berhasil');
    }


    
    public function deleteLampiran($id, $index)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $this->authorize($pemasukan);
    
        $lampiranList = explode(',', $pemasukan->lampiran);
        
        if (isset($lampiranList[$index])) {
            $filePath = public_path($lampiranList[$index]);
    
            // Hapus file fisik kalau ada
            if (file_exists($filePath)) {
                unlink($filePath);
            }
    
            // Hapus dari array
            unset($lampiranList[$index]);
    
            // Update database
            $pemasukan->lampiran = implode(',', array_values($lampiranList)); // reindex
            $pemasukan->save();
        }
    
        return redirect()->back()->with('success', 'Lampiran berhasil dihapus.');
    }

    
    
    public function sendApiPem(){
        $client = new Client();
        $url = 'https://api.insw.go.id/api-prod/inventory/temp/transaksi';
        
        $dataSend = Pemasukan::where('status_sending', 'a')
                                    ->where('departemen', 'OPERATION')
                                    ->get();
                                    
        if($dataSend != ""){
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
                    // "kdKegiatan" => (String) config('app.kode_pemasukan'),
                    "kdKegiatan" => '30',
                    "dokumenKegiatan" => [
                        [
                        "nomorDokKegiatan" =>  (String) $d['nomor_pemasukan'],
                        "tanggalKegiatan" =>  $d['tanggal_pemasukan'],
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

                try {
                    $request = $client->post($url, [
                        'headers' => [
                            'accept' => 'application/json',
                            'x-insw-key' => 'RqT40lH7Hy202uUybBLkFhtNnfAvxrlp',
                            'x-unique-key' => '0862fbfe75bc4cbb1d18c278b720a40549f3d6b226470318dd927054e0b89ed0'
                        ],
                        'json' => $data
                    ]);
                    $response = json_decode($request->getBody(), true);

                    if($response['code'] === '01'){
                        $dataResult[$no] = [
                            "status" => $response['code'],
                            "nomor_pemasukan" => $d['nomor_pemasukan'],
                            "kode" => $d['id'],
                        ];
                    }else{
                        $dataResultError[$no] = "Status Data = " . $response['code'] . " nomor Pemasukan = " . $d['nomor_pemasukan'];
                    }

                    for ($i=1; $i <= count($dataResult); $i++) { 
                        $dataUpdate = [
                            'status_sending' => 'n'
                        ];
                        DB::table('pemasukan')
                            ->where('id', $dataResult[$i]['kode'])
                            ->update($dataUpdate);
                    }

                } catch (\Throwable $e) {
                    
                    $error = $e->getResponse()->getBody()->getContents();
                    if($error != null){
                        $errorDecode = json_decode($error, true);
                        $pesanError = 'Kode Status = ' . $errorDecode['code'] . ', Pesan = ' . $errorDecode['message'];
                    }else{
                        $pesanError = $e->getMessage();
                    }
                    Log::error('Pengiriman Data Api Pemasukan Error : ' . $e->getMessage());
                    return redirect()->route('pemasukan.index')->with('error', $pesanError . ' -- Pada Data Pemasukan Ke = ' . $no . ' -- ' . now());
                }
            }
            
            return redirect()->route('pemasukan.index')
                ->with('success-unescaped', 'Berhasil Mengirimkan Data Ke INSW dengan ' .count($dataResult) . 'data berhasil, dan ' . count($dataResultError) . ' data error  -- ' . now());
        }else{
            return redirect()->route('pemasukan.index')
                ->with('success-unescaped', 'Data Yang Dikirim 0');
        }
    }
    
}
