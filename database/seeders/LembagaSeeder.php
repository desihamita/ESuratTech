<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lembaga;

class LembagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lembaga::create([
            'nama_lembaga' => 'Lembaga Pendidikan ABC',
            'telepon' => '022-98765432',
            'website' => 'https://lembaga-abc.com',
            'email' => 'contact@lembaga-abc.com',
            'alamat' => 'Jl. Pendidikan No. 2, Bandung',
            'tahun' => 2005,
            'kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kepala' => 'Dr. Jane Smith',
            'nip' => '1985121209876543',
            'jabatan' => 'Kepala Lembaga',
            'logo' => null,
        ]);
    }
}
