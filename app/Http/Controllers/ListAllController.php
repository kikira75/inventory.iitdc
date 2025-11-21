<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\ListAll;
// use App\Models\License;
use App\Models\Pemasukan;
use App\Models\Perusahaan;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ListAllController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index()
    {
        $this->authorize('view', ListAll::class);

        return view('listall/index');
    }

    
}
