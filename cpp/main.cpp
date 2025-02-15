#include <iostream>
#include "PetShop.cpp"

using namespace std;

int main() {
    PetShop myPetShop;    // Membuat objek PetShop untuk mengelola produk
    int choice;           // Variabel untuk menyimpan pilihan menu pengguna
    int id;              // Variabel untuk menyimpan ID produk
    string name, category, photo;    // Variabel untuk menyimpan data produk
    double price;        // Variabel untuk menyimpan harga produk

    do {
        // Menampilkan menu utama
        cout << "\n=== SISTEM MANAJEMEN PETSHOP ===\n";
        cout << "1. Tampilkan Data Produk\n";
        cout << "2. Tambah Produk Baru\n";
        cout << "3. Perbarui Produk\n";
        cout << "4. Hapus Produk\n";
        cout << "5. Cari Produk Berdasarkan Nama\n";
        cout << "6. Keluar\n";
        cout << "Pilih menu (1-6): ";
        cin >> choice;

        switch (choice) {
            case 1:
                // Menampilkan semua produk yang tersedia
                cout << "\n=== DAFTAR PRODUK ===\n";
                myPetShop.displayProducts();
                break;

            case 2:
                // Menambahkan produk baru
                cout << "\n=== TAMBAH PRODUK BARU ===\n";
                cout << "Masukkan Nama Produk: ";
                cin.ignore();
                getline(cin, name);

                cout << "Masukkan Kategori Produk: ";
                getline(cin, category);

                cout << "Masukkan Harga Produk: ";
                cin >> price;

                cout << "Masukkan Nama File Foto Produk: ";
                cin.ignore();
                getline(cin, photo);

                myPetShop.addProduct(name, category, price, photo);
                break;

            case 3:
                // Memperbarui produk berdasarkan ID
                cout << "\n=== PERBARUI PRODUK ===\n";
                cout << "Masukkan ID Produk yang akan diperbarui: ";
                cin >> id;

                cout << "Masukkan Nama Produk Baru: ";
                cin.ignore();
                getline(cin, name);

                cout << "Masukkan Kategori Produk Baru: ";
                getline(cin, category);

                cout << "Masukkan Harga Produk Baru (Rp): ";
                cin >> price;

                cout << "Masukkan Nama File Foto Produk Baru: ";
                cin.ignore();
                getline(cin, photo);

                myPetShop.updateProduct(id, name, category, price, photo);
                break;

            case 4:
                // Menghapus produk berdasarkan ID
                cout << "\n=== HAPUS PRODUK ===\n";
                cout << "Masukkan ID Produk yang akan dihapus: ";
                cin >> id;
                myPetShop.deleteProduct(id);
                break;

            case 5:
                // Mencari produk berdasarkan nama
                cout << "\n=== CARI PRODUK ===\n";
                cout << "Masukkan Nama Produk yang akan dicari: ";
                cin.ignore();
                getline(cin, name);
                myPetShop.searchProductByName(name);
                break;

            case 6:
                // Keluar dari program
                cout << "\nTerima kasih telah menggunakan sistem manajemen PetShop!\n";
                break;

            default:
                // Menangani input yang tidak valid
                cout << "\nError: Pilihan menu tidak valid! Silakan pilih 1-6.\n";
        }
    } while (choice != 6);

    return 0;
}