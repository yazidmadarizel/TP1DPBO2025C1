from tabulate import tabulate

class PetShop:
    def __init__(self):
        # Inisialisasi atribut privat untuk menyimpan data produk
        self._product_ids = []          # List untuk menyimpan ID produk
        self._product_names = []       # List untuk menyimpan nama produk
        self._product_categories = []  # List untuk menyimpan kategori produk
        self._product_prices = []      # List untuk menyimpan harga produk
        self._product_photos = []      # List untuk menyimpan foto produk
        self._next_id = 1              # Variabel untuk menghasilkan ID otomatis

    # Getter untuk mendapatkan list ID produk
    def get_product_ids(self):
        return self._product_ids

    # Setter untuk mengatur ID produk pada indeks tertentu
    def set_product_id(self, index, id):
        if 0 <= index < len(self._product_ids):  # Validasi indeks
            self._product_ids[index] = id
        else:
            print("Indeks tidak valid!")  # Pesan error jika indeks tidak valid

    # Getter untuk mendapatkan list nama produk
    def get_product_names(self):
        return self._product_names

    # Setter untuk mengatur nama produk pada indeks tertentu
    def set_product_name(self, index, name):
        if 0 <= index < len(self._product_names):  # Validasi indeks
            self._product_names[index] = name
        else:
            print("Indeks tidak valid!")  # Pesan error jika indeks tidak valid

    # Getter untuk mendapatkan list kategori produk
    def get_product_categories(self):
        return self._product_categories

    # Setter untuk mengatur kategori produk pada indeks tertentu
    def set_product_category(self, index, category):
        if 0 <= index < len(self._product_categories):  # Validasi indeks
            self._product_categories[index] = category
        else:
            print("Indeks tidak valid!")  # Pesan error jika indeks tidak valid

    # Getter untuk mendapatkan list harga produk
    def get_product_prices(self):
        return self._product_prices

    # Setter untuk mengatur harga produk pada indeks tertentu
    def set_product_price(self, index, price):
        if 0 <= index < len(self._product_prices) and price >= 0:  # Validasi indeks dan harga
            self._product_prices[index] = price
        else:
            print("Harga tidak boleh negatif atau indeks tidak valid!")  # Pesan error jika tidak valid

    # Getter untuk mendapatkan list foto produk
    def get_product_photos(self):
        return self._product_photos

    # Setter untuk mengatur foto produk pada indeks tertentu
    def set_product_photo(self, index, photo):
        if 0 <= index < len(self._product_photos):  # Validasi indeks
            self._product_photos[index] = photo
        else:
            print("Indeks tidak valid!")  # Pesan error jika indeks tidak valid

    # Getter untuk mendapatkan ID berikutnya
    def get_next_id(self):
        return self._next_id

    # Method untuk menampilkan semua produk dalam bentuk tabel
    def display_products(self):
        if not self._product_ids:  # Cek apakah list produk kosong
            print("Tidak ada produk yang tersedia.")
            return
        
        # Membuat list of lists untuk data produk
        table_data = []
        for i in range(len(self._product_ids)):
            table_data.append([
                self._product_ids[i],
                self._product_names[i],
                self._product_categories[i],
                f"Rp{self._product_prices[i]}",
                self._product_photos[i]
            ])
        
        # Menampilkan tabel menggunakan tabulate
        headers = ["ID", "Nama", "Kategori", "Harga", "Foto"]
        print(tabulate(table_data, headers=headers, tablefmt="pretty"))

    # Method untuk menambahkan produk baru
    def add_product(self, name, category, price, photo):
        if price < 0:  # Validasi harga tidak boleh negatif
            print("Harga tidak boleh negatif!")
            return
        # Menambahkan data produk ke dalam list
        self._product_ids.append(self._next_id)
        self._next_id += 1  # Increment ID untuk produk berikutnya
        self._product_names.append(name)
        self._product_categories.append(category)
        self._product_prices.append(price)
        self._product_photos.append(photo)
        print("Produk berhasil ditambahkan.")

    # Method untuk memperbarui produk
    def update_product(self, id, name, category, price, photo):
        if id in self._product_ids:  # Cek apakah ID produk ada
            index = self._product_ids.index(id)  # Cari indeks produk berdasarkan ID
            # Update data produk menggunakan setter
            self.set_product_name(index, name)
            self.set_product_category(index, category)
            self.set_product_price(index, price)
            self.set_product_photo(index, photo)
            print("Produk berhasil diperbarui.")
        else:
            print(f"Produk dengan ID {id} tidak ditemukan.")  # Pesan error jika ID tidak ditemukan

    # Method untuk menghapus produk
    def delete_product(self, id):
        if id in self._product_ids:  # Cek apakah ID produk ada
            index = self._product_ids.index(id)  # Cari indeks produk berdasarkan ID
            # Hapus data produk dari semua list
            self._product_ids.pop(index)
            self._product_names.pop(index)
            self._product_categories.pop(index)
            self._product_prices.pop(index)
            self._product_photos.pop(index)
            print("Produk berhasil dihapus.")
        else:
            print(f"Produk dengan ID {id} tidak ditemukan.")  # Pesan error jika ID tidak ditemukan

    # Method untuk mencari produk berdasarkan nama
    def search_product_by_name(self, name):
        found = False  # Flag untuk menandai apakah produk ditemukan
        table_data = []  # List untuk menyimpan data produk yang ditemukan
        # Loop untuk mencari produk berdasarkan nama
        for i in range(len(self._product_names)):
            if self._product_names[i] == name:
                # Tambahkan data produk ke dalam list
                table_data.append([
                    self._product_ids[i],
                    self._product_names[i],
                    self._product_categories[i],
                    f"Rp{self._product_prices[i]}",
                    self._product_photos[i]
                ])
                found = True  # Set flag menjadi True
        
        if found:  # Jika produk ditemukan
            headers = ["ID", "Nama", "Kategori", "Harga", "Foto"]
            print(tabulate(table_data, headers=headers, tablefmt="pretty"))
        else:  # Jika produk tidak ditemukan
            print(f"Produk dengan nama '{name}' tidak ditemukan.")


def main():
    my_pet_shop = PetShop()  # Membuat objek PetShop
    while True:
        # Menampilkan menu utama
        print("\n=== SISTEM MANAJEMEN PETSHOP ===")
        print("1. Tampilkan Data Produk")
        print("2. Tambah Produk Baru")
        print("3. Perbarui Produk")
        print("4. Hapus Produk")
        print("5. Cari Produk Berdasarkan Nama")
        print("6. Keluar")
        choice = input("Pilih menu (1-6): ")  # Input pilihan menu dari pengguna

        if choice == "1":
            my_pet_shop.display_products()  # Tampilkan semua produk
        elif choice == "2":
            # Input data produk baru
            name = input("Masukkan Nama: ")
            category = input("Masukkan Kategori: ")
            price = float(input("Masukkan Harga: "))
            photo = input("Masukkan Foto: ")
            my_pet_shop.add_product(name, category, price, photo)  # Tambahkan produk baru
        elif choice == "3":
            # Input data untuk memperbarui produk
            id = int(input("Masukkan ID Produk: "))
            name = input("Masukkan Nama: ")
            category = input("Masukkan Kategori: ")
            price = float(input("Masukkan Harga: "))
            photo = input("Masukkan Foto: ")
            my_pet_shop.update_product(id, name, category, price, photo)  # Perbarui produk
        elif choice == "4":
            # Input ID produk yang akan dihapus
            id = int(input("Masukkan ID Produk: "))
            my_pet_shop.delete_product(id)  # Hapus produk
        elif choice == "5":
            # Input nama produk yang akan dicari
            name = input("Masukkan Nama Produk: ")
            my_pet_shop.search_product_by_name(name)  # Cari produk berdasarkan nama
        elif choice == "6":
            print("Terima kasih!")  # Keluar dari program
            break
        else:
            print("Pilihan tidak valid!")  # Pesan error jika pilihan tidak valid


if __name__ == "__main__":
    main()  # Jalankan program utama