# STUDENTHUB
### Student Management & Campus Portal
> *"Connect. Learn. Participate."*

---

## 📌 Project Overview

| Attribute | Details |
| :--- | :--- |
| **Course Code & Title** | **ITUE203 – Web Development Frameworks** |
| **Semester** | 3rd Semester B.Tech Computer Science Engineering |
| **Academic Year** | 2026-27 |
| **Institution** | Chandubhai S. Patel Institute of Technology (CSPIT), CHARUSAT |
| **Project Type** | Continuous 15-Phase Progressive Web Development Project |
| **Student Name** | Daksh Shah |
| **Student ID / Roll** | 25CS102 |

---

## 🎯 Problem Statement & Objectives

### Problem Statement
Campus activities, technical workshops, cultural events, and student records are traditionally managed through fragmented tools, physical noticeboards, and disconnected spreadsheets. This causes high administrative overhead, communication lags, and poor student engagement tracking.

### Objectives
1. **Centralize Campus Engagement:** Provide an accessible, responsive web application for students to discover, search, and register for university events.
2. **Streamline Administration:** Equip faculty and campus administrators with complete CRUD capabilities for students, events, registrations, and security audit logs.
3. **Implement Robust Security:** Enforce secure authentication using bcrypt password hashing, session protection, Role-Based Access Control (RBAC), and 100% prepared SQL statements.
4. **Foster Asynchronous Interactivity:** Deliver modern UI interactions via JavaScript Fetch API and RESTful PHP JSON endpoints without full-page reloads.

---

## 🛠️ Technology Stack

- **Frontend:** HTML5 (Semantic Structure & Accessibility), CSS3 (Grid, Flexbox, Custom Variables, Dark Mode), Vanilla JavaScript ES6+ (Fetch API, DOM manipulation).
- **Backend:** PHP 8+ (Procedural & Modular Design, Sessions, RBAC Middleware).
- **Database:** MySQL 8.0 / MariaDB (Prepared Statements via MySQLi, Relational Schema with Foreign Keys & Indexes).
- **Server Environment:** Apache HTTP Server (via XAMPP).
- **Tools & Version Control:** Visual Studio Code, Git, GitHub, phpMyAdmin.

---

## 📁 Project Directory Structure

```
StudentHub/
│
├── index.html               # Public Home Page & Campus Highlights
├── about.html               # About StudentHub & Mission
├── register.html            # Student Registration Form
├── login.html               # User Authentication & Role Gateway
├── dashboard.php            # Authenticated Student Dashboard
├── events.php               # Campus Events Catalog & Interactive Search
├── profile.php              # Student Profile Management
├── contact.html             # Contact & Campus Inquiries
├── faq.html                 # Interactive Accordion FAQ
├── feedback.html            # Student Feedback Submission Form
│
├── admin/                   # Administrative Management Suite (Admin Role Only)
│   ├── index.php            # Admin KPI Dashboard & Metrics
│   ├── students.php         # Student Directory CRUD
│   ├── events.php           # Event Management & Poster Upload
│   ├── registrations.php    # Participant Registrations & Status Management
│   └── audit-logs.php       # System Security & Activity Audit Trail
│
├── php/                     # Server-Side Business Logic & Helpers
│   ├── db.php               # Database Connection & Error Handler
│   ├── register.php         # Server-Side Registration Processor
│   ├── login.php            # Server-Side Authentication & Session Initializer
│   ├── logout.php           # Secure Session Destruction & Cookie Clear
│   ├── auth.php             # Unified Authentication Middleware
│   ├── student-auth.php     # Student Role Guard
│   └── admin-auth.php       # Administrator Role Guard
│
├── api/                     # RESTful PHP JSON API Endpoints
│   ├── students.php         # Student CRUD API (GET, POST, PUT, DELETE)
│   └── events.php           # Events API (GET, POST, PUT, DELETE)
│
├── css/                     # Styling & Themes
│   ├── style.css            # Global CSS Variables, Base Styles & Utilities
│   ├── responsive.css       # Mobile, Tablet & Desktop Media Queries
│   └── admin.css            # Admin Dashboard & Console Styles
│
├── js/                      # Client-Side Interactivity & Validation
│   ├── main.js              # Theme Toggle, Mobile Nav, Accordions & Modals
│   ├── validation.js        # Real-Time Regex Form Validation
│   ├── events.js            # Dynamic Event Filtering, Sorting & Search
│   └── api.js               # Asynchronous AJAX Fetch Helper
│
├── data/                    # JSON Mock Data & Data Stores
│   ├── events.json          # Seed Event Catalog
│   ├── students.json        # Seed Student Directory
│   └── faqs.json            # Frequently Asked Questions Data
│
├── uploads/                 # Media & File Storage
│   └── events/              # Sanitized Event Posters (JPG, PNG)
│
├── sql/                     # Relational Database Schema & Migrations
│   └── studenthub.sql       # DDL Schema, Foreign Keys & Seed Data
│
├── docs/                    # Technical & Laboratory Documentation
│   ├── requirements.md      # Functional & Non-Functional Specifications
│   ├── sitemap.md           # 15-Page Sitemap & User Navigation Flows
│   ├── wireframe.md         # Low-Fidelity Layout Wireframes
│   ├── practical-01.md      # Practical 01 Lab Report & Viva Q&A
│   └── ...                  # Practicals 02 to 15 Reports
│
├── README.md                # Master Project Documentation
└── .gitignore               # Version Control Exclusions
```

---

## 🗄️ Database Architecture (`studenthub`)

The application utilizes a normalized relational schema with 5 core tables:

1. **`users`**: Authentication credentials, hashed passwords, user roles (`student`, `admin`), timestamps.
2. **`students`**: Detailed academic profiles linked to `users.id` (mobile, course, year, gender, status).
3. **`events`**: Campus events (title, description, event date, category, poster path, status).
4. **`registrations`**: Event enrollment records linking `students.id` and `events.id` with status tracking.
5. **`audit_logs`**: Security activity logs recording user actions, affected entities, client IPs, and timestamps.

---

## 🚀 Local Installation & Setup Guide

### Prerequisites
- Install [XAMPP](https://www.apachefriends.org/) (PHP 8.0+ and MySQL).
- Install [Git](https://git-scm.com/) and [VS Code](https://code.visualstudio.com/).

### Step-by-Step Installation
1. **Clone the Repository:**
   ```bash
   cd C:/xampp/htdocs
   git clone https://github.com/cs-cspit/25cs102-student-portel.git studenthub
   cd studenthub
   ```

2. **Start Services in XAMPP Control Panel:**
   - Start **Apache** module.
   - Start **MySQL** module.

3. **Import Database in phpMyAdmin:**
   - Open browser at `http://localhost/phpmyadmin/`.
   - Create a new database named `studenthub`.
   - Navigate to the **Import** tab and select `sql/studenthub.sql`.
   - Click **Go** to execute and seed the database.

4. **Verify Database Configuration:**
   - Check `php/db.php` settings:
     ```php
     $host = "localhost";
     $user = "root";
     $pass = "";
     $dbname = "studenthub";
     ```

5. **Launch Application:**
   - Open your browser and visit: `http://localhost/studenthub/`

---

## 👤 Default Demo Credentials

| Role | Email | Password | Access Area |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@studenthub.edu` | `Admin@123` | Full Admin Console (`/admin`) |
| **Student** | `daksh@charusat.edu.in` | `Student@123` | Student Dashboard (`/dashboard.php`) |

*(All passwords are automatically verified via `password_verify()` against bcrypt hashes).*

---

## 🗺️ Practical Roadmap & Progress

| Practical | Topic / Milestone | Status |
| :---: | :--- | :---: |
| **01** | Project Initiation, Requirements, Sitemap, Wireframe & GitHub Setup | ✅ COMPLETED |
| **02** | Semantic HTML5 Pages with Accessibility Landmarks | ⏳ PENDING |
| **03** | Responsive UI Design using CSS Grid, Flexbox & Design Tokens | ⏳ PENDING |
| **04** | JavaScript DOM Manipulation, Event Handling & Theme Switching | ⏳ PENDING |
| **05** | Registration Form Validation with Real-Time Feedback | ⏳ PENDING |
| **06** | Rendering JSON Data via Fetch API, Search, Filter & Pagination | ⏳ PENDING |
| **07** | PHP Form Processing with Server-Side Validation & File Storage | ⏳ PENDING |
| **08** | MySQL Schema Design, ER Modeling & Database Connectivity | ⏳ PENDING |
| **09** | Secure Registration with Duplicate Checks & Password Hashing | ⏳ PENDING |
| **10** | Secure Login/Logout with Sessions, RBAC & Inactivity Timeout | ⏳ PENDING |
| **11** | Administrative Student Management CRUD with Search & Filters | ⏳ PENDING |
| **12** | Event Management CRUD with Secure Poster Image Uploads | ⏳ PENDING |
| **13** | RESTful PHP JSON API & AJAX/Fetch-Based Asynchronous CRUD | ⏳ PENDING |
| **14** | Admin Analytics Dashboard, Dynamic Navigation & Audit Logging | ⏳ PENDING |
| **15** | Final Integration, Security Auditing, Deployment & Viva Prep | ⏳ PENDING |

---

## 🔒 Security Architecture
- **Password Security:** BCRYPT password hashing via `password_hash()`.
- **SQL Injection Defense:** 100% Prepared Statements for all dynamic queries.
- **XSS Sanitization:** `htmlspecialchars()` encoding on all rendered outputs.
- **Session Protection:** `session_regenerate_id(true)` upon authentication, cookie flags (`HttpOnly`, `SameSite=Strict`), 30-minute inactivity timeout.
- **Secure File Upload:** Extension whitelisting, MIME type verification via `finfo_file()`, image dimension verification, and sanitized randomized naming.

---

## 📄 License & Attribution
Developed as part of the academic curriculum for **ITUE203: Web Development Frameworks** at **CHARUSAT (CSPIT)**.  
Academic Year 2026-27.
