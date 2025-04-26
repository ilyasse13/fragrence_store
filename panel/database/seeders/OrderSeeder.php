<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();

        if ($customers->isEmpty()) {
            $this->command->warn('No customers found. Please seed customers first.');
            return;
        }

        for ($i = 0; $i < 200; $i++) {
            $randomDate = Carbon::now()->subDays(rand(0, 365));
            Order::create([
                'total_price' => rand(2000, 100000) / 100, // 20.00 to 1000.00
                'status' => collect(['pending', 'shipped', 'delivered'])->random(),
                'customer_id' => $customers->random()->id,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}
