# TP1DPBO2025C1

/*Saya Yazid Madarizel dengan NIM 2305328 mengerjakan
 soal TP 1 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.*/

## **Desain Program**  
Program terdiri dari satu class utama, yaitu PetShop, yang bertanggung jawab atas manajemen data produk di pet shop. PetShop memiliki atribut untuk menyimpan ID unik produk, nama, kategori, harga, serta foto produk, dengan _next_id sebagai penanda ID berikutnya. Metode dalam class ini mencakup add_product() untuk menambahkan produk baru, update_product() untuk memperbarui data produk berdasarkan ID, delete_product() untuk menghapus produk, display_products() untuk menampilkan daftar produk dalam bentuk tabel, serta search_product_by_name() untuk mencari produk berdasarkan nama.  

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

Berikut adalah alur program dalam bentuk yang lebih terstruktur untuk PHP:  

---

## **Alur Program dalam PHP**

1. **Inisialisasi Session dan Objek PetShop**  
   - Program memulai sesi PHP (`session_start()`) untuk menyimpan data produk.  
   - Kelas `PetShop` dibuat untuk mengelola produk.  

2. **Menampilkan Menu Utama**  
   - Halaman utama menampilkan daftar produk dalam bentuk tabel.  
   - Terdapat opsi untuk menambah, mengubah, menghapus, dan mencari produk.  

3. **Menampilkan Daftar Produk (Default View)**  
   - Mengambil data dari sesi (`$_SESSION['products']`).  
   - Jika tidak ada produk, tampilkan pesan "Tidak ada produk yang tersedia".  
   - Jika ada, tampilkan daftar produk dalam tabel dengan kolom ID, Nama, Kategori, Harga, dan Foto.  

4. **Menambahkan Produk Baru**  
   - User mengisi formulir dengan `nama`, `kategori`, `harga`, dan mengunggah `foto`.  
   - Jika harga negatif, tampilkan pesan error.  
   - File foto disimpan dalam folder `uploads/`.  
   - Data produk disimpan dalam `$_SESSION['products']`.  

5. **Memperbarui Produk**  
   - User memasukkan ID produk yang ingin diperbarui.  
   - Jika ID ditemukan, user dapat mengubah nama, kategori, harga, dan foto.  
   - Jika tidak ada foto baru, gunakan foto lama.  
   - Jika ID tidak valid, tampilkan pesan error.  

6. **Menghapus Produk**  
   - User memasukkan ID produk yang ingin dihapus.  
   - Produk dihapus dari `$_SESSION['products']`.  
   - Jika ID tidak ditemukan, tampilkan pesan error.  

7. **Mencari Produk Berdasarkan Nama**  
   - User memasukkan nama produk untuk pencarian.  
   - Program melakukan pencarian menggunakan `stripos()` untuk menemukan produk dengan nama yang mirip.  
   - Jika ditemukan, hanya produk yang sesuai yang ditampilkan.  
   - Jika tidak ada hasil, tampilkan pesan error.  

8. **Keluar dari Program**  
   - User dapat menutup browser atau menghapus sesi (`session_destroy()`) untuk mereset data produk.  

