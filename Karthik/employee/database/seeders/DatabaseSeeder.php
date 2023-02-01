<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\employee;
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

        // \App\Models\employee::HasFactory(10)->create();

        employee::create([
            'full_name' => 'Karthik',
            'dob' => "24/12/2000",
            'phone_number' => '9874563210',
            'email' => 'karthik@gmail.com',
            'gender' => "Male",
            'password' => '123456'
        ]);
    }
}