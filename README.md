# 📌 GUVI Internship Project v2

## 🚀 Full Stack User Authentication & Profile Management System

This project is a full-stack web application built as part of a GUVI internship assignment. It implements user registration, login, profile management, and session handling using MySQL, MongoDB, and Redis.

---

## 📂 Project Flow

Register → Login → Profile → Logout → Login Again

---

## 🛠️ Tech Stack

- Frontend: HTML, CSS, Bootstrap, JavaScript (jQuery AJAX)
- Backend: PHP
- Database:
  - MySQL (User authentication)
  - MongoDB (Profile data)
  - Redis (Session management)
- Dependency Manager: Composer

---

## ✨ Features

### 🔐 Authentication
- User registration
- Secure login system
- Password hashing using bcrypt
- Password verification

---

### 👤 Profile Management
- Stores DOB, Age (auto-calculated), Contact
- MongoDB used for profile storage
- AJAX-based profile update

---

### 🧠 Session Handling
- Redis-based session storage
- Session token generation
- Secure logout with session destruction

---

### ⚡ Frontend
- Bootstrap responsive UI
- jQuery AJAX (no form submission)
- Dynamic updates without page reload

---

## 📁 Project Structure

guvi-internship-project-v2/
│
├── assets/
│   ├── css/
│   └── js/
│
├── php/
│
├── index.html
├── register.html
├── login.html
├── profile.html
│
├── composer.json
├── composer.lock
└── README.md

---

## ⚙️ Setup Instructions

### 1. Clone Repository
git clone https://github.com/your-username/guvi-internship-project-v2.git

---

### 2. Move to XAMPP folder
C:\xampp\htdocs\

---

### 3. Start servers
- Apache
- MySQL
- MongoDB
- Redis

---

### 4. Install dependencies
composer install

---

### 5. Run project
http://localhost/guvi-internship-project-v2/

---

## 🧪 Test Flow

Register → Login → Profile Update → Logout → Login Again

---

## 🔒 Security

- bcrypt password hashing
- Prepared statements in MySQL
- Redis session validation
- AJAX-only communication

---

## 👨‍💻 Author

Gokulnath S  
GUVI Internship Project

---

## 📜 License

Educational purpose only
