Surplus Test by Laravel Framework

Note:
- Pengerjaan menggunakan scaffold yang saya buat sendiri (base CRUD) agar pengerjaan lebih cepat
- Spec API ada di Collection Postman (saya kirim di email beserta link github)
- Ada beberapa kebingungan di alur nya, terutama saat upload image. Karena struktur nya yang many to many. Tapi saya 
  memilih untuk tidak bertanya karena pengerjaan yang dilakukan malam hari, dan timeline sempit, jadi dari pertimbangan 
  saya, saya berusaha mengerjakannya sesuai dengan pemahaman sendiri.
- Saya ada beberapa part pengerjaan. Awalnya direncakan mulai pulang kerja kemarin (senin) dan selesai hari itu juga, 
  tapi karena 
  ada kendala dan saya harus pulang larut malam, maka pengerjaan mundur dan dilanjutkan esok harinya (hari ini, 
  selasa. Pas saat saya memiliki jadwal WFH).
- Tidak menggunakan PHPUnit (Unit Test), karena saya belum terbiasa menggunakan tools tersebut.
- Mohon untuk membaca deskripsi service.
- Update menggunakan method PUT, tapi karena ada bug di PHP. Maka di postman menggunakan method POST, dengan 
  tambahan body ("_method": "PUT")
- Ada Service User, tapi itu bawaan scaffold yg saya buat, jadi saya ga ngoding lagi.

**Penjelesan masing-masing service**:

**Service Category**
- Feature Simple CRUD.

**Service Image**
- Feature Simple CRUD
- Feature Upload dan Hapus Image saat Update & Delete data

**Service Product**
- Feature Simple CRUD
- Feature menambah image saat create & update
- Feature mengupdate image yang telah ada di schema table image saat create/update product (dengan kondisi id dari 
  data image wajib dikirim)
- Feature menghapus image bila ada perubahan image saat create/update product(dengan kondisi id dari data image 
  wajib dikirim)
- Bila id tidak dikirim pada key images, maka akan dianggap penambahan baru data images.
- Images tidak akan terhapus bila relasi di detach atau data produk dihapus. Karena pehaman saya, bila many to many 
  maka data images bisa jadi digunakan oleh produk lain. Tapi bila ada alur yang salah, bisa saya fix tergantung 
  kebutuhan.

**How To Run**:
- Buat DB surplus_test (atau bebas)
- Update .env, sesuai nama credential db (contoh ada di .env example)
- composer install
- php artisan key:generate
- php artisan migrate --seed / php artisan migrate:fresh --seed
- upload gambar untuk seeder dengan nama "foto-ayam.png" (optional)
- php artisan serve
