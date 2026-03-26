# 🚀 FutureWave EMS - Enterprise Management System

<p align="center">
  <strong>Modern Employee Management System built with Laravel</strong><br>
  Manage employees, attendance, leaves, and salaries efficiently.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?style=for-the-badge">
  <img src="https://img.shields.io/badge/PHP-8-blue?style=for-the-badge">
  <img src="https://img.shields.io/badge/MySQL-Database-orange?style=for-the-badge">
  <img src="https://img.shields.io/badge/Status-Active-success?style=for-the-badge">
</p>

---

## 📌 About the Project

**FutureWave EMS** is a full-featured Employee Management System designed to help organizations manage their workforce efficiently.  
This system includes real-world business features such as attendance tracking, leave management, salary handling, and reporting.

---

## ✨ Key Features

- 👨‍💼 Employee Management (CRUD)
- 📅 Attendance Tracking System
- 📝 Leave Management with Email Notifications
- 💰 Salary Management with PDF Generation
- 📊 Reports & Analytics Dashboard
- 🔐 Authentication System (Login/Register)
- 📧 Forgot Password (Email via Mailtrap)

---

## 🛠 Tech Stack

- **Backend:** Laravel 12  
- **Frontend:** Bootstrap 5  
- **Database:** MySQL  
- **Charts:** Chart.js  
- **PDF Generator:** DomPDF  
- **Email Testing:** Mailtrap  

---

## 📂 Project Structure
futurewave-app/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── .env
├── README.md
├── screenshots/

---

## ⚙️ Installation Guide

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/asadshabbir/futurewave-ems.git
cd futurewave-ems
2️⃣ Install Dependencies
composer install
npm install
3️⃣ Setup Environment
cp .env.example .env
php artisan key:generate
4️⃣ Configure Database

Edit .env file:

DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
5️⃣ Run Migrations
php artisan migrate
6️⃣ Start Server
php artisan serve

Open in browser: http://127.0.0.1:8000

🔐 Demo Credentials
Role	Email	Password
Admin	asadshabbir7373@gmail.com
	admin123
Employee	asadshabbir00025@gmail.com
	asadasad

    ## 📸 Screenshots

### Admin Dashboard
![Dashboard](screenshots/admin-dashboard.png)

### Employees Dashboard
![Employees](screenshots/employees-dashboard.png)

### Reports Dashboard
![Reports](screenshots/reports-dashboard.png)

### Employees List
![Employees List](screenshots/employees-list.png)

    👨‍💻 Author

Asad Shabbir
📧 asadshabbir7373@gmail.com

⭐ Support