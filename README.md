# 📦 Aplikasi Manajemen Rekrutmen
```bash

Aplikasi ini merupakan sistem manajemen rekrutmen berbasis Laravel.

## 🚀 Langkah Setelah Clone Project

Ikuti langkah-langkah di bawah ini setelah melakukan `git clone`.

---

## 1. 📥 Clone Project dari GitHub

git clone https://github.com/username/nama-project.git
cd nama-project

# 2. 📦 Instalasi Dependencies
composer install
cp .env.example .env
php artisan key:generate

# Atur konfigurasi database di file .env
# DB_DATABASE=...
# DB_USERNAME=...
# DB_PASSWORD=...

php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve

## 📝 Login

### Akun Admin
Email    : admin@gmail.com
Password : 1234

### Akun HRD
Email    : hrd@gmail.com
Password : 1234

```
