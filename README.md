# 🌟 Charity Management System
> **نظام إدارة الجمعيات الخيرية** – A Laravel 12 + TailwindCSS web platform  
> to manage **charities**, **beneficiaries**, **aids**, and **users** efficiently.

---

## 📜 Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Screenshots](#screenshots)
- [Installation](#installation)
- [Demo Data](#demo-data)
- [User Roles](#user-roles)
- [Project Structure](#project-structure)
- [Documentation](#documentation)
- [License](#license)
- [Contact](#contact)

---

## 📖 Overview
Charity Management System is a responsive web application designed to help **charitable associations**:
- Register and manage **beneficiaries** and their relatives.
- Track **aids** (financial, food, medical, etc.).
- Control **users and roles** inside each association.
- Generate **reports & statistics** in a single dashboard.

The UI is **mobile-friendly**, bilingual-ready (Arabic first), and optimized for modern browsers.

---

## ✨ Features
- **Associations**
  - Add / Edit / Delete charities.
  - Store registration number, phone, email, and status.
- **Beneficiaries**
  - Register beneficiaries and their family members.
  - Search and filter by association, gender, or income.
- **Aids**
  - Record financial, food, medical, or other types of aid.
  - Link aids to both beneficiaries and associations.
- **Users**
  - Role-based access: `Admin`, `Moderator`, `User`.
  - Association-bound accounts with active/inactive status.
- **Reports**
  - Dashboard statistics and quick export to Excel/PDF.
- **Authentication**
  - Secure login with Laravel Breeze/Sanctum (optional).
- **Responsive UI**
  - Built with TailwindCSS and fully RTL-ready.

---

## 🛠 Tech Stack
| Layer          | Technology                                   |
|----------------|-----------------------------------------------|
| **Backend**    | [Laravel 12](https://laravel.com/)            |
| **Frontend**   | Blade + [TailwindCSS](https://tailwindcss.com/) |
| **Database**   | MySQL / MariaDB                               |
| **Auth**       | Laravel Auth / Sanctum                        |
| **Others**     | Vite, Alpine.js (for small JS interactions)   |

---

## 📸 Screenshots
*(Add screenshots of dashboard, beneficiaries, aids, etc. here)*

---

## ⚡ Installation

### Prerequisites
- PHP **8.1+**
- Composer
- MySQL **8+** or MariaDB
- Node.js + NPM

### Steps
```bash
# 1. Clone repository
git clone https://github.com/your-username/charity-system.git
cd charity-system

# 2. Install PHP & JS dependencies
composer install
npm install

# 3. Create environment file
cp .env.example .env
# edit .env and set DB credentials

# 4. Run migrations & seed demo data
php artisan migrate --seed

# 5. Build frontend & start server
npm run dev
php artisan serve
# 6. Test Code
php artisan test
