<?php

use Illuminate\Database\Seeder;
use App\Devices;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Devices::class, 100)->create();
    }
}
