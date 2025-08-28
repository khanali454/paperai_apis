<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  $table->string('name');
        //     $table->string('email')->unique();
        //     $table->bigInteger('phone');
        User::create([
            'name'     => 'Aqeel Abbas',
            'email'    => 'aqeel@gmail.com',
            'phone'    => '1234567890',
            'password' => Hash::make('password123'),
        ]);
        User::create([
            'name'     => 'Naveed Ullah',
            'email'    => 'naveed@gmail.com',
            'phone'    => '1234567890',
            'password' => Hash::make('password123'),
        ]);
        User::create([
            'name'     => 'Muhammad Ramzan',
            'email'    => 'ramzan@gmail.com',
            'phone'    => '1234567890',
            'password' => Hash::make('password123'),
        ]);

    }
}
