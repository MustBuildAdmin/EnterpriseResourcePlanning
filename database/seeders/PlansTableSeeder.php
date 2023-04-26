<?php

namespace Database\Seeders;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create(
            [
                'name' => 'Free Plan',
                'price' => 0,
                'duration' => 'unlimited',
                'max_users' => 5,
                'max_customers' => 5,
                'max_venders' => 5,
                'max_clients' => 5,
                'crm' => 1,
                'hrm' => 1,
                'account' => 1,
                'project' => 1,
                'image'=>'free_plan.png',
            ]
        );
    }
}
