# PRD.md --- Laravel Dashboard Starter Kit (Flux-Inspired UI)

## 1. Ringkasan Proyek

**Nama proyek:** Laravel Dashboard Starter Kit\
**Jenis:** Reusable dashboard starter template\
**Tujuan:** Menyediakan fondasi dashboard admin yang ringan, rapi,
responsif, mudah dikembangkan, dan dapat digunakan kembali untuk
berbagai aplikasi Laravel.

Starter kit ini menggunakan Laravel versi stabil terbaru yang ditetapkan
pada saat proyek dibuat, Blade sebagai server-rendered view, dan
antarmuka bergaya Flux UI. Proyek wajib dibuat melalui
`composer create-project`, bukan `laravel new`, dan tidak menggunakan
Laravel Official Starter Kit.

> **Batasan teknis penting:** Flux UI resmi dirancang untuk Livewire.
> Karena proyek ini melarang Livewire, jangan mengandalkan komponen Flux
> yang memerlukan Livewire. Implementasikan komponen Blade biasa dengan
> tampilan yang terinspirasi Flux, Tailwind CSS, dan JavaScript ringan.
> Jangan memasang `livewire/livewire` atau membuat dependensi terhadap
> Livewire.

## 2. Tujuan dan Sasaran

-   Menjadi starter kit dashboard yang dapat disalin atau dijadikan
    dasar proyek baru.
-   Menyediakan layout dashboard dengan sidebar, topbar, konten utama,
    breadcrumb, dan area notifikasi.
-   Menyediakan dua modul CRUD dasar: **Tables** dan **Users**.
-   Menyediakan tabel data yang dinamis: pencarian, pengurutan,
    pagination, dan pilihan jumlah baris.
-   Menyediakan toast notifikasi di sudut kanan atas untuk operasi CRUD
    yang berhasil.
-   Memakai struktur kode Laravel yang mudah dipelihara dan mengikuti
    konvensi framework.
-   Tidak menggunakan Livewire, Inertia, Vue, React, Laravel Official
    Starter Kit, atau SPA framework.

## 3. Di Luar Cakupan

-   Tidak membuat sistem multi-tenant.
-   Tidak membuat REST API publik.
-   Tidak membuat role/permission kompleks.
-   Tidak membuat real-time update melalui WebSocket.
-   Tidak menggunakan Flux Pro atau fitur yang membutuhkan lisensi Flux.
-   Tidak membangun modul bisnis lain di luar Tables dan Users.
-   Tidak membuat dashboard analitik kompleks.

## 4. Teknologi

  -----------------------------------------------------------------------
  Area                                Pilihan
  ----------------------------------- -----------------------------------
  Framework                           Laravel 13 atau versi stabil
                                      terbaru saat implementasi

  PHP                                 PHP 8.3+ sesuai persyaratan versi
                                      Laravel yang dipilih

  Backend                             PHP, Laravel MVC

  View                                Blade

  Styling                             Tailwind CSS v4

  UI approach                         Komponen Blade custom, tampilan
                                      terinspirasi Flux UI

  Interaktivitas                      JavaScript ringan / Alpine.js
                                      opsional

  Database                            MySQL/MariaDB; SQLite diperbolehkan
                                      untuk pengembangan lokal

  Build assets                        Vite

  Authentication                      Implementasi auth sederhana buatan
                                      proyek; jangan pasang starter kit
                                      resmi

  Testing                             PHPUnit atau Pest sesuai setup
                                      proyek
  -----------------------------------------------------------------------

### 4.1 Ketentuan kompatibilitas Flux UI

Dokumentasi Flux UI resmi mensyaratkan Livewire. Karena Livewire
dilarang dalam proyek ini:

1.  Jangan memasang `livewire/livewire`.
2.  Jangan memasang `livewire/flux` sebagai fondasi komponen interaktif
    proyek.
3.  Jangan menggunakan tag Blade Flux yang bergantung pada lifecycle
    Livewire.
4.  Buat komponen Blade biasa untuk button, input, select, badge,
    dropdown, dialog konfirmasi, dan pagination.
5.  Gunakan Tailwind CSS untuk mereplikasi bahasa visual Flux: bersih,
    minimal, border halus, radius konsisten, fokus aksesibel, dan
    spacing yang teratur.
6.  Dokumentasikan bahwa UI merupakan **Flux-inspired**, bukan integrasi
    Flux UI resmi.

Jika pemilik proyek mengubah syarat dan mengizinkan Livewire, penggunaan
paket Flux UI resmi dapat dievaluasi sebagai opsi terpisah.

## 5. Instalasi Proyek

### 5.1 Buat proyek melalui Composer

Gunakan perintah berikut:

``` bash
composer create-project laravel/laravel dashboard-starter
cd dashboard-starter
```

Perintah tersebut mengambil rilis stabil yang tersedia dari paket
`laravel/laravel` ketika dijalankan. Pastikan versi Laravel dan
persyaratan PHP diverifikasi setelah instalasi:

``` bash
php artisan --version
php -v
composer show laravel/framework
```

### 5.2 Konfigurasi awal

``` bash
cp .env.example .env
php artisan key:generate
```

Atur kredensial database di `.env`, lalu jalankan:

``` bash
php artisan migrate
npm install
npm run build
composer run dev
```

Jika skrip `composer run dev` tidak tersedia pada skeleton yang
digunakan, jalankan server dan Vite secara terpisah:

``` bash
php artisan serve
npm run dev
```

Jangan menjalankan `laravel new`, jangan memilih starter kit resmi, dan
jangan memasang Livewire.

## 6. Arsitektur dan Struktur Kode

Gunakan pola MVC standar Laravel.

Contoh struktur:

``` text
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── TableController.php
│   │   └── UserController.php
│   └── Requests/
│       ├── StoreTableRequest.php
│       ├── UpdateTableRequest.php
│       ├── StoreUserRequest.php
│       └── UpdateUserRequest.php
├── Models/
│   ├── Table.php
│   └── User.php
resources/
├── css/app.css
├── js/app.js
└── views/
    ├── layouts/app.blade.php
    ├── components/
    │   ├── sidebar.blade.php
    │   ├── topbar.blade.php
    │   ├── toast-container.blade.php
    │   ├── confirm-dialog.blade.php
    │   └── data-table/
    ├── dashboard.blade.php
    ├── tables/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── users/
        ├── index.blade.php
        ├── create.blade.php
        └── edit.blade.php
routes/
└── web.php
```

Struktur di atas adalah acuan; model `Table` harus dimaknai sebagai
entitas data demo yang benar-benar memiliki tabel database, bukan
sebagai definisi struktur tabel database secara dinamis.

### 6.1 Konvensi implementasi

-   Gunakan named routes dan route model binding jika sesuai.
-   Gunakan Form Request untuk validasi create/update.
-   Gunakan Eloquent ORM dan mass-assignment protection (`$fillable`
    atau pendekatan yang sesuai).
-   Gunakan Blade layouts dan partials agar UI tidak diduplikasi.
-   Pisahkan query/filter tabel dari markup view bila logikanya mulai
    kompleks.
-   Jangan menambahkan abstraksi berlebihan untuk starter kit sekecil
    ini.
-   Jangan menggunakan raw SQL yang dirangkai dari input pengguna.
-   Jangan menampilkan stack trace atau detail exception kepada
    pengguna.

## 7. Layout Dashboard

### 7.1 Sidebar

Sidebar desktop menampilkan:

-   Identitas/logo aplikasi.
-   Dashboard.
-   Tables.
-   Users.
-   Area profil dan logout di bagian bawah.

Ketentuan:

-   Item aktif terlihat jelas.
-   Ikon konsisten, sederhana, dan tidak dekoratif berlebihan.
-   Sidebar dapat berubah menjadi drawer pada layar kecil.
-   Navigasi tetap dapat digunakan dengan keyboard.

### 7.2 Topbar

Topbar menampilkan:

-   Tombol membuka sidebar pada layar kecil.
-   Breadcrumb atau judul halaman.
-   Informasi pengguna yang sedang login.
-   Dropdown profil dengan aksi logout.
-   Dukungan dark mode boleh disediakan jika diterapkan konsisten.

### 7.3 Konten utama

-   Judul dan deskripsi singkat halaman.
-   Breadcrumb.
-   Tombol aksi utama di posisi yang konsisten.
-   Card/panel dengan border halus.
-   Tampilan kosong ketika belum ada data.
-   Indikator validasi yang jelas.
-   Layout responsif tanpa horizontal overflow yang tidak diperlukan.

### 7.4 Prinsip visual

-   Bersih, minimal, profesional, dan konsisten.
-   Gunakan palet netral dengan satu warna aksen.
-   Hindari gradient yang berlebihan, efek 3D, dan animasi yang tidak
    perlu.
-   Gunakan tipografi yang mudah dibaca.
-   Fokus keyboard dan state hover/focus/disabled harus jelas.
-   Animasi kecil hanya untuk membantu feedback, bukan menghambat
    interaksi.

## 8. Modul Dashboard

### 8.1 Dashboard Home

Route: `/dashboard`

Tampilkan ringkasan sederhana:

-   Total data Tables.
-   Total Users.
-   Pengguna yang dibuat terbaru, jika mudah ditampilkan.
-   Shortcut menuju halaman Tables dan Users.

Nilai ringkasan harus berasal dari database, bukan angka hard-coded.

## 9. Modul Tables

Route dasar: `/tables`

Modul ini adalah CRUD untuk **data demo**. Tentukan skema sederhana,
misalnya:

-   `id`
-   `name` --- wajib, maksimal 150 karakter
-   `description` --- opsional
-   `status` --- `active` atau `inactive`
-   `created_at`
-   `updated_at`

Buat migration, model, controller, request validation, routes, dan Blade
views yang dibutuhkan.

### 9.1 Daftar data dan fungsi tabel dinamis

Halaman daftar harus memiliki:

1.  **Search**: pencarian berdasarkan nama; gunakan query parameter agar
    state dapat dibagikan melalui URL.
2.  **Sorting**: minimal berdasarkan nama, status, dan tanggal dibuat;
    validasi kolom sorting dengan allowlist.
3.  **Pagination**: gunakan Laravel paginator di server, bukan memuat
    semua data sekaligus.
4.  **Page size**: pilihan jumlah baris, misalnya 10, 25, atau 50,
    dengan nilai default 10 dan batas yang tervalidasi.
5.  **Filter status**: semua, aktif, atau nonaktif.
6.  **Empty state**: pesan dan tombol untuk membuat data pertama.
7.  **Row actions**: detail opsional, edit, dan hapus.
8.  **Preserve query**: filter dan pencarian dipertahankan saat
    berpindah halaman.
9.  **Responsive behavior**: tabel dapat digunakan pada layar sempit.
10. **Accessible controls**: input memiliki label, tombol memiliki nama
    yang jelas, dan state fokus terlihat.

Semua filter dan sorting harus dilakukan dengan query yang aman. Jangan
menyusun nama kolom SQL langsung dari input pengguna.

### 9.2 Create

-   Form nama, deskripsi, dan status.
-   Validasi sisi server.
-   Tampilkan pesan validasi dekat field terkait.
-   Jika berhasil, simpan data lalu redirect ke daftar atau halaman
    detail.
-   Kirim flash message untuk toast sukses.

### 9.3 Read

-   Tampilkan data pada halaman daftar.
-   Halaman detail boleh disediakan jika diperlukan, tetapi tidak wajib
    untuk MVP.

### 9.4 Update

-   Form terisi dengan data yang sudah ada.
-   Validasi yang sama dengan create.
-   Jika berhasil, simpan perubahan dan tampilkan toast sukses.

### 9.5 Delete

-   Aksi hapus meminta konfirmasi melalui dialog ringan.
-   Penghapusan menggunakan metode HTTP `DELETE` dengan CSRF protection.
-   Jika berhasil, redirect kembali ke daftar dan tampilkan toast
    sukses.
-   Jika record sudah tidak ada, tampilkan respons yang sesuai tanpa
    error mentah.

## 10. Modul Users

Route dasar: `/users`

Gunakan model `App\Models\User` bawaan Laravel jika memungkinkan.
Hindari membuat tabel pengguna kedua yang duplikatif.

Field minimum:

-   `id`
-   `name`
-   `email`
-   `password` (hanya untuk proses create/update; tidak pernah
    ditampilkan)
-   `created_at`
-   `updated_at`

### 10.1 Daftar Users

Sediakan fitur dinamis yang konsisten dengan modul Tables:

-   Search nama dan email.
-   Sorting nama, email, dan tanggal dibuat.
-   Pagination server-side.
-   Pilihan jumlah baris 10, 25, atau 50.
-   Empty state.
-   Aksi edit dan hapus.
-   Pertahankan filter saat berpindah halaman.

### 10.2 Create User

-   Field nama, email, password, dan konfirmasi password.
-   Email harus valid dan unik.
-   Password divalidasi berdasarkan kebijakan keamanan aplikasi.
-   Password wajib di-hash menggunakan mekanisme Laravel, misalnya
    `Hash::make`.
-   Jangan pernah menampilkan password kembali setelah disimpan.
-   Setelah berhasil, tampilkan toast sukses.

### 10.3 Edit User

-   Field nama dan email dapat diubah.
-   Password opsional saat edit; jika kosong, password lama tidak
    berubah.
-   Email unik kecuali untuk user yang sedang diedit.
-   Jangan mengirim atau menampilkan hash password di view.
-   Setelah berhasil, tampilkan toast sukses.

### 10.4 Delete User dan perlindungan akun

-   Tampilkan dialog konfirmasi.
-   User tidak boleh menghapus akun dirinya sendiri dari halaman ini.
-   Jika sistem hanya memiliki satu akun admin, cegah penghapusan akun
    admin terakhir agar akses tidak terkunci.
-   Jika berhasil, tampilkan toast sukses.

### 10.5 Authentication dan authorization

Karena starter kit resmi dan Livewire dilarang, sediakan autentikasi
minimal menggunakan fitur inti Laravel (session-based authentication),
controller, form Blade, CSRF protection, dan middleware `auth`.

-   Halaman dashboard, Tables, dan Users hanya dapat diakses pengguna
    terautentikasi.
-   Sediakan login dan logout.
-   Logout harus menggunakan POST dengan CSRF protection.
-   Jangan membuat registrasi publik secara default.
-   Sediakan cara aman membuat admin awal melalui seeder atau perintah
    lokal yang terdokumentasi; jangan menanam password produksi dalam
    source code.
-   Semua route mutasi harus dilindungi middleware autentikasi dan
    validasi.
-   Jika role/permission tidak masuk MVP, dokumentasikan bahwa semua
    pengguna terautentikasi memiliki akses yang sama; jangan mengklaim
    ada RBAC.

## 11. Toast Notification

Toast merupakan fitur wajib untuk setiap operasi CRUD yang berhasil.

### 11.1 Posisi dan tampilan

-   Posisi: sudut kanan atas viewport.
-   Pada desktop: beri jarak yang cukup dari tepi layar dan topbar.
-   Pada mobile: toast tetap masuk ke viewport dan tidak menutupi
    seluruh konten.
-   Gunakan `position: fixed` dengan `z-index` yang sesuai.
-   Toast tidak boleh menggeser layout halaman.
-   Gunakan ikon sederhana dan teks singkat.
-   Sediakan tombol tutup yang aksesibel.

### 11.2 Jenis toast

-   Success: operasi berhasil.
-   Error: operasi gagal, bila diperlukan untuk feedback non-sensitif.
-   Warning/info: opsional.

Contoh pesan:

-   `Data berhasil ditambahkan.`
-   `Data berhasil diperbarui.`
-   `Data berhasil dihapus.`
-   `Pengguna berhasil ditambahkan.`
-   `Pengguna berhasil diperbarui.`
-   `Pengguna berhasil dihapus.`

### 11.3 Mekanisme implementasi tanpa Livewire

Gunakan pola **Post/Redirect/Get**:

1.  Controller memvalidasi dan menjalankan operasi.
2.  Setelah sukses, controller redirect dengan flash session, misalnya
    `->with('success', 'Data berhasil ditambahkan.')`.
3.  Layout Blade membaca flash message tersebut.
4.  JavaScript ringan menampilkan toast di sudut kanan atas.
5.  Toast hilang otomatis setelah sekitar 4--5 detik dan dapat ditutup
    manual.

Toast harus dipicu oleh hasil operasi server, bukan hanya karena tombol
ditekan. Jangan menampilkan toast sukses jika validasi atau penyimpanan
gagal. Hindari menyisipkan teks flash mentah ke JavaScript; gunakan
escaping yang aman atau serialisasi JSON yang tepat. Pastikan toast
tidak mengumumkan informasi sensitif dan dapat dibaca screen reader
melalui `role="status"` atau `aria-live`.

## 12. Routes

Gunakan nama route yang konsisten. Contoh konsep:

  Method      URI                      Nama route         Fungsi
  ----------- ------------------------ ------------------ -----------------
  GET         `/login`                 `login`            Form login
  POST        `/login`                 `login.store`      Memproses login
  POST        `/logout`                `logout`           Logout
  GET         `/dashboard`             `dashboard`        Ringkasan
  GET         `/tables`                `tables.index`     Daftar data
  GET         `/tables/create`         `tables.create`    Form create
  POST        `/tables`                `tables.store`     Simpan data
  GET         `/tables/{table}/edit`   `tables.edit`      Form edit
  PUT/PATCH   `/tables/{table}`        `tables.update`    Update data
  DELETE      `/tables/{table}`        `tables.destroy`   Hapus data
  GET         `/users`                 `users.index`      Daftar pengguna
  GET         `/users/create`          `users.create`     Form create
  POST        `/users`                 `users.store`      Simpan pengguna
  GET         `/users/{user}/edit`     `users.edit`       Form edit
  PUT/PATCH   `/users/{user}`          `users.update`     Update pengguna
  DELETE      `/users/{user}`          `users.destroy`    Hapus pengguna

Semua route dashboard dan CRUD harus berada di balik middleware `auth`.
Gunakan resource routes jika sesuai, dengan pengecualian untuk aksi yang
memang tidak disediakan.

## 13. Keamanan dan Validasi

-   Semua form mutasi memakai CSRF protection.
-   Validasi dilakukan di server melalui Form Request atau validasi
    controller yang terstruktur.
-   Gunakan Eloquent/query builder dengan parameter binding.
-   Validasi kolom sort dan arah sort dengan allowlist.
-   Password harus di-hash.
-   Lindungi route melalui middleware.
-   Gunakan escaping Blade `{{ }}` untuk output teks.
-   Hindari menampilkan exception, SQL, credential, dan detail internal
    kepada pengguna.
-   Terapkan pagination untuk membatasi data yang diambil.
-   Terapkan unique validation untuk email.
-   Jangan menghapus akun yang sedang login atau admin terakhir.
-   Jangan commit `.env`, secret, atau credential Flux Pro jika suatu
    saat dipakai dalam proyek lain.
-   Sediakan penanganan error dan log server yang layak.

## 14. Testing dan Kriteria Penerimaan

### 14.1 Instalasi dan arsitektur

-   [ ] Proyek dibuat dengan `composer create-project laravel/laravel`.
-   [ ] Tidak menggunakan `laravel new`.
-   [ ] Tidak memasang Laravel Official Starter Kit.
-   [ ] Tidak ada dependency Livewire.
-   [ ] View menggunakan Blade.
-   [ ] Asset berhasil dibangun melalui Vite.
-   [ ] Aplikasi berjalan pada versi PHP dan Laravel yang didukung.

### 14.2 Dashboard dan navigasi

-   [ ] Sidebar dan topbar konsisten pada semua halaman.
-   [ ] Navigasi aktif sesuai route.
-   [ ] Layout responsif.
-   [ ] Halaman dashboard hanya dapat diakses setelah login.
-   [ ] Logout mengakhiri sesi dengan benar.

### 14.3 Tables CRUD

-   [ ] Data dapat dibuat, dilihat, diperbarui, dan dihapus.
-   [ ] Validasi field berjalan.
-   [ ] Search, sorting, filter status, dan pagination berfungsi.
-   [ ] Page size tervalidasi.
-   [ ] Filter/query tetap ada saat pagination.
-   [ ] Konfirmasi tampil sebelum penghapusan.
-   [ ] Toast sukses tampil di sudut kanan atas setelah create, update,
    dan delete berhasil.
-   [ ] Tidak ada toast sukses palsu saat operasi gagal.

### 14.4 Users CRUD

-   [ ] User dapat dibuat, dilihat, diperbarui, dan dihapus sesuai
    aturan.
-   [ ] Email harus unik.
-   [ ] Password di-hash dan tidak pernah ditampilkan.
-   [ ] Search, sorting, dan pagination berfungsi.
-   [ ] User tidak dapat menghapus dirinya sendiri.
-   [ ] Penghapusan admin terakhir dicegah jika aturan tersebut berlaku.
-   [ ] Toast sukses muncul pada operasi yang berhasil.

### 14.5 Kualitas

-   [ ] Tidak ada error runtime atau route yang tidak berfungsi.
-   [ ] Tampilan empty state, validation error, dan flash toast
    tersedia.
-   [ ] Kontrol utama dapat digunakan melalui keyboard.
-   [ ] Automated feature tests mencakup akses tanpa login, validasi,
    CRUD, dan perlindungan user.
-   [ ] README berisi instruksi instalasi, setup database, build asset,
    testing, dan akun awal untuk development.

## 15. Tahapan Pengerjaan

1.  **Bootstrap:** buat proyek Composer, konfigurasi environment,
    database, dan Vite.
2.  **Foundation UI:** layout Blade, sidebar, topbar, komponen form,
    tombol, badge, dialog, dan toast.
3.  **Authentication:** login, logout, middleware, serta cara aman
    membuat akun admin development.
4.  **Tables CRUD:** migration, model, validation, routes, controller,
    dynamic table, dan toast.
5.  **Users CRUD:** validasi unik, password hashing, aturan proteksi
    akun, dynamic table, dan toast.
6.  **Testing:** feature tests, pemeriksaan responsif, aksesibilitas,
    dan skenario gagal.
7.  **Documentation:** README dan checklist penggunaan ulang.

## 16. Definition of Done

Starter kit dianggap selesai apabila dapat diinstal dari awal mengikuti
README, berjalan tanpa Livewire dan tanpa Laravel Official Starter Kit,
memiliki dashboard responsif, kedua modul CRUD berfungsi dengan tabel
dinamis, autentikasi dan validasi aman, serta toast di sudut kanan atas
muncul hanya setelah operasi CRUD berhasil.

## 17. Referensi Resmi

-   Flux UI Installation: https://fluxui.dev/docs/installation
-   Laravel Releases:
    https://github.com/laravel/docs/blob/13.x/releases.md
-   Laravel Application Skeleton di Packagist:
    https://packagist.org/packages/laravel/laravel?type=composer

**Catatan implementasi:** Periksa kembali dokumentasi dan kompatibilitas
dependency pada hari implementasi. "Versi terbaru" berarti rilis stabil
terbaru yang tersedia dan kompatibel, bukan versi prerelease.
