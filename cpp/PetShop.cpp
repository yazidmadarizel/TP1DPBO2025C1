#include <iostream>  // Menggunakan library untuk input dan output
#include <vector>    // Menggunakan library untuk struktur data vektor
#include <string>    // Menggunakan library untuk manipulasi string
#include <algorithm> // Menggunakan library untuk fungsi algoritma seperti find_if

using namespace std; // Menggunakan namespace std agar tidak perlu menulis std::

// Deklarasi kelas PetShop untuk mengelola produk dalam toko hewan peliharaan
class PetShop {
    private:
        // Struktur data untuk menyimpan informasi produk
        struct Product {
            int id;                // ID unik produk
            string name;           // Nama produk
            string category;       // Kategori produk
            double price;          // Harga produk
            string photo;          // URL atau path foto produk

            // Setter dan Getter untuk ID
            void setId(int newId) {
                id = newId;
            }

            int getId() const {
                return id;
            }

            // Setter dan Getter untuk Nama
            void setName(const string& newName) {
                name = newName;
            }

            string getName() const {
                return name;
            }

            // Setter dan Getter untuk Kategori
            void setCategory(const string& newCategory) {
                category = newCategory;
            }

            string getCategory() const {
                return category;
            }

            // Setter dan Getter untuk Harga
            void setPrice(double newPrice) {
                price = newPrice;
            }

            double getPrice() const {
                return price;
            }

            // Setter dan Getter untuk Foto
            void setPhoto(const string& newPhoto) {
                photo = newPhoto;
            }

            string getPhoto() const {
                return photo;
            }
        };
    
        vector<Product> products; // Vektor untuk menyimpan daftar produk
        int nextId;               // Variabel untuk menentukan ID berikutnya
    
    public:
        // Konstruktor untuk menginisialisasi nilai awal ID
        PetShop() : nextId(1) {}
    
        // Fungsi untuk menampilkan semua produk
        void displayProducts() const {
            if (products.empty()) { // Periksa apakah daftar produk kosong
                cout << "Tidak ada produk yang tersedia.\n";
                return;
            }
    
            // Loop untuk menampilkan semua produk yang ada dalam vektor
            for (const auto& product : products) {
                cout << "ID: " << product.getId() << "\n";
                cout << "Nama Produk: " << product.getName() << "\n";
                cout << "Kategori: " << product.getCategory() << "\n";
                cout << "Harga: Rp" << product.getPrice() << "\n";
                cout << "Foto: " << product.getPhoto() << "\n";
                cout << "-------------------------\n";
            }
        }
    
        // Fungsi untuk menambahkan produk baru ke dalam daftar
        void addProduct(const string& name, const string& category, double price, const string& photo) {
            Product newProduct;
            newProduct.setId(nextId++);
            newProduct.setName(name);
            newProduct.setCategory(category);
            newProduct.setPrice(price);
            newProduct.setPhoto(photo);
            products.push_back(newProduct); // Tambahkan produk ke dalam vektor
            cout << "Produk berhasil ditambahkan.\n";
        }
    
        // Fungsi untuk memperbarui informasi produk berdasarkan ID
        void updateProduct(int id, const string& name, const string& category, double price, const string& photo) {
            // Mencari produk berdasarkan ID menggunakan find_if
            auto it = find_if(products.begin(), products.end(), [id](const Product& p) { return p.getId() == id; });
            if (it != products.end()) { // Jika produk ditemukan
                it->setName(name);       // Perbarui nama produk
                it->setCategory(category); // Perbarui kategori
                it->setPrice(price);     // Perbarui harga
                it->setPhoto(photo);     // Perbarui foto
                cout << "Produk berhasil diperbarui.\n";
            } else { // Jika produk tidak ditemukan
                cout << "Produk dengan ID " << id << " tidak ditemukan.\n";
            }
        }
    
        // Fungsi untuk menghapus produk berdasarkan ID
        void deleteProduct(int id) {
            // Mencari produk berdasarkan ID menggunakan find_if
            auto it = find_if(products.begin(), products.end(), [id](const Product& p) { return p.getId() == id; });
            if (it != products.end()) { // Jika produk ditemukan
                products.erase(it); // Hapus produk dari daftar
                cout << "Produk berhasil dihapus.\n";
            } else { // Jika produk tidak ditemukan
                cout << "Produk dengan ID " << id << " tidak ditemukan.\n";
            }
        }
    
        // Fungsi untuk mencari produk berdasarkan nama
        void searchProductByName(const string& name) const {
            bool found = false; // Variabel untuk menandai apakah produk ditemukan atau tidak
            for (const auto& product : products) { // Loop melalui semua produk
                if (product.getName() == name) { // Jika nama produk cocok
                    cout << "ID: " << product.getId() << "\n";
                    cout << "Nama Produk: " << product.getName() << "\n";
                    cout << "Kategori: " << product.getCategory() << "\n";
                    cout << "Harga: Rp" << product.getPrice() << "\n";
                    cout << "Foto: " << product.getPhoto() << "\n";
                    cout << "-------------------------\n";
                    found = true;
                }
            }
    
            if (!found) { // Jika tidak ditemukan
                cout << "Produk dengan nama '" << name << "' tidak ditemukan.\n";
            }
        }
    };