<?php

use App\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currecies = ['usd', 'eur', 'gbp'];

        foreach($currecies as $currency)
        {
            Currency::create(['iso' => $currency]);
        }
    }
}
