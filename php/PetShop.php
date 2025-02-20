<?php

// Definisi kelas PetShop
class PetShop {
    private $id; // Properti untuk menyimpan ID produk
    private $name; // Properti untuk menyimpan nama produk
    private $category; // Properti untuk menyimpan kategori produk
    private $price; // Properti untuk menyimpan harga produk
    private $photo; // Properti untuk menyimpan URL foto produk

    // Konstruktor untuk menginisialisasi objek dengan nilai default
    public function __construct($name = "", $category = "", $price = 0, $photo = "") {
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->photo = $photo;
    }

    // Setter untuk ID
    public function setId($id) {
        $this->id = $id;
    }

    // Getter untuk ID
    public function getId() {
        return $this->id;
    }

    // Setter untuk Nama
    public function setName($name) {
        $this->name = $name;
    }

    // Getter untuk Nama
    public function getName() {
        return $this->name;
    }

    // Setter untuk Kategori
    public function setCategory($category) {
        $this->category = $category;
    }

    // Getter untuk Kategori
    public function getCategory() {
        return $this->category;
    }

    // Setter untuk Harga
    public function setPrice($price) {
        $this->price = $price;
    }

    // Getter untuk Harga
    public function getPrice() {
        return $this->price;
    }

    // Setter untuk Foto
    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    // Getter untuk Foto
    public function getPhoto() {
        return $this->photo;
    }

    // Metode untuk menyimpan produk ke dalam sesi
    public function save() {
        if (!isset($_SESSION['products'])) { // Jika array produk belum ada di sesi, buat array kosong
            $_SESSION['products'] = [];
        }

        if (!$this->id) { // Jika ID belum diatur, cari ID tertinggi dan tambahkan 1
            $maxId = 0;
            foreach ($_SESSION['products'] as $product) {
                $maxId = max($maxId, $product['id']);
            }
            $this->id = $maxId + 1;
        }

        // Simpan produk ke dalam sesi dengan ID sebagai kunci
        $_SESSION['products'][$this->id] = [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->price,
            'photo' => $this->photo
        ];
    }

    // Metode untuk mengambil semua produk dari sesi
    public function getAllProducts() {
        return $_SESSION['products'] ?? []; // Mengembalikan produk jika ada, jika tidak, kembalikan array kosong
    }

    // Metode untuk menghapus produk berdasarkan ID
    public function delete($id) {
        if (isset($_SESSION['products'][$id])) { // Jika produk dengan ID tertentu ada, hapus dari sesi
            unset($_SESSION['products'][$id]);
        }
    }

    // Metode untuk mencari produk berdasarkan kata kunci
    public function searchProducts($keyword) {
        if (empty($_SESSION['products'])) { // Jika tidak ada produk, kembalikan array kosong
            return [];
        }

        // Gunakan array_filter untuk mencari produk yang namanya mengandung kata kunci (tidak case-sensitive)
        return array_filter($_SESSION['products'], function ($product) use ($keyword) {
            return stripos($product['name'], $keyword) !== false;
        });
    }
}

?>