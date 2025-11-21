<?php

namespace App\Presenters;

/**
 * Class LicensePresenter
 */
class PemasukanPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'kode_dokumen_pabean',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Kode Dokumen Pabean'),
            ], [
                'field' => 'nomor_daftar',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nomor Daftar'),
            ], [
                'field' => 'tanggal_daftar',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Tanggal Daftar'),
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'nomor_pemasukan',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nomor Pemasukan'),
            ], [
                'field' => 'tanggal_pemasukan',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Tanggal Pemasukan'),
                'formatter' => 'dateDisplayFormatter',  
            ], [
                'field' => 'nama_pengirim',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nama Pengirim'),
            ], [
                'field' => 'kode_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Kode Barang'),
            ],[
                'field' => 'serial_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Serial Barang'),
            ],[
                'field' => 'lokasi_asset',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Lokasi'),
            ],[
                'field' => 'detail_lokasi_asset',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Detail Lokasi'),
            ], [
                'field' => 'kategori_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Kategori Barang'),
            ], [
                'field' => 'nama_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nama Barang'),
            ], [
                'field' => 'jumlah_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Jumlah Barang (Pemasukan)')
            ], [
                'field' => 'satuan_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Satuan Barang'),
            ],[
                'field' => 'mata_uang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Mata Uang'),
            ], [
                'field' => 'harga_satuan_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Harga Satuan Barang'),
            ], [
                'field' => 'harga_total_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Harga Total Barang'),
            ], [
                'field' => 'nomor_dokumen_pabean',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nomor Dokumen Pabean (HS-Code)'),
            ], [
                'field' => 'tanggal_dokumen_pabean',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Tanggal Dokumen Pabean')
            ], [
                'field' => 'status_sending',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Status Kirim')
            ], [
                'field' => 'keterangan_pemasukan',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Keterangan Pemasukan')
            ], 
            [
                'field' => 'lampiran_display',
                'searchable' => false,
                'sortable' => false,
                'title' => trans('Lampiran'),
                'escape' => false,
                'formatter' => 'lampiranFormatter',
            ],
        ];


        $layout[] = [
            'field' => 'actions',
            'searchable' => false,
            'sortable' => false,
            'switchable' => false,
            'title' => trans('table.actions'),
            'formatter' => 'pemasukanActionsFormatter',
        ];

        return json_encode($layout);
    }

    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayoutSeats()
    {
        $layout = [
            [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
           ],
           [
                'field' => 'name',
                'searchable' => false,
                'sortable' => false,
                'sorter'   => 'numericOnly',
                'switchable' => true,
                'title' => trans('admin/licenses/general.seat'),
                'visible' => true,
            ], [
                'field' => 'assigned_user',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('admin/licenses/general.user'),
                'visible' => true,
                'formatter' => 'usersLinkObjFormatter',
            ], [
                'field' => 'assigned_user.email',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('admin/users/table.email'),
                'visible' => true,
                'formatter' => 'emailFormatter',
            ], [
                'field' => 'department',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.department'),
                'visible' => false,
                'formatter' => 'departmentNameLinkFormatter',
            ], [
                'field' => 'assigned_asset',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('admin/licenses/form.asset'),
                'visible' => true,
                'formatter' => 'hardwareLinkObjFormatter',
            ], [
                'field' => 'location',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('general.location'),
                'visible' => true,
                'formatter' => 'locationsLinkObjFormatter',
            ],
            [
                'field' => 'notes',
                'searchable' => false,
                'sortable' => false,
                'visible' => false,
                'title' => trans('general.notes'),
                'formatter' => 'notesFormatter'
            ],
            [
                'field' => 'checkincheckout',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('general.checkin').'/'.trans('general.checkout'),
                'visible' => true,
                'formatter' => 'licenseSeatInOutFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Link to this licenses Name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('licenses.show', $this->name, $this->id);
    }

    /**
     * Link to this licenses Name
     * @return string
     */
    public function fullName()
    {
        return $this->name;
    }

    /**
     * Link to this licenses serial
     * @return string
     */
    public function serialUrl()
    {
        return (string) link_to('/licenses/'.$this->id, mb_strimwidth($this->serial, 0, 50, '...'));
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('licenses.show', $this->id);
    }
}
