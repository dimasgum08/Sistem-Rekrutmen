# 📦 Aplikasi Manajemen Rekrutmen

Aplikasi ini merupakan sistem manajemen rekrutmen berbasis Laravel.

## 🚀 Langkah Setelah Clone Project

Ikuti langkah-langkah di bawah ini setelah melakukan `git clone`.

---

## 1. 📥 Clone Project dari GitHub

```bash
git clone https://github.com/username/nama-project.git
cd nama-project


# 2. 📦 Instalasi Dependencies
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate

# Atur konfigurasi database di file .env
# DB_DATABASE=...
# DB_USERNAME=...
# DB_PASSWORD=...

php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

## 📝 Penggunaan

### Akun Admin
Email    : admin@gmail.com
Password : 1234

### Akun HRD
Email    : hrd@gmail.com
Password : 1234


