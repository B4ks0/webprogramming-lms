# Webprograming LMS

Webprograming LMS adalah aplikasi Learning Management System sederhana berbasis PHP untuk pengelolaan mata kuliah, dosen, mahasiswa, materi, tugas, submission tugas, nilai, dan status belajar.

## Fitur

- Login berbasis role: `admin`, `dosen`, `mahasiswa`
- Admin dapat CRUD user, dosen, mahasiswa, dan mata kuliah
- Dosen dapat membuat dan mengelola mata kuliah miliknya sendiri
- Admin/dosen dapat memasukkan mahasiswa ke mata kuliah
- Mahasiswa tidak bisa enroll sendiri
- Admin/dosen dapat menentukan status mahasiswa: aktif atau selesai
- Admin/dosen dapat memberi nilai akhir dan catatan dosen
- Admin/dosen dapat upload dan CRUD materi
- Mahasiswa dapat melihat/download materi dari mata kuliah yang sudah dienroll
- Admin/dosen dapat membuat tugas, upload file tugas, dan menentukan deadline
- Mahasiswa dapat melihat tugas dan upload submission
- Admin/dosen dapat cek submission, download jawaban, memberi nilai, dan feedback
- Mendukung database MySQL dan SQLite

## Akun Demo

```text
Admin      : admin@example.com / admin123
Dosen      : dosen@example.com / dosen123
Mahasiswa  : mahasiswa@example.com / mahasiswa123
```

## Struktur Penting

```text
admin/                 Halaman dan proses admin
guru/                  Dashboard dosen
siswa/                 Dashboard mahasiswa
module/                Modul materi, tugas, peserta, submission
koneksi/koneksi.php    Konfigurasi database MySQL/SQLite
admin/lms.sql          Schema dan seed MySQL
database/schema_sqlite.sql  Schema dan seed SQLite
scripts/init_sqlite.php     Generator database SQLite
uploads/               Folder upload materi, tugas, dan submission
```

## Kebutuhan

- PHP 8 atau lebih baru
- Ekstensi PHP:
  - `pdo`
  - `pdo_mysql` untuk MySQL
  - `pdo_sqlite` untuk SQLite
- Laragon atau server PHP lokal
- MySQL jika memakai mode MySQL

Cek ekstensi PHP:

```powershell
php -m
```

## Setup Dengan Laragon MySQL

Gunakan mode ini kalau Laragon dan MySQL aktif.

### 1. Clone repo

```powershell
cd C:\laragon\www
git clone https://github.com/B4ks0/webprogramming-lms.git
cd webprogramming-lms
```

Jika folder project sudah ada:

```powershell
cd C:\laragon\www\webprogramming\webprogramming
```

### 2. Buat database

Buka terminal dan jalankan:

```powershell
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -uroot -e "CREATE DATABASE IF NOT EXISTS db_webprogramming CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Jika path MySQL berbeda, sesuaikan dengan folder MySQL di Laragon.

### 3. Import schema

```powershell
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -uroot db_webprogramming < admin\lms.sql
```

### 4. Jalankan website

```powershell
php -S 127.0.0.1:8002
```

Buka:

```text
http://127.0.0.1:8002
```

## Setup Alternatif Dengan SQLite

Gunakan mode ini kalau Laragon MySQL tidak aktif atau kamu ingin menjalankan project tanpa MySQL.

### 1. Buat database SQLite

```powershell
cd C:\laragon\www\webprogramming\webprogramming
php scripts\init_sqlite.php
```

Perintah ini membuat file:

```text
database/database.sqlite
```

File SQLite ini tidak dipush ke GitHub karena masuk `.gitignore`.

### 2. Jalankan website dalam mode SQLite

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

Buka:

```text
http://127.0.0.1:8002
```

### 3. Kembali ke MySQL

Tutup server PHP, lalu jalankan tanpa `APP_DB=sqlite`:

```powershell
Remove-Item Env:\APP_DB
php -S 127.0.0.1:8002
```

Atau buka terminal baru dan langsung jalankan:

```powershell
php -S 127.0.0.1:8002
```

## Konfigurasi Database

File konfigurasi ada di:

```text
koneksi/koneksi.php
```

Default MySQL:

```text
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=db_webprogramming
```

Kamu bisa override lewat environment variable:

```powershell
$env:DB_HOST="localhost"
$env:DB_USER="root"
$env:DB_PASS=""
$env:DB_NAME="db_webprogramming"
php -S 127.0.0.1:8002
```

Untuk SQLite:

```powershell
$env:APP_DB="sqlite"
php -S 127.0.0.1:8002
```

## Cara Pakai Singkat

### Admin

1. Login sebagai admin.
2. Buka `Pengguna` untuk tambah/edit/hapus admin, dosen, dan mahasiswa.
3. Buka `Mata Kuliah` untuk tambah/edit/hapus mata kuliah.
4. Buka `Peserta MK` untuk memasukkan mahasiswa ke mata kuliah.
5. Buka `Materi` untuk upload atau kelola materi.
6. Buka `Tugas` untuk buat tugas, deadline, dan cek submission.

### Dosen

1. Login sebagai dosen.
2. Buat mata kuliah baru dari menu `Tambah MK`.
3. Buka `Peserta MK` untuk memasukkan mahasiswa ke mata kuliah miliknya.
4. Upload materi dari menu `Materi`.
5. Buat tugas dan deadline dari menu `Tugas`.
6. Cek submission mahasiswa, beri nilai, dan feedback.

### Mahasiswa

1. Login sebagai mahasiswa.
2. Mahasiswa hanya melihat mata kuliah yang sudah dimasukkan oleh admin/dosen.
3. Buka `Materi` untuk melihat/download materi.
4. Buka `Tugas` untuk melihat tugas dan upload jawaban.
5. Lihat nilai akhir/status di dashboard.

## Folder Upload

File upload tersimpan di:

```text
uploads/materi
uploads/tugas
uploads/submissions
```

Isi folder upload tidak dipush ke GitHub. Hanya file `.gitkeep` yang disimpan agar struktur folder tetap ada.

## Troubleshooting

### Port 8002 sudah dipakai

Gunakan port lain:

```powershell
php -S 127.0.0.1:8003
```

Lalu buka:

```text
http://127.0.0.1:8003
```

### MySQL tidak aktif

Gunakan SQLite:

```powershell
php scripts\init_sqlite.php
$env:APP_DB="sqlite"
php -S 127.0.0.1:8002
```

### Error `could not find driver`

Artinya ekstensi PDO untuk database belum aktif.

Cek:

```powershell
php -m
```

Pastikan ada:

```text
PDO
pdo_mysql
pdo_sqlite
```

### Reset database SQLite

Hapus file SQLite lalu generate ulang:

```powershell
Remove-Item database\database.sqlite
php scripts\init_sqlite.php
```

### Reset database MySQL

```powershell
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -uroot -e "DROP DATABASE IF EXISTS db_webprogramming; CREATE DATABASE db_webprogramming CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
& "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -uroot db_webprogramming < admin\lms.sql
```

## Git

Commit perubahan:

```powershell
git add .
git commit -m "Update LMS"
git push
```

Repo:

```text
https://github.com/B4ks0/webprogramming-lms
```
