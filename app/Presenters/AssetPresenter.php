<?php

namespace App\Presenters;

use App\Models\CustomField;
use Carbon\CarbonImmutable;
use DateTime;

/**
 * Class AssetPresenter
 */
class AssetPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'checkbox',
                'checkbox' => true,
            ], [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'company',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.company'),
                'visible' => false,
                'formatter' => 'assetCompanyObjFilterFormatter',
            ], 
            
            [
                'field' => 'kode_dokumen_pabean',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Kode Pabean'),
                'visible' => true,
                'formatter' => 'hardwareLinkFormatter',
            ], 
            [
                'field' => 'nama_dokumen_pabean',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Label Pabean'),
                'visible' => true,
                'formatter' => 'hardwareLinkFormatter',
            ], 
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nama Barang'),
                'visible' => true,
                'formatter' => 'hardwareLinkFormatter',
            ], 
            
            [
                'field' => 'asset_tag',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Kode Barang'),
                'visible' => true,
                'formatter' => 'hardwareLinkFormatter',
            ], 
            
            // [
            //     'field' => 'status_label',
            //     'searchable' => true,
            //     'sortable' => true,
            //     'title' => trans('admin/hardware/table.status'),
            //     'visible' => true,
            //     'formatter' => 'statuslabelsLinkObjFormatter',
            // ], 
            [
                'field' => 'status_pemasukan_mgpa',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Status Pemasukan'),

            ], 
            
            [
                'field' => 'checkout_counter',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('general.checkouts_count'),

            ], 
            
            [
                'field' => 'created_at',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('general.created_at'),
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'updated_at',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('general.updated_at'),
                'formatter' => 'dateDisplayFormatter',
            ], 
            
            [
                'field' => 'owner',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Owner'),

            ],
            [
                'field' => 'departemen',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Departemen'),

            ], 
            [
                'field' => 'site',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Site'),

            ], 
            [
                'field' => 'lokasi_asset',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Lokasi'),

            ], 
            [
                'field' => 'detail_lokasi_asset',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Detail Lokasi'),

            ], 
            
            [
                'field' => 'event',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Event'),

            ], 
            
            [
                'field' => 'nomor_purchase',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('No. Purchase'),

            ], 
            [
                'field' => 'keterangan',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Keterangan'),

            ], 
            
            [
                'field' => 'kategori_barang',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Kategori Barang'),

            ],[
                'field' => 'fasilitas',
                'title' => 'Fasilitas Fiskal',
                'sortable' => false,
                'searchable' => false,
                'switchable' => true,
                'visible' => false,
            ], [
                'field' => 'jumlah_barang',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Jumlah Barang'),

            ],[
                'field' => 'jumlah_baris_kode',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Jumlah Serial Pemasukan'),

            ], [
                'field' => 'jumlah_baris_pengeluaran',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Jumlah Serial Pengeluaran'),

            ], [
                'field' => 'jumlah_baris_stockopname',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Jumlah Serial StockOpname'),

            ], [
                'field' => 'jumlah_baris_adjustment',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Jumlah Serial Adjusment'),

            ], [
                'field' => 'satuan_barang',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Satuan Barang'),

            ],[
                'field' => 'mata_uang',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Mata Uang'),

            ], [
                'field' => 'harga_satuan_barang',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Harga Barang'),

            ], [
                'field' => 'harga_total_barang',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Harga Total Barang'),

            ], 
            [
                'field' => 'saldo_awal',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Saldo Awal'),
            ], 
            [
                'field' => 'pemasukan',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Pemasukan'),

            ], [
                'field' => 'pengeluaran',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Pengeluaran'),

            ], [
                'field' => 'penyesuaian',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Adjustment'),

            ], [
                'field' => 'saldo_buku',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Saldo Buku'),

            ], [
                'field' => 'stock_opname',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Stock Opname'),

            ], [
                'field' => 'selisih',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Selisih'),

            ], [
                'field' => 'hasil_pencacahan',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Hasil Pencacahan'),

            ], [
                'field' => 'jumlah_selisih',
                'searchable' => false,
                'sortable' => true,
                'visible' => false,
                'title' => trans('Jumlah Selisih'),

            ], [
                'field' => 'lampiran_display',
                'searchable' => false,
                'sortable' => false,
                'title' => trans('Lampiran'),
                'escape' => false,
                'formatter' => 'lampiranFormatter',
            ]
        ];

        

        $fields = CustomField::whereHas('fieldset', function ($query) {
            $query->whereHas('models');
        })->get();

        
        foreach ($fields as $field) {
            $layout[] = [
                'field' => 'custom_fields.'.$field->db_column,
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => $field->name,
                'formatter'=> 'customFieldsFormatter',
                'escape' => true,
                'class' => ($field->field_encrypted == '1') ? 'css-padlock' : '',
                'visible' => ($field->show_in_listview == '1') ? true : false,
            ];
        }

        $layout[] = [
            'field' => 'actions',
            'searchable' => false,
            'sortable' => false,
            'switchable' => false,
            'title' => trans('table.actions'),
            'formatter' => 'hardwareActionsFormatterHardware',
        ];

        return json_encode($layout);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('hardware.show', e($this->name), $this->id);
    }

    public function modelUrl()
    {
        if ($this->model->model) {
            return $this->model->model->present()->nameUrl();
        }

        return '';
    }

    /**
     * Generate img tag to this items image.
     * @return mixed|string
     */
    public function imageUrl()
    {
        $imagePath = '';
        if ($this->image && ! empty($this->image)) {
            $imagePath = $this->image;
            $imageAlt = $this->name;
        } elseif ($this->model && ! empty($this->model->image)) {
            $imagePath = $this->model->image;
            $imageAlt = $this->model->name;
        }
        $url = config('app.url');
        if (! empty($imagePath)) {
            $imagePath = '<img src="'.$url.'/uploads/assets/'.$imagePath.' height="50" width="50" alt="'.$imageAlt.'">';
        }

        return $imagePath;
    }

    /**
     * Generate img tag to this items image.
     * @return mixed|string
     */
    public function imageSrc()
    {
        $imagePath = '';
        if ($this->image && ! empty($this->image)) {
            $imagePath = $this->image;
        } elseif ($this->model && ! empty($this->model->image)) {
            $imagePath = $this->model->image;
        }
        if (! empty($imagePath)) {
            return config('app.url').'/uploads/assets/'.$imagePath;
        }

        return $imagePath;
    }

    /**
     * Get Displayable Name
     * @return string
     *
     * @todo this should be factored out - it should be subsumed by fullName (below)
     *
     **/
    public function name()
    {
        return $this->fullName;
    }

    /**
     * Helper for notification polymorphism.
     * @return mixed
     */
    public function fullName()
    {
        $str = '';

        // Asset name
        if ($this->model->name) {
            $str .= $this->model->name;
        }

        // Asset tag
        if ($this->asset_tag) {
            $str .= ' ('.$this->model->asset_tag.')';
        }

        // Asset Model name
        if ($this->model->model) {
            $str .= ' - '.$this->model->model->name;
        }

        return $str;
    }

    /**
     * Returns the date this item hits EOL.
     * @return false|string
     */
    public function eol_date()
    {
        if (($this->purchase_date) && ($this->model->model) && ($this->model->model->eol)) {
            return CarbonImmutable::parse($this->purchase_date)->addMonths($this->model->model->eol)->format('Y-m-d');
        }
    }

    /**
     * How many months until this asset hits EOL.
     * @return null
     */
    public function months_until_eol()
    {
        $today = date('Y-m-d');
        $d1 = new DateTime($today);
        $d2 = new DateTime($this->eol_date());

        if ($this->eol_date() > $today) {
            $interval = $d2->diff($d1);
        } else {
            $interval = null;
        }

        return $interval;
    }

    /**
     * @return string
     * This handles the status label "meta" status of "deployed" if
     * it's assigned. Should maybe deprecate.
     */
    public function statusMeta()
    {
        if ($this->model->assigned) {
            return 'deployed';
        }

        return $this->model->assetstatus->getStatuslabelType();
    }

    /**
     * @return string
     * This handles the status label "meta" status of "deployed" if
     * it's assigned. Should maybe deprecate.
     */
    public function statusText()
    {
        if ($this->model->assigned) {
            return trans('general.deployed');
        }

        return $this->model->assetstatus->name;
    }

    /**
     * @return string
     * This handles the status label "meta" status of "deployed" if
     * it's assigned. Results look like:
     *
     * (if assigned and the status label is "Ready to Deploy"):
     * (Deployed)
     *
     * (f assigned and status label is not "Ready to Deploy":)
     * Deployed (Another Status Label)
     *
     * (if not deployed:)
     * Another Status Label
     */
    public function fullStatusText()
    {
        // Make sure the status is valid
        if ($this->assetstatus) {

            // If the status is assigned to someone or something...
            if ($this->model->assigned) {

                // If it's assigned and not set to the default "ready to deploy" status
                if ($this->assetstatus->name != trans('general.ready_to_deploy')) {
                    return trans('general.deployed').' ('.$this->model->assetstatus->name.')';
                }

                // If it's assigned to the default "ready to deploy" status, just
                // say it's deployed - otherwise it's confusing to have a status that is
                // both "ready to deploy" and deployed at the same time.
                return trans('general.deployed');
            }

            // Return just the status name
            return $this->model->assetstatus->name;
        }

        // This status doesn't seem valid - either data has been manually edited or
        // the status label was deleted.
        return 'Invalid status';
    }

    /**
     * Date the warranty expires.
     * @return false|string
     */
    public function warranty_expires()
    {
        if (($this->purchase_date) && ($this->warranty_months)) {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->warranty_months.' months'));

            return date_format($date, 'Y-m-d');
        }

        return false;
    }

    /**
     * Used to take user created warranty URL and dynamically fill in the needed values per asset
     * @return string
     */
    public function dynamicWarrantyUrl()
    {
        $warranty_lookup_url = $this->model->model->manufacturer->warranty_lookup_url;
        $url = (str_replace('{LOCALE}',\App\Models\Setting::getSettings()->locale, $warranty_lookup_url));
        $url = (str_replace('{SERIAL}', urlencode($this->model->serial), $url));
        $url = (str_replace('{MODEL_NAME}', urlencode($this->model->model->name), $url));
        $url = (str_replace('{MODEL_NUMBER}', urlencode($this->model->model->model_number), $url));
        return $url;
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('hardware.show', $this->id);
    }

    public function glyph()
    {
        return '<i class="fas fa-barcode" aria-hidden="true"></i>';
    }
}
