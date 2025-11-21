<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Adjustment;
use App\Models\Asset;
use App\Models\Perusahaan;
use App\Models\TransaksiAdjusment;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdjusmentController extends Controller
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
        $this->authorize('view', Adjustment::class);

        $query = Adjustment::query();
        

        // Filter hanya berdasarkan tanggal_pelaksanaan
        if ($request->filled('tanggal_pelaksanaan_awal') && $request->filled('tanggal_pelaksanaan_akhir')) {
            $query->whereBetween('tanggal_pelaksanaan', [
                $request->input('tanggal_pelaksanaan_awal'),
                $request->input('tanggal_pelaksanaan_akhir')
            ]);
        } else if ($request->filled('tanggal_pelaksanaan')) {
            $query->where('tanggal_pelaksanaan', '=', $request->input('tanggal_pelaksanaan'));
        }

        // Ambil data sesuai kebutuhan (misal paginasi, sorting, dsb)
        $adjusments = $query->get();

        return view('adjusment/index', compact('adjusments'));
    }

    public function edit($adjusmentId){
        if (!$item = Adjustment::with('asset')->find($adjusmentId)) {
            // Redirect to the asset management page with error
            return redirect()->route('adjusment.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize($item);

        // dd($item);
        return view('adjusment/edit', compact('item'))
            ->with('kodeDokumen', Helper::kodeDokumen())
            ->with('category', Helper::kategoriBarang())
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

    public function update(Request $request){
        $adjusmentId = $request->input('id');
        if (!$adjust = Adjustment::find($adjusmentId)) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize($adjust);
        
        $rules = [];
        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'nullable|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);

        $asset = Asset::find($adjust->asset_id);

        $jumlahBarangSeb = intval($request->input('jumlah_barang'));
        $adjustAssetSeb = intval($asset->penyesuaian); 
        $saldoAwalSeb = intval($request->input('saldo_awal'));
        $pemasukanSeb = intval($request->input('pemasukan'));
        $pengeluaranSeb = intval($request->input('pengeluaran'));
        $saldoBukuSeb = intval($request->input('saldo_buku'));
        $stockOpname = intval($request->input('stock_opname'));
        $hasilPencacahan = intval($request->input('hasil_pencacahan'));

        
        $jumlahBarangAdjusment = intval($request->input('jumlah_barang_adjusment'));
        
        $selisih = $stockOpname - $saldoBukuSeb - $jumlahBarangAdjusment;
        
        $saldoBukuUpd = $saldoAwalSeb + $pemasukanSeb - $pengeluaranSeb + $jumlahBarangAdjusment;
        
        if($jumlahBarangAdjusment < 0){
            $totalBarang = $jumlahBarangSeb - abs($jumlahBarangAdjusment);
        }else{
            $totalBarang = $jumlahBarangSeb + abs($jumlahBarangAdjusment);
        }

        $hargaSatuanBarang = intval($request->input('harga_satuan_barang'));

        $hargaTotalBarangUpdate = $totalBarang * $hargaSatuanBarang;
        
        $jumlahSelisih      = $saldoBukuUpd - $hasilPencacahan;
        $jumlahSelisihSeb      = intval($asset->jumlah_selisih);

        $kodeDokumen = $request->input('kode_dokumen');
        $namaDokumen = $this->convertDokumen($kodeDokumen);

        // $det = [
        //     'jumlahBarangSeb' => $jumlahBarangSeb,
        //     'jumlahBarangAdjusment' => $jumlahBarangAdjusment,
        //     'adjustAssetSeb' => $adjustAssetSeb,
        //     'saldoAwalSeb' => $saldoAwalSeb,
        //     'pemasukanSeb' => $pemasukanSeb,
        //     'pengeluaranSeb' => $pengeluaranSeb,
        //     'saldoBukuSeb' => $saldoBukuSeb,
        //     'stockOpname' => $stockOpname,
        //     'saldoBukuUpd' => $saldoBukuUpd,
        //     'selisih' => $selisih,
        //     'totalBarang' => $totalBarang,
        //     'hargaTotalBarangUpdate' => $hargaTotalBarangUpdate,
        //     'jumlahSelisih' => $jumlahSelisih,
        // ];
        // dd($det);

        $adjust->nomor_dokumen_kegiatan = $request->input('nomor_dokumen_kegiatan');
        $adjust->nama_entitas_transaksi = $request->input('nama_entitas_transaksi');
        $adjust->tanggal_pelaksanaan = $request->input('tanggal_pelaksanaan');
        $adjust->kode_barang = $request->input('kode_barang');
        $adjust->nama_barang = $request->input('nama_barang');
        
        $adjust->kategori_barang = $request->input('kategori_barang');
        $adjust->nomor_kategori_barang = $request->input('nomor_kategori_barang');
        $adjust->satuan_barang = $request->input('satuan_barang');
        
        $adjust->jumlah_barang = $jumlahBarangSeb;
        $adjust->harga_satuan_barang = $request->input('harga_satuan_barang');
        $adjust->harga_total_barang = $request->input('harga_total_barang');
        $adjust->penyesuaian = $jumlahBarangAdjusment;
        $adjust->saldo_buku = $saldoBukuSeb;
        $adjust->selisih = $request->input('selisih');
        $adjust->hasil_pencacahan = $hasilPencacahan;
        $adjust->jumlah_selisih = $jumlahSelisihSeb;
        $adjust->keterangan = request('keterangan', '');
        $adjust->kode_dokumen = $kodeDokumen;
        $adjust->nama_dokumen = $namaDokumen;
        $adjust->nomor_dokumen = request('nomor_dokumen', '');
        $adjust->tanggal_dokumen = request('tanggal_dokumen', '');
        $adjust->status_kirim = 'B';
        
        $lampiranPaths = [];

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '-' . str_replace(' ', '_', $file->getClientOriginalName());
                    $folder = 'uploads/dokumen_adjustment';
                    $path = $folder . '/' . $filename;
        
                    $file->move(public_path($folder), $filename);
                    $lampiranPaths[] = $path;
                }
            }
        
            // Gabungkan file lama + file baru
            $existingLampiran = $adjust->lampiran ? explode(',', $adjust->lampiran) : [];
            $adjust->lampiran = implode(',', array_merge($existingLampiran, $lampiranPaths));
        }

        $save = $adjust->save();

        if($save){

            $asset->jumlah_barang        = $totalBarang;
            $asset->harga_total_barang   = $hargaTotalBarangUpdate;
            $asset->penyesuaian          = $jumlahBarangAdjusment;
            $asset->saldo_buku           = $saldoBukuUpd;
            $asset->selisih              = $selisih;
            $asset->jumlah_selisih       = $jumlahSelisih;
            $asset->update();

            \Log::debug(e($adjust->kode_barang));
            return redirect()->route('adjusment.index')
                ->with('success-unescaped', trans('admin/hardware/message.create.success_linked'));
        }


        return redirect()->back()->withInput()->withErrors($adjust->getErrors());
    }

    public function destroy($adjusmentId){
        if (is_null($adjust = Adjustment::find($adjusmentId))) {
            return redirect()->route('adjusment.index')
                ->with('error', trans('Data Adjusment Tidak Di Temukan'));
        }

        $asset = Asset::find($adjust->asset_id);
        $totalsaatiniadj       = $asset->jumlah_baris_adjustment ;
        $jadjustasset       = $asset->pengeluaran ;
        $jadjustbarang = $adjust->jumlah_barang;
        $totaladjust = intval($jadjustasset )-intval($jadjustbarang);
        $totalminussatuadj      = intval($totalsaatiniadj) - 1;

        $dataUpdAsset       = [
            'penyesuaian' => $totaladjust,
            'jumlah_baris_adjustment' => $totalminussatuadj,
        ];

        DB::table('assets')
                ->where('id', $adjust->asset_id)
                ->update($dataUpdAsset);


        $del = $adjust->delete();

        if($del){
            return redirect()->route('adjusment.index')
            ->with('success', trans('Data Adjusment Berhasil Di Hapus'));
        }else{
             return redirect()->route('adjusment.index')
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

        if (!$ids || !$action) {
            return back()->withErrors('Tidak ada aksi atau data dipilih');
        }

        if ($action === 'delete') {
            Adjustment::whereIn('id', $ids)->delete();
            return back()->with('success', 'Data berhasil dihapus');
        }

        if ($action == 'restore') {
        
            Adjustment::onlyTrashed()->whereIn('id', $ids)->restore();
            return back()->with('success', 'Data berhasil direstore');
        }

        return back()->with('success', 'Aksi berhasil');
    }
    
    public function deleteLampiran($id, $index)
    {
        $stockopname = Adjustment::findOrFail($id);
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

    public function sendApiAdjust(){
        $client = new Client();
        $url = 'https://api.insw.go.id/api-prod/inventory/temp/transaksi';

        // $dataSend = Adjustment::all()->where('status_kirim', 'B');
        $dataSend = Adjustment::where('status_kirim', 'B')
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
                        "kdKegiatan" => "33",
                        "npwp" => (String) $dataPerusahaan->perusahaan_npwp,
                        "nib" => (String) $dataPerusahaan->perusahaan_nib,
                        "dokumenKegiatan" => [
                            [
                            "nomorDokKegiatan" =>  (String) $d['nomor_dokumen_kegiatan'],
                            "tanggalKegiatan" =>  $d['tanggal_pelaksanaan'],
                            "namaEntitas" =>  (String) $d['nama_entitas_transaksi'],
                            "keterangan" => (String) $d['keterangan'],
                            "barangTransaksi" =>  [
                                        [
                                            "kdKategoriBarang" => (String) $d['nomor_kategori_barang'],
                                            "kdBarang" => (String) $d['kode_barang'],
                                            "uraianBarang" => (String) $d['nama_barang'],
                                            "jumlah" => (int) $d['penyesuaian'],
                                            "kdSatuan" => (String) $d['satuan_barang'],
                                            "nilai" => intval($d["harga_total_barang"]),
                                            "dokumen" => [
                                                [
                                                    "kodeDokumen" => $d['kode_dokumen'],
                                                    "nomorDokumen" => $d['nomor_dokumen'],
                                                    "tanggalDokumen" => $d['tanggal_dokumen'],
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
                    DB::table('adjusment')
                        ->where('id', $dataResult[$i]['kode'])
                        ->update($dataUpdate);
                }
        
                return redirect()->route('adjusment.index')
                ->with('success-unescaped', 'Berhasil Mengirimkan Data Ke INSW dengan ' .count($dataResult) . ' data berhasil, dan ' . count($dataResultError) . ' data error  -- ' . now());

            } catch (\Throwable $e) {
                
                $error = $e->getResponse()->getBody()->getContents();
                if($error != null){
                    $errorDecode = json_decode($error, true);
                    $pesanError = 'Kode Status = ' . $errorDecode['code'] . ', Pesan = ' . $errorDecode['message'];
                }else{
                    $pesanError = $e->getMessage();
                }
                Log::error('Pengiriman Data Api Adjusment Error : ' . $e->getMessage());
                return redirect()->route('adjusment.index')->with('error', $pesanError . ' -- Pada Data Adjusment Ke = ' . $no . ' -- ' . now());
            }
        }else{
            return redirect()->route('adjusment.index')
            ->with('success-unescaped', 'Berhasil Mengirimkan Data adjusment Ke INSW dengan jumlah data = 0 - ' . now());

        }

        
    }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
