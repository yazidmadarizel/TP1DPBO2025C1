# TP1DPBO2025C1

/*Saya Yazid Madarizel dengan NIM 2305328 mengerjakan
 soal Latihal Modul 1 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek
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
