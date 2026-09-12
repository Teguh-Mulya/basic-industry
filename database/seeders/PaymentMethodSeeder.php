<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'Tunai', 'description' => 'Pembayaran langsung di toko'],
            ['name' => 'Transfer Bank', 'description' => 'Transfer ke rekening Basic Industry'],
            ['name' => 'QRIS', 'description' => 'Pembayaran melalui QRIS Basic Industry'],
            ['name' => 'E-Wallet', 'description' => 'DANA / OVO / GoPay'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::firstOrCreate(['name' => $method['name']], $method + ['is_active' => true]);
        }
    }
}
