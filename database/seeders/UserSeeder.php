<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@yahoo.com',
                'password' => Hash::make('admin123'),
                'jabatan' => 'admin'
            ],
            [
                'name' => 'Apoteker',
                'email' => 'apoteker@yahoo.com',
                'password' => Hash::make('apoteker123'),
                'jabatan' => 'apoteker'
            ],
            [
                'name' => 'Karyawan',
                'email' => 'karyawan@yahoo.com',
                'password' => Hash::make('karyawan123'),
                'jabatan' => 'karyawan'
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@yahoo.com',
                'password' => Hash::make('kasir123'),
                'jabatan' => 'kasir'
            ],
            [
                'name' => 'Pemilik',
                'email' => 'pemilik@yahoo.com',
                'password' => Hash::make('pemilik123'),
                'jabatan' => 'pemilik'
            ]
        ]);
    }
}
