<?php

namespace App\Importer;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Statuslabel;
use App\Models\User;
use App\Events\CheckoutableCheckedIn;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AssetImporter extends ItemImporter
{
    protected $defaultStatusLabelId;

    public function __construct($filename)
    {
        parent::__construct($filename);

        if (!is_null(Statuslabel::first())) {
            $this->defaultStatusLabelId = Statuslabel::first()->id;
        }
    }

    protected function handle($row)
    {
        // ItemImporter handles the general fetching.
        parent::handle($row);

        if ($this->customFields) {
            foreach ($this->customFields as $customField) {
                $customFieldValue = $this->array_smart_custom_field_fetch($row, $customField);

                if ($customFieldValue) {
                    if ($customField->field_encrypted == 1) {
                        $this->item['custom_fields'][$customField->db_column_name()] = \Crypt::encrypt($customFieldValue);
                        $this->log('Custom Field '.$customField->name.': '.\Crypt::encrypt($customFieldValue));
                    } else {
                        $this->item['custom_fields'][$customField->db_column_name()] = $customFieldValue;
                        $this->log('Custom Field '.$customField->name.': '.$customFieldValue);
                    }
                } else {
                    // Clear out previous data.
                    $this->item['custom_fields'][$customField->db_column_name()] = null;
                }
            }
        }


        $this->createAssetIfNotExists($row);
    }

    /**
     * Create the asset if it does not exist.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param array $row
     * @return Asset|mixed|null
     */

     public function createAssetIfNotExists(array $row)
     {
        $editingAsset = false;
        $asset_tag = $this->findCsvMatch($row, 'asset_tag');

        $asset = new Asset;
         
        $this->item['name'] = trim($this->findCsvMatch($row, 'name'));
        $this->item['asset_tag'] = $asset_tag;
        // $this->item['model_id'] = intval(trim($this->findCsvMatch($row, 'model_id')));
        $this->item['model_id'] = 1;
        // $this->item['user_id'] = intVal(trim($this->findCsvMatch($row, 'user_id')));
        $this->item['user_id'] = 1;
        // $this->item['status_id'] = intVal(trim($this->findCsvMatch($row, 'status_id')));
        $this->item['status_id'] = 2;
        // $this->item['company_id'] = intVal(trim($this->findCsvMatch($row, 'company_id')));
        $this->item['company_id'] = 1;
        $this->item['assigned_type'] = trim($this->findCsvMatch($row, 'assigned_type'));
        $this->item['byod'] = 0;
        $this->item['kategori_barang'] = trim(strtolower($this->findCsvMatch($row, 'kategori_barang')));
        $this->item['nomor_kategori_barang'] = intval(trim($this->findCsvMatch($row, 'nomor_kategori_barang')));
        $this->item['owner'] = trim($this->findCsvMatch($row, 'owner'));
        $this->item['ncompanies'] = trim($this->findCsvMatch($row, 'owner'));
        $this->item['departemen'] = trim($this->findCsvMatch($row, 'departemen'));
        $this->item['site'] = trim($this->findCsvMatch($row, 'site'));
        $this->item['lokasi_asset'] = trim($this->findCsvMatch($row, 'lokasi_asset'));
        $this->item['detail_lokasi_asset'] = trim($this->findCsvMatch($row, 'detail_lokasi_asset'));
        $this->item['event'] = trim($this->findCsvMatch($row, 'event'));
        $this->item['metode_pengadaan'] = trim($this->findCsvMatch($row, 'metode_pengadaan'));
        $this->item['nomor_purchase'] = trim($this->findCsvMatch($row, 'nomor_purchase'));
        $this->item['keterangan'] = trim($this->findCsvMatch($row, 'keterangan'));
        $this->item['bea'] = trim($this->findCsvMatch($row, 'bea'));
        $this->item['ppn'] = intval(trim($this->findCsvMatch($row, 'ppn')));
        $this->item['ppnbm'] = trim($this->findCsvMatch($row, 'ppnbm'));
        $this->item['pph_impor'] = trim($this->findCsvMatch($row, 'pph_impor'));
        $this->item['nomor_pengajuan'] = trim($this->findCsvMatch($row, 'nomor_pengajuan'));
        $this->item['tanggal_pengajuan'] = trim($this->findCsvMatch($row, 'tanggal_pengajuan'));
        
        $jumlahBarang = intval(trim($this->findCsvMatch($row, 'jumlah_barang')));
        // $this->item['jumlah_barang'] = $jumlahBarang;
        $this->item['jumlah_barang'] = 0;
        $this->item['satuan_barang'] = trim($this->findCsvMatch($row, 'satuan_barang'));
        $this->item['mata_uang'] = trim($this->findCsvMatch($row, 'mata_uang'));
        $this->item['kode_dokumen_pabean'] = trim($this->findCsvMatch($row, 'kode_dokumen_pabean'));
        $this->item['nama_dokumen_pabean'] = trim($this->findCsvMatch($row, 'nama_dokumen_pabean'));
        $this->item['harga_satuan_barang'] = intval(trim($this->findCsvMatch($row, 'harga_satuan_barang')));
        // $this->item['harga_total_barang'] = intval(trim($this->findCsvMatch($row, 'harga_total_barang')));
        $this->item['harga_total_barang'] = intval(trim($this->findCsvMatch($row, 'harga_satuan_barang')));
        // $this->item['saldo_awal'] = $jumlahBarang;
        $this->item['saldo_awal'] = 0;
        $this->item['pemasukan'] = 0;
        $this->item['pengeluaran'] = 0;
        $this->item['penyesuaian'] = 0;
        // $this->item['saldo_buku'] = $jumlahBarang;
        $this->item['saldo_buku'] = 0;
        $this->item['stock_opname'] = 0;
        $this->item['selisih'] = 0;
        $this->item['hasil_pencacahan'] = 0;
        $this->item['jumlah_selisih'] = $jumlahBarang;
        $this->item['status_kirim'] = trim($this->findCsvMatch($row, 'status_kirim'));
        $this->item['status_pemasukan'] = trim($this->findCsvMatch($row, 'status_pemasukan'));
        $this->item['status_pemasukan_mgpa'] = trim(strtolower($this->findCsvMatch($row, 'status_pemasukan_mgpa')));
        // $this->item['jenis_transaksi'] = trim($this->findCsvMatch($row, 'jenis_transaksi'));
        $this->item['jenis_transaksi'] = 't';
 
 
         
         $item = $this->sanitizeItemForStoring($asset, $editingAsset);
         // The location id fetched by the csv reader is actually the rtd_location_id.
         // This will also set location_id, but then that will be overridden by the
         // checkout method if necessary below.
         
        
         if ($editingAsset) {
             $asset->update($item);
         } else {
             $asset->fill($item);
         }
 
         // This sets an attribute on the Loggable trait for the action log
         $asset->setImported(true);
         if ($asset->save()) {
 
             $this->log('Asset '.$this->item['name'].' with serial number '.$this->item['serial'].' was created');
 
             // If we have a target to checkout to, lets do so.
             //-- user_id is a property of the abstract class Importer, which this class inherits from and it's setted by
             //-- the class that needs to use it (command importer or GUI importer inside the project).
            
             return;
         }
         $this->logError($asset, 'Asset "'.$this->item['name'].'"');
     }


    // public function createAssetIfNotExists(array $row)
    // {
    //     $editingAsset = false;
    //     $asset_tag = $this->findCsvMatch($row, 'asset_tag');

    //     if(empty($asset_tag)){
    //         $asset_tag = Asset::autoincrement_asset();
    //     }


    //     $asset = Asset::where(['asset_tag'=> (string) $asset_tag])->first();
    //     if ($asset) {
    //         if (! $this->updating) {
    //             $this->log('A matching Asset '.$asset_tag.' already exists');

    //             return;
    //         }

    //         $this->log('Updating Asset');
    //         $editingAsset = true;
    //     } else {
    //         $this->log('No Matching Asset, Creating a new one');
    //         $asset = new Asset;
    //     }
    //     $this->item['notes'] = trim($this->findCsvMatch($row, 'asset_notes'));
    //     $this->item['image'] = trim($this->findCsvMatch($row, 'image'));
    //     $this->item['requestable'] = trim(($this->fetchHumanBoolean($this->findCsvMatch($row, 'requestable'))) == 1) ? '1' : 0;
    //     $asset->requestable = $this->item['requestable'];
    //     $this->item['warranty_months'] = intval(trim($this->findCsvMatch($row, 'warranty_months')));
    //     $this->item['model_id'] = $this->createOrFetchAssetModel($row);
    //     $this->item['byod'] = ($this->fetchHumanBoolean(trim($this->findCsvMatch($row, 'byod'))) == 1) ? '1' : 0;


    //     // If no status ID is found
    //     if (! array_key_exists('status_id', $this->item) && ! $editingAsset) {
    //         $this->log('No status field found, defaulting to first status.');
    //         $this->item['status_id'] = $this->defaultStatusLabelId;
    //     }

    //     $this->item['asset_tag'] = $asset_tag;

    //     // We need to save the user if it exists so that we can checkout to user later.
    //     // Sanitizing the item will remove it.
    //     if (array_key_exists('checkout_target', $this->item)) {
    //         $target = $this->item['checkout_target'];
    //     }
    //     $item = $this->sanitizeItemForStoring($asset, $editingAsset);
    //     // The location id fetched by the csv reader is actually the rtd_location_id.
    //     // This will also set location_id, but then that will be overridden by the
    //     // checkout method if necessary below.
    //     if (isset($this->item['location_id'])) {
    //         $item['rtd_location_id'] = $this->item['location_id'];
    //     }

    //     $item['last_audit_date'] = null;
    //     if (isset($this->item['last_audit_date'])) {
    //         $item['last_audit_date'] = $this->item['last_audit_date'];
    //     }

    //     $item['next_audit_date'] = null;
    //     if (isset($this->item['next_audit_date'])) {
    //         $item['next_audit_date'] = $this->item['next_audit_date'];
    //     }
       
    //     if ($editingAsset) {
    //         $asset->update($item);
    //     } else {
    //         $asset->fill($item);
    //     }

    //     // If we're updating, we don't want to overwrite old fields.
    //     if (array_key_exists('custom_fields', $this->item)) {
    //         foreach ($this->item['custom_fields'] as $custom_field => $val) {
    //             $asset->{$custom_field} = $val;
    //         }
    //     }
    //     // This sets an attribute on the Loggable trait for the action log
    //     $asset->setImported(true);
    //     if ($asset->save()) {

    //         $this->log('Asset '.$this->item['name'].' with serial number '.$this->item['serial'].' was created');

    //         // If we have a target to checkout to, lets do so.
    //         //-- user_id is a property of the abstract class Importer, which this class inherits from and it's setted by
    //         //-- the class that needs to use it (command importer or GUI importer inside the project).
    //         if (isset($target) && ($target !== false)) {
    //             if (!is_null($asset->assigned_to)){
    //                 if ($asset->assigned_to != $target->id){
    //                     event(new CheckoutableCheckedIn($asset, User::find($asset->assigned_to), Auth::user(), $asset->notes, date('Y-m-d H:i:s')));
    //                 }
    //             }

    //             $asset->fresh()->checkOut($target, $this->user_id, date('Y-m-d H:i:s'), null, $asset->notes, $asset->name);
    //         }

    //         return;
    //     }
    //     $this->logError($asset, 'Asset "'.$this->item['name'].'"');
    // }
}
