# Product Inventory CRUD Application with CodeIgniter 4

This is a basic CRUD (Create, Read, Update, Delete) application built using **PHP 8.2** and **CodeIgniter 4**. The project demonstrates the implementation of CRUD operations with server-side validation, Bootstrap for UI styling, and a simple relational database.

---

## Features
- Product listing.
- Create new products with validation.
- Edit and update existing products.
- Delete products with confirmation.
- CodeIgniter 4's model, controller, and routing structure.

---

## Requirements
- PHP 8.2 or later
- Composer
- MySQL or MariaDB
- Apache/Nginx server with `mod_rewrite` enabled
- CodeIgniter 4 framework

---

## Installation

### Step 1: Clone the Repository
Clone this repository to your local machine:
```bash
git clone https://github.com/avijitca/CodeIgniter-4-CRUD-Product-Inventory.git
cd <repository-name>

---


### Step 2: Install Dependencies
Install the project dependencies using Composer:
	composer install

### Step 3: Configure Environment
Copy the .env.example file to .env:
	cp env.example .env

Open the .env file and update the following settings:
app.baseURL = 'http://localhost/<repository-name>'
database.default.hostname = localhost
database.default.database = <your-database-name>
database.default.username = <your-database-username>
database.default.password = <your-database-password>
database.default.DBDriver = MySQLi

### Step 4: Create the Database

1. Create a database in MySQL or MariaDB.
2. Import the SQL schema provided in the database.sql file:

mysql -u <username> -p <database-name> < database.sql

###	Step 5: Serve the Application
Start the built-in development server using the following command:

php spark serve
Visit the application in your browser:

http://localhost:8080

---

## Usage

Accessing the Application

1. Open the URL in your browser: http://localhost:8080.
2. Use the navigation options to add, edit, or delete products.

## Default Routes

Product Listing: /products

1. Create Product: /product_inventory/create-product
2. Edit Product: /product_inventory/update-product/{id}
3. Delete Product: /product_inventory/delete-product/{id}
