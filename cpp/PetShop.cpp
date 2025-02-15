#include <iostream> // Mengimpor pustaka untuk input dan output (cin, cout)
#include <vector>   // Mengimpor pustaka untuk menggunakan struktur data vector
#include <algorithm> // Mengimpor pustaka untuk fungsi algoritma seperti sort, find, dll.

using namespace std; // Menggunakan namespace std agar tidak perlu menuliskan std:: sebelum fungsi bawaan C++


class PetShop {
private:
    vector<int> productIds;          // Menyimpan ID produk
    vector<string> productNames;     // Menyimpan nama produk
    vector<string> productCategories; // Menyimpan kategori produk
    vector<double> productPrices;    // Menyimpan harga produk
    vector<string> productPhotos;    // Menyimpan foto produk
    int nextId; // ID otomatis untuk produk baru

    // Getter untuk ID
    vector<int> getProductIds() const {
        return productIds;
    }

    // Getter untuk nama produk
    vector<string> getProductNames() const {
        return productNames;
    }

    // Getter untuk kategori produk
    vector<string> getProductCategories() const {
        return productCategories;
    }

    // Getter untuk harga produk
    vector<double> getProductPrices() const {
        return productPrices;
    }

    // Getter untuk foto produk
    vector<string> getProductPhotos() const {
        return productPhotos;
    }

    // Setter untuk ID (tidak diperlukan karena ID diatur otomatis)
    void setProductId(int index, int id) {
        if (index >= 0 && index < productIds.size()) {
            productIds[index] = id;
        }
    }

    // Setter untuk nama produk
    void setProductName(int index, const string& name) {
        if (index >= 0 && index < productNames.size()) {
            productNames[index] = name;
        }
    }

    // Setter untuk kategori produk
    void setProductCategory(int index, const string& category) {
        if (index >= 0 && index < productCategories.size()) {
            productCategories[index] = category;
        }
    }

    // Setter untuk harga produk
    void setProductPrice(int index, double price) {
        if (index >= 0 && index < productPrices.size() && price >= 0) {
            productPrices[index] = price;
        } else {
            cout << "Harga tidak boleh negatif!\n";
        }
    }

    // Setter untuk foto produk
    void setProductPhoto(int index, const string& photo) {
        if (index >= 0 && index < productPhotos.size()) {
            productPhotos[index] = photo;
        }
    }

    public:
    PetShop() : nextId(1) {} // Konstruktor kelas, menginisialisasi ID produk berikutnya ke 1

    // Menampilkan semua produk
    void displayProducts() const {
        if (productIds.empty()) { // Mengecek apakah tidak ada produk dalam daftar
            cout << "Tidak ada produk yang tersedia.\n"; // Menampilkan pesan jika daftar kosong
            return; // Keluar dari fungsi
        }
        for (size_t i = 0; i < productIds.size(); ++i) { // Melakukan iterasi untuk menampilkan semua produk
            cout << "ID: " << productIds[i] << "\n"; // Menampilkan ID produk
            cout << "Nama: " << productNames[i] << "\n"; // Menampilkan nama produk
            cout << "Kategori: " << productCategories[i] << "\n"; // Menampilkan kategori produk
            cout << "Harga: Rp" << productPrices[i] << "\n"; // Menampilkan harga produk
            cout << "Foto: " << productPhotos[i] << "\n"; // Menampilkan URL atau path foto produk
            cout << "-------------------------\n"; // Garis pemisah antar produk
        }
    }

    // Menambahkan produk baru
    void addProduct(const string& name, const string& category, double price, const string& photo) {
        if (price < 0) { // Memeriksa apakah harga produk negatif
            cout << "Harga tidak boleh negatif!\n"; // Menampilkan pesan kesalahan jika harga negatif
            return; // Keluar dari fungsi
        }
        productIds.push_back(nextId++); // Menambahkan ID produk baru dan meningkatkan nilai ID berikutnya
        productNames.push_back(name); // Menambahkan nama produk ke daftar
        productCategories.push_back(category); // Menambahkan kategori produk ke daftar
        productPrices.push_back(price); // Menambahkan harga produk ke daftar
        productPhotos.push_back(photo); // Menambahkan foto produk ke daftar
        cout << "Produk berhasil ditambahkan.\n"; // Menampilkan pesan konfirmasi
    }

    // Memperbarui produk berdasarkan ID
    void updateProduct(int id, const string& name, const string& category, double price, const string& photo) {
        auto it = find(productIds.begin(), productIds.end(), id); // Mencari produk berdasarkan ID
        if (it != productIds.end()) { // Jika produk ditemukan
            size_t index = distance(productIds.begin(), it); // Menentukan indeks produk dalam daftar
            setProductName(index, name); // Memperbarui nama produk
            setProductCategory(index, category); // Memperbarui kategori produk
            setProductPrice(index, price); // Memperbarui harga produk
            setProductPhoto(index, photo); // Memperbarui foto produk
            cout << "Produk berhasil diperbarui.\n"; // Menampilkan pesan konfirmasi
        } else {
            cout << "Produk dengan ID " << id << " tidak ditemukan.\n"; // Menampilkan pesan jika produk tidak ditemukan
        }
    }

    // Menghapus produk berdasarkan ID
    void deleteProduct(int id) {
        auto it = find(productIds.begin(), productIds.end(), id); // Mencari produk berdasarkan ID
        if (it != productIds.end()) { // Jika produk ditemukan
            size_t index = distance(productIds.begin(), it); // Menentukan indeks produk dalam daftar
            productIds.erase(productIds.begin() + index); // Menghapus ID produk dari daftar
            productNames.erase(productNames.begin() + index); // Menghapus nama produk dari daftar
            productCategories.erase(productCategories.begin() + index); // Menghapus kategori produk dari daftar
            productPrices.erase(productPrices.begin() + index); // Menghapus harga produk dari daftar
            productPhotos.erase(productPhotos.begin() + index); // Menghapus foto produk dari daftar
            cout << "Produk berhasil dihapus.\n"; // Menampilkan pesan konfirmasi
        } else {
            cout << "Produk dengan ID " << id << " tidak ditemukan.\n"; // Menampilkan pesan jika produk tidak ditemukan
        }
    }

    // Mencari produk berdasarkan nama
    void searchProductByName(const string& name) const {
        bool found = false; // Menandai apakah produk ditemukan
        for (size_t i = 0; i < productNames.size(); ++i) { // Iterasi untuk mencari produk
            if (productNames[i] == name) { // Jika nama produk cocok
                cout << "ID: " << productIds[i] << "\n"; // Menampilkan ID produk
                cout << "Nama: " << productNames[i] << "\n"; // Menampilkan nama produk
                cout << "Kategori: " << productCategories[i] << "\n"; // Menampilkan kategori produk
                cout << "Harga: Rp" << productPrices[i] << "\n"; // Menampilkan harga produk
                cout << "Foto: " << productPhotos[i] << "\n"; // Menampilkan foto produk
                cout << "-------------------------\n"; // Garis pemisah antar produk
                found = true; // Menandai bahwa produk ditemukan
            }
        }
        if (!found) { // Jika tidak ada produk yang ditemukan
            cout << "Produk dengan nama '" << name << "' tidak ditemukan.\n"; // Menampilkan pesan jika produk tidak ditemukan
        }
    }

};