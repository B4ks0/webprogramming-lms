# Webprograming LMS

Aplikasi Learning Management System berbasis PHP untuk pengelolaan mata kuliah, dosen, mahasiswa, materi, tugas, absensi, jadwal, dan kategori.

## Fitur

### Admin
- Dashboard dengan 8 statistik (Total Users, Mahasiswa, Dosen, Enrollments, Courses, Published, Draft, Lessons)
- CRUD **Users** (admin, dosen, mahasiswa)
- CRUD **Courses** (mata kuliah)
- CRUD **Lessons** (materi per mata kuliah)
- CRUD **Enrollments** (daftarkan mahasiswa ke mata kuliah)
- CRUD **Categories** (kategori mata kuliah)
- CRUD **Ruang Kelas** (data kelas dengan kode dan kapasitas)
- CRUD **Jadwal** (jadwal per course, kelas, hari, jam, ruangan)
- CRUD **Absensi** (kehadiran mahasiswa per course & jadwal, filter by mahasiswa/course)
- Kelola tugas: buat, edit, hapus, cek submission mahasiswa
- Beri nilai dan feedback submission mahasiswa

### Dosen
- Dashboard ringkasan mata kuliah yang diampu
- Kelola mata kuliah, materi, tugas, peserta, jadwal, dan absensi

### Mahasiswa
- Dashboard status belajar dan nilai akhir
- Lihat dan download materi
- Upload submission tugas
- Lihat nilai dan feedback dosen

## Akun Demo

```
Admin      : admin@example.com    / admin123
Dosen 1    : dosen@example.com    / dosen123
Dosen 2    : sari@example.com     / dosen123
Dosen 3    : hendra@example.com   / dosen123
Dosen 4    : maya@example.com     / dosen123
Mahasiswa 1: mahasiswa@example.com / mahasiswa123
Mahasiswa 2: budi@example.com     / mahasiswa123
Mahasiswa 3: citra@example.com    / mahasiswa123
Mahasiswa 4: dian@example.com     / mahasiswa123
Mahasiswa 5: eko@example.com      / mahasiswa123
Mahasiswa 6: fina@example.com     / mahasiswa123
```

## Struktur Folder

```
admin/          Halaman admin (dashboard, CRUD semua fitur)
guru/           Dashboard dosen
siswa/          Dashboard mahasiswa
module/         Modul materi, tugas, peserta, submission
koneksi/        Konfigurasi koneksi database (MySQL/SQLite)
database/       File SQL dump dan schema
  db_webprogramming.sql   Dump MySQL lengkap + dummy data
  schema_sqlite.sql       Schema SQLite
scripts/
  seed_data.sql           Script seed data dummy
  init_sqlite.php         Generator database SQLite
uploads/        Folder upload materi, tugas, submission
assets/         CSS, JS, vendor (Bootstrap, FontAwesome)
```

## Kebutuhan

- PHP 8.0 atau lebih baru
- Ekstensi PHP: `pdo`, `pdo_mysql` (untuk MySQL) atau `pdo_sqlite` (untuk SQLite)
- Laragon (rekomendasi) atau web server PHP lain
- MySQL 8 jika menggunakan mode MySQL

Cek ekstensi:
```powershell
php -m
```

---

## Setup dengan Laragon + MySQL (Rekomendasi)

### 1. Clone repo ke folder Laragon

```powershell
cd C:\laragon\www
git clone https://github.com/B4ks0/webprogramming-lms.git webprogramming
```

Atau jika sudah ada foldernya:
```powershell
cd C:\laragon\www\webprogramming\webprogramming
git pull origin main
```

### 2. Buat database

```powershell
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -uroot -e "CREATE DATABASE IF NOT EXISTS db_webprogramming CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

> Sesuaikan path MySQL jika versi berbeda. Cek folder di `C:\laragon\bin\mysql\`.

### 3. Import database (schema + dummy data)

```powershell
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -uroot db_webprogramming < database\db_webprogramming.sql
```

### 4. Akses website

Pastikan Laragon Apache sudah aktif, lalu buka:

```
http://localhost/webprogramming/webprogramming/
```

Atau jika ingin jalankan manual dengan PHP built-in server:

```powershell
php -S 127.0.0.1:8002
```
Buka: `http://127.0.0.1:8002`

---

## Setup dengan SQLite (tanpa MySQL)

Gunakan ini jika tidak ingin mengaktifkan MySQL.

### 1. Generate database SQLite

```powershell
cd C:\laragon\www\webprogramming\webprogramming
php scripts\init_sqlite.php
```

### 2. Jalankan dalam mode SQLite

PowerShell:
```powershell
$env:APP_DB="sqlite"
php -S 127.0.0.1:8002
```

Command Prompt:
```cmd
set APP_DB=sqlite
php -S 127.0.0.1:8002
```

Buka: `http://127.0.0.1:8002`

---

## Konfigurasi Database

File: `koneksi/koneksi.php`

Default MySQL (tanpa env variable):
```
Host : localhost
User : root
Pass : (kosong)
DB   : db_webprogramming
```

Override via environment variable:
```powershell
$env:DB_HOST="localhost"
$env:DB_USER="root"
$env:DB_PASS=""
$env:DB_NAME="db_webprogramming"
php -S 127.0.0.1:8002
```

---

## Cara Pakai

### Admin
1. Login → `admin@example.com / admin123`
2. **Users** — tambah/edit/hapus dosen dan mahasiswa
3. **Categories** — buat kategori mata kuliah
4. **Courses** — tambah mata kuliah, assign ke dosen dan kategori
5. **Lessons** — upload materi per mata kuliah
6. **Enrollments** — daftarkan mahasiswa ke mata kuliah
7. **Ruang Kelas** — kelola data kelas
8. **Jadwal** — buat jadwal: course + kelas + hari + jam + ruangan
9. **Absensi** — catat kehadiran mahasiswa, filter by course atau mahasiswa

### Dosen
1. Login → `dosen@example.com / dosen123`
2. Kelola mata kuliah yang diampu
3. Buat dan kelola materi, tugas, jadwal, dan absensi

### Mahasiswa
1. Login → `mahasiswa@example.com / mahasiswa123`
2. Lihat mata kuliah yang sudah dienrollkan
3. Download materi, upload jawaban tugas
4. Cek nilai dan feedback dosen

---

## Troubleshooting

### Port sudah dipakai
```powershell
php -S 127.0.0.1:8003
```

### MySQL tidak aktif
Gunakan SQLite:
```powershell
php scripts\init_sqlite.php
$env:APP_DB="sqlite"
php -S 127.0.0.1:8002
```

### Error `could not find driver`
Ekstensi PDO belum aktif. Cek dengan `php -m` dan pastikan ada `PDO`, `pdo_mysql`, atau `pdo_sqlite`.

### Reset database MySQL
```powershell
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -uroot -e "DROP DATABASE IF EXISTS db_webprogramming; CREATE DATABASE db_webprogramming CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -uroot db_webprogramming < database\db_webprogramming.sql
```

### Reset database SQLite
```powershell
Remove-Item database\database.sqlite
php scripts\init_sqlite.php
```

---

## Repository

```
https://github.com/B4ks0/webprogramming-lms
```
