<?php
session_start(); // Start a session to persist data across requests

class PetShop {
    private $products = []; // Array to hold product data
    private $file = 'products.json'; // File to store product data in JSON format

    // Getter for products
    public function getProducts() {
        return $this->products;
    }

    // Setter for products
    public function setProducts($products) {
        $this->products = $products;
        $this->saveProducts(); // Save the updated products list to the file
    }

    // Getter for file
    public function getFile() {
        return $this->file;
    }

    // Setter for file
    public function setFile($file) {
        $this->file = $file;
    }

    public function __construct() {
        // Check if the products file exists, and load the products data from it
        if (file_exists($this->getFile())) {
            $this->setProducts(json_decode(file_get_contents($this->getFile()), true)); // Decode JSON data into an associative array
        }
    }

    private function saveProducts() {
        // Save the products array back to the JSON file with pretty print formatting
        file_put_contents($this->getFile(), json_encode($this->getProducts(), JSON_PRETTY_PRINT));
    }

    public function displayProducts() {
        // Return the products array to be displayed
        return $this->getProducts();
    }

    public function addProduct($name, $category, $price, $photo) {
        $products = $this->getProducts(); // Get current products
        $maxId = 0; // Initialize variable to store the highest product ID
        // Loop through all products to find the highest ID
        foreach ($products as $product) {
            if ($product['id'] > $maxId) {
                $maxId = $product['id']; // Update maxId if a higher ID is found
            }
        }
        $id = $maxId + 1; // Set the new product ID to be one greater than the max ID
        // Add the new product to the products array
        $products[] = [
            'id' => $id,
            'name' => $name,
            'category' => $category,
            'price' => $price,
            'photo' => $photo
        ];
        $this->setProducts($products); // Save the updated products list
    }

    public function updateProduct($id, $name, $category, $price, $photo) {
        $products = $this->getProducts(); // Get current products
        // Loop through the products and find the one with the matching ID
        foreach ($products as &$product) {
            if ($product['id'] == $id) {
                // Update the product details
                $product['name'] = $name;
                $product['category'] = $category;
                $product['price'] = $price;
                $product['photo'] = $photo;
                $this->setProducts($products); // Save the updated products list
                return true; // Return true if the product was successfully updated
            }
        }
        return false; // Return false if no product with the given ID was found
    }

    public function deleteProduct($id) {
        $products = $this->getProducts(); // Get current products
        // Filter out the product with the given ID from the products array
        $products = array_filter($products, function ($product) use ($id) {
            return $product['id'] != $id; // Keep products whose ID doesn't match the one to delete
        });
        $this->setProducts($products); // Save the updated products list
    }

    public function searchProductByName($name) {
        $products = $this->getProducts(); // Get current products
        // Filter products by name using case-insensitive search
        return array_filter($products, function ($product) use ($name) {
            return stripos($product['name'], $name) !== false; // Return products whose name contains the search string
        });
    }
}

$petShop = new PetShop(); // Create a new PetShop instance
$searchResults = null; // Initialize variable to hold search results
$currentAction = 'display'; // Set default action to 'display'

// Store the current action in session if it's submitted
if (isset($_POST['action'])) {
    $_SESSION['current_action'] = $_POST['action']; // Save the current action to session
    $currentAction = $_POST['action']; // Set the current action
} elseif (isset($_SESSION['current_action'])) {
    $currentAction = $_SESSION['current_action']; // Get the current action from session
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle the GET request to reset search results
    if (isset($_GET['reset']) && $_GET['reset'] == 'true') {
        $searchResults = null; // Reset search results
        $_SESSION['current_action'] = 'display'; // Set the action back to display
        $currentAction = 'display'; // Set the current action to display
        // Redirect back to remove the query parameter
        header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
        exit; // Exit to prevent further processing
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle the POST request based on the action submitted
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                // Handle the 'add' action to add a new product
                if (!empty($_FILES['photo']['name'])) {
                    $targetDir = "uploads/"; // Set the directory to save uploaded photos
                    $fileName = basename($_FILES['photo']['name']); // Get the file name of the uploaded photo
                    $targetFile = $targetDir . $fileName; // Set the target file path
                    move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile); // Move the uploaded file to the target directory
                    // Add the new product with the uploaded photo
                    $petShop->addProduct($_POST['name'], $_POST['category'], $_POST['price'], $targetFile);
                }
                $searchResults = null; // Reset search results after adding a product
                break;
            case 'update':
                // Handle the 'update' action to update an existing product
                if (!empty($_FILES['photo']['name'])) {
                    $targetDir = "uploads/"; // Set the directory to save uploaded photos
                    $fileName = basename($_FILES['photo']['name']); // Get the file name of the uploaded photo
                    $targetFile = $targetDir . $fileName; // Set the target file path
                    move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile); // Move the uploaded file to the target directory
                    // Update the product with the new details
                    $petShop->updateProduct($_POST['id'], $_POST['name'], $_POST['category'], $_POST['price'], $targetFile);
                } else {
                    // If no new photo is uploaded, update the product with the old photo
                    $petShop->updateProduct($_POST['id'], $_POST['name'], $_POST['category'], $_POST['price'], $_POST['old_photo']);
                }
                $searchResults = null; // Reset search results after updating a product
                break;
            case 'delete':
                // Handle the 'delete' action to delete a product
                $petShop->deleteProduct($_POST['id']); // Delete the product by ID
                $searchResults = null; // Reset search results after deleting a product
                break;
            case 'search':
                // Handle the 'search' action to search for products by name
                $searchResults = $petShop->searchProductByName($_POST['search_name']); // Get the search results based on the name
                break;
        }
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
                $productsToDisplay = $searchResults ?? $petShop->displayProducts(); // Get products to display, either from search or all products
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
        function toggleForm(formId) { // Function to toggle visibility of add form
            var form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none'; // Toggle between 'none' and 'block'
        }

        function toggleUpdateForm(id, name, category, price, photo) { // Function to populate update form and display it
            var updateForm = document.getElementById('update-form');
           
                document.getElementById('update-id').value = id; // Set product ID in update form
                document.getElementById('update-name').value = name; // Set product name in update form
                document.getElementById('update-category').value = category; // Set product category in update form
                document.getElementById('update-price').value = price; // Set product price in update form
                document.getElementById('update-old-photo').value = photo; // Set product photo in update form
                updateForm.style.display = 'block'; // Display update form
        }
    </script>
</body>
</html>