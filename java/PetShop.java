import java.util.ArrayList; // Mengimpor kelas ArrayList untuk menyimpan data dalam bentuk list
import java.util.List; // Mengimpor interface List untuk mendefinisikan list
import java.util.Scanner; // Mengimpor kelas Scanner untuk menerima input dari pengguna

public class PetShop {
    // Deklarasi list untuk menyimpan data produk
    private List<Integer> productIds; // List untuk menyimpan ID produk
    private List<String> productNames; // List untuk menyimpan nama produk
    private List<String> productCategories; // List untuk menyimpan kategori produk
    private List<Double> productPrices; // List untuk menyimpan harga produk
    private List<String> productPhotos; // List untuk menyimpan foto produk
    private int nextId; // Variabel untuk menghasilkan ID otomatis

    // Konstruktor untuk inisialisasi list dan variabel
    public PetShop() {
        productIds = new ArrayList<>(); // Inisialisasi list ID produk
        productNames = new ArrayList<>(); // Inisialisasi list nama produk
        productCategories = new ArrayList<>(); // Inisialisasi list kategori produk
        productPrices = new ArrayList<>(); // Inisialisasi list harga produk
        productPhotos = new ArrayList<>(); // Inisialisasi list foto produk
        nextId = 1; // Inisialisasi ID awal
    }

    public List<Integer> getProductIds() { return productIds; }
    public List<String> getProductNames() { return productNames; }
    public List<String> getProductCategories() { return productCategories; }
    public List<Double> getProductPrices() { return productPrices; }
    public List<String> getProductPhotos() { return productPhotos; }

    public void setProductName(int index, String name) { productNames.set(index, name); }
    public void setProductCategory(int index, String category) { productCategories.set(index, category); }
    public void setProductPrice(int index, double price) { productPrices.set(index, price); }
    public void setProductPhoto(int index, String photo) { productPhotos.set(index, photo); }


    // Mengambil panjang maksimum dari elemen dalam daftar
    private int getMaxLength(List<?> list) {
        int maxLength = 0; // Inisialisasi panjang maksimum
        for (Object item : list) { // Iterasi setiap item dalam daftar
            int length = item.toString().length(); // Hitung panjang string item
            if (length > maxLength) { // Periksa apakah panjang lebih besar dari maxLength saat ini
                maxLength = length; // Perbarui maxLength
            }
        }
        return maxLength; // Kembalikan panjang maksimum
    }

    // Mengambil panjang maksimum untuk kolom harga
    private int getMaxPriceLength() {
        int maxLength = "Harga".length(); // Inisialisasi dengan panjang kata "Harga"
        for (Double price : getProductPrices()) { // Iterasi setiap harga dalam daftar harga produk
            String priceStr = String.format("Rp%.1f", price); // Format harga menjadi string dengan prefiks "Rp"
            if (priceStr.length() > maxLength) { // Periksa apakah panjang string harga lebih besar dari maxLength saat ini
                maxLength = priceStr.length(); // Perbarui maxLength
            }
        }
        return maxLength; // Kembalikan panjang maksimum untuk harga
    }

    // Membuat garis pemisah dengan karakter tertentu
    private String createLine(int length, char ch) {
        StringBuilder sb = new StringBuilder(); // Gunakan StringBuilder untuk efisiensi
        for (int i = 0; i < length; i++) { // Iterasi sebanyak length
            sb.append(ch); // Tambahkan karakter ke StringBuilder
        }
        return sb.toString(); // Kembalikan string hasil
    }

    // Memformat string agar memiliki panjang tetap dengan padding ke kanan
    private String padString(String str, int length) {
        return String.format("%-" + length + "s", str); // Gunakan format string untuk padding
    }

    // Menampilkan tabel produk
    public void displayProducts() {
        if (getProductIds().isEmpty()) { // Periksa apakah daftar produk kosong
            System.out.println("Tidak ada produk yang tersedia."); // Cetak pesan jika kosong
            return; // Keluar dari metode
        }

        // Menghitung lebar maksimum untuk setiap kolom
        int idWidth = Math.max(getMaxLength(getProductIds()), "ID".length());
        int nameWidth = Math.max(getMaxLength(getProductNames()), "Nama".length());
        int categoryWidth = Math.max(getMaxLength(getProductCategories()), "Kategori".length());
        int priceWidth = getMaxPriceLength();
        int photoWidth = Math.max(getMaxLength(getProductPhotos()), "Foto".length());

        // Menghitung total lebar tabel dengan tambahan 13 karakter untuk pemisah
        int totalWidth = idWidth + nameWidth + categoryWidth + priceWidth + photoWidth + 13;

        // Mencetak garis atas tabel
        String headerLine = createLine(totalWidth + 3, '-'); // Buat garis header
        System.out.println(headerLine); // Cetak garis header

        // Mencetak header tabel
        System.out.printf("| %s | %s | %s | %s | %s |\n",
            padString("ID", idWidth),
            padString("Nama", nameWidth),
            padString("Kategori", categoryWidth),
            padString("Harga", priceWidth),
            padString("Foto", photoWidth));
        System.out.println(headerLine); // Cetak garis pemisah header

        // Mencetak isi tabel
        for (int i = 0; i < getProductIds().size(); i++) {
            String priceStr = String.format("Rp%.1f", getProductPrices().get(i)); // Format harga
            System.out.printf("| %s | %s | %s | %s | %s |\n",
                padString(getProductIds().get(i).toString(), idWidth),
                padString(getProductNames().get(i), nameWidth),
                padString(getProductCategories().get(i), categoryWidth),
                padString(priceStr, priceWidth),
                padString(getProductPhotos().get(i), photoWidth));
        }
        System.out.println(headerLine); // Cetak garis bawah tabel
    }


// Metode untuk menambahkan produk baru
public void addProduct(String name, String category, double price, String photo) {
    // Cek jika harga negatif
    if (price < 0) { 
        // Pesan error jika harga negatif
        System.out.println("Harga tidak boleh negatif!"); 
        return; // Menghentikan metode jika harga negatif
    }
    
    // Menambahkan ID produk baru ke dalam daftar ID produk
    getProductIds().add(nextId++);
    
    // Menambahkan nama produk ke dalam daftar nama produk
    getProductNames().add(name);
    
    // Menambahkan kategori produk ke dalam daftar kategori produk
    getProductCategories().add(category);
    
    // Menambahkan harga produk ke dalam daftar harga produk
    getProductPrices().add(price);
    
    // Menambahkan foto produk ke dalam daftar foto produk
    getProductPhotos().add(photo);
    
    // Pesan sukses setelah produk berhasil ditambahkan
    System.out.println("Produk berhasil ditambahkan."); 
}


    // Metode untuk memperbarui produk berdasarkan ID
// Metode untuk memperbarui produk berdasarkan ID
public void updateProduct(int id, String name, String category, double price, String photo) {
    // Mencari indeks produk berdasarkan ID
    int index = getProductIds().indexOf(id);
    
    // Jika produk ditemukan (index != -1)
    if (index != -1) {
        // Memperbarui nama produk pada indeks yang ditemukan
        setProductName(index, name);
        
        // Memperbarui kategori produk pada indeks yang ditemukan
        setProductCategory(index, category);
        
        // Memperbarui harga produk pada indeks yang ditemukan
        setProductPrice(index, price);
        
        // Memperbarui foto produk pada indeks yang ditemukan
        setProductPhoto(index, photo);
        
        // Pesan sukses setelah produk berhasil diperbarui
        System.out.println("Produk berhasil diperbarui.");
    } else {
        // Pesan error jika produk dengan ID tersebut tidak ditemukan
        System.out.println("Produk dengan ID " + id + " tidak ditemukan.");
    }
}

    // Metode untuk menghapus produk berdasarkan ID
// Metode untuk menghapus produk berdasarkan ID
public void deleteProduct(int id) {
    // Mencari indeks produk berdasarkan ID
    int index = getProductIds().indexOf(id);
    
    // Jika produk ditemukan (index != -1)
    if (index != -1) {
        // Menghapus ID produk pada indeks yang ditemukan
        getProductIds().remove(index);
        
        // Menghapus nama produk pada indeks yang ditemukan
        getProductNames().remove(index);
        
        // Menghapus kategori produk pada indeks yang ditemukan
        getProductCategories().remove(index);
        
        // Menghapus harga produk pada indeks yang ditemukan
        getProductPrices().remove(index);
        
        // Menghapus foto produk pada indeks yang ditemukan
        getProductPhotos().remove(index);
        
        // Pesan sukses setelah produk berhasil dihapus
        System.out.println("Produk berhasil dihapus.");
    } else {
        // Pesan error jika produk dengan ID tersebut tidak ditemukan
        System.out.println("Produk dengan ID " + id + " tidak ditemukan.");
    }
}


    // Metode untuk mencari produk berdasarkan nama
public void searchProductByName(String name) {
    // Variabel untuk menandai apakah produk ditemukan
    boolean found = false;
    
    // Daftar untuk menyimpan indeks produk yang cocok
    List<Integer> matchingIndexes = new ArrayList<>();
    
    // Mencari produk dengan nama yang mengandung string pencarian (case-insensitive)
    for (int i = 0; i < getProductNames().size(); i++) {
        // Jika nama produk mengandung nama pencarian, tambahkan indeksnya ke dalam daftar matchingIndexes
        if (getProductNames().get(i).toLowerCase().contains(name.toLowerCase())) {
            matchingIndexes.add(i);
            found = true;
        }
    }

    // Jika tidak ada produk yang ditemukan, tampilkan pesan error
    if (!found) {
        System.out.println("Produk dengan nama '" + name + "' tidak ditemukan.");
        return; // Menghentikan eksekusi jika tidak ada produk yang ditemukan
    }

    // Menghitung panjang kolom berdasarkan panjang data produk yang ada
    int idWidth = Math.max(getMaxLength(getProductIds()), "ID".length());
    int nameWidth = Math.max(getMaxLength(getProductNames()), "Nama".length());
    int categoryWidth = Math.max(getMaxLength(getProductCategories()), "Kategori".length());
    int priceWidth = getMaxPriceLength();
    int photoWidth = Math.max(getMaxLength(getProductPhotos()), "Foto".length());
    
    // Menghitung lebar total untuk mencetak tabel
    int totalWidth = idWidth + nameWidth + categoryWidth + priceWidth + photoWidth + 13;

    // Membuat garis pemisah untuk header tabel
    String headerLine = createLine(totalWidth + 3, '-');
    
    // Menampilkan header hasil pencarian
    System.out.println("\nHasil pencarian untuk '" + name + "':");
    System.out.println(headerLine);
    
    // Menampilkan header kolom
    System.out.printf("| %s | %s | %s | %s | %s |\n",
        padString("ID", idWidth),
        padString("Nama", nameWidth),
        padString("Kategori", categoryWidth),
        padString("Harga", priceWidth),
        padString("Foto", photoWidth));
    
    System.out.println(headerLine);

    // Menampilkan informasi produk yang ditemukan
    for (int index : matchingIndexes) {
        String priceStr = String.format("Rp%.1f", getProductPrices().get(index));
        
        // Menampilkan data produk dalam format tabel
        System.out.printf("| %s | %s | %s | %s | %s |\n",
            padString(getProductIds().get(index).toString(), idWidth),
            padString(getProductNames().get(index), nameWidth),
            padString(getProductCategories().get(index), categoryWidth),
            padString(priceStr, priceWidth),
            padString(getProductPhotos().get(index), photoWidth));
    }
    
    // Menampilkan garis pemisah di bawah tabel
    System.out.println(headerLine);
}


    
    // Metode utama untuk menjalankan program
    public static void main(String[] args) {
        PetShop myPetShop = new PetShop(); // Buat objek PetShop
        Scanner scanner = new Scanner(System.in); // Buat objek Scanner untuk input
        int choice, id; // Variabel untuk pilihan menu dan ID produk
        String name, category, photo; // Variabel untuk nama, kategori, dan foto produk
        double price; // Variabel untuk harga produk

        do {
            // Menampilkan menu
            System.out.println("\n=== SISTEM MANAJEMEN PETSHOP ===");
            System.out.println("1. Tampilkan Data Produk");
            System.out.println("2. Tambah Produk Baru");
            System.out.println("3. Perbarui Produk");
            System.out.println("4. Hapus Produk");
            System.out.println("5. Cari Produk Berdasarkan Nama");
            System.out.println("6. Keluar");
            System.out.print("Pilih menu (1-6): ");
            choice = scanner.nextInt(); // Menerima input pilihan menu

            switch (choice) {
                case 1:
                    myPetShop.displayProducts(); // Tampilkan semua produk
                    break;
                case 2:
                    System.out.print("Masukkan Nama: ");
                    scanner.nextLine(); // Membersihkan buffer
                    name = scanner.nextLine(); // Menerima input nama
                    System.out.print("Masukkan Kategori: ");
                    category = scanner.nextLine(); // Menerima input kategori
                    System.out.print("Masukkan Harga: ");
                    price = scanner.nextDouble(); // Menerima input harga
                    System.out.print("Masukkan Foto: ");
                    scanner.nextLine(); // Membersihkan buffer
                    photo = scanner.nextLine(); // Menerima input foto
                    myPetShop.addProduct(name, category, price, photo); // Tambahkan produk baru
                    break;
                case 3:
                    System.out.print("Masukkan ID Produk: ");
                    id = scanner.nextInt(); // Menerima input ID produk
                    System.out.print("Masukkan Nama: ");
                    scanner.nextLine(); // Membersihkan buffer
                    name = scanner.nextLine(); // Menerima input nama
                    System.out.print("Masukkan Kategori: ");
                    category = scanner.nextLine(); // Menerima input kategori
                    System.out.print("Masukkan Harga: ");
                    price = scanner.nextDouble(); // Menerima input harga
                    System.out.print("Masukkan Foto: ");
                    scanner.nextLine(); // Membersihkan buffer
                    photo = scanner.nextLine(); // Menerima input foto
                    myPetShop.updateProduct(id, name, category, price, photo); // Perbarui produk
                    break;
                case 4:
                    System.out.print("Masukkan ID Produk: ");
                    id = scanner.nextInt(); // Menerima input ID produk
                    myPetShop.deleteProduct(id); // Hapus produk
                    break;
                case 5:
                    System.out.print("Masukkan Nama Produk: ");
                    scanner.nextLine(); // Membersihkan buffer
                    name = scanner.nextLine(); // Menerima input nama
                    myPetShop.searchProductByName(name); // Cari produk berdasarkan nama
                    break;
                case 6:
                    System.out.println("Terima kasih!"); // Pesan keluar
                    break;
                default:
                    System.out.println("Pilihan tidak valid!"); // Pesan error untuk pilihan tidak valid
            }
        } while (choice != 6); // Ulangi sampai pengguna memilih keluar

        scanner.close(); // Tutup Scanner
    }
}