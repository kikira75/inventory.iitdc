<?php

namespace Database\Seeders;

use App\Models\StockOpname;
use Illuminate\Database\Seeder;

class StockOpnameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        StockOpname::create([
            'assets_id' => 1,
            'implementation_date' => '2024-03-01',
            'item_code' => '123',
            'item_category' => 'mesin dan peralatan',
            'item_name' => 'SUPER CUB 50',
            'item_unit' => 'PCE',
            'item_quantity' => 1,
            'description' => 'tes',
            'entry_status' => 'l',
            'status_sending' => 'A',
            'datetime_sending' => ''
        ]);
    }
}
