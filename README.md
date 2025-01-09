# Panduan Membuat Database Adek

Panduan ini menjelaskan langkah-langkah untuk membuat database **Adek** beserta tabel-tabelnya sesuai dengan desain yang ada.

---

## 1. Membuat Database
Buat database dengan nama `adek` menggunakan perintah berikut:
```sql
CREATE DATABASE adek;
USE adek;
```

---

## 2. Membuat Tabel

### 2.1 Tabel `admin`
```sql
CREATE TABLE admin (
    username CHAR(5) PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(20) NOT NULL,
    noTelp_admin VARCHAR(14),
    gambar VARCHAR(100)
);
```

### 2.2 Tabel `artikel`
```sql
CREATE TABLE artikel (
    id_buku CHAR(5) PRIMARY KEY,
    user VARCHAR(30),
    kategori ENUM('diet', 'olahraga', 'makanan', 'minuman'),
    isi_buku LONGTEXT,
    nama VARCHAR(100)
);
```

### 2.3 Tabel `detail_kalori`
```sql
CREATE TABLE detail_kalori (
    id_detailkalori INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_user CHAR(5),
    id_menu CHAR(5),
    tanggal DATE,
    jumlah INT(11),
    total_kalori INT(11),
    total_minum INT(11),
    total_protein DOUBLE,
    total_karbohidrat DOUBLE,
    total_lemak DOUBLE,
    total_gula DOUBLE
);
```

### 2.4 Tabel `menu`
```sql
CREATE TABLE menu (
    id_menu CHAR(5) PRIMARY KEY,
    nama_menu VARCHAR(15) NOT NULL,
    kategori_menu ENUM('makanan_berat', 'dessert', 'minuman_sehat'),
    protein INT(4),
    karbohidrat INT(4),
    lemak INT(4),
    kalori INT(4),
    resep LONGTEXT,
    gambar VARCHAR(100),
    satuan ENUM('gram', 'sendok', 'mangkuk', 'porsi'),
    gula DECIMAL(10,2)
);
```

### 2.5 Tabel `data_pengguna`
```sql
CREATE TABLE data_pengguna (
    id_user CHAR(5) PRIMARY KEY,
    nama_lengkap VARCHAR(70) NOT NULL,
    password VARCHAR(255) NOT NULL,
    no_hp VARCHAR(15),
    tinggi_badan VARCHAR(4),
    berat_badan VARCHAR(4),
    tanggal_lahir DATE,
    tipe_diet ENUM('Menambah berat badan', 'Mengurangi berat badan', 'Mempertahankan berat badan'),
    gender ENUM('Laki-laki', 'Perempuan'),
    gambar VARCHAR(100)
);
```

### 2.6 Tabel `riwayat_makanan`
```sql
CREATE TABLE riwayat_makanan (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_user CHAR(5),
    id_menu CHAR(5),
    tanggal DATE,
    jumlah INT(11),
    total_kalori INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 2.7 Tabel `olahraga`
```sql
CREATE TABLE olahraga (
    id_olahraga CHAR(5) PRIMARY KEY,
    nama_olahraga VARCHAR(30) NOT NULL,
    deskripsi LONGTEXT,
    cara_olahraga TEXT,
    jenis_olahraga ENUM('kardio', 'kekuatan', 'interval'),
    username CHAR(5),
    gambar VARCHAR(100),
    kalori DECIMAL(10,2)
);
```

### 2.8 Tabel `konsultan`
```sql
CREATE TABLE konsultan (
    id_konsultan CHAR(5) PRIMARY KEY,
    nama_lengkap VARCHAR(70) NOT NULL,
    no_hp VARCHAR(15),
    gambar VARCHAR(100)
);
```

---

## 3. Relasi Antar Tabel
- Tabel `detail_kalori` memiliki foreign key `id_user` yang merujuk ke `data_pengguna(id_user)` dan `id_menu` yang merujuk ke `menu(id_menu)`.
- Tabel `riwayat_makanan` memiliki foreign key `id_user` yang merujuk ke `data_pengguna(id_user)` dan `id_menu` yang merujuk ke `menu(id_menu)`.
- Tabel `olahraga` memiliki foreign key `username` yang merujuk ke `admin(username)`.

Tambahkan foreign key menggunakan perintah berikut (contoh untuk `detail_kalori`):
```sql
ALTER TABLE detail_kalori
ADD FOREIGN KEY (id_user) REFERENCES data_pengguna(id_user),
ADD FOREIGN KEY (id_menu) REFERENCES menu(id_menu);
```

---

## 4. Menambahkan Data Dummy (Opsional)
Tambahkan data dummy untuk pengujian:
```sql
INSERT INTO admin (username, email, password, nama, noTelp_admin, gambar)
VALUES ('A001', 'admin@gmail.com', 'admin123', 'Admin', '08123456789', 'admin.jpg');

INSERT INTO data_pengguna (id_user, nama_lengkap, password, no_hp, tinggi_badan, berat_badan, tanggal_lahir, tipe_diet, gender, gambar)
VALUES ('U001', 'John Doe', 'password123', '081234567890', '175', '70', '1990-01-01', 'Mengurangi berat badan', 'Laki-laki', 'johndoe.jpg');
```

---

## 5. Menguji Database
Gunakan perintah SQL berikut untuk memeriksa data:
```sql
SELECT * FROM admin;
SELECT * FROM data_pengguna;
SELECT * FROM menu;
```

---

Selesai! Database Anda telah dibuat sesuai dengan struktur di atas.

