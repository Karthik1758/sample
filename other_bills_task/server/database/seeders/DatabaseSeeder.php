<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\IfscCode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        IfscCode::firstOrCreate([
            'ifsc_code' => "SBIN0020199",
            'bank_name' => "State Bank of India",
            'state' => "Telangana",
            'branch' => "shadnagar"
        ]);

        IfscCode::firstOrCreate([
            'ifsc_code' => "HDFC0004330",
            'bank_name' => "HDFC",
            'state' => "Telangana",
            'branch' => "shadnagar"
        ]);
        IfscCode::firstOrCreate([
            'ifsc_code' => "CNRB0000843",
            'bank_name' => "Canara",
            'state' => "Telangana",
            'branch' => "shadnagar"
        ]);

    }

}