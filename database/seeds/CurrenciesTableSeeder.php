<?php

use App\Currency;

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ "id" => "1", "country" => "Kenya", "currency" => "Kenyan shilling", "code" => "KES", "symbol" => "KSh",
            "thousand_separator" => ",", "decimal_separator" => ".", "created_at" => null , "updated_at" => null ]
      ];

        Currency::insert($data);

        Currency::insert([
            [ "country" => "Uganda", "currency" => "Uganda shillings", "code" => "UGX", "symbol" => "USh", "thousand_separator" => ",", "decimal_separator" => ".", "created_at" => null , "updated_at" => null ],
            [ "country" => "Tanzania", "currency" => "Tanzanian shilling", "code" => "TZS", "symbol" => "TSh", "thousand_separator" => ",", "decimal_separator" => ".", "created_at" => null , "updated_at" => null ],
      ]);
    }
}
