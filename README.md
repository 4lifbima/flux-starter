# Laravel Dashboard Starter Kit (Flux-Inspired UI)

Starter kit dashboard admin yang ringan, rapi, responsif, dan mudah dikembangkan untuk berbagai aplikasi Laravel. Menggunakan **Blade view**, **Tailwind CSS v4**, dan desain **Flux-inspired** tanpa ketergantungan pada Livewire, Inertia, Vue/React, maupun Laravel Official Starter Kit.

---

## 🌟 Fitur Utama

- **Flux-Inspired UI Design System:**
  - Estetika minimalis, bersih, dan profesional ala Linear / Flux UI.
  - Border halus, radius konsisten (`rounded-xl`), palet netral (zinc/slate), dan fokus cincin aksesibel.
  - Tipografi modern menggunakan font *Instrument Sans*.
- **🎨 Kustomisasi Tema Dinamis ("Make it your own."):**
  - **18 Warna Primer:** Base, Red, Orange, Amber, Yellow, Lime, Green, Emerald, Teal, Cyan, Sky, Blue, Indigo, Violet, Purple, Fuchsia, Pink, Rose.
  - **Palet Netral:** Slate, Gray, Zinc, Neutral, Stone, Mauve, Olive, Mist, Taupe.
  - **Mode Tampilan:** Light & Dark mode switcher terintegrasi.
  - **Live Preview & Persistensi:** Perubahan warna dan mode langsung terlihat seketika dan tersimpan di `localStorage` (dilengkapi proteksi anti-FOUC).
- **Icon System (Blade Icons):**
  - Menggunakan paket resmi [blade-ui-kit/blade-icons](https://github.com/blade-ui-kit/blade-icons) & `blade-ui-kit/blade-heroicons`.
  - Terintegrasi penuh tanpa raw inline SVG yang berserakan.
- **Layout & Navigasi Responsif:**
  - Sidebar desktop dengan menu aktif, pemilih tema, dan profil pengguna.
  - Drawer navigasi mobile dengan backdrop blur dan animasi transisi halus.
  - Topbar dengan breadcrumbs dinamis, tombol pemilih tema cepat, dan dropdown profil pengguna.
- **Autentikasi Mandiri (Custom Session Auth):**
  - Dibuat mandiri tanpa starter kit resmi (Breeze/Jetstream).
  - Dilindungi middleware `auth`, login form dengan remember me, dan POST logout berproteksi CSRF.
  - Seeder akun pengembang bawaan dengan kredensial aman untuk lokal.
- **Modul CRUD Tables Dinamis (`/tables`):**
  - Entitas data demo lengkap (`name`, `description`, `status`, `timestamps`).
  - **Pencarian:** Real-time search berdasarkan nama data.
  - **Filter Status:** Filter cepat untuk status `active`, `inactive`, atau semua.
  - **Pengurutan Aman:** Allowlist sorting untuk kolom `name`, `status`, dan `created_at` (`asc`/`desc`).
  - **Paginasi Server-Side:** Pilihan baris `10`, `25`, `50` dengan mempertahankan query filter/pencarian URL.
  - **Empty State:** Tampilan ramah ketika tidak ada data atau hasil pencarian nihil.
  - **Dialog Konfirmasi Hapus:** Modal konfirmasi sebelum menghapus record.
- **Modul CRUD Users Dinamis (`/users`):**
  - Manajemen pengguna menggunakan model bawaan `App\Models\User`.
  - Hashing password otomatis via `Hash::make`.
  - Password bersifat opsional saat proses edit (tidak ditimpa jika dikosongkan).
  - Validasi email unik yang aman saat pembaruan data.
  - **Proteksi Akun:**
    1. Pengguna dilarang menghapus akun dirinya sendiri.
    2. Sistem mencegah penghapusan jika hanya tersisa satu pengguna/admin terakhir.
- **Sistem Toast Notifikasi Sudut Kanan Atas:**
  - Posisi tetap di sudut kanan atas viewport (`fixed top-5 right-5 z-50`).
  - Berbasis pola *Post/Redirect/Get* via flash session (`session('success')` atau `session('error')`).
  - Auto-dismiss otomatis dalam ~4.5 detik dan tombol tutup manual (X).
  - Ramah aksesibilitas dengan atribut `role="status"` dan `aria-live="polite"`.
- **Pengujian Otomatis (Automated Feature Tests):**
  - 32 pengujian fitur dengan 105 asersi mencakup autentikasi, proteksi route, CRUD, paginasi, pengurutan, validasi, dan proteksi akun.

---

## 🛠️ Persyaratan Lingkungan (Prerequisites)

- **PHP:** Versi 8.3 atau lebih tinggi (ekstensi: `pdo_sqlite` atau `pdo_mysql`, `mbstring`, `openssl`).
- **Composer:** Versi 2.x
- **Node.js:** Versi 18+ atau 22+
- **NPM:** Versi 9+ atau 11+
- **Database:** SQLite (default lokal) atau MySQL/MariaDB.

---

## 🚀 Panduan Instalasi Cepat

### 1. Salin Environment
```bash
cp .env.example .env
```

### 2. Pasang Dependensi PHP
```bash
composer install
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Konfigurasi Basis Data & Migrasi
Secara default, starter kit telah terkonfigurasi dengan **SQLite** untuk kemudahan pengembangan langsung:

```bash
php artisan migrate --seed
```

> **Catatan MySQL (Opsional):** Jika Anda menggunakan Laragon atau server MySQL lokal, sesuaikan `.env`:
> ```env
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=flux_starter
> DB_USERNAME=root
> DB_PASSWORD=
> ```

### 5. Pasang & Kompilasi Asset Frontend (Tailwind CSS v4 & Vite)
```bash
npm install
npm run build
```

---

## 🔑 Kredensial Default Development

Setelah menjalankan `php artisan db:seed`, akun berikut siap digunakan:

| Peran | Alamat Email | Kata Sandi |
| :--- | :--- | :--- |
| **Administrator** | `admin@example.com` | `password` |

Selain akun administrator utama, seeder juga menyiapkan **5 akun pengguna demo** dan **15 data tables** untuk demonstrasi tabel dinamis.

---

## 💻 Menjalankan Server Pengembangan

Jalankan perintah berikut pada dua terminal terpisah:

**Terminal 1 (Backend Server):**
```bash
php artisan serve
```

**Terminal 2 (Vite Hot Module Reloading):**
```bash
npm run dev
```

Buka peramban (browser) dan akses: [http://localhost:8000](http://localhost:8000).

---

## 🧪 Menjalankan Pengujian (Automated Tests)

Semua fungsionalitas diuji secara komprehensif menggunakan PHPUnit:

```bash
php artisan test
```

Untuk melihat detail pengujian per fitur:
```bash
php artisan test --testdox
```

Hasil pengujian mencakup:
- Proteksi route guest vs terautentikasi (AuthTest)
- Login, session regeneration, dan CSRF-protected logout
- Filter status, pencarian nama, dan allowlist sort (TableTest)
- Validasi input form request create/update table & user
- Hashing password dan keamanan email unik (UserTest)
- Proteksi pencegahan hapus akun sendiri & admin terakhir

---

## 📁 Struktur Direktori & Kode

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php          # Login, authenticate, logout
│   │   ├── DashboardController.php     # Ringkasan analitik dan aktivitas
│   │   ├── TableController.php         # CRUD Tables dengan dynamic query
│   │   └── UserController.php          # CRUD Users dengan security guards
│   └── Requests/
│       ├── StoreTableRequest.php       # Validasi penambahan data tabel
│       ├── UpdateTableRequest.php      # Validasi pengubahan data tabel
│       ├── StoreUserRequest.php        # Validasi pembuatan pengguna
│       └── UpdateUserRequest.php       # Validasi pembaruan pengguna
├── Models/
│   ├── Table.php                       # Model demo data
│   └── User.php                        # Model akun pengguna
└── View/
    └── Components/
        ├── AppLayout.php               # Komponen layout utama dashboard
        └── GuestLayout.php             # Komponen layout halaman auth

resources/
├── css/
│   └── app.css                         # Tailwind CSS v4 setup & custom typography
├── js/
│   └── app.js                          # Drawer mobile, dialog modal, toast dismiss
└── views/
    ├── layouts/
    │   ├── app.blade.php               # Shell dashboard Flux-inspired
    │   └── guest.blade.php             # Shell halaman tamu / login
    ├── components/
    │   ├── sidebar.blade.php           # Desktop sidebar & mobile drawer
    │   ├── topbar.blade.php            # Breadcrumb & dropdown profil
    │   ├── toast-container.blade.php   # Notifikasi toast sudut kanan atas
    │   └── confirm-dialog.blade.php    # Dialog modal konfirmasi tindakan
    ├── auth/
    │   └── login.blade.php             # Form login elegan
    ├── dashboard.blade.php             # Tampilan overview dashboard
    ├── tables/
    │   ├── index.blade.php             # Dynamic data table
    │   ├── create.blade.php            # Form create table
    │   └── edit.blade.php              # Form edit table
    └── users/
        ├── index.blade.php             # Dynamic user table
        ├── create.blade.php            # Form create user
        └── edit.blade.php              # Form edit user

routes/
└── web.php                             # Named routes rapi & terstruktur
```

---

## 📜 Lisensi

Starter kit ini dilisensikan di bawah [MIT License](LICENSE).
