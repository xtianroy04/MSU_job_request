<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // Create a cost center and get its ID
        $costCenterId = DB::table('cost_centers')->insertGetId([
            'name' => 'College of Marine and Allied Sciences',
            'code' => 'CCMAS-0001',
        ]);

        // Create a user and associate the cost center with them
        DB::table('users')->insert([
            'first_name' => 'Casseee',
            'last_name' => 'Orion',
            'email' => 'admin@gmail.com',
            'contact_number' => '09922583516',
            'roles' => 'Admin',
            'password' => Hash::make('password'),
            'cost_center_id' => $costCenterId, // Associate the cost center with the user
        ]);
    }
}

