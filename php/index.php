<?php

require('PetShop.php'); // Memuat file kelas PetShop

session_start(); // Memulai sesi untuk menyimpan data produk

$petShop = new PetShop(); // Membuat objek PetShop
$searchResults = null; // Variabel untuk menyimpan hasil pencarian
$currentAction = $_SESSION['current_action'] ?? 'display'; // Menentukan aksi saat ini, default 'display'

// Mengecek apakah ada permintaan POST dan aksi yang dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $_SESSION['current_action'] = $_POST['action']; // Menyimpan aksi saat ini ke sesi
    switch ($_POST['action']) {
        case 'add': // Jika aksi adalah menambahkan produk
            if (!empty($_FILES['photo']['name'])) { // Jika ada file foto yang diunggah
                $targetFile = "uploads/" . basename($_FILES['photo']['name']); // Menentukan lokasi penyimpanan
                move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile); // Memindahkan file ke folder uploads

                // Membuat objek PetShop dengan data yang dikirim dari form
                $petShop = new PetShop($_POST['name'], $_POST['category'], $_POST['price'], $targetFile);
                $petShop->save(); // Menyimpan produk ke sesi
            }
            break;

        case 'update': // Jika aksi adalah memperbarui produk
            $photo = !empty($_FILES['photo']['name']) ? "uploads/" . basename($_FILES['photo']['name']) : $_POST['old_photo']; // Menentukan foto yang akan digunakan
            if (!empty($_FILES['photo']['name'])) {
                move_uploaded_file($_FILES['photo']['tmp_name'], $photo); // Memindahkan file baru jika ada
            }

            // Membuat objek PetShop dengan data yang diperbarui
            $petShop = new PetShop($_POST['name'], $_POST['category'], $_POST['price'], $photo);
            $petShop->setId($_POST['id']); // Mengatur ID produk yang akan diperbarui
            $petShop->save(); // Menyimpan perubahan ke sesi
            break;

        case 'delete': // Jika aksi adalah menghapus produk
            $petShop->delete($_POST['id']); // Menghapus produk berdasarkan ID
            break;

        case 'search': // Jika aksi adalah mencari produk
            $searchResults = $petShop->searchProducts($_POST['search_name']); // Mencari produk berdasarkan kata kunci
            break;
    }
}

$productsToDisplay = $searchResults ?? $petShop->getAllProducts(); // Menentukan produk yang akan ditampilkan
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
                <input type="text" name="search_name" placeholder="Cari Produk" required> <!-- Input pencarian produk -->
                <input type="hidden" name="action" value="search"> <!-- Input tersembunyi untuk aksi pencarian -->
                <button type="submit">Cari</button> <!-- Tombol submit pencarian -->
                <?php if (isset($searchResults)): ?>
                    <a href="?reset=true" class="return-button">Kembali</a> <!-- Tombol kembali jika ada hasil pencarian -->
                <?php endif; ?>
            </form>
        </div>

        <!-- Product Add Form Section -->
        <div class="form-container">
            <h2>Tambah Produk</h2>
            <button class="create-new-button" onclick="toggleForm('add-form')">Create New</button> <!-- Tombol untuk menampilkan form tambah produk -->
            <form method="post" enctype="multipart/form-data" id="add-form" style="display:none;"> <!-- Form tambah produk, tersembunyi secara default -->
                <input type="text" name="name" placeholder="Nama Produk" required> <!-- Input nama produk -->
                <input type="text" name="category" placeholder="Kategori" required> <!-- Input kategori produk -->
                <input type="number" step="0.01" name="price" placeholder="Harga" required> <!-- Input harga produk -->
                <input type="file" name="photo" required> <!-- Input unggah foto produk -->
                <input type="hidden" name="action" value="add"> <!-- Input tersembunyi untuk aksi tambah -->
                <button type="submit">Tambah Produk</button> <!-- Tombol submit tambah produk -->
            </form>
        </div>
        
        <!-- Product List Table Section -->
        <h2>Daftar Produk</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Kolom ID produk -->
                    <th>Nama Produk</th> <!-- Kolom Nama produk -->
                    <th>Kategori</th> <!-- Kolom Kategori produk -->
                    <th>Harga</th> <!-- Kolom Harga produk -->
                    <th>Foto</th> <!-- Kolom Foto produk -->
                    <th>Aksi</th> <!-- Kolom Aksi (edit/hapus) -->
                </tr>
            </thead>
            <tbody>
    <?php foreach ($productsToDisplay as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['id']) ?></td> <!-- Menampilkan ID produk -->
            <td><?= htmlspecialchars($product['name']) ?></td> <!-- Menampilkan Nama produk -->
            <td><?= htmlspecialchars($product['category']) ?></td> <!-- Menampilkan Kategori produk -->
            <td>Rp<?= htmlspecialchars($product['price']) ?></td> <!-- Menampilkan Harga produk -->
            <td><img src="<?= htmlspecialchars($product['photo']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"></td> <!-- Menampilkan Foto produk -->
            <td class="action-buttons">
                <form method="post" style="display:inline;"> <!-- Form hapus produk -->
                    <input type="hidden" name="id" value="<?= $product['id'] ?>"> <!-- Input ID produk -->
                    <input type="hidden" name="action" value="delete"> <!-- Input aksi hapus -->
                    <button type="submit">Hapus</button> <!-- Tombol hapus produk -->
                </form>
                <button onclick="toggleUpdateForm(
                    '<?= $product['id'] ?>', 
                    '<?= $product['name'] ?>', 
                    '<?= $product['category'] ?>', 
                    '<?= $product['price'] ?>', 
                    '<?= $product['photo'] ?>'
                )">Edit</button> <!-- Tombol edit produk -->
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
        </table>

        <!-- Product Update Form Section -->
        <div class="form-container" style="margin-top: 30px;">
            <h2>Update Produk</h2>
            <form method="post" enctype="multipart/form-data" id="update-form" style="display:none;"> <!-- Form update produk -->
                <input type="hidden" name="id" id="update-id"> <!-- Input ID produk yang akan diupdate -->
                <input type="text" name="name" id="update-name" placeholder="Nama Produk" required> <!-- Input nama produk -->
                <input type="text" name="category" id="update-category" placeholder="Kategori" required> <!-- Input kategori produk -->
                <input type="number" step="0.01" name="price" id="update-price" placeholder="Harga" required> <!-- Input harga produk -->
                <input type="file" name="photo" id="update-photo"> <!-- Input unggah foto baru -->
                <input type="hidden" name="old_photo" id="update-old-photo"> <!-- Input tersembunyi foto lama -->
                <input type="hidden" name="action" value="update"> <!-- Input aksi update -->
                <button type="submit">Update Produk</button> <!-- Tombol submit update produk -->
            </form>
        </div>
    </div>

    <script>
    function toggleForm(formId) {
        var form = document.getElementById(formId); // Mendapatkan elemen form berdasarkan ID
        form.style.display = form.style.display === 'none' ? 'block' : 'none'; // Toggle visibilitas form
    }

    function toggleUpdateForm(id, name, category, price, photo) {
        var updateForm = document.getElementById('update-form'); // Mendapatkan elemen form update
        
        document.getElementById('update-id').value = id; // Mengisi ID produk
        document.getElementById('update-name').value = name; // Mengisi nama produk
        document.getElementById('update-category').value = category; // Mengisi kategori produk
        document.getElementById('update-price').value = price; // Mengisi harga produk
        document.getElementById('update-old-photo').value = photo; // Mengisi foto lama produk
        
        updateForm.style.display = 'block'; // Menampilkan form update
    }
    </script>
</body>

</html>