<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            'name' => 'Trial',
            'slug' => 'trial',
            'stripe_plan' => '',
            'cost' => 0,
            'description' => 'trial with 30 days',      
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
