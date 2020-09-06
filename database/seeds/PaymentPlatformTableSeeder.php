<?php

use App\PaymentPlatform;
use Illuminate\Database\Seeder;

class PaymentPlatformTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentPlatform::create([
            'name' => 'Paypal',
            'image' => 'img/paypal.jpg'
        ]);

        PaymentPlatform::create([
            'name' => 'Stripe',
            'image' => 'img/stripe.jpg'
        ]);

        PaymentPlatform::create([
            'name' => 'MercadoPago',
            'image' => 'img/mercadopago.jpg'
        ]);
    }
}
