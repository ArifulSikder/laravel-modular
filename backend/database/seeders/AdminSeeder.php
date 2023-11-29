<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class AdminSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('users')->delete();
        $usersRecord = [
            [
                'id' => 1, 'name' => 'M Hannan', 'email' => 'admin@admin.com', 'password' => Hash::make('12345678')
            ]
        ];
        DB::table('users')->insert($usersRecord);
    }
}
