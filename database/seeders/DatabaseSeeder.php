<?php

namespace Database\Seeders;

use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Primary Development Administrator
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Demo Users for testing pagination & search
        $demoUsers = [
            ['name' => 'Alif Bima Pradana', 'email' => 'budi@example.com'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti@example.com'],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@example.com'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com'],
            ['name' => 'Rizky Pratama', 'email' => 'rizky@example.com'],
        ];

        foreach ($demoUsers as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Seed Spatie Roles & Permissions
        $this->call(RolePermissionSeeder::class);

        // 3. Demo Tables for testing dynamic table functionality
        $demoTables = [
            ['name' => 'Pelanggan Enterprise', 'description' => 'Daftar klien tier korporat skala besar dengan kontrak tahunan.', 'status' => 'active'],
            ['name' => 'Inventaris Gudang Utama', 'description' => 'Monitoring stok barang fisik di fasilitas logistik pusat.', 'status' => 'active'],
            ['name' => 'Transaksi Penjualan Q1', 'description' => 'Rekapitulasi penjualan ritel dan online kuartal pertama.', 'status' => 'active'],
            ['name' => 'Arsip Transaksi 2024', 'description' => 'Data historis keuangan tahun lalu yang telah diaudit.', 'status' => 'inactive'],
            ['name' => 'Katalog Produk Digital', 'description' => 'Daftar lisensi software dan paket e-course aktif.', 'status' => 'active'],
            ['name' => 'Vendor Pengiriman Reguler', 'description' => 'Mitra kurir logistik dan ekspedisi kargo darat.', 'status' => 'active'],
            ['name' => 'Log Aktivitas Sistem', 'description' => 'Pencatatan riwayat request API internal dan eksternal.', 'status' => 'active'],
            ['name' => 'Survey Kepuasan Karyawan', 'description' => 'Hasil kuesioner internal departemen operasional.', 'status' => 'inactive'],
            ['name' => 'Daftar Cabang Regional', 'description' => 'Alamat dan kontak kantor perwakilan di seluruh provinsi.', 'status' => 'active'],
            ['name' => 'Paket Langganan SaaS', 'description' => 'Konfigurasi harga dan kuota tier starter, pro, dan enterprise.', 'status' => 'active'],
            ['name' => 'Data Mitra Afiliasi', 'description' => 'Jaringan affiliate marketer dan komisi bulanan.', 'status' => 'active'],
            ['name' => 'Template Email Notifikasi', 'description' => 'Pola template HTML untuk blast email berkala.', 'status' => 'inactive'],
            ['name' => 'Kategori Aset Perusahaan', 'description' => 'Pengelompokan perangkat keras dan inventaris kantor.', 'status' => 'active'],
            ['name' => 'Daftar Blacklist IP', 'description' => 'Daftar alamat IP yang diblokir oleh firewall server.', 'status' => 'inactive'],
            ['name' => 'Jadwal Pemeliharaan Server', 'description' => 'Timeline maintenance rutin server cloud dan database.', 'status' => 'active'],
        ];

        foreach ($demoTables as $item) {
            Table::updateOrCreate(
                ['name' => $item['name']],
                [
                    'description' => $item['description'],
                    'status' => $item['status'],
                ]
            );
        }
    }
}
