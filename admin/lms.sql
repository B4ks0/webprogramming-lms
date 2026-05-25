CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'dosen', 'mahasiswa') DEFAULT 'mahasiswa',
    foto_profil VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    category_id INT,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    gambar_cover VARCHAR(255),
    harga DECIMAL(10,2) DEFAULT 0,
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    judul_materi VARCHAR(255) NOT NULL,
    konten_teks LONGTEXT,
    video_url VARCHAR(255),
    file_path VARCHAR(255),
    urutan INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    judul_tugas VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    file_path VARCHAR(255),
    deadline DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE assignment_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT NOT NULL,
    user_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    catatan TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nilai DECIMAL(5,2),
    feedback TEXT,
    status ENUM('submitted', 'reviewed') DEFAULT 'submitted',
    UNIQUE KEY unique_assignment_user (assignment_id, user_id),
    FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    tgl_daftar DATETIME DEFAULT CURRENT_TIMESTAMP,
    status_belajar ENUM('aktif', 'selesai') DEFAULT 'aktif',
    nilai_akhir DECIMAL(5,2),
    catatan_dosen TEXT,
    UNIQUE KEY unique_enrollment (user_id, course_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

INSERT INTO users (nama_lengkap, email, password, role) VALUES
('Administrator', 'admin@example.com', '$2y$12$25sliOlSg/CfNi8LNHbFTOWoe4l.FWoE7ji3U519iDgPfJzrJEMkW', 'admin'),
('Dr. Budi Santoso', 'dosen@example.com', '$2y$12$3A5SEzDqc5I19KKXR9/KjOWDr/nEEJBxLBXCgg3aLAAl.NFRuVBve', 'dosen'),
('Andi Mahasiswa', 'mahasiswa@example.com', '$2y$12$OShvlrwiJWAB4W.RGEpJu.WEQ8JK547BenrYV9w.yxlb83OlEezGm', 'mahasiswa');

INSERT INTO categories (nama_kategori, slug) VALUES
('Pemrograman Web', 'pemrograman-web'),
('Basis Data', 'basis-data');

INSERT INTO courses (teacher_id, category_id, judul, deskripsi, harga, status) VALUES
(2, 1, 'Web Programming Dasar', 'HTML, CSS, PHP, MySQL, dan dasar pembuatan LMS sederhana.', 0, 'published'),
(2, 2, 'Basis Data MySQL', 'Desain tabel, relasi, query SELECT, INSERT, UPDATE, DELETE, dan laporan sederhana.', 0, 'published');

INSERT INTO lessons (course_id, judul_materi, konten_teks, urutan) VALUES
(1, 'Pengenalan LMS', 'Materi pengantar tentang Learning Management System dan alur belajar online.', 1),
(1, 'Form Login PHP', 'Membuat autentikasi berbasis session dan role user.', 2),
(2, 'Relasi Database', 'Mengenal foreign key, one-to-many, dan many-to-many.', 1);

INSERT INTO assignments (course_id, judul_tugas, deskripsi, deadline) VALUES
(1, 'Tugas Login PHP', 'Buat halaman login sederhana menggunakan session dan role.', DATE_ADD(NOW(), INTERVAL 7 DAY));
