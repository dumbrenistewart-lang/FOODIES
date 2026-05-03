# 🍔 Foodies — PHP Shopping Cart

A PHP/MySQL food ordering web application with a customer-facing shop and a password-protected admin panel.

---

## 📋 Requirements

| Requirement | Version |
|-------------|---------|
| PHP | 7.4 or higher |
| MySQL / MariaDB | 5.7 / 10.3 or higher |
| Web server | Apache (XAMPP/WAMP/LAMP) or Nginx |

---

## 🚀 Installation & Setup

### 1. Place the project files

Copy the entire `shoppingcart/` folder into your web server's root directory:

- **XAMPP (Windows/macOS):** `C:/xampp/htdocs/shoppingcart/`
- **WAMP (Windows):** `C:/wamp64/www/shoppingcart/`
- **Linux/LAMP:** `/var/www/html/shoppingcart/`

### 2. Create the database

Open **phpMyAdmin** (usually at `http://localhost/phpmyadmin`) or a MySQL shell and run **one** of the following SQL files (they are equivalent — pick the most complete one):

```
setup_db.sql      ← Recommended: creates DB, all tables, sample products, and admin user
```

To run via MySQL shell:
```bash
mysql -u root -p < setup_db.sql
```

### 3. Configure the database connection

Open `config.php` and update the credentials to match your MySQL setup:

```php
$conn = mysqli_connect('localhost', 'root', '', 'shop_db');
//                      ^host        ^user   ^pass  ^db name
```

### 4. Set folder permissions

Make sure the `uploaded_img/` folder is writable by the web server (needed for product image uploads):

```bash
chmod 775 uploaded_img/
```

### 5. Open the website

Navigate to:
```
http://localhost/shoppingcart/products.php
```

---

## 🔐 Default Login Credentials

### Admin Account

| Field    | Value      |
|----------|------------|
| Username | `admin`    |
| Password | `Admin@123` |
| URL      | `http://localhost/shoppingcart/admin.php` |

> ⚠️ **IMPORTANT:** Change the admin password immediately after your first login by updating the password hash in your database. The username is **not** case-sensitive — `Admin`, `ADMIN`, and `admin` all work.

### Regular Users

Regular users self-register at:
```
http://localhost/shoppingcart/register.php
```

New registrations are always assigned the `user` role automatically.

---

## 📁 File Structure

```
shoppingcart/
├── config.php          — Database connection settings
├── header.php          — Shared navigation header
├── auth_check.php      — Login/admin session helper functions
│
├── products.php        — Main shop page (browse & add to cart)
├── cart.php            — Shopping cart view
├── checkout.php        — Order checkout form
│
├── login.php           — Login page (case-insensitive username)
├── register.php        — New user registration
├── logout.php          — Ends session and redirects to login
│
├── admin.php           — Admin panel (add / edit / delete products)
├── seed_admin.php      — One-time script to create the admin account
│                         DELETE THIS FILE after running it
│
├── setup_db.sql        — Full database setup (recommended)
├── setup_users.sql     — Users table + admin account only
├── shop_db.sql         — Alternative setup script
│
├── css/style.css       — Main stylesheet
├── js/script.js        — Frontend JavaScript
├── images/             — Static product images
└── uploaded_img/       — Product images uploaded via admin panel
```

---

## 🖥️ Pages Overview

### Customer Pages

| Page | URL | Description |
|------|-----|-------------|
| Products | `/products.php` | Browse all available food items |
| Cart | `/cart.php` | View items added to cart |
| Checkout | `/checkout.php` | Enter delivery details and place order |
| Login | `/login.php` | Sign in to your account |
| Register | `/register.php` | Create a new customer account |

### Admin Pages

| Page | URL | Access |
|------|-----|--------|
| Admin Panel | `/admin.php` | Admin only |

---

## 🛠️ Admin Panel Guide

Access the admin panel at `http://localhost/shoppingcart/admin.php` using the admin credentials above.

### Adding a Product
1. Fill in the **Product Name** and **Price** fields.
2. Choose a product **image** (PNG, JPG, or JPEG).
3. Click **Add the Product**.

### Editing a Product
1. In the product table, click the **Update** button next to the product.
2. Modify the name, price, or image in the edit form that appears.
3. Click **Update the Product**.

### Deleting a Product
1. Click the **Delete** button next to the product.
2. Confirm the deletion in the prompt.

---

## 🔒 Login Behaviour

- **Usernames are case-insensitive** — `Admin`, `admin`, and `ADMIN` are treated identically.
- **Passwords are case-sensitive** — `Admin@123` ≠ `admin@123`.
- After login, admins are automatically redirected to `admin.php`; regular users go to `products.php`.
- Attempting to access `admin.php` without admin privileges redirects to `products.php`.

---

## ⚙️ Alternative Admin Setup (seed_admin.php)

If the SQL file doesn't create the admin account correctly, you can use `seed_admin.php`:

1. Open `http://localhost/shoppingcart/seed_admin.php` in your browser.
2. You should see a green success message.
3. **Delete `seed_admin.php` from the server immediately** — leaving it accessible is a security risk.

---

## 🐛 Troubleshooting

| Problem | Likely Cause | Fix |
|---------|-------------|-----|
| "connection failed" on any page | Wrong DB credentials | Edit `config.php` |
| Admin login rejected | Wrong password in DB | Re-run `setup_db.sql` or use `seed_admin.php` |
| Images not showing after upload | `uploaded_img/` not writable | Run `chmod 775 uploaded_img/` |
| Blank white page | PHP errors suppressed | Enable error reporting or check server logs |
| "no account found" on login | Username mismatch | Username is stored lowercase; try typing in lowercase |

---

## 🔑 Security Notes

1. **Change the default admin password** as soon as the site is running.
2. **Delete `seed_admin.php`** after first use.
3. Do not expose `config.php` — move it above the web root in production.
4. The `admin.php` product queries use `mysqli_query` directly — consider switching to prepared statements for all queries before deploying to production.
