# 📋 Aplikasi Manajemen User & Kegiatan (Laravel + React + Blade)

## 1. Pendahuluan

Aplikasi ini dikembangkan untuk keperluan **manajemen data user dan kegiatan**, yang dapat digunakan oleh admin maupun user biasa. Sistem ini menyediakan dua antarmuka:

- **Blade (Laravel View):** Untuk kebutuhan manajemen langsung dari server (SSR).
- **React.js (SPA):** Untuk pengalaman pengguna yang lebih dinamis berbasis REST API.

Fitur-fitur utama:
- Manajemen User: tambah, edit, hapus
- Manajemen Kegiatan: tambah, edit, hapus, upload gambar
- Import User dari Excel
- Dynamic Input untuk field tambahan user
- Role-based Access Control: `admin`, `user`
- Sistem login SPA dengan Laravel Sanctum

---

## 2. Teknologi yang Digunakan

| Stack        | Teknologi                          |
|--------------|-------------------------------------|
| Backend      | Laravel 10+, Sanctum, Laravel Excel |
| Frontend SSR | Blade, TailwindCSS / Bootstrap 5    |
| Frontend SPA | React.js, React Router, Axios       |
| Database     | MySQL / SQLite                      |

---

## 3. Struktur Folder

``` text
├── app/ # Model, Controller Laravel
├── resources/
│ └── views/ # Blade Templates
│ ├── users/ # Index, Create, Edit
│ └── kegiatan/ # Index, Create, Edit
├── public/
│ └── storage/ # Gambar upload
├── frontend/ # React SPA
│ └── src/
│ ├── components/ # Layout, form, dll
│ ├── pages/ # Dashboard, UserForm, UserImport
│ └── App.jsx
├── routes/
│ ├── web.php # Route Blade
│ └── api.php # Route API
```

## 4. Instalasi & Setup

### A. Laravel Backend

```bash
git clone https://github.com/username/nama-proyek.git
cd nama-proyek

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```
### B. React Frontend

```
cd frontend
npm install
npm run dev
```

## 5. Akun Login (Dummy)

| Role  | Email                                   | Password |
| ----- | --------------------------------------- | -------- |
| Admin | [admin@mail.com](mailto:admin@mail.com) | password |
| User  | [user@mail.com](mailto:user@mail.com)   | password |

## 6. Cara Mengakses

| Halaman       | URL Lokal                                                  | Keterangan                |
| ------------- | ---------------------------------------------------------- | ------------------------- |
| Blade View    | [http://localhost:8000/users](http://localhost:8000/users) | Dashboard berbasis server |
| React SPA     | [http://localhost:5173/](http://localhost:5173/)           | SPA berbasis API          |
| Login API SPA | [http://localhost:5173/login](http://localhost:5173/login) | Login menggunakan Sanctum |

## 7. Fitur CRUD

A. User (Blade)

-Tambah/Edit User
-Dynamic Form Fields (dari tabel inputs)
-Import Excel (.xls/.xlsx)
- Role: admin/user
- Validasi lengkap (required, email, password opsional)

B. Kegiatan (Blade)

- Judul, deskripsi, upload gambar
- Tersimpan ke folder storage/app/public/gambar

C. React (SPA)

- Halaman dashboard user/admin
- Form dinamis & validasi
- Terhubung ke API Laravel (Axios)

## 8. API Endpoint Utama

| Endpoint          | Method | Keterangan                |
| ----------------- | ------ | ------------------------- |
| `/api/login`      | POST   | Login via React + Sanctum |
| `/api/users`      | GET    | Ambil semua user          |
| `/api/users/{id}` | GET    | Ambil detail user         |
| `/api/users`      | POST   | Tambah user               |
| `/api/users/{id}` | PUT    | Update user               |
| `/api/users/{id}` | DELETE | Hapus user                |
| `/api/inputs`     | GET    | Ambil dynamic input       |

## 9. Contoh Tampilan

# Blade View (Admin Panel)
![image](https://github.com/user-attachments/assets/5de3e3b9-647d-48ff-a139-f55392a7684a)

# React SPA
![image](https://github.com/user-attachments/assets/76ba0d61-bd31-4eae-8c8e-5092953bb5dd)

## 10. Kesimpulan
Aplikasi ini menunjukkan implementasi multi frontend (SSR dan SPA) yang saling terhubung ke satu backend Laravel. Penggunaan dynamic form dan import Excel menambah fleksibilitas manajemen data user, serta membiasakan developer dengan konsep API + SPA terpisah.

## 11. Kontak
- Nama: M. Mahameru. A
- Email: mahameru0504@gmail.com
- GitHub: https://github.com/Mahameruuu
