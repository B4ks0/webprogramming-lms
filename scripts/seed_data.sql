-- ============================================================
-- SEED DATA LENGKAP - LMS Webprogramming
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- ABSENSI TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS absensi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  course_id INT NOT NULL,
  jadwal_id INT,
  tanggal DATE NOT NULL,
  status ENUM('hadir','izin','sakit','alpha') DEFAULT 'hadir',
  keterangan VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
  FOREIGN KEY (jadwal_id) REFERENCES jadwal(id) ON DELETE SET NULL
);

-- ============================================================
-- USERS
-- ============================================================
INSERT INTO users (id, nama_lengkap, email, password, role) VALUES
(5,  'Dr. Sari Dewi',       'sari@example.com',    '$2y$10$2L/CLX.mALC/RnG6x1tXn.zw4cpHxojdTSmzzWb9o93emSO32Fhh.', 'dosen'),
(6,  'Dr. Hendra Gunawan',  'hendra@example.com',  '$2y$10$2L/CLX.mALC/RnG6x1tXn.zw4cpHxojdTSmzzWb9o93emSO32Fhh.', 'dosen'),
(7,  'Dr. Maya Putri',      'maya@example.com',    '$2y$10$2L/CLX.mALC/RnG6x1tXn.zw4cpHxojdTSmzzWb9o93emSO32Fhh.', 'dosen'),
(8,  'Budi Prasetyo',       'budi@example.com',    '$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW', 'mahasiswa'),
(9,  'Citra Lestari',       'citra@example.com',   '$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW', 'mahasiswa'),
(10, 'Dian Permata',        'dian@example.com',    '$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW', 'mahasiswa'),
(11, 'Eko Santoso',         'eko@example.com',     '$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW', 'mahasiswa'),
(12, 'Fina Rahmawati',      'fina@example.com',    '$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW', 'mahasiswa')
ON DUPLICATE KEY UPDATE nama_lengkap=VALUES(nama_lengkap);

-- ============================================================
-- CATEGORIES
-- ============================================================
INSERT INTO categories (id, nama_kategori, slug) VALUES
(3, 'Jaringan Komputer', 'jaringan-komputer'),
(4, 'Sistem Operasi',    'sistem-operasi'),
(5, 'Pemrograman Mobile','pemrograman-mobile'),
(6, 'Kecerdasan Buatan', 'kecerdasan-buatan')
ON DUPLICATE KEY UPDATE nama_kategori=VALUES(nama_kategori);

-- ============================================================
-- COURSES
-- ============================================================
INSERT INTO courses (id, teacher_id, category_id, judul, deskripsi, status) VALUES
(3, 3, 1, 'Pemrograman PHP Lanjut',     'OOP, Framework MVC, dan REST API menggunakan PHP modern.', 'published'),
(4, 3, 2, 'Desain Database',            'Perancangan ERD, normalisasi, stored procedure, dan optimasi query.', 'published'),
(5, 5, 3, 'Jaringan Komputer Dasar',    'Konsep jaringan, model OSI, TCP/IP, dan konfigurasi router dasar.', 'published'),
(6, 6, 4, 'Sistem Operasi Linux',       'Administrasi sistem Linux, manajemen proses, dan shell scripting.', 'published'),
(7, 7, 5, 'Android Development',        'Pengembangan aplikasi Android menggunakan Java dan Android Studio.', 'published'),
(8, 5, 6, 'Machine Learning Dasar',     'Pengenalan ML, regresi linear, klasifikasi, dan clustering dengan Python.', 'published')
ON DUPLICATE KEY UPDATE judul=VALUES(judul);

-- ============================================================
-- KELAS
-- ============================================================
INSERT INTO kelas (id, nama_kelas, kode_kelas, kapasitas) VALUES
(4, 'Kelas D', 'KLS-D', 35),
(5, 'Kelas E', 'KLS-E', 35)
ON DUPLICATE KEY UPDATE nama_kelas=VALUES(nama_kelas);

-- ============================================================
-- JADWAL (course_id, kelas_id, hari, jam_mulai, jam_selesai, ruangan)
-- ============================================================
INSERT INTO jadwal (id, course_id, kelas_id, hari, jam_mulai, jam_selesai, ruangan) VALUES
(1,  1, 1, 'Senin',   '08:00:00', '10:00:00', 'Gedung A-101'),
(2,  1, 2, 'Rabu',    '13:00:00', '15:00:00', 'Gedung A-102'),
(3,  2, 1, 'Selasa',  '08:00:00', '10:00:00', 'Lab Basis Data'),
(4,  2, 3, 'Kamis',   '13:00:00', '15:00:00', 'Lab Basis Data'),
(5,  3, 2, 'Senin',   '10:00:00', '12:00:00', 'Gedung B-201'),
(6,  4, 1, 'Selasa',  '13:00:00', '15:00:00', 'Gedung B-202'),
(7,  5, 4, 'Rabu',    '08:00:00', '10:00:00', 'Lab Jaringan'),
(8,  6, 2, 'Kamis',   '08:00:00', '10:00:00', 'Gedung C-301'),
(9,  7, 5, 'Jumat',   '08:00:00', '10:00:00', 'Lab Mobile'),
(10, 8, 3, 'Jumat',   '13:00:00', '15:00:00', 'Lab AI')
ON DUPLICATE KEY UPDATE ruangan=VALUES(ruangan);

-- ============================================================
-- LESSONS
-- ============================================================
-- Course 1: Web Programming Dasar (lesson 1 sudah ada)
INSERT INTO lessons (id, course_id, judul_materi, konten_teks, urutan) VALUES
(2,  1, 'HTML & CSS Fundamental',    'Struktur halaman HTML5, semantic elements, CSS box model, flexbox, dan grid layout.', 2),
(3,  1, 'PHP Dasar & Form Handling', 'Sintaks PHP, variabel, array, kondisi, loop, dan menangani form POST/GET.', 3),
-- Course 2: Basis Data MySQL
(4,  2, 'Pengenalan Basis Data Relasional', 'Konsep RDBMS, tabel, baris, kolom, primary key dan foreign key.', 1),
(5,  2, 'Query SELECT & JOIN',        'SELECT, WHERE, ORDER BY, GROUP BY, INNER JOIN, LEFT JOIN, dan subquery.', 2),
(6,  2, 'Normalisasi & Optimasi',     '1NF, 2NF, 3NF, BCNF, indexing, dan explain query untuk optimasi.', 3),
-- Course 3: Pemrograman PHP Lanjut
(7,  3, 'OOP PHP: Class & Object',   'Encapsulation, inheritance, polymorphism, dan abstract class di PHP.', 1),
(8,  3, 'Framework MVC Laravel',     'Routing, controller, model, view, migration, dan eloquent ORM.', 2),
(9,  3, 'REST API dengan PHP',       'Membuat RESTful API, format JSON, autentikasi token, dan dokumentasi API.', 3),
-- Course 4: Desain Database
(10, 4, 'Entity Relationship Diagram', 'Entitas, atribut, relasi, kardinalitas, dan konversi ERD ke tabel.', 1),
(11, 4, 'Stored Procedure & Trigger', 'Membuat prosedur tersimpan, fungsi, dan trigger di MySQL.', 2),
(12, 4, 'Backup & Recovery',         'mysqldump, restore database, dan strategi backup database produksi.', 3),
-- Course 5: Jaringan Komputer Dasar
(13, 5, 'Model OSI 7 Layer',         'Penjelasan tiap layer OSI: Physical, Data Link, Network, Transport, Session, Presentation, Application.', 1),
(14, 5, 'TCP/IP & Subnetting',       'Protokol TCP/IP, pengalamatan IPv4, CIDR, dan perhitungan subnet.', 2),
(15, 5, 'Konfigurasi Router & Switch','VLAN, routing statis, routing dinamis (OSPF, RIP), dan konfigurasi via CLI.', 3),
-- Course 6: Sistem Operasi Linux
(16, 6, 'Pengenalan Linux & CLI',    'Distribusi Linux, navigasi direktori, manajemen file, dan permission.', 1),
(17, 6, 'Manajemen Proses & Servis', 'ps, kill, systemctl, crontab, dan monitoring sistem dengan top/htop.', 2),
(18, 6, 'Shell Scripting Bash',      'Variabel, kondisi, loop, fungsi, dan skrip otomatisasi dengan bash.', 3),
-- Course 7: Android Development
(19, 7, 'Android Studio & Struktur Proyek', 'Setup environment, struktur proyek Android, AndroidManifest, dan Gradle.', 1),
(20, 7, 'Activity, Fragment & Intent','Siklus hidup Activity, Fragment, dan komunikasi antar komponen via Intent.', 2),
(21, 7, 'RecyclerView & Retrofit',   'Menampilkan data list dengan RecyclerView dan konsumsi REST API dengan Retrofit.', 3),
-- Course 8: Machine Learning Dasar
(22, 8, 'Pengenalan Machine Learning', 'Supervised vs unsupervised learning, dataset, fitur, dan label.', 1),
(23, 8, 'Regresi Linear & Logistik', 'Implementasi regresi linear dan logistik menggunakan scikit-learn.', 2),
(24, 8, 'Klasifikasi: KNN & Decision Tree', 'Algoritma KNN, pohon keputusan, dan evaluasi model dengan confusion matrix.', 3)
ON DUPLICATE KEY UPDATE judul_materi=VALUES(judul_materi);

-- ============================================================
-- ASSIGNMENTS
-- ============================================================
-- Course 1 (assignment 1 sudah ada)
INSERT INTO assignments (id, course_id, judul_tugas, deskripsi, deadline) VALUES
(2,  1, 'Tugas 2: Buat CRUD Sederhana',       'Implementasikan CRUD mahasiswa dengan PHP dan MySQL.', '2026-07-15 23:59:00'),
(3,  1, 'Tugas 3: Upload File & Validasi',    'Form upload foto dengan validasi tipe dan ukuran file.', '2026-07-29 23:59:00'),
(4,  2, 'Tugas 1: Query JOIN',                 'Buat 5 query menggunakan INNER JOIN dan LEFT JOIN pada database LMS.', '2026-07-01 23:59:00'),
(5,  2, 'Tugas 2: Normalisasi Tabel',          'Normalisasikan tabel yang diberikan hingga ke bentuk 3NF.', '2026-07-15 23:59:00'),
(6,  3, 'Tugas 1: Implementasi OOP',           'Buat class hierarchy untuk sistem perpustakaan dengan PHP OOP.', '2026-07-01 23:59:00'),
(7,  3, 'Tugas 2: REST API CRUD',              'Buat REST API untuk manajemen produk dengan autentikasi token.', '2026-07-15 23:59:00'),
(8,  4, 'Tugas 1: ERD Sistem Akademik',        'Rancang ERD untuk sistem akademik lengkap dengan minimal 8 entitas.', '2026-07-01 23:59:00'),
(9,  4, 'Tugas 2: Stored Procedure',           'Buat stored procedure untuk laporan nilai mahasiswa per semester.', '2026-07-15 23:59:00'),
(10, 5, 'Tugas 1: Analisis Paket Wireshark',   'Capture traffic jaringan dan analisis paket TCP handshake dengan Wireshark.', '2026-07-01 23:59:00'),
(11, 5, 'Tugas 2: Konfigurasi VLAN',           'Konfigurasi VLAN dan inter-VLAN routing pada simulator Packet Tracer.', '2026-07-15 23:59:00'),
(12, 6, 'Tugas 1: Shell Script Monitoring',    'Buat script bash untuk monitoring disk usage dan email alert otomatis.', '2026-07-01 23:59:00'),
(13, 7, 'Tugas 1: Aplikasi To-Do List Android','Buat aplikasi Android To-Do List dengan SQLite lokal.', '2026-07-01 23:59:00'),
(14, 8, 'Tugas 1: Prediksi Harga Rumah',       'Implementasi regresi linear untuk prediksi harga rumah dengan dataset yang disediakan.', '2026-07-01 23:59:00')
ON DUPLICATE KEY UPDATE judul_tugas=VALUES(judul_tugas);

-- ============================================================
-- ENROLLMENTS
-- ============================================================
-- Andi (4) sudah enroll course 1 & 2, tambahkan course 3
INSERT INTO enrollments (user_id, course_id, status_belajar) VALUES
(4,  3, 'aktif'),
-- Budi (8): course 1, 2, 5, 7
(8,  1, 'aktif'),
(8,  2, 'aktif'),
(8,  5, 'aktif'),
(8,  7, 'aktif'),
-- Citra (9): course 2, 4, 6, 8
(9,  2, 'aktif'),
(9,  4, 'aktif'),
(9,  6, 'aktif'),
(9,  8, 'aktif'),
-- Dian (10): course 1, 3, 6, 7
(10, 1, 'selesai'),
(10, 3, 'aktif'),
(10, 6, 'aktif'),
(10, 7, 'aktif'),
-- Eko (11): course 2, 4, 5, 8
(11, 2, 'aktif'),
(11, 4, 'aktif'),
(11, 5, 'selesai'),
(11, 8, 'aktif'),
-- Fina (12): course 1, 2, 3, 4
(12, 1, 'aktif'),
(12, 2, 'aktif'),
(12, 3, 'aktif'),
(12, 4, 'aktif')
ON DUPLICATE KEY UPDATE status_belajar=VALUES(status_belajar);

-- Update nilai akhir untuk yang sudah selesai
UPDATE enrollments SET nilai_akhir=88.50, catatan_dosen='Mahasiswa aktif dan berprestasi'
WHERE user_id=10 AND course_id=1;
UPDATE enrollments SET nilai_akhir=91.00, catatan_dosen='Sangat baik, lulus dengan pujian'
WHERE user_id=11 AND course_id=5;

-- ============================================================
-- ASSIGNMENT SUBMISSIONS
-- ============================================================
INSERT INTO assignment_submissions (assignment_id, user_id, file_path, catatan, nilai, feedback, status) VALUES
-- Andi (4) submits for course 1
(1,  4, 'submissions/andi_tugas1_login.php',    'Sudah saya kerjakan sesuai ketentuan.',   85.00, 'Bagus, login berfungsi dengan baik.',             'reviewed'),
(2,  4, 'submissions/andi_tugas2_crud.php',      'Menambahkan fitur search juga.',          88.00, 'Excellent, bonus untuk fitur tambahan.',          'reviewed'),
-- Budi (8) submits for course 1
(1,  8, 'submissions/budi_tugas1_login.php',     'Login dengan hash password.',             90.00, 'Implementasi keamanan sangat baik.',              'reviewed'),
(2,  8, 'submissions/budi_tugas2_crud.php',      'CRUD lengkap dengan validasi.',           87.00, 'Validasi sudah baik, perhatikan XSS.',            'reviewed'),
-- Dian (10) submits for course 1
(1, 10, 'submissions/dian_tugas1_login.php',     'Selesai sesuai spesifikasi.',             78.00, 'Fungsionalitas OK, perbaiki tampilan.',           'reviewed'),
-- Fina (12) submits for course 1
(1, 12, 'submissions/fina_tugas1_login.php',     NULL,                                      NULL,  NULL,                                              'submitted'),
(2, 12, 'submissions/fina_tugas2_crud.php',      'Masih ada bug pada delete.',              NULL,  NULL,                                              'submitted'),
-- Budi (8) submits for course 2
(4,  8, 'submissions/budi_tugas1_query.sql',     '5 query JOIN sudah lengkap.',             82.00, 'Query sudah benar, optimalkan dengan index.',     'reviewed'),
-- Citra (9) submits for course 2
(4,  9, 'submissions/citra_tugas1_query.sql',    'Query dengan subquery juga.',             91.00, 'Penggunaan subquery sangat kreatif.',             'reviewed'),
(5,  9, 'submissions/citra_tugas2_normal.pdf',   'Normalisasi 3NF lengkap dengan penjelasan.',76.00,'Penjelasan cukup, perlu diperdalam BCNF.',       'reviewed'),
-- Eko (11) submits for course 2
(4, 11, 'submissions/eko_tugas1_query.sql',      NULL,                                      NULL,  NULL,                                              'submitted'),
-- Fina (12) submits for course 2
(4, 12, 'submissions/fina_tugas1_query.sql',     'Query sederhana.',                        70.00, 'Perlu latihan lebih untuk query kompleks.',       'reviewed'),
-- Andi (4) & Budi (8) submits for course 3
(6,  4, 'submissions/andi_tugas1_oop.php',       'OOP untuk perpustakaan.',                 86.00, 'Inheritance dan interface sudah baik.',           'reviewed'),
(6,  8, 'submissions/budi_tugas1_oop.php',       'Lengkap dengan design pattern.',          93.00, 'Implementasi pattern sangat baik!',               'reviewed'),
-- Citra (9) submits for course 4
(8,  9, 'submissions/citra_tugas1_erd.pdf',      'ERD sistem akademik 10 entitas.',         89.00, 'ERD komprehensif dan relasi tepat.',              'reviewed'),
-- Budi (8) submits for course 5
(10, 8, 'submissions/budi_tugas1_wireshark.pdf', 'Capture 3 TCP handshake.',               84.00, 'Analisis paket sudah benar.',                     'reviewed'),
-- Eko (11) submits for course 8
(14,11, 'submissions/eko_tugas1_ml.ipynb',       'Prediksi dengan LinearRegression.',       88.00, 'Implementasi regresi baik, tambahkan visualisasi.','reviewed')
ON DUPLICATE KEY UPDATE status=VALUES(status);

-- ============================================================
-- ABSENSI
-- Setiap mahasiswa diabsen berdasarkan jadwal & course
-- ============================================================

-- Course 1 (jadwal 1: Senin, jadwal 2: Rabu)
-- Andi (4) - course 1
INSERT INTO absensi (user_id, course_id, jadwal_id, tanggal, status, keterangan) VALUES
(4, 1, 1, '2026-05-05', 'hadir', NULL),
(4, 1, 2, '2026-05-07', 'hadir', NULL),
(4, 1, 1, '2026-05-12', 'hadir', NULL),
(4, 1, 2, '2026-05-14', 'izin',  'Keperluan keluarga'),
(4, 1, 1, '2026-05-19', 'hadir', NULL),
(4, 1, 2, '2026-05-21', 'hadir', NULL),
(4, 1, 1, '2026-05-26', 'hadir', NULL),
(4, 1, 2, '2026-05-28', 'sakit', 'Demam'),
-- Budi (8) - course 1
(8, 1, 1, '2026-05-05', 'hadir', NULL),
(8, 1, 2, '2026-05-07', 'hadir', NULL),
(8, 1, 1, '2026-05-12', 'hadir', NULL),
(8, 1, 2, '2026-05-14', 'hadir', NULL),
(8, 1, 1, '2026-05-19', 'alpha', NULL),
(8, 1, 2, '2026-05-21', 'hadir', NULL),
(8, 1, 1, '2026-05-26', 'hadir', NULL),
(8, 1, 2, '2026-05-28', 'hadir', NULL),
-- Dian (10) - course 1
(10, 1, 1, '2026-05-05', 'hadir', NULL),
(10, 1, 2, '2026-05-07', 'hadir', NULL),
(10, 1, 1, '2026-05-12', 'sakit', 'Surat dokter terlampir'),
(10, 1, 2, '2026-05-14', 'hadir', NULL),
(10, 1, 1, '2026-05-19', 'hadir', NULL),
(10, 1, 2, '2026-05-21', 'hadir', NULL),
(10, 1, 1, '2026-05-26', 'hadir', NULL),
(10, 1, 2, '2026-05-28', 'hadir', NULL),
-- Fina (12) - course 1
(12, 1, 1, '2026-05-05', 'hadir', NULL),
(12, 1, 2, '2026-05-07', 'hadir', NULL),
(12, 1, 1, '2026-05-12', 'hadir', NULL),
(12, 1, 2, '2026-05-14', 'hadir', NULL),
(12, 1, 1, '2026-05-19', 'izin',  'Mengurus berkas akademik'),
(12, 1, 2, '2026-05-21', 'hadir', NULL),
(12, 1, 1, '2026-05-26', 'hadir', NULL),
(12, 1, 2, '2026-05-28', 'hadir', NULL),

-- Course 2 (jadwal 3: Selasa, jadwal 4: Kamis)
-- Andi (4) - course 2
(4, 2, 3, '2026-05-06', 'hadir', NULL),
(4, 2, 4, '2026-05-08', 'hadir', NULL),
(4, 2, 3, '2026-05-13', 'hadir', NULL),
(4, 2, 4, '2026-05-15', 'hadir', NULL),
(4, 2, 3, '2026-05-20', 'alpha', NULL),
(4, 2, 4, '2026-05-22', 'hadir', NULL),
(4, 2, 3, '2026-05-27', 'hadir', NULL),
(4, 2, 4, '2026-05-29', 'hadir', NULL),
-- Budi (8) - course 2
(8, 2, 3, '2026-05-06', 'hadir', NULL),
(8, 2, 4, '2026-05-08', 'hadir', NULL),
(8, 2, 3, '2026-05-13', 'izin',  'Sakit ringan'),
(8, 2, 4, '2026-05-15', 'hadir', NULL),
(8, 2, 3, '2026-05-20', 'hadir', NULL),
(8, 2, 4, '2026-05-22', 'hadir', NULL),
(8, 2, 3, '2026-05-27', 'hadir', NULL),
(8, 2, 4, '2026-05-29', 'hadir', NULL),
-- Citra (9) - course 2
(9, 2, 3, '2026-05-06', 'hadir', NULL),
(9, 2, 4, '2026-05-08', 'hadir', NULL),
(9, 2, 3, '2026-05-13', 'hadir', NULL),
(9, 2, 4, '2026-05-15', 'sakit', 'Flu'),
(9, 2, 3, '2026-05-20', 'hadir', NULL),
(9, 2, 4, '2026-05-22', 'hadir', NULL),
(9, 2, 3, '2026-05-27', 'hadir', NULL),
(9, 2, 4, '2026-05-29', 'hadir', NULL),
-- Eko (11) - course 2
(11, 2, 3, '2026-05-06', 'hadir', NULL),
(11, 2, 4, '2026-05-08', 'hadir', NULL),
(11, 2, 3, '2026-05-13', 'hadir', NULL),
(11, 2, 4, '2026-05-15', 'hadir', NULL),
(11, 2, 3, '2026-05-20', 'hadir', NULL),
(11, 2, 4, '2026-05-22', 'izin',  'Urusan organisasi'),
(11, 2, 3, '2026-05-27', 'hadir', NULL),
(11, 2, 4, '2026-05-29', 'hadir', NULL),
-- Fina (12) - course 2
(12, 2, 3, '2026-05-06', 'hadir', NULL),
(12, 2, 4, '2026-05-08', 'alpha', NULL),
(12, 2, 3, '2026-05-13', 'hadir', NULL),
(12, 2, 4, '2026-05-15', 'hadir', NULL),
(12, 2, 3, '2026-05-20', 'hadir', NULL),
(12, 2, 4, '2026-05-22', 'hadir', NULL),
(12, 2, 3, '2026-05-27', 'sakit', 'Migrain'),
(12, 2, 4, '2026-05-29', 'hadir', NULL),

-- Course 3 (jadwal 5: Senin 10-12)
(4,  3, 5, '2026-05-05', 'hadir', NULL),
(4,  3, 5, '2026-05-12', 'hadir', NULL),
(4,  3, 5, '2026-05-19', 'hadir', NULL),
(4,  3, 5, '2026-05-26', 'izin',  'Presentasi lomba'),
(8,  3, 5, '2026-05-05', 'hadir', NULL),
(8,  3, 5, '2026-05-12', 'hadir', NULL),
(8,  3, 5, '2026-05-19', 'hadir', NULL),
(8,  3, 5, '2026-05-26', 'hadir', NULL),
(10, 3, 5, '2026-05-05', 'hadir', NULL),
(10, 3, 5, '2026-05-12', 'sakit', 'Demam'),
(10, 3, 5, '2026-05-19', 'hadir', NULL),
(10, 3, 5, '2026-05-26', 'hadir', NULL),
(12, 3, 5, '2026-05-05', 'hadir', NULL),
(12, 3, 5, '2026-05-12', 'hadir', NULL),
(12, 3, 5, '2026-05-19', 'hadir', NULL),
(12, 3, 5, '2026-05-26', 'hadir', NULL),

-- Course 4 (jadwal 6: Selasa 13-15)
(9,  4, 6, '2026-05-06', 'hadir', NULL),
(9,  4, 6, '2026-05-13', 'hadir', NULL),
(9,  4, 6, '2026-05-20', 'hadir', NULL),
(9,  4, 6, '2026-05-27', 'izin',  'Acara kampus'),
(11, 4, 6, '2026-05-06', 'hadir', NULL),
(11, 4, 6, '2026-05-13', 'alpha', NULL),
(11, 4, 6, '2026-05-20', 'hadir', NULL),
(11, 4, 6, '2026-05-27', 'hadir', NULL),
(12, 4, 6, '2026-05-06', 'hadir', NULL),
(12, 4, 6, '2026-05-13', 'hadir', NULL),
(12, 4, 6, '2026-05-20', 'hadir', NULL),
(12, 4, 6, '2026-05-27', 'hadir', NULL),

-- Course 5 (jadwal 7: Rabu 08-10)
(8,  5, 7, '2026-05-07', 'hadir', NULL),
(8,  5, 7, '2026-05-14', 'hadir', NULL),
(8,  5, 7, '2026-05-21', 'hadir', NULL),
(8,  5, 7, '2026-05-28', 'hadir', NULL),
(11, 5, 7, '2026-05-07', 'hadir', NULL),
(11, 5, 7, '2026-05-14', 'izin',  'Seminar nasional'),
(11, 5, 7, '2026-05-21', 'hadir', NULL),
(11, 5, 7, '2026-05-28', 'hadir', NULL),

-- Course 6 (jadwal 8: Kamis 08-10)
(9,  6, 8, '2026-05-08', 'hadir', NULL),
(9,  6, 8, '2026-05-15', 'hadir', NULL),
(9,  6, 8, '2026-05-22', 'hadir', NULL),
(9,  6, 8, '2026-05-29', 'sakit', 'Flu berat'),
(10, 6, 8, '2026-05-08', 'hadir', NULL),
(10, 6, 8, '2026-05-15', 'hadir', NULL),
(10, 6, 8, '2026-05-22', 'alpha', NULL),
(10, 6, 8, '2026-05-29', 'hadir', NULL),

-- Course 7 (jadwal 9: Jumat 08-10)
(8,  7, 9, '2026-05-09', 'hadir', NULL),
(8,  7, 9, '2026-05-16', 'hadir', NULL),
(8,  7, 9, '2026-05-23', 'hadir', NULL),
(8,  7, 9, '2026-05-30', 'hadir', NULL),
(10, 7, 9, '2026-05-09', 'hadir', NULL),
(10, 7, 9, '2026-05-16', 'izin',  'Izin keluarga'),
(10, 7, 9, '2026-05-23', 'hadir', NULL),
(10, 7, 9, '2026-05-30', 'hadir', NULL),

-- Course 8 (jadwal 10: Jumat 13-15)
(9,  8, 10, '2026-05-09', 'hadir', NULL),
(9,  8, 10, '2026-05-16', 'hadir', NULL),
(9,  8, 10, '2026-05-23', 'hadir', NULL),
(9,  8, 10, '2026-05-30', 'hadir', NULL),
(11, 8, 10, '2026-05-09', 'hadir', NULL),
(11, 8, 10, '2026-05-16', 'hadir', NULL),
(11, 8, 10, '2026-05-23', 'sakit', 'Surat sakit'),
(11, 8, 10, '2026-05-30', 'hadir', NULL);

SET FOREIGN_KEY_CHECKS = 1;
