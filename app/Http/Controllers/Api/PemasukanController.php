<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\LicenseSeatsTransformer;
use App\Http\Transformers\LicensesTransformer;
use App\Http\Transformers\PemasukanTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Company;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
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
            $this->authorize('view', Pemasukan::class);

            $query = Pemasukan::select('*');

            $status = $request->input('status');

            if ($status == 'Deleted') {
                $query->onlyTrashed();
            } elseif ($status == 'All') {
                $query->withTrashed();
            }

            // -------- FILTERS --------
            if ($request->filled('nama_pengirim')) {
                $query->where('nama_pengirim', $request->nama_pengirim);
            }

            if ($request->filled('nomor_daftar')) {
                $query->where('nomor_daftar', $request->nomor_daftar);
            }

            if ($request->filled('tanggal_daftar')) {
                $query->where('tanggal_daftar', $request->tanggal_daftar);
            }

            if ($request->filled('nomor_pemasukan')) {
                $query->where('nomor_pemasukan', $request->nomor_pemasukan);
            }

            // Range tanggal pemasukan
            if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
                $query->whereBetween('tanggal_pemasukan', [
                    $request->tanggal_mulai,
                    $request->tanggal_akhir
                ]);
            }

            if ($request->filled('kode_barang')) {
                $query->where('kode_barang', $request->kode_barang);
            }

            if ($request->filled('nama_barang')) {
                $query->where('nama_barang', $request->nama_barang);
            }

            if ($request->filled('nama_company')) {
                $query->where('nama_company', $request->nama_company);
            }

            if ($request->filled('departemen')) {
                $query->where('departemen', $request->departemen);
            }

            if ($request->filled('search')) {
                $query->TextSearch($request->search);
            }

            // -------- SORTING --------
            $allowed = [
                'id','assets_id','nomor_daftar','tanggal_daftar','nomor_pemasukan',
                'tanggal_pemasukan','nama_pengirim','kode_barang','kategori_barang',
                'nama_barang','satuan_barang','jumlah_barang','harga_satuan_barang',
                'harga_total_barang','nomor_dokumen_pabean','kode_dokumen_pabean',
                'tanggal_dokumen_pabean','keterangan_pemasukan','nama_company','departemen'
            ];

            $sort = $request->input('sort');
            $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

            if (!in_array($sort, $allowed)) {
                $sort = 'nama_barang';
            }

            $query->orderBy($sort, $order);

            // -------- PAGINATION --------
            $offset = intval($request->input('offset', 0));
            $limit = intval($request->input('limit', 50));

            $total = $query->count();

            $data = $query->skip($offset)->take($limit)->get();
            $data->transform(function ($item) {
                $item->checkbox = $item->id;
                return $item;
            });

            return (new PemasukanTransformer)->transformPemasukans($data, $total);
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
