<?php

namespace App\Http\Controllers\Assets;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Actionlog;
use App\Models\Adjustment;
use Illuminate\Support\Facades\Log;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\Company;
use App\Models\Keterangan;
use App\Models\Detaillokasi;
use App\Models\Lokasi;
use App\Models\Owner;
use App\Models\Location;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Perusahaan;
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Models\StockOpname;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\View\Label;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;

/**
 * This class controls all actions related to assets for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class AssetsController extends Controller
{
    protected $qrCodeDimensions = ['height' => 3.5, 'width' => 3.5];
    protected $barCodeDimensions = ['height' => 2, 'width' => 22];

    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the assets listing, which is generated in getDatatable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see AssetController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @param Request $request
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', Asset::class);
        $company = Company::find($request->input('company_id'));

        return view('hardware/index')->with('company', $company);
    }

    /**
     * Returns a view that presents a form to create a new asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param Request $request
     * @return View
     * @internal param int $model_id
     */

    private function getMataUang(){
        $currency = Helper::mataUang();
        $data = [];
        foreach ($currency as $key => $c) {
            $data[$key] = $c['code'] . ' - ' . $c['title'] . ' - ' . $c['symbol'];
        }

        return $data;
    }

    public function getDataCompanies()
        {
            $companiess = DB::table('companies')->select('id', 'name')->get();
            return response()->json($companiess);

            // if ($companiess) {
            //     $namacompany = explode(', ', $companiess->name);
            //     return response()->json(['namacompany' => $namacompany]);
            // }

            // return response()->json(['namacompany' => []]);
        }


    public function create(Request $request)
    {
        $this->authorize('create', Asset::class);
 
        $dataMataUang = $this->getMataUang();        

        $view = View::make('hardware/edit')
            ->with('statuslabel_list', Helper::statusLabelList())
            ->with('item', new Asset)
            ->with('statuslabel_types', Helper::statusTypeList())
            ->with('kodeDokumen', Helper::kodeDokumen())
            ->with('listdetaillokasi', Helper::listdetaillokasi())
            ->with('listownerr', Helper::listownerr())
            ->with('listlokasi', Helper::listlokasi())
            ->with('category', Helper::kategoriBarang())
            ->with('satuan', Helper::satuanBarang())
            ->with('mataUang', $dataMataUang)
            ->with('statusEdit', false)
            ->with('keteranganPemasukan', Helper::keteranganPemasukan());

        if ($request->filled('model_id')) {
            $selected_model = AssetModel::find($request->input('model_id'));
            $view->with('selected_model', $selected_model);
        }

        return $view;
    }
    
    private function convertDokumen($kodeDokumen)
    {
        $data = \App\Models\KodeDokumen::pluck('label', 'kode')->toArray();

        return array_key_exists($kodeDokumen, $data) ? $data[$kodeDokumen] : '';
    }


    public function cekNomorPengiriman($noPeng){
        $dataPem = Pemasukan::where("nomor_pemasukan", $noPeng)->count();
        if($dataPem == "" || $dataPem == 0){
            $data = [
                "status" => "200",
                "message" => "data tidak Ada",
                "response" => ""
            ]; 
        }else{
            $data = [
                "status" => "201",
                "message" => "data Ada",
                "response" => $dataPem
            ]; 
        }

        return response()->json($data);
    }

    /**
     * Validate and process new asset form data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return Redirect
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize(Asset::class);

        // Handle asset tags - there could be one, or potentially many.
        // This is only necessary on create, not update, since bulk editing is handled
        // differently
        $asset_tags = $request->input('asset_tags');

        $settings = Setting::getSettings();

        $success = false;
        $serials = $request->input('serials');
        
        $rules = [];

        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'required|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);

        try {
            for ($a = 1; $a <= count($asset_tags); $a++) {
                $asset = new Asset();
                $asset->model()->associate(AssetModel::find($request->input('model_id')));
                $asset->name = $request->input('name');
    
                // Check for a corresponding serial
                if (($serials) && (array_key_exists($a, $serials))) {
                    $asset->serial = $serials[$a];
                }
    
                if (($asset_tags) && (array_key_exists($a, $asset_tags))) {
                    $asset->asset_tag = $asset_tags[$a];
                }
                // dd($request->input('kode_dokumen_pabean'));
                
                // dd($kodeDokumen);
                $kodeDokumen = $request->input('kode_dokumen');
                $namaDokumen = $this->convertDokumen($kodeDokumen);
                // dd($this->convertDokumen($kodeDokumen));
    
                $asset->company_id              = Company::getIdForCurrentUser($request->input('company_id'));
                $asset->model_id                = 1;
                $asset->ncompanies              = $request->input('companiess');
                $asset->order_number            = $request->input('order_number');
                $asset->notes                   = $request->input('notes');
                $asset->user_id                 = Auth::id();
                $asset->status_id               = request('status_id');
                $asset->warranty_months         = request('warranty_months', null);
                $asset->purchase_cost           = request('purchase_cost', null);
                $asset->purchase_date           = request('purchase_date', null);
                $asset->asset_eol_date          = request('asset_eol_date', null);
                // $asset->assigned_to             = request('assigned_to', null);
                $asset->assigned_to             = null;
                $asset->supplier_id             = request('supplier_id', null);
                $asset->requestable             = request('requestable', 0);
                $asset->rtd_location_id         = request('rtd_location_id', null);
                $asset->byod                    = request('byod', 0);
                
                // saya yang tambahin
                // $jenisTransaksi = $request->input('jenis_transaksi');
                $jenisTransaksi = 't';
    
                $asset->status_pemasukan_mgpa   = $request->input('status_pemasukan_mgpa');
                $asset->nomor_purchase          = request('nomor_purchase', '');
                $asset->event                   = request('event', '');
                // $asset->metode_pengadaan        = request('metode_pengadaan', '');
                $asset->owner                   = $request->input('nama_owner');
                $asset->departemen              = request('departemenMGPA', '');
                $asset->site                    = request('site', '');
                $asset->nomor_pengajuan          = $request->input('nomor_pengajuan');
                $asset->tanggal_pengajuan        = $request->input('tanggal_pengajuan');
                $asset->lokasi_asset            = $request->input('namalokasi');
                // dd($request->input('detail_lokasi'));
                // dd($request->input('namalokasi'));
                // dd($request->all());
                $asset->detail_lokasi_asset     = $request->input('detail_lokasi');
                $asset->kategori_barang         = $request->input('kategori_barang');
                $asset->nomor_kategori_barang   = $request->input('nomor_kategori_barang');
                $asset->jumlah_barang           = $request->input('jumlah_barang');
                $asset->mata_uang               = $request->input('mata_uang');
                $asset->satuan_barang           = $request->input('satuan_barang');
                $asset->harga_satuan_barang     = $request->input('harga_satuan_barang');
                $asset->harga_total_barang      = $request->input('harga_total_barang');
                $asset->keterangan              = request('keterangan', '');
                // dd($kodeDokumen);
                $asset->kode_dokumen_pabean    = $kodeDokumen;
                $asset->nama_dokumen_pabean    = $namaDokumen;
                $asset->bea        = $request->input('bea');                // Radio
                $asset->ppn        = $request->has('PPN') ? 1 : 0;          // Checkbox
                $asset->pph_impor  = $request->has('PPhImpor') ? 1 : 0;     // Checkbox
                $asset->ppnbm      = $request->has('PPnBM') ? 1 : 0;        // Checkbox
                $lampiranPaths = [];
            
                if ($request->hasFile('lampiran')) {
                    foreach ($request->file('lampiran') as $file) {
                        if ($file->isValid()) {
                            $filename = time() . '-' . str_replace(' ', '_', $file->getClientOriginalName());
                            $folder = 'uploads/dokumen_saldo';
                            $path = $folder . '/' . $filename;
                
                            $file->move(public_path($folder), $filename);
                            $lampiranPaths[] = $path;
                        }
                    }
                
                    $asset->lampiran = implode(',', $lampiranPaths);
                }
                $asset->lampiran = implode(',', $lampiranPaths);
                $asset->status_pemasukan        = 'B';
                $asset->jenis_transaksi         = 't';
                
    
                if($jenisTransaksi == 'y'){
                    // $saldoAwal        = intval($request->input('saldo_awal'));
                    $saldoAwal        = 0;
                    $pemasukan        = intval($request->input('jumlah_barang'));
                    $pengeluaran      = 0;
                    $penyesuaian      = 0;
                    $saldoBukuBaru    = $saldoAwal + $pemasukan - $pengeluaran;
                    $saldoBuku        = $saldoBukuBaru; 
                    $stockopname      = 0;
                    $selisih          = 0;
                    $hasil_pencacahan = 0;
                    $jumlah_selisih   = intval($saldoBuku) - $hasil_pencacahan;
                }else{
                    // $saldoAwal        = $request->input('saldo_awal');
                    $saldoAwal        = 0;
                    $pemasukan        = 0;
                    $pengeluaran      = 0;
                    $penyesuaian      = 0;
                    // $saldoBuku        = $saldoAwal; 
                    $saldoBuku        = 0; 
                    $stockopname      = 0;
                    $selisih          = 0;
                    $hasil_pencacahan = 0;
                    $jumlah_selisih   = intval($saldoBuku) - $hasil_pencacahan;
                }
    
                $asset->saldo_awal       = $saldoAwal;
                // $asset->saldo_awal       = 0;
                $asset->jumlah_baris_kode       = 0;
                $asset->pemasukan        = $pemasukan;
                $asset->pengeluaran      = $pengeluaran;
                $asset->penyesuaian      = $penyesuaian;
                $asset->saldo_buku       = $saldoBuku;
                $asset->stock_opname     = $stockopname;
                $asset->selisih          = $selisih;
                $asset->hasil_pencacahan = $hasil_pencacahan;
                $asset->jumlah_selisih   = $jumlah_selisih;
    
                // ====== internal snipe it
                if (!empty($settings->audit_interval)) {
                    $asset->next_audit_date = Carbon::now()->addMonths($settings->audit_interval)->toDateString();
                }
    
                // Set location_id to rtd_location_id ONLY if the asset isn't being checked out
                if (!request('assigned_user') && !request('assigned_asset') && !request('assigned_location')) {
                    $asset->location_id = $request->input('rtd_location_id', null);
                }
    
                // Create the image (if one was chosen.)
                if ($request->has('image')) {
                    $asset = $request->handleImages($asset);
                }
    
                // Update custom fields in the database.
                // Validation for these fields is handled through the AssetRequest form request
                $model = AssetModel::find($request->get('model_id'));
    
                if (($model) && ($model->fieldset)) {
                    foreach ($model->fieldset->fields as $field) {
                        if ($field->field_encrypted == '1') {
                            if (Gate::allows('admin')) {
                                if (is_array($request->input($field->db_column))) {
                                    $asset->{$field->db_column} = Crypt::encrypt(implode(', ', $request->input($field->db_column)));
                                } else {
                                    $asset->{$field->db_column} = Crypt::encrypt($request->input($field->db_column));
                                }
                            }
                        } else {
                            if (is_array($request->input($field->db_column))) {
                                $asset->{$field->db_column} = implode(', ', $request->input($field->db_column));
                            } else {
                                $asset->{$field->db_column} = $request->input($field->db_column);
                            }
                        }
                    }
                }
                
                // Validate the asset before saving
                if ($asset->isValid() && $asset->save()) {
                    Log::warning('insert data asset ' . $asset_tags[$a] . ' Sukses');
                    if (request('assigned_user')) {
                        $target = User::find(request('assigned_user'));
                        $location = $target->location_id;
                    } elseif (request('assigned_asset')) {
                        $target = Asset::find(request('assigned_asset'));
                        $location = $target->location_id;
                    } elseif (request('assigned_location')) {
                        $target = Location::find(request('assigned_location'));
                        $location = $target->id;
                    }
    
                    if (isset($target)) {
                        $asset->checkOut($target, Auth::user(), date('Y-m-d H:i:s'), $request->input('expected_checkin', null), 'Checked out on asset creation', $request->get('name'), $location);
                    }
    
                
                    if($jenisTransaksi == 'y'){
                        // $dataPemasukan = 
                        $kodeDokumen = $request->input('kode_dokumen');
                        $namaDokumen = $this->convertDokumen($kodeDokumen);
                        $keteranganPemasukan = $request->input('keterangan_pemasukan');
    
                        $pemasukannew = new Pemasukan();
                        $pemasukannew->assets_id               =  $asset->id;
                        $pemasukannew->nomor_daftar            =  $request->input('nomor_daftar');
                        $pemasukannew->tanggal_daftar          =  $request->input('tanggal_daftar');
                        $pemasukannew->nomor_pemasukan         =  $request->input('nomor_penerimaan_barang');
                        $pemasukannew->tanggal_pemasukan       =  $request->input('tanggal_penerimaan_barang');
                        $pemasukannew->nama_pengirim           =  $request->input('nama_pengirim');
                        $pemasukannew->serial_barang           =  $asset_tags[$a];
                        $pemasukannew->kode_barang             =  $asset_tags[$a];
                        $pemasukannew->kategori_barang         =  $request->input('kategori_barang');
                        $pemasukannew->nomor_kategori_barang   =  $request->input('nomor_kategori_barang');
                        $pemasukannew->nama_barang             =  $request->input('name');
                        $pemasukannew->satuan_barang           =  $request->input('satuan_barang');
                        $pemasukannew->jumlah_barang           =  $request->input('jumlah_barang');
                        $pemasukannew->departemen              =  $request->input('departemenMGPA');
                        $pemasukannew->mata_uang               =  $request->input('mata_uang');
                        $pemasukannew->harga_satuan_barang     =  $request->input('harga_satuan_barang');
                        $pemasukannew->harga_total_barang      =  $request->input('harga_total_barang');
                        $pemasukannew->lokasi_asset            =  $request->input('lokasi_asset', '');
                        $pemasukannew->detail_lokasi_asset     =  $request->input('detail_lokasi_asset', '');
                        $pemasukannew->kode_dokumen_pabean     =  $kodeDokumen;
                        $pemasukannew->nama_dokumen_pabean     =  $namaDokumen;
                        $pemasukannew->nomor_dokumen_pabean    =  $request->input('nomor_dokumen');
                        $pemasukannew->tanggal_dokumen_pabean  =  $request->input('tanggal_dokumen');
                        $pemasukannew->keterangan_pemasukan    =  $keteranganPemasukan;
                        $pemasukannew->status_sending          =  'a';
                        $pem                                = $pemasukannew->save();
                        if($pem){
                            Log::warning('insert pemasukan ' . $asset_tags[$a] . ' Sukses');
                            return redirect()->route('hardware.index')
                            ->with('success-unescaped', trans('admin/hardware/message.create.success_linked', ['link' => route('hardware.show', $asset->id), 'id', 'tag' => e($asset->asset_tag)]));
                        }else{
                            Log::error('insert pemasukan ' . $asset_tags[$a] . ' Gagal, Dengan Error = ' . json_encode($pemasukannew->getErrors()));
                            if (!empty($dataAsset = Asset::where('id', $asset->id))) {
                                $delAsset =  $dataAsset->forceDelete();
                            }
                        }
                    }else{
                        return redirect()->route('hardware.index')
                        ->with('success-unescaped', trans('admin/hardware/message.create.success_linked', ['link' => route('hardware.show', $asset->id), 'id', 'tag' => e($asset->asset_tag)]));
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('Error Menu Asset : ' . json_encode($e->getMessage()) );
        }

        return redirect()->back()->withInput()->withErrors($asset->getErrors());    
    }
    
    public function deleteLampiran($id, $index)
    {
        $asset = Asset::findOrFail($id);
        $this->authorize($asset);
    
        $lampiranList = array_map('trim', explode(',', $asset->lampiran));
    
        if (isset($lampiranList[$index])) {
            $relativePath = $lampiranList[$index];
            $fullPath = public_path($relativePath);
            $realPath = realpath($fullPath);
    
            \Log::info('Proses hapus lampiran', [
                'index' => $index,
                'relativePath' => $relativePath,
                'fullPath' => $fullPath,
                'realPath' => $realPath,
                'exists' => file_exists($realPath),
            ]);
    
            if ($realPath && file_exists($realPath)) {
                unlink($realPath);
            }
    
            unset($lampiranList[$index]);
    
            $asset->lampiran = implode(',', array_values($lampiranList));
            $asset->save();
        }
    
        return redirect()->back()->with('success', 'Lampiran berhasil dihapus.');
    }

    public function getOptionCookie(Request $request)
    {
        $value = $request->cookie('optional_info');
        echo $value;
        return $value;
    }

    /**
     * Returns a view that presents a form to edit an existing asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return View
     */
    
     public function getPemasukan($assetId){
        $item = Asset::find($assetId);

        $this->authorize('getPemasukan', Asset::class);

        $dataMataUang = $this->getMataUang();

        if($item == NULL || $item == '' || empty($item)){
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        return view('hardware/pemasukan', compact('item'))
            ->with('kodeDokumen', Helper::kodeDokumen())
            ->with('listdetaillokasi', Helper::listdetaillokasi())
            ->with('listownerr', Helper::listownerr())
            ->with('listketerangan', Helper::listketerangan())
            ->with('listlokasi', Helper::listlokasi())
            ->with('mataUang', $dataMataUang)
            ->with('keteranganPemasukan', Helper::keteranganPemasukan());
    }
    
    private function convertDetailLokasi($listdetaillokasi)
    {
        return Detaillokasi::where('id', $listdetaillokasi)->value('detail_lokasi') ?? '';
    }

    private function convertLokasi($listlokasi)
    {
        return Lokasi::where('id', $listlokasi)->value('namalokasi') ?? '';
    }

    private function convertKeterangan($listketerangan)
    {
        return Keterangan::where('id', $listketerangan)->value('listketerangan') ?? '';
    }

    private function convertOwner($listownerr)
    {
        return Owner::where('id', $listownerr)->value('nama_owner') ?? '';
    }



    public function savePemasukan(Request $request, $assetId = null){
        // 1️⃣ Cek asset valid
        $asset = Asset::find($assetId);
        if (!$asset) {
            return redirect()->route('hardware.index')
                ->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize($asset);
        
        $rules = [];

        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'required|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);
        
        try {
            $pemasukan = new Pemasukan();
            
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
            
                $pemasukan->lampiran = implode(',', $lampiranPaths);
            }
            
            // dd($request->input('lampiran'), $request->file('lampiran'));
            // dd($request->file('lampiran'));
            $kodeDokumen = $request->input('kode_dokumen');
            $namaDokumen = $this->convertDokumen($kodeDokumen);
            // $keteranganPemasukan = $request->input('keterangan_pemasukan');
            $keteranganPemasukan = $this->convertKeterangan($request->input('listketerangan'));
    
            // $pemasukan = new Pemasukan();
            
            $pemasukan->assets_id              = $asset->id;
            $pemasukan->serial_barang          = $request->input('serial_barang');
            $pemasukan->nomor_daftar           = $request->input('nomor_daftar');
            $pemasukan->tanggal_daftar         = $request->input('tanggal_daftar');
            $pemasukan->nomor_pemasukan        = $request->input('nomor_penerimaan_barang');
            $pemasukan->tanggal_pemasukan      = $request->input('tanggal_penerimaan_barang');
            $pemasukan->nama_pengirim          = $request->input('nama_pengirim');
            // $pemasukan->metode_pengadaan       = $request->input('metode_pengadaan');
            $pemasukan->status_pemasukan_mgpa  = $request->input('status_pemasukan_mgpa');
            $pemasukan->site                   = $request->input('site');
            $pemasukan->event                  = $request->input('event');
            $pemasukan->owner                  = $this->convertOwner($request->input('nama_owner'));
            $pemasukan->nama_company           = $request->input('nama_company');
            $pemasukan->kode_barang            = $request->input('kode_barang');
            $pemasukan->kategori_barang        = $request->input('kategori_barang');
            $pemasukan->nomor_kategori_barang  = $request->input('nomor_kategori_barang');
            $pemasukan->nama_barang            = $request->input('name');
            $pemasukan->satuan_barang          = $request->input('satuan_barang');
            $pemasukan->jumlah_barang          = $request->input('jumlah_barang_tambahan');
            $pemasukan->mata_uang              = $request->input('mata_uang');
            $pemasukan->harga_satuan_barang    = $request->input('harga_satuan_barang');
            $pemasukan->harga_total_barang     = $request->input('harga_total_barang');
            $pemasukan->nomor_dokumen_pabean   = $request->input('nomor_dokumen');
            $pemasukan->departemen             = $request->input('departemen');
            $pemasukan->kode_dokumen_pabean    = $kodeDokumen;
            $pemasukan->nama_dokumen_pabean    = $namaDokumen;
            $pemasukan->tanggal_dokumen_pabean = $request->input('tanggal_dokumen');
            $pemasukan->keterangan_pemasukan   = $keteranganPemasukan;
            $pemasukan->detail_lokasi_asset     = $request->input('detail_lokasi');
            $pemasukan->lokasi_asset     = $request->input('namalokasi');
            // dd($request->input('namalokasi'));
            $pemasukan->status_sending         = 'a';
            $pemasukan->status_penyesuaian     = 'B';
            $pemasukan->lampiran = implode(',', $lampiranPaths);
            // dd($request->all());
            // dd([
            //     'lokasi_asset' => $this->convertDetailLokasi($request->input('namalokasi')),
            //     'detail_lokasi_asset' => $this->convertLokasi($request->input('detail_lokasi')),
            // ]);
            
            
            $save                              = $pemasukan->save();
            if($save){
                $pemasukanSeb   = intval($asset->pemasukan);
                $pengeluaranSeb = intval($asset->pengeluaran);
                $penyesuaianSeb = intval($asset->penyesuaian);
                $stockOpnameSeb = intval($asset->stock_opname);
                $saldoAwalSeb   = intval($asset->saldo_awal);
    
                $pemasukan      = intval($request->input('jumlah_barang_tambahan'));
                $totalPemasukan = $pemasukanSeb + $pemasukan;
    
                $saldoBuku        = $saldoAwalSeb + $totalPemasukan - $pengeluaranSeb + $penyesuaianSeb; 
                $saldoBukuSelisih = $saldoAwalSeb + $totalPemasukan - $pengeluaranSeb; 
                
                if($stockOpnameSeb == 0){
                    $selisih = 0;
                }else{
                    $selisih = $stockOpnameSeb - $saldoBukuSelisih - $penyesuaianSeb;
                }
    
                $jumlahBarSeb       = $asset->jumlah_barang;
                $jumlahBarSek       = $request->input('jumlah_barang_tambahan');
                $totalBarang        = intval($jumlahBarSeb) + intval($jumlahBarSek);
    
                $jumlahTotalBarSeb  = $asset->harga_total_barang;
                $jumlahTotalBarSek  = $request->input('harga_total_barang');
                $totalHargaBarang   = intval($jumlahTotalBarSeb) + intval($jumlahTotalBarSek);
                $totalsaatini       = $asset->jumlah_baris_kode;
                $totalplussatu      = intval($totalsaatini) + 1;
                
                $hasilPencacahanSeb = intval($asset->hasil_pencacahan);
                $jumlahSelisih      = $saldoBuku - $hasilPencacahanSeb;
                // unset($asset->tanggal_pengajuan);
                app()->instance('asset_action_context', 'pemasukan');
                $asset->jumlah_baris_kode  = $totalplussatu;
                $asset->jumlah_barang      = $totalBarang;
                $asset->harga_total_barang = $totalHargaBarang;
                $asset->pemasukan          = $totalPemasukan;
                $asset->pengeluaran        = $pengeluaranSeb;
                $asset->penyesuaian        = $penyesuaianSeb;
                $asset->saldo_buku         = $saldoBuku;
                $asset->stock_opname       = $stockOpnameSeb;
                $asset->selisih            = $selisih;
                $asset->jumlah_selisih     = $jumlahSelisih;
                // dd($asset->getAttributes());
                if (!$asset->save()) {
                    Log::error('Gagal update asset3', ['errors' => $asset->getErrors() ?? null]);
                } else {
                    Log::info('Berhasil update asset pakai fill+save');
                }
                // $asset->update($dataUpdAsset);
                
                // DB::table('assets')
                //         ->where('id', $assetId)
                //         ->update($dataUpdAsset);

                Log::warning('Berhasil Menambahkan Data Pemasukan Pada Transaksi Pemasukan Dengan Kode Barang = ' . $request->input('kode_barang'));    
                return redirect()->route('pemasukan.index')->with('success-unescaped', 'Berhasil Menambahkan Data Pemasukan');
            }else{
                Log::error('Gagal Menambahkan Data Pemasukan Pada Transaksi Pemasukan Dengan Kode Barang = ' . $request->input('kode_barang') . ' Karena ' . $pemasukan->getErrors());    
                return redirect()->to("hardware/$assetId/pemasukan")->withInput()->withErrors($pemasukan->getErrors());
            }
        } catch (\Throwable $e) {
            Log::error('Gagal Menambahkan Data Pemasukan Pada Transaksi Pemasukan Dengan Kode Barang = ' . $request->input('kode_barang') . ' Karena ' . $e->getMessage());    
        }
        // return redirect()->back()->withInput()->withErrors($pemasukan->getErrors());
        
        return redirect()->back()->withInput()->withErrors(['lampiran' => $e->getMessage()]);
    }
    

    public function getAdjusment($assetId){
        $item = Asset::find($assetId);

        $this->authorize($item);

        if($item == NULL || $item == '' || empty($item)){
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        return view('hardware/adjusment', compact('item'))
            ->with('kodeDokumen', Helper::kodeDokumen());
    }

    public function saveAdjusment(Request $request, $assetId = null){
        if (!$asset = Asset::find($assetId)) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize($asset);
        
        $rules = [];

        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'required|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);

        try {
            $jumlahBarangSeb = $request->input('jumlah_barang');
            $jumlahBarangAdjusment = intval($request->input('jumlah_barang_adjusment'));
        
            $kodeDokumen = $request->input('kode_dokumen');
            $namaDokumen = $this->convertDokumen($kodeDokumen);


            $saldoBuku = intval($request->input('saldo_buku'));
            $stockopname = intval($request->input('stock_opname'));

            $saldoAwalAsset = intval($asset->saldo_awal);
            $pemasukanAssset = intval($asset->pemasukan);
            $pengeluaranAsset = intval($asset->pengeluaran);
            $penyesuaianAsset = intval($asset->penyesuaian);
            
            $selisih = $stockopname - $saldoBuku - $jumlahBarangAdjusment;

            $akumulasiAdjust = $penyesuaianAsset + $jumlahBarangAdjusment;
            
            $saldoBukuUpd = $saldoAwalAsset + $pemasukanAssset - $pengeluaranAsset + $akumulasiAdjust;

            $totalsaatiniadj       = $asset->jumlah_baris_adjustment;
            $totalplussatuadj      = intval($totalsaatiniadj) + 1;
            // dd($totalplussatuadj);
            
            $jumlahBarangAsset = intval($asset->jumlah_barang);
            if($jumlahBarangAdjusment < 0){
                $totalBarang = $jumlahBarangAsset - abs($jumlahBarangAdjusment);
            }else{
                $totalBarang = $jumlahBarangAsset + abs($jumlahBarangAdjusment);
            }

            $hargaSatuanBarang = intval($request->input('harga_satuan_barang'));

            $hargaTotalBarangUpdate = $totalBarang * $hargaSatuanBarang;

            $hasilPencacahanSeb = intval($asset->hasil_pencacahan);
            $jumlahSelisih      = $saldoBukuUpd - $hasilPencacahanSeb;

            $adjust = new Adjustment();
            
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
            
                $adjust->lampiran = implode(',', $lampiranPaths);
            }

            $adjust->asset_id = $assetId;
            $adjust->nomor_dokumen_kegiatan = $request->input('nomor_dokumen_kegiatan');
            $adjust->nama_entitas_transaksi = $request->input('nama_entitas_transaksi');
            $adjust->tanggal_pelaksanaan = $request->input('tanggal_pelaksanaan');
            $adjust->kode_barang = $request->input('asset_tag');
            $adjust->nama_barang = $request->input('name');
            $adjust->departemen = $request->input('departemen');
            
            $adjust->kategori_barang = $request->input('kategori_barang');
            $adjust->nomor_kategori_barang = $request->input('nomor_kategori_barang');
            $adjust->satuan_barang = $request->input('satuan_barang');
            
            $adjust->jumlah_barang = $jumlahBarangSeb;
            $adjust->saldo_awal = $request->input('saldo_awal');
            $adjust->jumlah_pemasukan_barang = $request->input('pemasukan');
            $adjust->jumlah_pengeluaran_barang = $request->input('pengeluaran');
            $adjust->penyesuaian = $jumlahBarangAdjusment;
            $adjust->saldo_buku = $request->input('saldo_buku');
            $adjust->selisih = $request->input('selisih');
            $adjust->stock_opname = $request->input('stock_opname');
            $adjust->hasil_pencacahan = $request->input('hasil_pencacahan');
            $adjust->jumlah_selisih = $request->input('jumlah_selisih');;
            $adjust->keterangan = request('keterangan', '');
            $adjust->kode_dokumen = $kodeDokumen;
            $adjust->nama_dokumen = $namaDokumen;
            $adjust->nomor_dokumen = request('nomor_dokumen', '');
            $adjust->tanggal_dokumen = request('tanggal_dokumen', '');
            $adjust->status_kirim = 'B';
            // $adjust->status_penyesuaian = 'B';
            $adjust->lampiran = implode(',', $lampiranPaths);
            
            $adjust->harga_satuan_barang = $request->input('harga_satuan_barang');
            $adjust->harga_total_barang = $request->input('harga_total_barang');

            $save = $adjust->save();

            if($save){
                $asset->jumlah_baris_adjustment = $totalplussatuadj;
                $asset->jumlah_barang        = $totalBarang;
                $asset->harga_total_barang   = $hargaTotalBarangUpdate;
                $asset->penyesuaian          = $akumulasiAdjust;
                $asset->saldo_buku           = $saldoBukuUpd;
                $asset->selisih              = $selisih;
                $asset->jumlah_selisih       = $jumlahSelisih;
                // Tandai bahwa update berikutnya adalah dari Adjustment
                app()->instance('asset_action_context', 'adjustment');
                $asset->update();

                Log::warning("Berhasil Menambahkan Data Adjusment Dengan Kode Barang : " . $request->input('asset_tag'));
                return redirect()->route('adjusment.index')
                ->with('success-unescaped', trans('admin/hardware/message.create.success_linked'));
            }else{
                Log::error("gagal Menambahkan Data Adjusment Dengan Kode Barang : " . $request->input('asset_tag') . ' karena ' . json_encode($adjust->getErrors()));
            }
        } catch (\Throwable $e) {
            Log::error("gagal Menambahkan Data Adjusment Dengan Kode Barang : " . $request->input('asset_tag') . ' karena ' . json_encode($e->getMessage()));

        }

        return redirect()->back()->withInput()->withErrors($adjust->getErrors());
    }

    public function getStockOpname($assetId){
        $item = Asset::find($assetId);

        $this->authorize($item);

        if($item == NULL || $item == '' || empty($item)){
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        return view('hardware/stock-opname', compact('item'))
        ->with('kodeDokumen', Helper::kodeDokumen());
    }
        
    public function saveStockOpname(Request $request, $assetId = null){
        if (!$asset = Asset::find($assetId)) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize($asset);
        
        $rules = [];

        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'required|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);
        
        try {
            $kodeDokumen = $request->input('kode_dokumen');
            $namaDokumen = $this->convertDokumen($kodeDokumen);

            $opname = new StockOpname();
            
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
            
                $opname->lampiran = implode(',', $lampiranPaths);
            }

            $opname->asset_id = $assetId;
            $opname->nomor_dokumen_kegiatan = $request->input('nomor_dokumen_kegiatan');
            $opname->nama_entitas_transaksi = $request->input('nama_entitas_transaksi');
            $opname->tanggal_pelaksanaan = $request->input('tanggal_pelaksanaan');
            $opname->kode_barang = $request->input('asset_tag');
            $opname->nama_barang = $request->input('name');
            $opname->departemen = $request->input('departemen');
            
            $opname->kategori_barang = $request->input('kategori_barang');
            $opname->nomor_kategori_barang = $request->input('nomor_kategori_barang');
            $opname->satuan_barang = $request->input('satuan_barang');
            
            $jumlahBarangSeb = $request->input('jumlah_barang');
            $jumlahBarangOpname = $request->input('jumlah_barang_opname');

            $selisihBarang =  $jumlahBarangOpname - $jumlahBarangSeb;
            $totalsaatinistck       = $asset->jumlah_baris_stockopname;
            $totalplussatustck      = intval($totalsaatinistck) + 1;

            $opname->jumlah_barang = $jumlahBarangOpname;
            $opname->jumlah_barang_sebelumnya = $jumlahBarangSeb;
            $opname->selisih_barang = $selisihBarang;
            $opname->harga_satuan_barang = request('harga_satuan_barang', '');
            $opname->harga_total_barang = request('harga_total_barang', '');
            $opname->kode_dokumen_pabean = $kodeDokumen;
            $opname->nama_dokumen_pabean = $namaDokumen;
            $opname->nomor_dokumen_pabean = request('nomor_dokumen', '');
            $opname->tanggal_dokumen_pabean = request('tanggal_dokumen', '');
            $opname->status_kirim = 'B';
            $opname->lampiran = implode(',', $lampiranPaths);
            
            $opname->harga_total_barang = $request->input('harga_total_barang');

            $save = $opname->save();

            if($save){
                $asset->jumlah_baris_stockopname = $totalplussatustck;
                $stockOpnameSeb = intval($asset->stock_opname);
                $stockOpnameSek = intval($request->input('jumlah_barang_opname'));
                $totalStockopname = intval($stockOpnameSeb + $stockOpnameSek);

                $saldoBuku = intval($asset->saldo_buku);
                $penyesuaian = intval($asset->penyesuaian);

                $selisih = $totalStockopname - $saldoBuku; 
                $hasilPencacahanSeb     = intval($asset->hasil_pencacahan);
                $jumlahSelisih          = $saldoBuku - $hasilPencacahanSeb;

                $asset->stock_opname    = $totalStockopname;
                $asset->selisih = $selisih;
                $asset->jumlah_selisih  = $jumlahSelisih;
                app()->instance('asset_action_context', 'stock_opname');
                $asset->update();

                Log::warning("Berhasil Menambahkan Data Stockopname Dengan Kode Barang : " . $request->input('asset_tag'));
                return redirect()->route('stockopname.index')->with('success-unescaped', trans('admin/hardware/message.create.success_linked'));
            }
        } catch (\Throwable $e) {
            Log::error("Gagal Menambahkan Data Stockopname Dengan Kode Barang : " . $request->input('asset_tag') . ' karena ' . json_encode($e->getMessage()));
        }
        return redirect()->back()->withInput()->withErrors($opname->getErrors());
    }
    
    public function edit($assetId = null)
    {
        if (!$item = Asset::with('pemasukan')->find($assetId)) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        
        //Handles company checks and permissions.
        $this->authorize($item);

        $currency = Helper::mataUang();
        $data = [];
        foreach ($currency as $key => $c) {
            $data[$key] = $c['code'] . ' - ' . $c['title'] . ' - ' . $c['symbol'];
        }
        if (isset($item->nama_dokumen_pabean)) {
            $dok = trim($item->nama_dokumen_pabean);
        
            // logika sederhana untuk mencocokkan potongan teks
            $match = \App\Models\KodeDokumen::where('label', 'like', "%{$dok}%")->value('label');
        
            $item->nama_dokumen_pabean = $match ?? $dok;
        }
        
        return view('hardware/editasset', compact('item'))
            ->with('statuslabel_list', Helper::statusLabelList())
            ->with('statuslabel_types', Helper::statusTypeList())
            ->with('editkodeDokumen', Helper::editkodeDokumen())
            ->with('category', Helper::kategoriBarang())
            ->with('satuan', Helper::satuanBarang())
            ->with('mataUang', $data)
            ->with('statusEdit', true)
            ->with('editlistdetaillokasi', Helper::editlistdetaillokasi())
            ->with('editlistownerr', Helper::editlistownerr())
            ->with('editlistketerangan', Helper::editlistketerangan())
            ->with('editlistlokasi', Helper::editlistlokasi())
            ->with('keteranganPemasukan', Helper::keteranganPemasukan());
    }


    /**
     * Returns a view that presents information about an asset for detail view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return View
     */
    public function show($assetId = null)
    {
        $asset = Asset::withTrashed()->find($assetId);
        $this->authorize('view', $asset);
        $settings = Setting::getSettings();

        if (isset($asset)) {
            $audit_log = Actionlog::where('action_type', '=', 'audit')
                ->where('item_id', '=', $assetId)
                ->where('item_type', '=', Asset::class)
                ->orderBy('created_at', 'DESC')->first();

            if ($asset->location) {
                $use_currency = $asset->location->currency;
            } else {
                if ($settings->default_currency != '') {
                    $use_currency = $settings->default_currency;
                } else {
                    $use_currency = trans('general.currency');
                }
            }

            $qr_code = (object) [
                'display' => $settings->qr_code == '1',
                'url' => route('qr_code/hardware', $asset->id),
            ];

            return view('hardware/view', compact('asset', 'qr_code', 'settings'))
                ->with('use_currency', $use_currency)->with('audit_log', $audit_log);
        }

        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
    }

    /**
     * Validate and process asset edit form.
     *
     * @param int $assetId
     * @return \Illuminate\Http\RedirectResponse|Redirect
     *@since [v1.0]
     * @author [A. Gianotto] [<snipe@snipe.net>]
     */
    //UPDATEasset
    public function update(ImageUploadRequest $request)
    // public function update(ImageUploadRequest $request, $assetId = null)
    {
        $assetId = $request->input('id'); // Ambil dari input hidden
        // Check if the asset exists
        if (!$asset = Asset::find($assetId)) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize($asset);
        $rules = [];

        foreach ($request->file('lampiran') ?? [] as $index => $file) {
            $rules["lampiran.$index"] = 'nullable|file|mimes:pdf,jpg,jpeg,png,bmp|max:20480';
        }
        $request->validate($rules);

        $asset->status_id = $request->input('status_id', null);
        $asset->warranty_months = null;
        $asset->purchase_cost = null;
        $asset->purchase_date = null;
        // if ($request->filled('purchase_date') && !$request->filled('asset_eol_date') && ($asset->model->eol > 0)) {
        //     $asset->purchase_date = $request->input('purchase_date', null);
        //     $asset->asset_eol_date = Carbon::parse($request->input('purchase_date'))->addMonths($asset->model->eol)->format('Y-m-d');
        //     $asset->eol_explicit = false;
        // } elseif ($request->filled('asset_eol_date')) {
        //     $asset->asset_eol_date = $request->input('asset_eol_date', null);
        //     $months = Carbon::parse($asset->asset_eol_date)->diffInMonths($asset->purchase_date);
        //     if ($asset->model->eol) {
        //         if ($months != $asset->model->eol > 0) {
        //             $asset->eol_explicit = true;
        //         } else {
        //             $asset->eol_explicit = false;
        //         }
        //     } else {
        //         $asset->eol_explicit = true;
        //     }
        // } elseif (!$request->filled('asset_eol_date') && (($asset->model->eol) == 0)) {
        //     $asset->asset_eol_date = null;
        //     $asset->eol_explicit = false;
        // }
        // $asset->supplier_id = $request->input('supplier_id', null);
        $asset->expected_checkin = null;

        // If the box isn't checked, it's not in the request at all.
        $asset->requestable = 0;
        $asset->rtd_location_id = null;
        $asset->byod = 0;

        // Update the asset data
        
        $asset_tag = $request->input('asset_tags');
        
        $serial = $request->input('serials');
        $asset->name = $request->input('name');
        $asset->serial = $serial[1];
        $asset->company_id = Company::getIdForCurrentUser($request->input('company_id'));
        $asset->model_id = 1;
        $asset->order_number = null;
        $asset->asset_tag = $asset_tag[1];
        $asset->notes = null;
        $kodeDokumen = $request->input('kode_dokumen_pabean');
        $namaDokumen = $this->convertDokumen($kodeDokumen);

        // $asset = $request->handleImages($asset);

        $asset->status_pemasukan_mgpa   = $request->input('status_pemasukan_mgpa');
        $asset->nomor_purchase          = request('nomor_purchase', '');
        $asset->event                   = request('event', '');
        // $asset->metode_pengadaan        = request('metode_pengadaan', '');
        // $asset->owner                   = request('owner', '');
        $asset->owner                   = $request->input('nama_owner');
        
        $asset->ncompanies              = request('companiess', '');
        $asset->departemen              = request('departemenMGPA', '');
        $asset->site                    = request('site', '');
        $asset->lokasi_asset            = $request->input('namalokasi');
        // dd($request->input('namalokasi'));
        // dd($request->input('detail_lokasi'));
        $asset->detail_lokasi_asset     = $request->input('detail_lokasi');
        // $asset->detail_lokasi           = 'asdasd';
        $asset->kategori_barang         = $request->input('kategori_barang');
        $asset->nomor_pengajuan             = $request->input('nomor_pengajuan');
        $asset->tanggal_pengajuan             = $request->input('tanggal_pengajuan');
        $asset->nomor_kategori_barang   = $request->input('nomor_kategori_barang');
        $asset->jumlah_barang           = $request->input('jumlah_barang');
        $asset->satuan_barang           = $request->input('satuan_barang');
        $asset->mata_uang               = $request->input('mata_uang');
        $asset->harga_satuan_barang     = $request->input('harga_satuan_barang');
        $asset->harga_total_barang      = $request->input('harga_total_barang');
        $asset->keterangan              = request('keterangan', '');
        $asset->status_pemasukan        = 'B';
        $asset->jenis_transaksi         = 't';
        $asset->kode_dokumen_pabean    = $kodeDokumen;
        $asset->nama_dokumen_pabean    = $namaDokumen;
        $asset->bea        = $request->input('bea');                // Radio
        $asset->ppn        = $request->has('PPN') ? 1 : 0;          // Checkbox
        $asset->pph_impor  = $request->has('PPhImpor') ? 1 : 0;     // Checkbox
        $asset->ppnbm      = $request->has('PPnBM') ? 1 : 0;        // Checkbox
        $lampiranPaths = [];

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '-' . str_replace(' ', '_', $file->getClientOriginalName());
                    $folder = 'uploads/dokumen_saldo';
                    $path = $folder . '/' . $filename;
        
                    $file->move(public_path($folder), $filename);
                    $lampiranPaths[] = $path;
                }
            }
        
            // Gabungkan file lama + file baru
            $existingLampiran = $asset->lampiran ? explode(',', $asset->lampiran) : [];
            $asset->lampiran = implode(',', array_merge($existingLampiran, $lampiranPaths));
        }
        

        // Update custom fields in the database.
        // Validation for these fields is handlded through the AssetRequest form request
        // FIXME: No idea why this is returning a Builder error on db_column_name.
        // Need to investigate and fix. Using static method for now.
        $model = AssetModel::find($request->get('model_id'));
        if (($model) && ($model->fieldset)) {
            foreach ($model->fieldset->fields as $field) {
                if ($field->field_encrypted == '1') {
                    if (Gate::allows('admin')) {
                        if (is_array($request->input($field->db_column))) {
                            $asset->{$field->db_column} = Crypt::encrypt(implode(', ', $request->input($field->db_column)));
                        } else {
                            $asset->{$field->db_column} = Crypt::encrypt($request->input($field->db_column));
                        }
                    }
                } else {
                    if (is_array($request->input($field->db_column))) {
                        $asset->{$field->db_column} = implode(', ', $request->input($field->db_column));
                    } else {
                        $asset->{$field->db_column} = $request->input($field->db_column);
                    }
                }
            }
        }
        $updAsset = $asset->update();

        if($updAsset){
                Log::warning("Berhasil Mengupdate Data Asset Dengan Kode Barang : " . $asset_tag[1]);
                return redirect()->route('hardware.show', $assetId)
                    ->with('success', trans('admin/hardware/message.update.success'));
        }else{
            return redirect()->back()->withInput()->withErrors($asset->getErrors());
        }
        return redirect()->back()->withInput()->withErrors($asset->getErrors());
        
    }
    

    /**
     * Delete a given asset (mark as deleted).
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return Redirect
     */
    public function destroy($assetId)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('delete', $asset);

        $kodeBarang = $asset->asset_tag;

        DB::table('assets')
            ->where('id', $asset->id)
            ->update(['assigned_to' => null]);

        if ($asset->image) {
            try {
                Storage::disk('public')->delete('assets' . '/' . $asset->image);
            } catch (\Exception $e) {
                Log::debug($e);
                Log::error($e);
            }
        }

        $del = $asset->delete();
        if($del){
            Log::warning("Berhasil Menghapus Data Asset Dengan Kode Barang : " . $kodeBarang );
        }else{
            Log::error("Gagal Menghapus Data Asset Dengan Kode Barang : " . $kodeBarang . ' karena ' . json_encode($e->getMessage()));
        }

        return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.delete.success'));
    }

    /**
     * Searches the assets table by serial, and redirects if it finds one
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return Redirect
     */
    public function getAssetBySerial(Request $request)
    {
        $topsearch = ($request->get('topsearch') == "true");

        if (!$asset = Asset::where('serial', '=', $request->get('serial'))->first()) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize('view', $asset);
        return redirect()->route('hardware.show', $asset->id)->with('topsearch', $topsearch);
    }

    /**
     * Searches the assets table by asset tag, and redirects if it finds one
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return Redirect
     */
    public function getAssetByTag(Request $request, $tag = null)
    {
        $tag = $tag ? $tag : $request->get('assetTag');
        $topsearch = ($request->get('topsearch') == 'true');

        if (!$asset = Asset::where('asset_tag', '=', $tag)->first()) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize('view', $asset);

        return redirect()->route('hardware.show', $asset->id)->with('topsearch', $topsearch);
    }


    /**
     * Return a QR code for the asset
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return Response
     */
    public function getQrCode($assetId = null)
    {
        $settings = Setting::getSettings();

        if ($settings->qr_code == '1') {
            $asset = Asset::withTrashed()->find($assetId);
            if ($asset) {
                $size = Helper::barcodeDimensions($settings->barcode_type);
                $qr_file = public_path() . '/uploads/barcodes/qr-' . str_slug($asset->asset_tag) . '-' . str_slug($asset->id) . '.png';

                if (isset($asset->id, $asset->asset_tag)) {
                    if (file_exists($qr_file)) {
                        $header = ['Content-type' => 'image/png'];

                        return response()->file($qr_file, $header);
                    } else {
                        $barcode = new \Com\Tecnick\Barcode\Barcode();
                        $barcode_obj = $barcode->getBarcodeObj($settings->barcode_type, route('hardware.show', $asset->id), $size['height'], $size['width'], 'black', [-2, -2, -2, -2]);
                        file_put_contents($qr_file, $barcode_obj->getPngData());

                        return response($barcode_obj->getPngData())->header('Content-type', 'image/png');
                    }
                }
            }

            return 'That asset is invalid';
        }
    }

    /**
     * Return a 2D barcode for the asset
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return Response
     */
    public function getBarCode($assetId = null)
    {
        $settings = Setting::getSettings();
        if ($asset = Asset::withTrashed()->find($assetId)) {
            $barcode_file = public_path() . '/uploads/barcodes/' . str_slug($settings->alt_barcode) . '-' . str_slug($asset->asset_tag) . '.png';

            if (isset($asset->id, $asset->asset_tag)) {
                if (file_exists($barcode_file)) {
                    $header = ['Content-type' => 'image/png'];

                    return response()->file($barcode_file, $header);
                } else {
                    // Calculate barcode width in pixel based on label width (inch)
                    $barcode_width = ($settings->labels_width - $settings->labels_display_sgutter) * 200.000000000001;

                    $barcode = new \Com\Tecnick\Barcode\Barcode();
                    try {
                        $barcode_obj = $barcode->getBarcodeObj($settings->alt_barcode, $asset->asset_tag, ($barcode_width < 300 ? $barcode_width : 300), 50);
                        file_put_contents($barcode_file, $barcode_obj->getPngData());

                        return response($barcode_obj->getPngData())->header('Content-type', 'image/png');
                    } catch (\Exception $e) {
                        Log::debug('The barcode format is invalid.');

                        return response(file_get_contents(public_path('uploads/barcodes/invalid_barcode.gif')))->header('Content-type', 'image/gif');
                    }
                }
            }
        }
        return null;
    }

    /**
     * Return a label for an individual asset.
     *
     * @author [L. Swartzendruber] [<logan.swartzendruber@gmail.com>
     * @param int $assetId
     * @return View
     */
    public function getLabel($assetId = null)
    {
        if (isset($assetId)) {
            $asset = Asset::find($assetId);
            $this->authorize('view', $asset);

            return (new Label())
                ->with('assets', collect([$asset]))
                ->with('settings', Setting::getSettings())
                ->with('template', request()->get('template'))
                ->with('offset', request()->get('offset'))
                ->with('bulkedit', false)
                ->with('count', 0);
        }
    }

    /**
     * Returns a view that presents a form to clone an asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return View
     */
    public function getClone($assetId = null)
    {
        // Check if the asset exists
        if (is_null($asset_to_clone = Asset::find($assetId))) {
            // Redirect to the asset management page
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('create', $asset_to_clone);

        $asset = clone $asset_to_clone;
        $asset->id = null;
        $asset->asset_tag = '';
        $asset->serial = '';
        $asset->assigned_to = '';

        return view('hardware/edit')
            ->with('statuslabel_list', Helper::statusLabelList())
            ->with('statuslabel_types', Helper::statusTypeList())
            ->with('item', $asset)
            ->with('category', Helper::kategoriBarang())
            ->with('satuan', Helper::satuanBarang());
    }

    /**
     * Return history import view
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function getImportHistory()
    {
        $this->authorize('admin');

        return view('hardware/history');
    }

    /**
     * Import history
     *
     * This needs a LOT of love. It's done very inelegantly right now, and there are
     * a ton of optimizations that could (and should) be done.
     *
     * Updated to respect checkin dates:
     * No checkin column, assume all items are checked in (todays date)
     * Checkin date in the past, update history.
     * Checkin date in future or empty, check the item out to the user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.3]
     * @return View
     */
    public function postImportHistory(Request $request)
    {
        if (!$request->hasFile('user_import_csv')) {
            return back()->with('error', 'No file provided. Please select a file for import and try again. ');
        }

        if (!ini_get('auto_detect_line_endings')) {
            ini_set('auto_detect_line_endings', '1');
        }
        $csv = Reader::createFromPath($request->file('user_import_csv'));
        $csv->setHeaderOffset(0);
        $header = $csv->getHeader();
        $isCheckinHeaderExplicit = in_array('checkin date', (array_map('strtolower', $header)));
        try {
            $results = $csv->getRecords();
        } catch (\Exception $e) {
            return back()->with('error', trans('general.error_in_import_file', ['error' => $e->getMessage()]));
        }
        $item = [];
        $status = [];
        $status['error'] = [];
        $status['success'] = [];
        foreach ($results as $row) {
            if (is_array($row)) {
                $row = array_change_key_case($row, CASE_LOWER);
                $asset_tag = Helper::array_smart_fetch($row, 'asset tag');
                if (!array_key_exists($asset_tag, $item)) {
                    $item[$asset_tag] = [];
                }
                $batch_counter = count($item[$asset_tag]);
                $item[$asset_tag][$batch_counter]['checkout_date'] = Carbon::parse(Helper::array_smart_fetch($row, 'checkout date'))->format('Y-m-d H:i:s');

                if ($isCheckinHeaderExplicit) {
                    //checkin date not empty, assume past transaction or future checkin date (expected)
                    if (!empty(Helper::array_smart_fetch($row, 'checkin date'))) {
                        $item[$asset_tag][$batch_counter]['checkin_date'] = Carbon::parse(Helper::array_smart_fetch($row, 'checkin date'))->format('Y-m-d H:i:s');
                    } else {
                        $item[$asset_tag][$batch_counter]['checkin_date'] = '';
                    }
                } else {
                    //checkin header missing, assume data is unavailable and make checkin date explicit (now) so we don't encounter invalid state.
                    $item[$asset_tag][$batch_counter]['checkin_date'] = Carbon::parse(now())->format('Y-m-d H:i:s');
                }

                $item[$asset_tag][$batch_counter]['asset_tag'] = Helper::array_smart_fetch($row, 'asset tag');
                $item[$asset_tag][$batch_counter]['name'] = Helper::array_smart_fetch($row, 'name');
                $item[$asset_tag][$batch_counter]['email'] = Helper::array_smart_fetch($row, 'email');
                if ($asset = Asset::where('asset_tag', '=', $asset_tag)->first()) {
                    $item[$asset_tag][$batch_counter]['asset_id'] = $asset->id;
                    $base_username = User::generateFormattedNameFromFullName(Setting::getSettings()->username_format, $item[$asset_tag][$batch_counter]['name']);
                    $user = User::where('username', '=', $base_username['username']);
                    $user_query = ' on username ' . $base_username['username'];
                    if ($request->input('match_firstnamelastname') == '1') {
                        $firstnamedotlastname = User::generateFormattedNameFromFullName('firstname.lastname', $item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $firstnamedotlastname['username'];
                        $user->orWhere('username', '=', $firstnamedotlastname['username']);
                        $user_query .= ', or on username ' . $firstnamedotlastname['username'];
                    }
                    if ($request->input('match_flastname') == '1') {
                        $flastname = User::generateFormattedNameFromFullName('filastname', $item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $flastname['username'];
                        $user->orWhere('username', '=', $flastname['username']);
                        $user_query .= ', or on username ' . $flastname['username'];
                    }
                    if ($request->input('match_firstname') == '1') {
                        $firstname = User::generateFormattedNameFromFullName('firstname', $item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $firstname['username'];
                        $user->orWhere('username', '=', $firstname['username']);
                        $user_query .= ', or on username ' . $firstname['username'];
                    }
                    if ($request->input('match_email') == '1') {
                        if ($item[$asset_tag][$batch_counter]['name'] == '') {
                            $item[$asset_tag][$batch_counter]['username'][] = $user_email = User::generateEmailFromFullName($item[$asset_tag][$batch_counter]['name']);
                            $user->orWhere('username', '=', $user_email);
                            $user_query .= ', or on username ' . $user_email;
                        }
                    }
                    if ($request->input('match_username') == '1') {
                        // Added #8825: add explicit username lookup
                        $raw_username = $item[$asset_tag][$batch_counter]['name'];
                        $user->orWhere('username', '=', $raw_username);
                        $user_query .= ', or on username ' . $raw_username;
                    }

                    // A matching user was found
                    if ($user = $user->first()) {
                        //$user is now matched user from db
                        $item[$asset_tag][$batch_counter]['user_id'] = $user->id;

                        Actionlog::firstOrCreate([
                            'item_id' => $asset->id,
                            'item_type' => Asset::class,
                            'user_id' =>  Auth::user()->id,
                            'note' => 'Checkout imported by ' . Auth::user()->present()->fullName() . ' from history importer',
                            'target_id' => $item[$asset_tag][$batch_counter]['user_id'],
                            'target_type' => User::class,
                            'created_at' =>  $item[$asset_tag][$batch_counter]['checkout_date'],
                            'action_type'   => 'checkout3',
                        ]);

                        $checkin_date = $item[$asset_tag][$batch_counter]['checkin_date'];

                        if ($isCheckinHeaderExplicit) {

                            //if checkin date header exists, assume that empty or future date is still checked out
                            //if checkin is before todays date, assume it's checked in and do not assign user ID, if checkin date is in the future or blank, this is the expected checkin date, items is checked out

                            if ((strtotime($checkin_date) > strtotime(Carbon::now())) || (empty($checkin_date))
                            ) {
                                //only do this if item is checked out
                                $asset->assigned_to = $user->id;
                                $asset->assigned_type = User::class;
                            }
                        }

                        if (!empty($checkin_date)) {
                            //only make a checkin there is a valid checkin date or we created one on import.
                            Actionlog::firstOrCreate([
                                'item_id' => $item[$asset_tag][$batch_counter]['asset_id'],
                                'item_type' => Asset::class,
                                'user_id' => Auth::user()->id,
                                'note' => 'Checkin imported by ' . Auth::user()->present()->fullName() . ' from history importer',
                                'target_id' => null,
                                'created_at' => $checkin_date,
                                'action_type' => 'checkin',
                            ]);
                        }

                        if ($asset->save()) {
                            $status['success'][]['asset'][$asset_tag]['msg'] = 'Asset successfully matched for ' . Helper::array_smart_fetch($row, 'name') . $user_query . ' on ' . $item[$asset_tag][$batch_counter]['checkout_date'];
                        } else {
                            $status['error'][]['asset'][$asset_tag]['msg'] = 'Asset and user was matched but could not be saved.';
                        }
                    } else {
                        $item[$asset_tag][$batch_counter]['user_id'] = null;
                        $status['error'][]['user'][Helper::array_smart_fetch($row, 'name')]['msg'] = 'User does not exist so no checkin log was created.';
                    }
                } else {
                    $item[$asset_tag][$batch_counter]['asset_id'] = null;
                    $status['error'][]['asset'][$asset_tag]['msg'] = 'Asset does not exist so no match was attempted.';
                }
            }
        }

        return view('hardware/history')->with('status', $status);
    }

    public function sortByName(array $recordA, array $recordB): int
    {
        return strcmp($recordB['Full Name'], $recordA['Full Name']);
    }

    /**
     * Restore a deleted asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return View
     */
    public function getRestore($assetId = null)
    {
        if ($asset = Asset::withTrashed()->find($assetId)) {
            $this->authorize('delete', $asset);

            if ($asset->deleted_at == '') {
                return redirect()->back()->with('error', trans('general.not_deleted', ['item_type' => trans('general.asset')]));
            }

            if ($asset->restore()) {
                // Redirect them to the deleted page if there are more, otherwise the section index
                $deleted_assets = Asset::onlyTrashed()->count();
                if ($deleted_assets > 0) {
                    return redirect()->back()->with('success', trans('admin/hardware/message.restore.success'));
                }
                return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.restore.success'));
            }

            // Check validation to make sure we're not restoring an asset with the same asset tag (or unique attribute) as an existing asset
            return redirect()->back()->with('error', trans('general.could_not_restore', ['item_type' => trans('general.asset'), 'error' => $asset->getErrors()->first()]));
        }

        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
    }

    public function quickScan()
    {
        $this->authorize('audit', Asset::class);
        $dt = Carbon::now()->addMonths(12)->toDateString();

        return view('hardware/quickscan')->with('next_audit_date', $dt);
    }

    public function quickScanCheckin()
    {
        $this->authorize('checkin', Asset::class);

        return view('hardware/quickscan-checkin');
    }

    public function audit($id)
    {
        $settings = Setting::getSettings();
        $this->authorize('audit', Asset::class);
        $dt = Carbon::now()->addMonths($settings->audit_interval)->toDateString();
        $asset = Asset::findOrFail($id);

        return view('hardware/audit')->with('asset', $asset)->with('next_audit_date', $dt)->with('locations_list');
    }

    public function dueForAudit()
    {
        $this->authorize('audit', Asset::class);

        return view('hardware/audit-due');
    }

    public function overdueForAudit()
    {
        $this->authorize('audit', Asset::class);

        return view('hardware/audit-overdue');
    }


    public function auditStore(Request $request, $id)
    {
        $this->authorize('audit', Asset::class);

        $rules = [
            'location_id' => 'exists:locations,id|nullable|numeric',
            'next_audit_date' => 'date|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(Helper::formatStandardApiResponse('error', null, $validator->errors()->all()));
        }

        $asset = Asset::findOrFail($id);

        // We don't want to log this as a normal update, so let's bypass that
        $asset->unsetEventDispatcher();

        $asset->next_audit_date = $request->input('next_audit_date');
        $asset->last_audit_date = date('Y-m-d H:i:s');

        // Check to see if they checked the box to update the physical location,
        // not just note it in the audit notes
        if ($request->input('update_location') == '1') {
            Log::debug('update location in audit');
            $asset->location_id = $request->input('location_id');
        }

        if ($asset->save()) {
            $file_name = '';
            // Upload an image, if attached
            if ($request->hasFile('image')) {
                $path = 'private_uploads/audits';
                if (!Storage::exists($path)) {
                    Storage::makeDirectory($path, 775);
                }
                $upload = $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                $file_name = 'audit-' . str_random(18) . '.' . $ext;
                Storage::putFileAs($path, $upload, $file_name);
            }


            $asset->logAudit($request->input('note'), $request->input('location_id'), $file_name);
            return redirect()->route('assets.audit.due')->with('success', trans('admin/hardware/message.audit.success'));
        }
    }

    public function getRequestedIndex($user_id = null)
    {
        $this->authorize('index', Asset::class);
        $requestedItems = CheckoutRequest::with('user', 'requestedItem')->whereNull('canceled_at')->with('user', 'requestedItem');

        if ($user_id) {
            $requestedItems->where('user_id', $user_id)->get();
        }

        $requestedItems = $requestedItems->orderBy('created_at', 'desc')->get();

        return view('hardware/requested', compact('requestedItems'));
    }

    public function sendApi()
    {
        $client = new Client();
        
        $url = 'https://api.insw.go.id/api-prod/inventory/temp/saldoAwal';
        
        
        $dataSend = Asset::where('status_kirim', 'B')
                            ->where('departemen', 'OPERATION')
                            ->get();
        
        $dt = Carbon::now();
        $tahunSekarang = date('Y', strtotime($dt->toDateString()));

        $dataKegiatan = [];
        $data = [];
        foreach ($dataSend as $key => $d) {
            $row = [];
            $row["kd_kategori_barang"] = (String) $d['nomor_kategori_barang'];
            $row["kd_barang"] = $d["asset_tag"];
            $row["uraian_barang"] = $d["name"];
            $row["jumlah"] = $d["jumlah_barang"];
            $row["satuan"] = $d["satuan_barang"];
            $row["nilai"] = $d["harga_total_barang"];
            $row["tanggal_declare"] = $d["created_at"];
            $data[] = $row;
        }
        
        $dataPerusahaan = Perusahaan::find(1);

        $dataKegiatan["no_kegiatan"] = "001/SALDOAWAL/" . $tahunSekarang;
        $dataKegiatan["tgl_kegiatan"] = $dt->toDateString();
        $dataKegiatan["npwp"] = (String) $dataPerusahaan->perusahaan_npwp;
        $dataKegiatan["nib"] = (String) $dataPerusahaan->perusahaan_nib;
        $dataKegiatan["barangSaldo"] = $data;

        
        try {
            $request = $client->post($url, [
                'headers' => [
                    'accept' => 'application/json',
                    
                    'x-insw-key' => 'pZ66hobzPpXBn2bMHVPTz0wG1pxuWQdo',
                    'x-unique-key' => '0862fbfe75bc4cbb1d18c278b720a40549f3d6b226470318dd927054e0b89ed0'
                ],
                'json' => [
                    "data" => $dataKegiatan
                    
                ]
            ]);

            $response = json_decode($request->getBody()->getContents(), true);
            
            if($response['code'] === '01'){
                
                
                foreach ($dataSend as $key => $d) {
                    $dataUpdate = [
                        'status_kirim' => 'S',
                        'saldo_awal' => $d['jumlah_barang'],
                        'pemasukan'=> 0,
                        
                    ];
                    DB::table('assets')
                        ->where('id', $d['id'])
                        ->update($dataUpdate);
                    }
                    // Update semua data di tabel 'pemasukan' tanpa where
                    DB::table('pemasukan')->update(['status_sending' => 'n']);
                    return redirect()->route('hardware.index')
                    ->with('success-unescaped', 'Sukses Mengirim Data Ke INSW');
                }else{
                    return redirect()->back()->withErrors('Gagal Mengirim Data Ke Insw');
                }

            
            // return response()->json($response['code']);
        } catch (\Throwable $e) {
            // Handle exceptions during the request
            // echo "Error: " . $e->getMessage();
            // dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function sendApiFinal(){
        $client = new Client();
        // $url = 'https://api.insw.go.id/api-prod/inventory/tempFinalisasiRegistrasi';
        $url = 'https://api.insw.go.id/api-prod/inventory/temp/registrasi';

        try {

            $request = $client->put($url, [
                'headers' => [
                    'accept' => 'application/json',
                    // 'x-insw-key' => config('app.api_key_insw')
                    'x-insw-key' => 'pZ66hobzPpXBn2bMHVPTz0wG1pxuWQdo',
                    'x-unique-key' => '0862fbfe75bc4cbb1d18c278b720a40549f3d6b226470318dd927054e0b89ed0'
                ],
                // 'form_params' => [
                //     "npwp" => '902280312915000'
                // ]
            ]);

            $response = json_decode($request->getBody()->getContents(), true);
            if($response['code'] === '01'){
                return redirect()->route('hardware.index')
                ->with('success-unescaped', 'Sukses Mefinalkan Data INSW');
            }else{
                return redirect()->back()->withInput()->withErrors('Gagal Mefinalkan Data Ke INSW');
            }

            
            // return response()->json($response['code']);
        } catch (\Exception $e) {
            // Handle exceptions during the request
            echo "Error: " . $e->getMessage();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function CleansingDataApi(){
        $client = new Client();
        $url = 'https://api.insw.go.id/api-prod/inventory/tempCleansing';
        try {
            $request = $client->delete($url, [
                'headers' => [
                    'accept' => 'application/json',
                    // 'x-insw-key' => config('app.api_key_insw')
                    'x-insw-key' => 'pZ66hobzPpXBn2bMHVPTz0wG1pxuWQdo',
                    'x-unique-key' => 'f676e7f530a572df82ddf244a3c064dfb655a1019f4162705233d1ecf797b82b'
                ],
                'form_params' => [
                    "npwp" => '902280312915000'
                ]
            ]);

            $response = json_decode($request->getBody()->getContents(), true);
            if($response['code'] === '01'){
                return redirect()->route('hardware.index')
                ->with('success-unescaped', 'Sukses Membersihkan Data INSW');
            }else{
                return redirect()->back()->withInput()->withErrors('Gagal Membersihkan Data Ke INSW');
            }
            // return response()->json($response['code']);
        } catch (\Exception $e) {
            // Handle exceptions during the request
            echo "Error: " . $e->getMessage();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
