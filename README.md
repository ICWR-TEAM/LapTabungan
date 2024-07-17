# Aplikasi Laporan Tabungan Pribadi

Aplikasi ini dibangun dengan menggunakan Laravel dan bertujuan untuk menyediakan sistem laporan tabungan pribadi di mana pengguna dapat melacak tabungan dan penarikan mereka.

## Fitur-fitur

- **Autentikasi Pengguna**: Sistem autentikasi pengguna yang aman dan registrasi.
- **Dasbor**: Ikhtisar transaksi tabungan.
- **Manajemen Transaksi**: Menambahkan dan menghapus transaksi tabungan.
- **Desain Responsif**: Antarmuka yang ramah mobile untuk akses mudah di berbagai perangkat.

## Teknologi yang Digunakan

- **Laravel**: Framework PHP untuk pengembangan backend.
- **MySQL**: Sistem manajemen basis data untuk menyimpan data transaksional.
- **Bootstrap**: Framework frontend untuk desain responsif.

## Instalasi

   ```bash

    git clone https://github.com/username/LapTabungan.git
    cd LapTabungan
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
    php artisan serve

   ```

## Kontribusi
Kami menyambut kontribusi dari komunitas! Silakan fork repository ini, lakukan perubahan, dan buat pull request untuk perbaikan atau fitur baru.

## License

Proyek ini dilisensikan di bawah [MIT License](LICENSE).


