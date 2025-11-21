<?php

namespace App\Console\Commands;

use App\Models\Perusahaan;
use App\Models\StockOpname;
use App\Models\TransaksiStockopname;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CronjobOpname extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sg:cronjob-transaksi-stockopname';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'kirim data stock opname otomatis';

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

     public function handle(){
        $client = new Client();
        $url = config('app.endpoint_pemasukan');

        // $dataSend = StockOpname::all()->where('status_kirim', 'B');
        $dataSend = StockOpname::where('status_kirim', 'B')
                            ->where('departemen', 'Logistic KePabeanan')
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
                            'x-insw-key' => 'RqT40lH7Hy202uUybBLkFhtNnfAvxrlp'
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
        
                echo 'success-unescaped', 'Berhasil Mengirimkan stock opnameData Ke INSW dengan ' .count($dataResult) . 'data berhasil, dan ' . count($dataResultError) . ' data error  -- ' . now();

            } catch (\Throwable $e) {
                
                $error = $e->getResponse()->getBody()->getContents();
                if($error != null){
                    $errorDecode = json_decode($error, true);
                    $pesanError = 'Kode Status = ' . $errorDecode['code'] . ', Pesan = ' . $errorDecode['message'];
                }else{
                    $pesanError = $e->getMessage();
                }
                Log::error('Pengiriman Data Api Stockopname Error : ' . $e->getMessage());
                echo $pesanError . ' -- Pada Data Stockopname Ke = ' . $no . ' -- ' . now();
            }
            
        }else{
            echo 'success-unescaped', 'Berhasil Mengirimkan Data stock opname Ke INSW dengan jumlah data = 0 - ' . now();

        }
     }


    //  public function handle()
    //  {
    //      $client = new Client();
    //      $url = config('app.endpoint_pemasukan');
 
    //      $opname = StockOpname::all()->where('status_kirim', 'B');
 
    //      $dt = Carbon::now();
    //      $data = [];
    //      $dataKet = [];
    //      foreach ($opname as $key => $a) {
    //          $row = [];
 
    //          if($a['kode_dokumen'] == "" || $a['kode_dokumen'] == NULL || empty($a['kode_dokumen'])){
    //              $dataDokumen = "";
    //          }else{
    //              $dataDokumen = [
    //                  "kodeDokumen" => $a['kode_dokumen'],
    //                  "nomorDokumen" => $a['nomor_dokumen'],
    //                  "tanggalDokumen" => $a['tanggal_dokumen'],
    //              ];
    //          }
 
    //          $row["kdKategoriBarang"] = (String) $a['nomor_kategori_barang'];
    //          $row["kdBarang"] = (String) $a["kode_barang"];
    //          $row["uraianBarang"] = (String) $a["nama_barang"];
    //          $row["jumlah"] = $a["jumlah_barang"];
    //          $row["kdSatuan"] = $a["satuan_barang"];
    //          $row["nilai"] = intval($a["harga_total_barang"]);
    //          $row["dokumen"] = [$dataDokumen];
    //          $data[] = $row;
    //      }
 
    //      $dataTransaksi = TransaksiStockopname::all()->last();
    //      $noTrans = (int) $dataTransaksi->transaksi_nomor;
    //      $nomorDokKegiatan = ucwords($dataTransaksi->transaksi_ket) . intval($noTrans);
 
    //      $dataPerusahaan = Perusahaan::find(1);
 
    //      $dataKet["nomorDokKegiatan"] = (String) $nomorDokKegiatan;
    //      $dataKet["tanggalKegiatan"] = $dt->toDateString();
    //      $dataKet["namaEntitas"] = (String) $dataPerusahaan->perusahaan_nama;
    //      $dataKet["barangTransaksi"] = $data;
         
    //      $dataHead["kdKegiatan"] = "32"; 
    //      $dataHead["npwp"] = (String) $dataPerusahaan->perusahaan_npwp; 
    //      $dataHead["nib"] = (String) $dataPerusahaan->perusahaan_nib; 
    //      $dataHead["dokumenKegiatan"] = [$dataKet]; 
 
    //      try {
    //          $request = $client->post($url, [
    //              'headers' => [
    //                  'accept' => 'application/json',
    //                  'x-insw-key' => 'RqT40lH7Hy202uUybBLkFhtNnfAvxrlp'
    //              ],
    //              'json' => [
    //                  "data" => [
    //                      $dataHead
    //                  ]
                     
    //              ]
    //          ]);
     
    //          $response = json_decode($request->getBody(), true);
    //          if($response['code'] === '01'){
    //              $noTrans = (int)  $noTrans + 1;
    //              $transaksi = new TransaksiStockopname();
    //              $transaksi->transaksi_nomor = $noTrans;
    //              $transaksi->transaksi_ket = 'StockOpname';
    //              $transaksi->save();
 
    //              foreach ($opname as $key => $d) {
    //                  $dataUpdate = [
    //                      'status_kirim' => 'S'
    //                  ];
    //                  DB::table('stock_opname')
    //                      ->where('asset_id', $d['id'])
    //                      ->update($dataUpdate);
    //              }
    //              echo 'Berhasil Mengirimkan Data Ke INSW' . now();
    //          }else{
    //              echo 'Gagal Mengirimkan Data Ke INSW' . now();
    //          }
             
    //      }catch (\Exception $e) {
    //          // Handle exceptions during the request
    //          // echo "Error: " . $e->getMessage();
    //          echo 'Error:' . $e->getMessage();
             
    //      }
 
 
    //  }

    // public function handle()
    // {
    //     $client = new Client();
    //     $url = config('app.endpoint_pemasukan');

    //     $opname = StockOpname::all()->where('status_kirim', 'B');

    //     $dt = Carbon::now();
    //     $data = [];
    //     $dataKet = [];
    //     foreach ($opname as $key => $a) {
    //         $row = [];

    //         if($a['kode_dokumen'] == "" || $a['kode_dokumen'] == NULL || empty($a['kode_dokumen'])){
    //             $dataDokumen = "";
    //         }else{
    //             $dataDokumen = [
    //                 "kodeDokumen" => $a['kode_dokumen'],
    //                 "nomorDokumen" => $a['nomor_dokumen'],
    //                 "tanggalDokumen" => $a['tanggal_dokumen'],
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

    //     $dataTransaksi = TransaksiStockopname::all()->last();
    //     $noTrans = (int) $dataTransaksi->transaksi_nomor;
    //     $nomorDokKegiatan = ucwords($dataTransaksi->transaksi_ket) . intval($noTrans);

    //     $dataPerusahaan = Perusahaan::find(1);

    //     $dataKet["nomorDokKegiatan"] = (String) $nomorDokKegiatan;
    //     $dataKet["tanggalKegiatan"] = $dt->toDateString();
    //     $dataKet["namaEntitas"] = (String) $dataPerusahaan->perusahaan_nama;
    //     $dataKet["barangTransaksi"] = $data;
        
    //     $dataHead["kdKegiatan"] = "32"; 
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
    //             $noTrans = (int)  $noTrans + 1;
    //             $transaksi = new TransaksiStockopname();
    //             $transaksi->transaksi_nomor = $noTrans;
    //             $transaksi->transaksi_ket = 'StockOpname';
    //             $transaksi->save();

    //             foreach ($opname as $key => $d) {
    //                 $dataUpdate = [
    //                     'status_kirim' => 'S'
    //                 ];
    //                 DB::table('stock_opname')
    //                     ->where('asset_id', $d['id'])
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


    // }
}
