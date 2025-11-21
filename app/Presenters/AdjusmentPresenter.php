<?php

namespace App\Presenters;

/**
 * Class LicensePresenter
 */
class AdjusmentPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field'     => 'ids',
                'title'     => '',
                'checkbox'  => true,
                'formatter' => 'conditionalCheckboxFormatter',
                'sortable'  => false,
                'searchable'=> false,
            ],
            [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'tanggal_pelaksanaan',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Tanggal Pelaksanaan'),
            ], [
                'field' => 'nomor_dokumen_kegiatan',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nomor Dokumen Kegiatan'),
            ], [
                'field' => 'nama_entitas_transaksi',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nama Entitas Transaksi'),
            ],  [
                'field' => 'kode_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Kode Barang'),
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
                'title' => trans('Jumlah Barang Sebelumnya'),
            ], [
                'field' => 'satuan_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Satuan Barang'),
            ], [
                'field' => 'harga_satuan_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Harga Satuan barang'),
            ], [
                'field' => 'harga_total_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Harga Total barang'),
            ], [
                'field' => 'saldo_awal',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Saldo Awal'),
            ], [
                'field' => 'jumlah_pemasukan_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Jml. Pemasukan Barang'),
            ], [
                'field' => 'jumlah_pengeluaran_barang',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Jml. Pengeluaran Barang'),
            ], [
                'field' => 'penyesuaian',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Jumlah Barang Adjustment'),
            ], [
                'field' => 'saldo_buku',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Saldo Akhir'),
            ], [
                'field' => 'stock_opname',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Stock Opname'),
            ], [
                'field' => 'selisih',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Selisih'),
            ], [
                'field' => 'hasil_pencacahan',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Hasil Pencacahan'),
            ], [
                'field' => 'jumlah_selisih',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Jumlah Selisih'),
            ], [
                'field' => 'kode_dokumen',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Kode Dokumen Pabean'),
            ],[
                'field' => 'nomor_dokumen',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Nomor Dokumen Pabean (HS-Code)'),
            ], [
                'field' => 'tanggal_dokumen',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Tanggal Dokumen')
            ], [
                'field' => 'status_sending',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('Status Kirim'),
            ], [
                'field' => 'lampiran_display',
                'searchable' => false,
                'sortable' => false,
                'title' => trans('Lampiran'),
                'escape' => false,
            ]
        ];


        $layout[] = [
            'field' => 'actions',
            'searchable' => false,
            'sortable' => false,
            'switchable' => false,
            'title' => trans('table.actions'),
            'formatter' => 'adjusmentActionsFormatter',
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
