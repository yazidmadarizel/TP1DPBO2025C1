<?php
// Memulai session untuk menyimpan data produk
session_start(); 

// Mendefinisikan kelas PetShop
class PetShop {
    // Properti untuk menyimpan daftar produk
    private $products = []; 

    // Konstruktor untuk inisialisasi kelas
    public function __construct() {
        // Memeriksa apakah session 'products' sudah ada, jika tidak, inisialisasi sebagai array kosong
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [];
        }
        // Menggunakan referensi ke session 'products' untuk menyimpan data produk
        $this->products = &$_SESSION['products'];
    }

    // Method untuk mendapatkan daftar produk
    public function getProducts() {
        return $this->products;
    }

    // Method untuk menambahkan produk baru
    public function addProduct($name, $category, $price, $photo) {
        // Menentukan ID baru dengan menambahkan 1 ke ID tertinggi yang ada
        $maxId = empty($this->products) ? 0 : max(array_column($this->products, 'id'));
        $id = $maxId + 1; 

        // Menambahkan produk baru ke dalam array products
        $this->products[] = [
            'id' => $id,
            'name' => $name,
            'category' => $category,
            'price' => $price,
            'photo' => $photo
        ];
    }

    // Method untuk memperbarui produk yang sudah ada
    public function updateProduct($id, $name, $category, $price, $photo) {
        // Melakukan iterasi melalui array products untuk mencari produk dengan ID yang sesuai
        foreach ($this->products as &$product) {
            if ($product['id'] == $id) {
                // Memperbarui data produk
                $product['name'] = $name;
                $product['category'] = $category;
                $product['price'] = $price;
                $product['photo'] = $photo;
                return true; // Mengembalikan true jika produk berhasil diperbarui
            }
        }
        return false; // Mengembalikan false jika produk tidak ditemukan
    }

    // Method untuk menghapus produk berdasarkan ID
    public function deleteProduct($id) {
        // Menghapus produk dengan ID tertentu dan mengindeks ulang array
        $this->products = array_values(array_filter($this->products, fn($product) => $product['id'] != $id));
    }

    // Method untuk mencari produk berdasarkan nama
    public function searchProductByName($name) {
        // Mengembalikan array produk yang namanya mengandung kata kunci pencarian
        return array_filter($this->products, fn($product) => stripos($product['name'], $name) !== false);
    }
}

// Membuat instance dari kelas PetShop
$petShop = new PetShop(); 
// Variabel untuk menyimpan hasil pencarian
$searchResults = null; 
// Menentukan aksi yang sedang dilakukan berdasarkan session atau default 'display'
$currentAction = $_SESSION['current_action'] ?? 'display';

// Memeriksa apakah request method adalah POST dan action telah ditentukan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // Menyimpan aksi saat ini ke dalam session
    $_SESSION['current_action'] = $_POST['action'];
    // Melakukan switch case berdasarkan aksi yang dipilih
    switch ($_POST['action']) {
        case 'add':
            // Memeriksa apakah file foto telah diunggah
            if (!empty($_FILES['photo']['name'])) {
                // Menentukan lokasi file yang diunggah
                $targetFile = "uploads/" . basename($_FILES['photo']['name']);
                // Memindahkan file yang diunggah ke lokasi yang ditentukan
                move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);
                // Menambahkan produk baru dengan data yang diberikan
                $petShop->addProduct($_POST['name'], $_POST['category'], $_POST['price'], $targetFile);
            }
            break;
        case 'update':
            // Menentukan foto baru atau menggunakan foto lama jika tidak ada foto baru yang diunggah
            $photo = !empty($_FILES['photo']['name']) ? "uploads/" . basename($_FILES['photo']['name']) : $_POST['old_photo'];
            // Memindahkan file foto baru jika ada
            if (!empty($_FILES['photo']['name'])) move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
            // Memperbarui produk dengan data yang diberikan
            $petShop->updateProduct($_POST['id'], $_POST['name'], $_POST['category'], $_POST['price'], $photo);
            break;
        case 'delete':
            // Menghapus produk berdasarkan ID
            $petShop->deleteProduct($_POST['id']);
            break;
        case 'search':
            // Mencari produk berdasarkan nama dan menyimpan hasilnya
            $searchResults = $petShop->searchProductByName($_POST['search_name']);
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PetShop Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .form-container h2 {
            margin-top: 0;
            color: #555;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-container input[type="text"], 
        .form-container input[type="number"], 
        .form-container input[type="file"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: auto;
            align-self: flex-start;
        }
        .form-container button:hover {
            background-color: #218838;
        }
        .create-new-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
            width: auto;
            align-self: flex-start;
        }
        .create-new-button:hover {
            background-color: #0056b3;
        }
        .return-button {
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            width: auto;
            align-self: flex-start;
        }
        .return-button:hover {
            background-color: #5a6268;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 12px;
            text-align: left;
       
        }
        table th {
            background-color: #f8f9fa;
            color: #333;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        img {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
        }

        td.action-buttons {
    border-bottom: 0px solid #ddd;
}


        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .action-buttons button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: auto;
        }
        .action-buttons button[type="submit"] {
            background-color: #dc3545;
            color: #fff;
        }
        .action-buttons button[type="submit"]:hover {
            background-color: #c82333;
        }
        .action-buttons button:not([type="submit"]) {
            background-color: #ffc107;
            color: #000;
        }
        .action-buttons button:not([type="submit"]):hover {
            background-color: #e0a800;
        }
        .update-form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .update-form-container h2 {
            margin-top: 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Title Section -->
        <h1>Pet Shop Management</h1>
        
        <!-- Product Search Form Section -->
        <div class="form-container">
            <h2>Cari Produk</h2>
            <form method="post" id="search-form">
                <input type="text" name="search_name" placeholder="Cari Produk" required> <!-- Input for search query -->
                <input type="hidden" name="action" value="search"> <!-- Hidden input to indicate search action -->
                <button type="submit">Cari</button> <!-- Search button -->
                <?php if ($searchResults !== null): ?> <!-- If search results are present -->
                    <a href="?reset=true" class="return-button">Kembali</a> <!-- Reset search button -->
                <?php endif; ?>
            </form>
        </div>

        <!-- Product Add Form Section -->
        <div class="form-container">
            <h2>Tambah Produk</h2>
            <button class="create-new-button" onclick="toggleForm('add-form')">Create New</button> <!-- Button to show add product form -->
            <form method="post" enctype="multipart/form-data" id="add-form" style="display:none;">
                <input type="text" name="name" placeholder="Nama Produk" required> <!-- Input for product name -->
                <input type="text" name="category" placeholder="Kategori" required> <!-- Input for product category -->
                <input type="number" step="0.01" name="price" placeholder="Harga" required> <!-- Input for product price -->
                <input type="file" name="photo" required> <!-- Input for product image -->
                <input type="hidden" name="action" value="add"> <!-- Hidden input to indicate add action -->
                <button type="submit">Tambah Produk</button> <!-- Button to submit add product form -->
            </form>
        </div>
        
        <!-- Product List Table Section -->
        <h2>Daftar Produk</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Table header for ID -->
                    <th>Nama Produk</th> <!-- Table header for product name -->
                    <th>Kategori</th> <!-- Table header for product category -->
                    <th>Harga</th> <!-- Table header for product price -->
                    <th>Foto</th> <!-- Table header for product photo -->
                    <th>Aksi</th> <!-- Table header for actions (edit, delete) -->
                </tr>
            </thead>
            <tbody>
                <?php 
                $productsToDisplay = $searchResults ?? $petShop->getProducts(); 
                foreach ($productsToDisplay as $product): ?> <!-- Loop through each product -->
                    <tr>
                        <td><?= htmlspecialchars($product['id']) ?></td> <!-- Display product ID -->
                        <td><?= htmlspecialchars($product['name']) ?></td> <!-- Display product name -->
                        <td><?= htmlspecialchars($product['category']) ?></td> <!-- Display product category -->
                        <td>Rp<?= htmlspecialchars($product['price']) ?></td> <!-- Display product price with 'Rp' -->
                        <td><img src="<?= htmlspecialchars($product['photo']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"></td> <!-- Display product photo -->
                        <td class="action-buttons">
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>"> <!-- Hidden input for product ID for delete -->
                                <input type="hidden" name="action" value="delete"> <!-- Hidden input for delete action -->
                                <button type="submit">Hapus</button> <!-- Delete button -->
                            </form>
                            <button onclick="toggleUpdateForm(<?= $product['id'] ?>, '<?= $product['name'] ?>', '<?= $product['category'] ?>', <?= $product['price'] ?>, '<?= $product['photo'] ?>')">Edit</button> <!-- Edit button, opens update form -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Product Update Form Section -->
        <div class="form-container" style="margin-top: 30px;">
            <h2>Update Produk</h2>
            <form method="post" enctype="multipart/form-data" id="update-form" style="display:none;">
                <input type="hidden" name="id" id="update-id"> <!-- Hidden input for product ID for update -->
                <input type="text" name="name" id="update-name" placeholder="Nama Produk" required> <!-- Input for product name for update -->
                <input type="text" name="category" id="update-category" placeholder="Kategori" required> <!-- Input for product category for update -->
                <input type="number" step="0.01" name="price" id="update-price" placeholder="Harga" required> <!-- Input for product price for update -->
                <input type="file" name="photo" id="update-photo"> <!-- Input for product photo for update -->
                <input type="hidden" name="old_photo" id="update-old-photo"> <!-- Hidden input for current product photo (for update) -->
                <input type="hidden" name="action" value="update"> <!-- Hidden input to indicate update action -->
                <button type="submit">Update Produk</button> <!-- Button to submit update product form -->
            </form>
        </div>

    </div>

    <!-- JavaScript Section -->
    <script>
    // Fungsi untuk menampilkan atau menyembunyikan form berdasarkan ID form
    function toggleForm(formId) { 
        // Mengambil elemen form berdasarkan ID
        var form = document.getElementById(formId);
        // Mengubah tampilan form: jika tersembunyi (none), tampilkan (block), dan sebaliknya
        form.style.display = form.style.display === 'none' ? 'block' : 'none'; 
    }

    // Fungsi untuk menampilkan form update dan mengisi nilai-nilai yang sesuai
    function toggleUpdateForm(id, name, category, price, photo) { 
        // Mengambil elemen form update berdasarkan ID
        var updateForm = document.getElementById('update-form');
        
        // Mengisi nilai-nilai input di form update dengan data yang diberikan
        document.getElementById('update-id').value = id; // Mengisi ID produk
        document.getElementById('update-name').value = name; // Mengisi nama produk
        document.getElementById('update-category').value = category; // Mengisi kategori produk
        document.getElementById('update-price').value = price; // Mengisi harga produk
        document.getElementById('update-old-photo').value = photo; // Mengisi foto lama produk
        
        // Menampilkan form update
        updateForm.style.display = 'block'; 
    }
</script>
</body>
</html>
