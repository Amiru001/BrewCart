# ☕ BrewCart – Coffee Shop Website

BrewCart is a coffee shop website developed as an early web development project. It was created to practise building a dynamic website using PHP, MySQL, HTML, CSS, and JavaScript.

The website provides a coffee shop interface where visitors can explore products, register for an account, log in, and use basic shopping cart functionality. It also includes an admin area for adding products.

## 📌 Project Overview

BrewCart demonstrates the development of a simple dynamic e-commerce-style website, including frontend design, server-side PHP processing, database connectivity, and basic user management.

**Project Type:** Individual Learning Project  
**Category:** Web Development / Coffee Shop Website  
**Backend:** PHP  
**Database:** MySQL

## ✨ Features

### Customer Website
- Responsive coffee shop homepage.
- About Us section introducing the coffee shop.
- Dynamic product display using MySQL data.
- Product images, names, and prices.
- Basic add-to-cart functionality.
- Customer registration and login.
- Customer reviews section.
- Contact information and social media section.

### Admin Area
- Separate admin login.
- Session-based admin access protection.
- Admin dashboard.
- Add new products to the database.
- Upload product images.
- Validate uploaded image types and file sizes.

## 🛠️ Technologies Used

| Technology | Purpose |
|---|---|
| HTML5 | Website structure |
| CSS3 | Website styling and layout |
| JavaScript | Frontend interactions |
| PHP | Server-side development |
| MySQL | Database management |
| Bootstrap 4 | Admin form styling |

## 📂 Project Structure

```text
BrewCart/
│
├── admin_area/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── insert_product.php
│   ├── require_admin.php
│   ├── style1.css
│   └── product_images/
│
├── config/
│   ├── bootstrap.php
│   └── database.php
│
├── database/
│   └── schema.sql
│
├── functions/
│   └── common_functions.php
│
├── images/
│
├── index.php
├── login.html
├── loginHandler.php
├── registrationHandler.php
├── style.css
├── script.js
├── .env.example
├── .gitignore
└── README.md
```

## 🚀 Getting Started

Follow these steps to run BrewCart on your local computer.

### 1. Requirements

Install one of the following local development environments:

- [XAMPP](https://www.apachefriends.org/)
- [WampServer](https://www.wampserver.com/)

The project requires:
- PHP with the `mysqli` and `fileinfo` extensions enabled.
- MySQL or MariaDB.
- Apache web server.

### 2. Clone the Repository

```bash
git clone https://github.com/Amiru001/BrewCart.git
```

Move into the project directory:

```bash
cd BrewCart
```

### 3. Configure the Environment

Copy `.env.example` and create a local `.env` file in the project root.

For Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Open `.env` and update the database configuration according to your local MySQL settings.

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=brewcart
DB_USER=root
DB_PASSWORD=

ADMIN_USERNAME=admin
ADMIN_PASSWORD_HASH=
```

Do not upload your `.env` file to GitHub. It contains local configuration and may contain sensitive information.

### 4. Create the Database

1. Start Apache and MySQL from XAMPP or WAMP.
2. Open phpMyAdmin.
3. Import the SQL file located at `database/schema.sql`.
4. The script creates the `brewcart` database and the required tables:
   - `products`
   - `user`
   - `cart_details`

The database schema does not contain sample products. Products can be added through the admin area.

### 5. Configure Admin Login

Generate a secure password hash using PHP:

```bash
php -r "echo password_hash('YourOwnPassword', PASSWORD_DEFAULT), PHP_EOL;"
```

Copy the generated hash into the `ADMIN_PASSWORD_HASH` value in your local `.env` file.

Set your preferred admin username using `ADMIN_USERNAME`.

Never commit your actual admin password or `.env` file.

### 6. Run the Website

Place the BrewCart project folder inside your local server's web root:

- XAMPP: `htdocs`
- WAMP: `www`

Start Apache and MySQL.

Open the website in your browser:

```text
http://localhost/BrewCart/
```

To access the admin login:

```text
http://localhost/BrewCart/admin_area/login.php
```

After logging in, use the **Insert Product** option to add products to the website.

## 👨‍💻 Author

**Amiru Pinsara**

GitHub: [@Amiru001](https://github.com/Amiru001)

---

*BrewCart – An early project in my web development journey.*