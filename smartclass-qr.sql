DROP DATABASE IF EXISTS smartclass_qr;
CREATE DATABASE smartclass_qr;
USE smartclass_qr;

-- USERS (login semua role)
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','dosen','mahasiswa'),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- DOSEN
CREATE TABLE dosen (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    nidn VARCHAR(50) UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- KELAS
CREATE TABLE kelas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(50),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- MAHASISWA
CREATE TABLE mahasiswa (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    nim VARCHAR(50) UNIQUE,
    kelas_id BIGINT UNSIGNED,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE
);

-- MATA KULIAH
CREATE TABLE mata_kuliah (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_mk VARCHAR(20) UNIQUE,
    nama_mk VARCHAR(100),
    sks INT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- JADWAL KULIAH
CREATE TABLE jadwal_kuliah (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dosen_id BIGINT UNSIGNED,
    mata_kuliah_id BIGINT UNSIGNED,
    kelas_id BIGINT UNSIGNED,
    hari VARCHAR(20),
    jam_mulai TIME,
    jam_selesai TIME,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (dosen_id) REFERENCES dosen(id) ON DELETE CASCADE,
    FOREIGN KEY (mata_kuliah_id) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE
);

-- SESI PRESENSI
CREATE TABLE sesi_presensi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jadwal_kuliah_id BIGINT UNSIGNED,
    pertemuan INT,
    qr_token VARCHAR(255),
    status ENUM('dibuka','ditutup') DEFAULT 'dibuka',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (jadwal_kuliah_id) REFERENCES jadwal_kuliah(id) ON DELETE CASCADE
);

-- KEHADIRAN
CREATE TABLE kehadiran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sesi_presensi_id BIGINT UNSIGNED,
    mahasiswa_id BIGINT UNSIGNED,
    status ENUM('H','X','-') DEFAULT 'X',
    waktu_scan TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (sesi_presensi_id) REFERENCES sesi_presensi(id) ON DELETE CASCADE,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    UNIQUE KEY unique_kehadiran (sesi_presensi_id, mahasiswa_id)
);

-- SESSIONS (untuk Laravel SESSION_DRIVER=database)
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL
);