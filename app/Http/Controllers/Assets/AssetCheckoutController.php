<?php

namespace App\Http\Controllers\Assets;

use App\Exceptions\CheckoutNotAllowed;
use App\Helpers\Helper;
use App\Http\Controllers\CheckInOutRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCheckoutRequest;
use App\Models\Asset;
use App\Models\Pengeluaran;
use App\Models\JenisPeng;
use App\Models\Statusp;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssetCheckoutController extends Controller
{
    use CheckInOutRequest;

    /**
     * Returns a view that presents a form to check an asset out to a
     * user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return View
     */
    public function create($assetId)
    {
        // Check if the asset exists
        if (is_null($item = Asset::with('company')->find(e($assetId)))) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkout', $item);

        if ($item->availableForCheckout()) {
            return view('hardware/checkout', compact('item'))
                ->with('statusLabel_list', Helper::deployableStatusLabelList())
                ->with('jenisPengeluaran', Helper::jenisPengeluaran())
                ->with('listStatusp', Helper::listStatusp())
                ->with('listjenisPeng', Helper::listjenisPeng())
                ->with('kodeDokumen', Helper::kodeDokumen());
        }

        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.not_available'));
    }

    /**
     * Validate and process the form data to check out an asset to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckoutRequest $request
     * @param int $assetId
     * @return Redirect
     * @since [v1.0]
     */

    //  private function convertDokumen($kodeDokumen){

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
    
    private function convertStatusp($listStatusp)
    {
        return Statusp::where('id', $listStatusp)->value('nama_status') ?? '';
    }

    private function convertJenisP($listjenisPeng)
    {
        return JenisPeng::where('id', $listjenisPeng)->value('nama_jenis') ?? '';
    }

    
    
    public function store(Request $request, $assetId)
    {
        if (!$asset = Asset::find($assetId)) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize($asset);
        
        $lampiranFiles = $request->file('lampiran') ?? [];
        $rules = [];

        foreach ($lampiranFiles as $index => $file) {
            $rules["lampiran.$index"] = 'required|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);
        
        try {
            $peng = new Pengeluaran();

            $lampiranPaths = [];
            if (count($lampiranFiles)) {
                foreach ($lampiranFiles as $file) {
            
            // if ($request->hasFile('lampiran')) {
            //     foreach ($request->file('lampiran') as $file) {
                    if ($file->isValid()) {
                        $filename = time() . '-' . str_replace(' ', '_', $file->getClientOriginalName());
                        $folder = 'uploads/dokumen_pengeluaran';
                        $path = $folder . '/' . $filename;
            
                        $file->move(public_path($folder), $filename);
                        $lampiranPaths[] = $path;
                    }
                }
            
                $peng->lampiran = implode(',', $lampiranPaths);
            }

            $jenisPengeluaran = $request->input('jenis_pengeluaran');
            $kodeDokumen = $request->input('kode_dokumen');
            $namaDokumen = $this->convertDokumen($kodeDokumen);
            // dd($request->all());

            
            $peng->asset_id       =  $asset->id;
            $peng->nomor_daftar    =  $request->input('nomor_daftar');
            $peng->tanggal_daftar  =  $request->input('tanggal_daftar');
            $peng->nomor_pengeluaran =  $request->input('nomor_pengeluaran');
            $peng->tanggal_pengeluaran =  $request->input('checkout_at');
            $peng->nama_pengirim   =  $request->input('nama_pengirim');
            $peng->kode_barang     =  $request->input('kode_barang');
            $peng->departemen     =  $request->input('departemen');
            $peng->kategori_barang     =  $request->input('kategori_barang');
            $peng->nomor_kategori_barang     =  $request->input('nomor_kategori_barang');
            $peng->nama_barang     =  $request->input('name');
            $peng->satuan_barang   =  $request->input('satuan_barang');
            $peng->jumlah_barang   =  $request->input('jumlah_barang_peng');
            $peng->harga_satuan_barang   =  $request->input('harga_satuan_barang');
            $peng->harga_total_barang =  $request->input('harga_total_barang');
            $peng->nomor_dokumen_pabean =  $request->input('nomor_dokumen');
            $peng->kode_dokumen_pabean =  $kodeDokumen;
            // $peng->jenis_pengeluaran =  $jenisPengeluaran;
            $peng->statuspeng = $this->convertStatusp($request->input('nama_statusp'));
            $peng->jenis_pengeluaran = $this->convertJenisP($request->input('nama_jenis'));
            $peng->nama_dokumen_pabean =  $namaDokumen;
            $peng->tanggal_dokumen_pabean =  $request->input('tanggal_dokumen');
            $peng->status_sending =  'a';
            $peng->status_penyesuaian =  'B';
            $peng->user_id = request('assigned_user', 1);
            // $peng->lampiran = implode(',', $lampiranPaths);
            $save = $peng->save();

            if($save){
                $pemasukanSeb   = intval($asset->pemasukan);
                $pengeluaranSeb = intval($asset->pengeluaran);
                $penyesuaianSeb = intval($asset->penyesuaian);
                $stockOpnameSeb = intval($asset->stock_opname);
                $saldoAwalSeb   = intval($asset->saldo_awal);

                $pengeluaran      = intval($request->input('jumlah_barang_peng'));
                $totalPengeluaran = $pengeluaranSeb + $pengeluaran;

                $saldoBuku      = $saldoAwalSeb + $pemasukanSeb - $totalPengeluaran + $penyesuaianSeb; 
                $saldoBukuSelisih      = $saldoAwalSeb + $pemasukanSeb - $totalPengeluaran; 
                
                if($stockOpnameSeb == 0){
                    $selisih = 0;
                }else{
                    $selisih = $stockOpnameSeb - $saldoBukuSelisih - $penyesuaianSeb;
                }

                $jumlahBarSeb = $asset->jumlah_barang;
                $totalBarang  = intval($jumlahBarSeb) - intval($pengeluaran);

                $jumlahTotalBarSeb = $asset->harga_total_barang;
                $jumlahTotalBarSek = $request->input('harga_total_barang');
                $totalHargaBarang  = intval($jumlahTotalBarSeb) - intval($jumlahTotalBarSek);
                $hasilPencacahanSeb = intval($asset->hasil_pencacahan);
                $totalsaatinipeng       = $asset->jumlah_baris_pengeluaran;
                $totalplussatupeng      = intval($totalsaatinipeng) + 1;

                if($jenisPengeluaran == 'dispose'){
                    $hasilPencacahan = $hasilPencacahanSeb + $pengeluaran;
                }else{
                    $hasilPencacahan = $hasilPencacahanSeb;
                }
                
                $jumlahSelisih = $saldoBuku - $hasilPencacahan;

                $dataUpdAsset = [
                    'pengeluaran'           => $totalPengeluaran,
                    'jumlah_baris_pengeluaran'     => $totalplussatupeng,
                    'jumlah_barang'         => $totalBarang,
                    'harga_total_barang'    => $totalHargaBarang,
                    'penyesuaian'           => $penyesuaianSeb,
                    'saldo_buku'            => $saldoBuku,
                    'stock_opname'          => $stockOpnameSeb,
                    'selisih'               => $selisih,
                    'hasil_pencacahan'      => $hasilPencacahan,
                    'jumlah_selisih'        => $jumlahSelisih,
                ];

                DB::table('assets')
                        ->where('id', $assetId)
                        ->update($dataUpdAsset);

                $admin = Auth::user();

                $target = $this->determineCheckoutTarget($asset);

                $asset = $this->updateAssetLocation($asset, $target);

                $checkout_at = date('Y-m-d H:i:s');
                if (($request->filled('checkout_at')) && ($request->get('checkout_at') != date('Y-m-d'))) {
                    $checkout_at = $request->get('checkout_at');
                }

                $expected_checkin = '';
                if ($request->filled('expected_checkin')) {
                    $expected_checkin = $request->get('expected_checkin');
                }

                if ($request->filled('status_id')) {
                    $asset->status_id = $request->get('status_id');
                }

                if (!empty($asset->licenseseats->all())) {
                    if (request('checkout_to_type') == 'user') {
                        foreach ($asset->licenseseats as $seat) {
                            $seat->assigned_to = null;
                            $seat->save();
                        }
                    }
                }

                $settings = \App\Models\Setting::getSettings();

                // We have to check whether $target->company_id is null here since locations don't have a company yet
                if (($settings->full_multiple_companies_support) && ((!is_null($target->company_id)) &&  (!is_null($asset->company_id)))) {
                    if ($target->company_id != $asset->company_id) {
                        return redirect()->to("hardware/$assetId/checkout")->with('error', trans('general.error_user_company'));
                    }
                }

                if ($asset->checkOut($target, $admin, $checkout_at, $expected_checkin, $request->get('note'), $request->get('name'))) {
                    DB::table('assets')
                        ->where('id', $assetId)
                        ->update(['assigned_to' => null]);
                    return redirect()->route('pengeluaran.index')->with('success', trans('admin/hardware/message.checkout.success'));
                }

                Log::warning("Berhasil Menambahkan Data Pengeluaran Dengan Kode Barang : " . $request->input('kode_barang'));
            }else{

                Log::error("Gagal Menambahkan Data Pengeluaran Dengan Kode Barang : " . $request->input('kode_barang') . ' karena' . json_encode($peng->getErrors()));
                return redirect()->to("hardware/$assetId/checkout")->with('error', trans('Error Data Pengeluarann'))->withInput()->withErrors($peng->getErrors());
            }
            // Redirect to the asset management page with error
            return redirect()->to("hardware/$assetId/checkout")->with('error', trans('admin/hardware/message.checkout.error') . $peng->getErrors());
        } catch (\Throwable $e) {
            Log::error('Gagal Menambahkan Data Pengeluaran Pada Transaksi Pengeluaran Dengan Kode Barang = ' . $request->input('kode_barang') . ' Karena ' . $e->getMessage());    
        }
        // return redirect()->back()->withInput()->withErrors($pemasukan->getErrors());
        
        return redirect()->back()->withInput()->withErrors(['lampiran' => $e->getMessage()]);
    }
}
