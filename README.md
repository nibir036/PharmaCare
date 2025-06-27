# PharmaCare 💊

PharmaCare is a web-based pharmacy management system designed to streamline medicine inventory, customer interactions, and order processing. Built using HTML, CSS, JavaScript, PHP, and MySQL, this project aims to provide a simple yet efficient digital interface for small to medium-sized pharmacies.

---

## 🚀 Features

- ✅ User-friendly front-end interface
- 📦 Medicine inventory management
- 🧾 Customer purchase and billing
- 🔍 Search and filter medicines
- 📊 Basic analytics/report generation (if included)
- 🔐 Admin login system (optional)
- 📅 Expiry tracking (if implemented)

---

## 🛠️ Technologies Used

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  
- **Server:** XAMPP (Apache + MySQL)  

---

## 🖥️ Getting Started

To run this project on your local machine:

### 1. 🔽 Clone the Repository
```bash
git clone https://github.com/nibir036/pharmacare.git
````

### 2. 🧰 Set Up XAMPP

Make sure you have [XAMPP](https://www.apachefriends.org/index.html) installed.

* Open XAMPP Control Panel
* Start **Apache** and **MySQL**

### 3. 📁 Move Project to `htdocs`

Copy the cloned folder into the `htdocs` directory inside your XAMPP installation:

```
C:/xampp/htdocs/pharmacare/
```

### 4. 🗃️ Import the Database

* Open your browser and go to [phpMyAdmin](http://localhost/phpmyadmin)
* Create a new database (e.g., `pharmacare`)
* Import the SQL file (usually named `pharmacare.sql`) from the project folder

### 5. 🏃‍♂️ Run the Project

Navigate to:

```
http://localhost/pharmacare/
```

---

## ⚙️ Configuration

If needed, update database connection settings in your `config.php` or similar file:

```php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'pharmacare';
```


## 🤝 Contributing

Feel free to fork the project and submit pull requests.
If you find any bugs or issues, please [open an issue](https://github.com/nibir036/pharmacare/issues).

---

## 👨‍💻 Developer

**Nibir Islam**
BRAC University, CSE
[LinkedIn](https://www.linkedin.com/in/nibir036) | [GitHub](https://github.com/nibir036)

