# TP1DPBO2025C1

/*Saya Yazid Madarizel dengan NIM 2305328 mengerjakan
 soal Latihal Modul 1 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.*/

## **Desain Program**  
Program terdiri dari satu class utama, yaitu `PetShop`, yang bertanggung jawab atas manajemen data produk di pet shop.  

**Class: `PetShop`**  
- **Atribut:**  
  - `_product_ids` (List[int]): Menyimpan ID unik setiap produk.  
  - `_product_names` (List[str]): Menyimpan nama produk.  
  - `_product_categories` (List[str]): Menyimpan kategori produk.  
  - `_product_prices` (List[float]): Menyimpan harga produk.  
  - `_product_photos` (List[str]): Menyimpan URL atau path foto produk.  
  - `_next_id` (int): Menyimpan ID berikutnya yang akan digunakan.  

- **Method:**  
  - `add_product(name, category, price, photo)`: Menambahkan produk baru ke sistem.  
  - `update_product(id, name, category, price, photo)`: Memperbarui data produk berdasarkan ID.  
  - `delete_product(id)`: Menghapus produk berdasarkan ID.  
  - `display_products()`: Menampilkan semua produk dalam bentuk tabel.  
  - `search_product_by_name(name)`: Mencari produk berdasarkan nama.  

---

## **Alur Program**  
1. **Menampilkan menu utama**  
   - User disajikan dengan menu pilihan untuk mengelola produk dalam pet shop.  

2. **Menampilkan daftar produk (Pilihan 1)**  
   - Jika tidak ada produk, sistem akan menampilkan pesan "Tidak ada produk yang tersedia".  
   - Jika ada produk, sistem menampilkan daftar produk dalam bentuk tabel.  

3. **Menambahkan produk baru (Pilihan 2)**  
   - User memasukkan nama, kategori, harga, dan foto produk.  
   - Jika harga negatif, sistem akan menampilkan pesan error.  
   - Produk akan ditambahkan ke dalam daftar jika valid.  

4. **Memperbarui produk (Pilihan 3)**  
   - User memasukkan ID produk yang ingin diperbarui.  
   - Jika ID valid, user dapat mengubah nama, kategori, harga, dan foto produk.  
   - Jika ID tidak ditemukan, sistem akan menampilkan pesan error.  

5. **Menghapus produk (Pilihan 4)**  
   - User memasukkan ID produk yang ingin dihapus.  
   - Jika ID valid, produk dihapus dari daftar.  
   - Jika ID tidak ditemukan, sistem akan menampilkan pesan error.  

6. **Mencari produk berdasarkan nama (Pilihan 5)**  
   - User memasukkan nama produk yang ingin dicari.  
   - Jika produk ditemukan, sistem menampilkan informasi produk.  
   - Jika tidak ditemukan, sistem menampilkan pesan error.  

7. **Keluar dari program (Pilihan 6)**  
   - Program akan berhenti setelah menampilkan pesan "Terima kasih!".  
