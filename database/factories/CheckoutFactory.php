<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'assets_id' => 1,
            'document_type' => '1234',
            'registration_number' => 'abcd1234',
            'registration_date' => '2024-03-01',
            'receipt_number' => 200,
            'receipt_date' => '2024-03-01',
            'item_code' => '123',
            'item_category' => 'mesin dan peralatan',
            'item_name' => 'SUPER CUB 50',
            'item_unit' => 'PCE',
            'item_quantity' => 1,
            'entry_status' => 'l',
            'status_sending' => 'A',
            'datetime_sending' => '',
        ];
    }
}
