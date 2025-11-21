<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\Pengeluaran;
use App\Models\Perusahaan;
use App\Models\TransaksiPengeluaran;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CronjobTransaksiPengeluaran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sg:cronjob-transaksi-pengeluaran';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menambahkan Transaksi Pengeluaran Otomatis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        // $url = 'https://api.insw.go.id/api-prod/inventory/pemasukan/tempInsert';
        $url = config('app.endpoint_pengeluaran');

        $dataSend = Pengeluaran::all()->where('status_sending', 'a');
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
                            'x-insw-key' => 'RqT40lH7Hy202uUybBLkFhtNnfAvxrlp'
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
        
                echo 'Berhasil Mengirimkan Data Pengeluaran Ke INSW dengan ' . count($dataResult) . ' Berhasil, dan ' . count($dataResultError) . ' data error - ' . now();
                
            } catch (\Throwable $e) {
                $error = $e->getResponse()->getBody()->getContents();
                if($error != null){
                    $errorDecode = json_decode($error, true);
                    $pesanError = 'Kode Status = ' . $errorDecode['code'] . ', Pesan = ' . $errorDecode['message'];
                }else{
                    $pesanError = $e->getMessage();
                }
                Log::error('Pengiriman Data Api Pengeluaran Error : ' . $e->getMessage());
                echo $pesanError . ' -- Pada Data Pengeluaran Ke = ' . $no . ' -- ' . now();
            }

        }else{
            echo 'Berhasil Mengirimkan Data Pengeluaran Ke INSW dengan Data yang dikirim 0 - ' . now();

        }
        
    
    }
    
    //  public function handle()
    // {
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
    //             echo 'Berhasil Mengirimkan Data Ke INSW' . now();
    //         }else{
    //             echo 'Gagal Mengirimkan Data Ke INSW' . now();
    //         }
            
    //     }catch (\Exception $e) {
    //         // Handle exceptions during the request
    //         // echo "Error: " . $e->getMessage();
    //         echo 'Error:' . $e->getMessage();
            
    //     }

        
    //     // echo 'Cron kita sudah jalan!';
    //     // // info("Cron Job running at ". now());
    //     // \Log::info('Cron kita sudah jalan!');
    
    // }
}
