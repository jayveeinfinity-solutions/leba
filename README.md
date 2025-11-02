# 🛍️ Leba E-Commerce

Leba E-Commerce is a simple **PHP-based e-commerce system** built entirely from scratch — **no frameworks required**.  
It features a custom database class (`IB_Database`), an autoloading system for controllers and seeders, plus migration and seeding tools to quickly set up your database.

---

## ⚙️ System Requirements

Before installing, ensure your system meets these requirements:

| Component | Version | Notes |
|------------|----------|-------|
| **PHP** | 7.4 or higher | Required for running the project |
| **MySQL** | 8.0 or higher | Used as the main database |
| **Apache Web Server** | Included with XAMPP or Laravel Herd | Required for serving the project |
| **Git** | Latest | To clone the repository |

---

## 🧰 Recommended Development Setup

### ✅ Option 1: Using [Laravel Herd](https://herd.laravel.com/)
1. Install **Laravel Herd** on your computer.
2. Make sure PHP and MySQL services are running.
3. Place this project in your Herd directory, e.g.:
   ```
   ~/Herd/leba
   ```
4. Access the site in your browser:
   ```
   https://leba.test
   ```

---

### ✅ Option 2: Using [XAMPP](https://www.apachefriends.org/)
1. Download and install **XAMPP**.
2. Open **XAMPP Control Panel** and start **Apache** and **MySQL**.
3. Move the project folder to:
   ```
   C:\xampp\htdocs\leba
   ```
4. Access the site in your browser:
   ```
   http://localhost/leba
   ```

---

## 🚀 Installation Guide

### 1. Clone the Repository
Clone the project from your repository:

```bash
git clone https://github.com/yourusername/leba.git
cd leba
```

---

### 2. Create the Database
Create a new MySQL database named **`leba`**.

You can do this via phpMyAdmin or MySQL CLI:

```sql
CREATE DATABASE leba;
```

---

### 3. Configure Database Connection

Open the file:

```
app/ib_init.php
```

and update the database configuration as needed:

```php
<?php

$GLOBALS['config'] = array(
    'info' => array(
        'appname' => 'Leba E-Commerce',
        'appurl' => 'https://leba.test/'
    ),
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'database' => 'leba',
    )
);
```

> 💡 **Note:**  
> - Default XAMPP MySQL user: `root`  
> - Default password: *(empty)*  
> - Change these values if your setup differs.

---

### 4. Run Database Migrations

Run the migration script to create all required tables:

```bash
php migrate.php
```

This will automatically create the following tables:

- `cart_tbl`
- `collections_tbl`
- `products_tbl`
- `roles_tbl`
- `seeder_log`
- `transactions_tbl`
- `users_tbl`
- `user_informations_tbl`

Each table will be created using `CREATE TABLE IF NOT EXISTS`,  
so running the migration multiple times will not duplicate tables.

---

### 5. Run Seeders (Optional)

If you have seeder classes, run the seeder script to populate default data:

```bash
php seed.php
```

✅ The seeder automatically checks the `seeder_log` table to avoid reseeding the same data.

Example seeder behavior:
- If a seeder has already run, it will be skipped.
- If not, it runs and logs its name into `seeder_log`.

---

### 6. Start Your Local Server

You can start your server using one of the following methods:

#### 🖥️ Using PHP built-in server
```bash
php -S localhost:8000
```
Then open your browser and visit:
```
http://localhost:8000
```

#### 🖥️ Using XAMPP
Start **Apache** from XAMPP Control Panel and visit:
```
http://localhost/leba
```

#### 🖥️ Using Laravel Herd
Once the project is in your Herd directory, simply visit:
```
https://leba.test
```

---

## 🧱 Project Structure

```
leba/
├── app/
│   ├── controllers/
│   │   ├── IB_Database.php
│   │   ├── IB_Collection.php
│   │   ├── IB_DBSeeder.php
│   │   └── ...
│   ├── database/
│   │   ├── migrations/
│   │   │   └── create_tables.php
│   │   └── seeders/
│   │       └── UsersTableSeeder.php
│   ├── ib_init.php
│   └── ...
├── migrate.php
├── seed.php
├── index.php
└── README.md
```

---

## ⚙️ Autoloader Configuration

Your project includes a custom autoloader that detects and loads classes automatically:

| Class Naming | Location | Description |
|---------------|-----------|-------------|
| Starts with `IB_` | `app/controllers/` | Controller classes |
| Contains `Seeder` | `app/database/seeders/` | Seeder classes |

Example usage:

```php
new IB_Collection(); // Loads from app/controllers/
new UsersTableSeeder(); // Loads from app/database/seeders/
```

---

## ⚡ Troubleshooting

| Issue | Solution |
|-------|-----------|
| `Class not found` | Check your class name and autoload path. |
| `Access denied for user 'root'@'localhost'` | Update credentials in `app/ib_init.php`. |
| `Table already exists` | Safe to ignore, migrations use `IF NOT EXISTS`. |
| `Seeder re-runs multiple times` | Ensure `seeder_log` table exists and has a `PRIMARY KEY`. |

---

## 👨‍💻 Author

**Leba E-Commerce Project**  
Developed by **Jayvee Infinity** 💻  
📧 Contact: [jayveeinfinity@gmail.com](mailto:jayveeinfinity@gmail.com)

---

## 🪪 License

This project is licensed under the **MIT License**.  
Feel free to use, modify, and distribute for educational or commercial purposes.

---
