-- =====================================================================
-- SETUP DATABASE  ·  Sistem Manajemen Perpustakaan "immanuel-library"
-- Pemrograman Web Lanjutan  ·  Kelas XI  ·  SMK Kristen Immanuel Pontianak
-- ---------------------------------------------------------------------
-- Cara pakai (Terminal Laragon, dari folder proyek):
--     mysql -u root < immanuel_library_setup.sql
-- Atau lewat phpMyAdmin: menu Import, pilih berkas ini, klik Go.
--
-- Nama database yang dibuat: immanuel_library
-- Pastikan config/database.php memakai nama yang sama:
--     $dbname = "immanuel_library";
--
-- PERINGATAN: berkas ini menghapus database lama bernama
-- immanuel_library beserta seluruh isinya, lalu membuatnya dari nol.
-- =====================================================================

DROP DATABASE IF EXISTS immanuel_library;
CREATE DATABASE immanuel_library
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;
USE immanuel_library;


-- =====================================================================
-- 1. TABEL categories
--    Satu kategori dimiliki banyak buku (relasi satu ke banyak).
-- =====================================================================
CREATE TABLE categories (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT
) ENGINE = InnoDB;


-- =====================================================================
-- 2. TABEL authors
--    Data penulis, dihubungkan ke buku lewat tabel book_author.
-- =====================================================================
CREATE TABLE authors (
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    bio  TEXT
) ENGINE = InnoDB;


-- =====================================================================
-- 3. TABEL books
--    category_id menunjuk ke categories.id (foreign key).
-- =====================================================================
CREATE TABLE books (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(200) NOT NULL,
    isbn        VARCHAR(30),
    year        INT,
    stock       INT NOT NULL DEFAULT 0,
    description TEXT,
    category_id INT,
    CONSTRAINT fk_books_categories
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE = InnoDB;


-- =====================================================================
-- 4. TABEL book_author (tabel penghubung / pivot, tetap bentuk tunggal)
--    Satu buku boleh punya banyak penulis, satu penulis boleh
--    menulis banyak buku (relasi banyak ke banyak).
--    ON DELETE CASCADE: kalau buku dihapus, pasangannya ikut hilang.
-- =====================================================================
CREATE TABLE book_author (
    book_id   INT NOT NULL,
    author_id INT NOT NULL,
    PRIMARY KEY (book_id, author_id),
    CONSTRAINT fk_ba_books
        FOREIGN KEY (book_id) REFERENCES books(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_ba_authors
        FOREIGN KEY (author_id) REFERENCES authors(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;


-- =====================================================================
-- 5. TABEL users
--    Kolom password dibuat 255 karakter karena menyimpan hasil
--    password_hash(), bukan kata sandi asli.
-- =====================================================================
CREATE TABLE users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(150) NOT NULL,
    email    VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role     ENUM('admin', 'member') NOT NULL DEFAULT 'member'
) ENGINE = InnoDB;


-- =====================================================================
-- 6. TABEL profiles
--    Data tambahan milik satu pengguna (relasi satu ke satu),
--    dipakai oleh halaman pages/profiles/edit.php.
-- =====================================================================
CREATE TABLE profiles (
    user_id INT PRIMARY KEY,
    phone   VARCHAR(30),
    address VARCHAR(255),
    bio     TEXT,
    CONSTRAINT fk_profiles_users
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;


-- =====================================================================
-- DATA CONTOH
-- Isinya sama dengan array statis pada folder repositories/ starter kit,
-- supaya tampilan sebelum dan sesudah tersambung database terlihat mirip.
-- =====================================================================

INSERT INTO categories (id, name, description) VALUES
(1, 'Fiksi',     'Novel dan cerita rekaan'),
(2, 'Sains',     'Buku ilmu pengetahuan alam'),
(3, 'Sejarah',   'Buku sejarah dan biografi'),
(4, 'Teknologi', 'Buku pemrograman dan teknologi');

INSERT INTO authors (id, name, bio) VALUES
(1, 'Andrea Hirata',        'Penulis asal Belitung, dikenal lewat novel Laskar Pelangi.'),
(2, 'Tere Liye',            'Penulis produktif asal Indonesia dengan banyak novel populer.'),
(3, 'J.K. Rowling',         'Penulis asal Inggris, pencipta seri novel Harry Potter.'),
(4, 'Pramoedya Ananta Toer','Sastrawan besar Indonesia, penulis tetralogi Buru.'),
(5, 'Sapardi Djoko Damono', 'Penyair dan penulis Indonesia, dikenal lewat puisi-puisinya.');

INSERT INTO books (id, title, isbn, year, stock, description, category_id) VALUES
(1, 'Laskar Pelangi',                '978-979-1227-78-0', 2005, 12,
    'Kisah perjuangan sepuluh anak Belitung mengejar pendidikan di tengah keterbatasan.', 1),
(2, 'Bumi',                          '978-602-03-0491-5', 2014,  8,
    'Petualangan Raib, Seli, dan Ali menjelajahi dunia paralel di seri Bumi.', 1),
(3, 'Harry Potter dan Batu Bertuah', '978-979-22-3115-6', 1997,  5,
    'Awal petualangan Harry Potter menemukan dunia sihir dan Hogwarts.', 1),
(4, 'Bumi Manusia',                  '978-979-9731-23-1', 1980,  6,
    'Kisah Minke pada masa kolonial, bagian pertama Tetralogi Buru.', 3),
(5, 'Antologi Rasa Nusantara',       '978-602-1234-56-7', 2021,  4,
    'Kumpulan puisi dan cerita pendek dari berbagai penulis Nusantara.', 1);

-- Buku nomor 5 sengaja punya dua penulis, untuk menguji relasi banyak ke banyak.
INSERT INTO book_author (book_id, author_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 4),
(5, 5);

-- ---------------------------------------------------------------------
-- Akun percobaan. Kolom password sudah berisi hasil password_hash(),
-- jadi bisa langsung dipakai dengan password_verify().
--     admin@ski.sch.id            kata sandi: admin123
--     richard.m@ski.sch.id        kata sandi: admin123
--     budi.santoso@siswa.ski.sch.id   kata sandi: member123
--     siti.aminah@siswa.ski.sch.id    kata sandi: member123
-- Kata sandi di atas hanya untuk latihan di kelas. Jangan dipakai
-- pada aplikasi yang benar benar dipublikasikan.
-- ---------------------------------------------------------------------
INSERT INTO users (id, name, email, password, role) VALUES
(1, 'Admin Utama',     'admin@ski.sch.id',
    '$2a$10$yDBnzFCARB.wk.DWpb0TcejNxhbJo.PoeUdRd.M4ZlD2nAfTTRoTe', 'admin'),
(2, 'Budi Santoso',    'budi.santoso@siswa.ski.sch.id',
    '$2a$10$jIGD7jw9TMeNenSrpjp75OS7Qy2WEFrddmtwiPv4dD6SzfVHgzZuK', 'member'),
(3, 'Siti Aminah',     'siti.aminah@siswa.ski.sch.id',
    '$2a$10$jIGD7jw9TMeNenSrpjp75OS7Qy2WEFrddmtwiPv4dD6SzfVHgzZuK', 'member'),
(4, 'Richard Marcell', 'richard.m@ski.sch.id',
    '$2a$10$yDBnzFCARB.wk.DWpb0TcejNxhbJo.PoeUdRd.M4ZlD2nAfTTRoTe', 'admin');

INSERT INTO profiles (user_id, phone, address, bio) VALUES
(2, '0812-3456-7890',
    'Jl. Merdeka No. 21, Pontianak, Kalimantan Barat',
    'Murid kelas XI TKJ yang gemar membaca novel fiksi dan buku pengembangan diri.');


-- =====================================================================
-- PEMERIKSAAN CEPAT
-- Jalankan baris di bawah untuk memastikan data dan relasi sudah benar.
-- =====================================================================

SELECT 'Jumlah data per tabel' AS pemeriksaan;
SELECT
    (SELECT COUNT(*) FROM categories)  AS kategori,
    (SELECT COUNT(*) FROM authors)     AS penulis,
    (SELECT COUNT(*) FROM books)       AS buku,
    (SELECT COUNT(*) FROM book_author) AS relasi_penulis,
    (SELECT COUNT(*) FROM users)       AS pengguna;

SELECT 'Buku beserta kategori dan penulisnya' AS pemeriksaan;
SELECT
    books.id,
    books.title,
    categories.name AS category_name,
    GROUP_CONCAT(authors.name ORDER BY authors.name SEPARATOR ', ') AS penulis
FROM books
INNER JOIN categories  ON books.category_id = categories.id
LEFT  JOIN book_author ON books.id = book_author.book_id
LEFT  JOIN authors     ON book_author.author_id = authors.id
GROUP BY books.id, books.title, categories.name
ORDER BY books.title ASC;
