#include "PetShop.cpp" // Mengimpor file PetShop.cpp yang berisi implementasi kelas PetShop

int main() {
    PetShop myPetShop; // Membuat objek PetShop untuk mengelola data produk
    int choice, id; // Variabel untuk menyimpan pilihan menu dan ID produk
    string name, category, photo; // Variabel untuk menyimpan nama, kategori, dan foto produk
    double price; // Variabel untuk menyimpan harga produk

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
        cin >> choice; // Menerima input pilihan dari pengguna

        switch (choice) {
            case 1:
                myPetShop.displayProducts(); // Memanggil fungsi untuk menampilkan daftar produk
                break;
            case 2:
                cout << "Masukkan Nama: ";
                cin.ignore(); // Mengabaikan karakter newline dari input sebelumnya
                getline(cin, name); // Menerima input nama produk
                cout << "Masukkan Kategori: ";
                getline(cin, category); // Menerima input kategori produk
                cout << "Masukkan Harga: ";
                cin >> price; // Menerima input harga produk
                cout << "Masukkan Foto: ";
                cin.ignore(); // Mengabaikan karakter newline dari input sebelumnya
                getline(cin, photo); // Menerima input URL atau path foto produk
                myPetShop.addProduct(name, category, price, photo); // Menambahkan produk baru ke sistem
                break;
            case 3:
                cout << "Masukkan ID Produk: ";
                cin >> id; // Menerima input ID produk yang akan diperbarui
                cout << "Masukkan Nama: ";
                cin.ignore();
                getline(cin, name); // Menerima input nama baru produk
                cout << "Masukkan Kategori: ";
                getline(cin, category); // Menerima input kategori baru produk
                cout << "Masukkan Harga: ";
                cin >> price; // Menerima input harga baru produk
                cout << "Masukkan Foto: ";
                cin.ignore();
                getline(cin, photo); // Menerima input foto baru produk
                myPetShop.updateProduct(id, name, category, price, photo); // Memperbarui data produk berdasarkan ID
                break;
            case 4:
                cout << "Masukkan ID Produk: ";
                cin >> id; // Menerima input ID produk yang akan dihapus
                myPetShop.deleteProduct(id); // Menghapus produk berdasarkan ID
                break;
            case 5:
                cout << "Masukkan Nama Produk: ";
                cin.ignore();
                getline(cin, name); // Menerima input nama produk yang akan dicari
                myPetShop.searchProductByName(name); // Mencari produk berdasarkan nama
                break;
            case 6:
                cout << "Terima kasih!\n"; // Menampilkan pesan keluar
                break;
            default:
                cout << "Pilihan tidak valid!\n"; // Menampilkan pesan jika input tidak valid
        }
    } while (choice != 6); // Mengulang menu sampai pengguna memilih opsi keluar (6)

    return 0; // Mengembalikan 0 untuk menunjukkan program selesai dengan sukses
}
