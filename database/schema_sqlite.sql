PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS assignment_submissions;
DROP TABLE IF EXISTS assignments;
DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS lessons;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama_lengkap TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'mahasiswa' CHECK (role IN ('admin', 'dosen', 'mahasiswa')),
    foto_profil TEXT DEFAULT 'default.jpg',
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama_kategori TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE
);

CREATE TABLE courses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    teacher_id INTEGER NOT NULL,
    category_id INTEGER,
    judul TEXT NOT NULL,
    deskripsi TEXT,
    gambar_cover TEXT,
    harga REAL DEFAULT 0,
    status TEXT DEFAULT 'draft' CHECK (status IN ('draft', 'published')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE lessons (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    course_id INTEGER NOT NULL,
    judul_materi TEXT NOT NULL,
    konten_teks TEXT,
    video_url TEXT,
    file_path TEXT,
    urutan INTEGER DEFAULT 0,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE enrollments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    course_id INTEGER NOT NULL,
    tgl_daftar TEXT DEFAULT CURRENT_TIMESTAMP,
    status_belajar TEXT DEFAULT 'aktif' CHECK (status_belajar IN ('aktif', 'selesai')),
    nilai_akhir REAL,
    catatan_dosen TEXT,
    UNIQUE (user_id, course_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE assignments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    course_id INTEGER NOT NULL,
    judul_tugas TEXT NOT NULL,
    deskripsi TEXT,
    file_path TEXT,
    deadline TEXT NOT NULL,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE assignment_submissions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    assignment_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    file_path TEXT NOT NULL,
    catatan TEXT,
    submitted_at TEXT DEFAULT CURRENT_TIMESTAMP,
    nilai REAL,
    feedback TEXT,
    status TEXT DEFAULT 'submitted' CHECK (status IN ('submitted', 'reviewed')),
    UNIQUE (assignment_id, user_id),
    FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (id, nama_lengkap, email, password, role) VALUES
(1, 'Administrator', 'admin@example.com', '$2y$12$25sliOlSg/CfNi8LNHbFTOWoe4l.FWoE7ji3U519iDgPfJzrJEMkW', 'admin'),
(2, 'Dr. Budi Santoso', 'dosen@example.com', '$2y$12$3A5SEzDqc5I19KKXR9/KjOWDr/nEEJBxLBXCgg3aLAAl.NFRuVBve', 'dosen'),
(3, 'Andi Mahasiswa', 'mahasiswa@example.com', '$2y$12$OShvlrwiJWAB4W.RGEpJu.WEQ8JK547BenrYV9w.yxlb83OlEezGm', 'mahasiswa');

INSERT INTO categories (id, nama_kategori, slug) VALUES
(1, 'Pemrograman Web', 'pemrograman-web'),
(2, 'Basis Data', 'basis-data');

INSERT INTO courses (id, teacher_id, category_id, judul, deskripsi, harga, status) VALUES
(1, 2, 1, 'Web Programming Dasar', 'HTML, CSS, PHP, MySQL, dan dasar pembuatan LMS sederhana.', 0, 'published'),
(2, 2, 2, 'Basis Data MySQL', 'Desain tabel, relasi, query SELECT, INSERT, UPDATE, DELETE, dan laporan sederhana.', 0, 'published');

INSERT INTO lessons (course_id, judul_materi, konten_teks, urutan) VALUES
(1, 'Pengenalan LMS', 'Materi pengantar tentang Learning Management System dan alur belajar online.', 1),
(1, 'Form Login PHP', 'Membuat autentikasi berbasis session dan role user.', 2),
(2, 'Relasi Database', 'Mengenal foreign key, one-to-many, dan many-to-many.', 1);

INSERT INTO enrollments (user_id, course_id, status_belajar) VALUES
(3, 1, 'aktif'),
(3, 2, 'aktif');

INSERT INTO assignments (course_id, judul_tugas, deskripsi, deadline) VALUES
(1, 'Tugas Login PHP', 'Buat halaman login sederhana menggunakan session dan role.', datetime('now', '+7 days'));
