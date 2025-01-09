<?php

class Olahraga_model
{

    private $table = 'olahraga';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllOlahraga()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultset();
    }

    public function getOlahragaById($id)
    {
        $query = "SELECT * FROM olahraga WHERE id_olahraga = :id";

        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function getIdOlahraga()
    {
        $this->db->query('SELECT MAX(id_olahraga) AS id_terbesar FROM olahraga');
        return $this->db->single();
    }

    public function tambahDataOlahraga($data)
    {
        $query = "INSERT INTO olahraga VALUES (:id_olahraga, :nama_olahraga, :deskripsi, :cara_olahraga, :jenis_olahraga, :username, :gambar, :kalori)";

        $fileName = $data['gambar']['name'];
        $uploadDirectory = "../app/upload/olahraga/";
        $filePath = $uploadDirectory . $fileName;

        move_uploaded_file($data['gambar']['tmp_name'], $filePath);

        $this->db->query($query);
        $this->db->bind('id_olahraga', $data['id_olahraga']);
        $this->db->bind('nama_olahraga', $data['nama_olahraga']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('cara_olahraga', $data['cara_olahraga']);
        $this->db->bind('jenis_olahraga', $data['jenis_olahraga']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('gambar', $fileName);
        $this->db->bind('kalori', $data['kalori']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusDataOlahraga($id)
    {
        $query = "DELETE FROM olahraga WHERE id_olahraga = :id";

        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahDataOlahraga($data)
    {

        $this->db->query("SELECT gambar FROM olahraga WHERE id_olahraga = :id_olahraga");
        $this->db->bind('id_olahraga', $data['id_olahraga']);
        $result = $this->db->single();

        $gambarLama = $result ? $result['gambar'] : null;

        $query = "UPDATE olahraga SET 
        nama_olahraga= :nama_olahraga,
        deskripsi = :deskripsi,
        cara_olahraga = :cara_olahraga,
        jenis_olahraga = :jenis_olahraga,
        username = :username,
        gambar = :gambar,
        kalori = :kalori
        WHERE id_olahraga = :id_olahraga";

        // Handle file upload jika ada file baru
        if (isset($data['gambar']) && $data['gambar']['error'] === 0) {
            $fileName = $data['gambar']['name'];
            $uploadDirectory = "../app/upload/olahraga/";
            $filePath = $uploadDirectory . $fileName;
            move_uploaded_file($data['gambar']['tmp_name'], $filePath);
        } else {
            $fileName = $gambarLama;
        }

        $this->db->query($query);
        $this->db->bind('nama_olahraga', $data['nama_olahraga']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('cara_olahraga', $data['cara_olahraga']);
        $this->db->bind('jenis_olahraga', $data['jenis_olahraga']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('gambar', $fileName);
        $this->db->bind('kalori', $data['kalori']);
        $this->db->bind('id_olahraga', $data['id_olahraga']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cariAllMenu()
    {
        $keyword = $_POST['keyword'];

        $query = "SELECT * FROM olahraga WHERE nama_olahraga LIKE :keyword";

        $this->db->query($query);
        $this->db->bind('keyword', "%$keyword%");
        return $this->db->resultset();
    }

    public function filter()
    {
        $keyword = $_POST['filter'];

        // Jika filter adalah 'all', ambil semua data
        if ($keyword == "all") {
            $query = "SELECT * FROM olahraga";
        } else {
            $query = "SELECT * FROM olahraga WHERE jenis_olahraga LIKE :filter";
        }

        $this->db->query($query);

        // Hanya bind jika bukan 'all'
        if ($keyword != "all") {
            $this->db->bind('filter', "%$keyword%");
        }

        return $this->db->resultset();
    }
}
