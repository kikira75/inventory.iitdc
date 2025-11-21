<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\LicenseSeatsTransformer;
use App\Http\Transformers\LicensesTransformer;
use App\Http\Transformers\ListAllTransformer;
use App\Http\Transformers\ListTransformer;
use App\Http\Transformers\PemasukanTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Company;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\ListAll;
use App\Models\Listall as ModelsListall;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', ListAll::class);

        $listall = ListAll::select('*');
        // dd($listall);

        $allowed_columns =
        [
            // 'name',
            // 'id',
            // 'assets_id',
            // 'nomor_daftar',
            // 'tanggal_daftar',
            // 'nomor_pemasukan',
            // 'tanggal_pemasukan',
            // 'nama_pengirim',
            // 'kode_barang',
            // 'kategori_barang',
            // 'nama_barang',
            // 'satuan_barang',
            // 'jumlah_barang',
            // 'harga_satuan_barang',
            // 'harga_total_barang',
            // 'nomor_dokumen_pabean',
            // 'kode_dokumen_pabean',
            // 'tanggal_dokumen_pabean',
            // 'keterangan_pemasukan',

            'id_detail_asset',
            'assets_id',
            'kode_barang',
            'kode_dokumen_kepabeanan',
            'serial_barang',
            'nama_barang',
            'company',
            'departemen',
            'metode_pengadaan',
            'status_pemasukan',
            'owner',
            'lokasi',
            'detil_lokasi',
            'site',
            'event',
            'satuan_barang',
            'harga_barang',
            'jumlah_barang',
        ];

        // dd($listall);

        // if ($request->filled('name')) {
        //     $listall->where('assets.name', '=', $request->input('name'));
        // }


        if ($request->filled('event')) {
            $listall->where('event', '=', $request->input('event'));
        }

        if ($request->filled('departemen')) {
            $listall->where('departemen', '=', $request->input('departemen'));
        }
        if ($request->filled('lokasi')) {
            $listall->where('lokasi', '=', $request->input('lokasi'));
        }
        if ($request->filled('site')) {
            $listall->where('site', '=', $request->input('site'));
        }
        if ($request->filled('tanggal_pemasukan')) {
            $listall->where('tanggal_pemasukan', '=', $request->input('tanggal_pemasukan'));
        }
        if ($request->filled('owner')) {
            $listall->where('owner', '=', $request->input('owner'));
        }
        if ($request->filled('kode_barang')) {
            $listall->where('kode_barang', '=', $request->input('kode_barang'));
        }
        if ($request->filled('nama_barang')) {
            $listall->where('nama_barang', '=', $request->input('nama_barang'));
        }
        if ($request->filled('satuan_barang')) {
            $listall->where('satuan_barang', '=', $request->input('satuan_barang'));
        }
        if ($request->filled('jumlah_barang')) {
            $listall->where('jumlah_barang', '=', $request->input('jumlah_barang'));
        }
        if ($request->filled('harga_satuan_barang')) {
            $listall->where('harga_satuan_barang', '=', $request->input('harga_satuan_barang'));
        }
        if ($request->filled('harga_total_barang')) {
            $listall->where('harga_total_barang', '=', $request->input('harga_total_barang'));
        }
        if ($request->filled('tanggal_dokumen_pabean')) {
            $listall->where('tanggal_dokumen_pabean', '=', $request->input('tanggal_dokumen_pabean'));
        }
        if ($request->filled('keterangan_pemasukan')) {
            $listall->where('keterangan_pemasukan', '=', $request->input('keterangan_pemasukan'));
        }

        if ($request->filled('search')) {
            $listall = $listall->TextSearch($request->input('search'));
        }

        // if ($request->input('deleted')=='true') {
        //     $listall->onlyTrashed();
        // }

        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $listall->count()) ? $listall->count() : app('api_offset_value');
        $limit = app('api_limit_value');

        
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'nama_barang';
        // dd($sort);
        $listall->orderBy($sort, $order);

        $total = $listall->count();
        $listall = $listall->skip($offset)->take($limit)->get();
        return (new ListTransformer)->transformLists($listall, $total);
        
        // transformListsListTransformer
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->authorize('create', License::class);
        $license = new License;
        $license->fill($request->all());

        if ($license->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $license, trans('admin/licenses/message.create.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $license->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', License::class);
        $license = License::withCount('freeSeats')->findOrFail($id);
        $license = $license->load('assignedusers', 'licenseSeats.user', 'licenseSeats.asset');

        return (new LicensesTransformer)->transformLicense($license);
    }

    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->authorize('update', License::class);

        $license = License::findOrFail($id);
        $license->fill($request->all());

        if ($license->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $license, trans('admin/licenses/message.update.success')));
        }

        return Helper::formatStandardApiResponse('error', null, $license->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $license = License::findOrFail($id);
        $this->authorize('delete', $license);

        if ($license->assigned_seats_count == 0) {
            // Delete the license and the associated license seats
            DB::table('license_seats')
                ->where('id', $license->id)
                ->update(['assigned_to' => null, 'asset_id' => null]);

            $licenseSeats = $license->licenseseats();
            $licenseSeats->delete();
            $license->delete();

            // Redirect to the licenses management page
            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/licenses/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/licenses/message.assoc_users')));
    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @see \App\Http\Transformers\SelectlistTransformer
     */
    public function selectlist(Request $request)
    {
        $licenses = License::select([
            'licenses.id',
            'licenses.name',
        ]);

        if ($request->filled('search')) {
            $licenses = $licenses->where('licenses.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $licenses = $licenses->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($licenses);
    }
}
