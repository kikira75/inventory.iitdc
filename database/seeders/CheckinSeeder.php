<?php

namespace Database\Seeders;

use App\Models\Checkin;
use Illuminate\Database\Seeder;

class CheckinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Checkin::create([
            'assets_id' => 1,
            'document_type' => '4321',
            'registration_number' => 'abcd4321',
            'registration_date' => '2024-03-01',
            'expense_number' => 200,
            'dispensing_date' => '2024-03-01',
            'item_code' => '123',
            'item_category' => 'mesin dan peralatan',
            'item_name' => 'SUPER CUB 50',
            'item_unit' => 'PCE',
            'item_quantity' => 1,
            'entry_status' => 'l',
            'status_sending' => 'A',
            'datetime_sending' => ''
        ]);
    }
}
