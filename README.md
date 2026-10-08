# STUDENTHUB
### Student Management & Campus Portal
> *"Connect. Learn. Participate."*

---

## 📌 Academic Project Overview

| Attribute | Details |
| :--- | :--- |
| **Course Code & Title** | **ITUE203 – Web Development Frameworks** |
| **Semester** | 3rd Semester B.Tech Computer Science Engineering |
| **Academic Year** | 2026-27 |
| **Institution** | Chandubhai S. Patel Institute of Technology (CSPIT), CHARUSAT |
| **Project Type** | Continuous 15-Phase Progressive Web Development Project |
| **Student Name** | Daksh Shah |
| **Student ID / Roll** | 25CS102 |
| **Faculty Mentor** | Dhara Ma'am |
| **GitHub Repository** | [cs-cspit/25cs102-student-portel](https://github.com/cs-cspit/25cs102-student-portel.git) |
| **Branch** | `main` |
| **Project Status** | **15/15 Practicals Complete (100%)** |

---

## 🎯 Executive Summary & Problem Statement

### Problem Statement
Higher education institutions conduct numerous academic, co-curricular, and extracurricular activities. Traditionally, campus operations suffer from fragmented announcement boards, spreadsheet-based event registrations, lack of student self-service portals, and absence of security audit tracking.

### Solution: StudentHub
**StudentHub** is an integrated, secure, and responsive web application engineered using modern standards (HTML5, CSS3, JavaScript ES6+, PHP 8+, and MySQL). It unifies campus event publishing, student registration workflows, profile management, RESTful JSON APIs, administrative CRUD operations, and security audit logs.

---

## 🛠️ Technology Stack

- **Frontend Tier:** Semantic HTML5 (WCAG 2.1 AA Compliant), CSS3 (CSS Grid, Flexbox, Design Tokens, Light/Dark Theming), Vanilla JavaScript ES6+ (Fetch API, DOM Manipulation, Web Storage API).
- **Backend Tier:** PHP 8+ (Modular Architecture, Session Regeneration, Inactivity Timeout, RBAC Middleware).
- **Database Tier:** MySQL 8.0 / MariaDB (Normalized 3NF Schema, InnoDB Engine, Foreign Keys with Cascading Actions, Prepared Statements via MySQLi).
- **Local Server Stack:** Apache HTTP Server & MySQL via XAMPP.
- **Development Tooling:** Visual Studio Code, Git, GitHub, phpMyAdmin.

---

## 📁 Complete Project Directory Tree

```
StudentHub/
│
├── index.html               # Public Home Page with Content Slider & Modal Dialogs
├── about.html               # Mission, Objectives & Academic Framework
├── register.html            # Student Registration with Real-Time Regex Validation
├── login.html               # User Authentication & Role Gateway
├── dashboard.php            # Authenticated Student Dashboard & Enrolled Events
├── events.html              # Dynamic Campus Events Catalog with Fetch API Search & Filter
├── profile.php              # Authenticated Student Academic Profile Management
├── contact.html             # Contact Directory & Support Inquiry Form
├── faq.html                 # Interactive Accordion FAQ Knowledge Base
├── feedback.html            # Student Feedback & Satisfaction Rating Form
│
├── admin/                   # Administrative Management Console (Admin Role Only)
│   ├── index.php            # Admin Overview KPI Dashboard & Monthly Participation Chart
│   ├── students.php         # Student Directory CRUD with Department Search & Filter
│   ├── events.php           # Event Publishing, Seating CRUD & Secure Poster Upload
│   ├── registrations.php    # Participant Roster Oversight & Status Updates
│   └── audit-logs.php       # Security Activity Audit Trail with IP Origin Logging
│
├── php/                     # Server-Side Business Logic & Security Guards
│   ├── db.php               # Database Connection & Parameterized Query Helpers
│   ├── register.php         # Server-Side Registration Processor & Dual Table Insert
│   ├── login.php            # Secure Login Processor with Password Verification & RBAC
│   ├── logout.php           # Secure Session Destruction & Cookie Clear
│   ├── auth.php             # Unified Authentication Middleware & Timeout Checker
│   ├── student-auth.php     # Student Role Guard Middleware
│   ├── admin-auth.php       # Administrator Role Guard Middleware
│   └── contact.php          # Contact Form Processor & Inquiries Storage
│
├── api/                     # RESTful JSON API Endpoints
│   ├── students.php         # Student CRUD API (GET, POST, PUT, DELETE)
│   └── events.php           # Event CRUD API (GET, POST, PUT, DELETE)
│
├── css/                     # Styling & Responsive Design System
│   ├── style.css            # Design Tokens, Light/Dark Theme Variables & Components
│   ├── responsive.css       # Mobile (<768px), Tablet, and Desktop Media Queries
│   └── admin.css            # Admin Console Layout & Component Styles
│
├── js/                      # Client-Side Interactivity & Validation Engines
│   ├── main.js              # Theme Switcher, Accordions, Modals, Sliders, Banners
│   ├── validation.js        # Real-Time Regex Form Validation & Password Strength
│   ├── events.js            # Asynchronous Fetch API Event Catalog & Pagination
│   └── api.js               # Reusable AJAX Fetch API Client Library
│
├── data/                    # JSON Mock Data & Flat-File Stores
│   ├── events.json          # Seed Event Catalog (16 Records)
│   ├── students.json        # Seed Student Directory (16 Records)
│   ├── faqs.json            # Categorized FAQ Questions (15 Records)
│   └── registrations.json   # Flat-File Fallback Storage
│
├── uploads/                 # Media & File Storage
│   └── events/              # Sanitized Uploaded Event Posters (JPG, PNG)
│
├── sql/                     # Relational Database Schema & Migrations
│   └── studenthub.sql       # 3NF Schema DDL, Foreign Keys, Indexes & Seed Data
│
├── docs/                    # Laboratory Practical Manuals (Practicals 01 to 15)
│   ├── requirements.md      # Functional & Non-Functional Specifications
│   ├── sitemap.md           # 15-Page Sitemap & User Navigation Flows
│   ├── wireframe.md         # Low-Fidelity Layout Wireframes
│   ├── practical-01.md      # Lab 01 Report & Viva Guide
│   ├── practical-02.md      # Lab 02 Report & Viva Guide
│   ├── ...                  # Lab 03 to Lab 14 Reports
│   └── practical-15.md      # Final Integration & Deployment Manual
│
├── README.md                # Master Project Documentation
└── .gitignore               # Version Control Exclusions
```

---

## 🗄️ Relational Database Schema (`studenthub`)

The normalized relational database comprises 5 interconnected tables:

1. **`users`**: User ID, Name, Unique Email, BCRYPT Hashed Password, Role (`student`, `admin`), Timestamps.
2. **`students`**: Student ID, Foreign Key `user_id` (Cascading), Name, Email, Mobile, Department/Course, Academic Year, Gender, Status (`Active`, `Pending`, `Inactive`).
3. **`events`**: Event ID, Title, Description, Date, Time Slot, Venue, Category (`technical`, `workshop`, `cultural`, `sports`), Poster Path, Seating Capacity, Status (`Active`, `Upcoming`, `Completed`, `Cancelled`).
4. **`registrations`**: Registration ID, Foreign Keys `student_id` and `event_id` (Unique Composite Pair), Status (`Confirmed`, `Waitlisted`, `Cancelled`), Registration Date.
5. **`audit_logs`**: Log ID, Foreign Key `user_id`, Action Event, Entity, Entity ID, Client IP Address, Activity Details, Timestamp.

---

## 🚀 Local Installation & Setup Guide

### Prerequisites
- Install [XAMPP](https://www.apachefriends.org/) (PHP 8.0+ and MySQL).
- Install [Git](https://git-scm.com/) and [VS Code](https://code.visualstudio.com/).

### Step-by-Step Installation
1. **Clone the Repository into XAMPP Web Root:**
   ```bash
   cd C:/xampp/htdocs
   git clone https://github.com/cs-cspit/25cs102-student-portel.git studenthub
   cd studenthub
   ```

2. **Start Apache & MySQL:**
   - Launch the **XAMPP Control Panel**.
   - Start the **Apache** and **MySQL** services.

3. **Import Database in phpMyAdmin:**
   - Open browser at `http://localhost/phpmyadmin/`.
   - Create a new database named `studenthub`.
   - Navigate to the **Import** tab and select `sql/studenthub.sql`.
   - Click **Go** to execute DDL schema and seed all tables.

4. **Verify Database Connection:**
   - Database credentials in `php/db.php`:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'studenthub');
     ```

5. **Launch Application:**
   - Open browser and visit: `http://localhost/studenthub/`

---

## 👤 Default Demo Credentials

| User Role | Email Address | Password | Landing Dashboard |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@studenthub.edu` | `Admin@123` | Admin Console (`/admin/index.php`) |
| **Student** | `25cs102@charusat.edu.in` | `Student@123` | Student Dashboard (`/dashboard.php`) |

---

## 🗺️ Complete 15-Practical Roadmap & Commit Mapping

| Lab | Milestone Title | Commit Hash | Status |
| :---: | :--- | :---: | :---: |
| **P01** | Project Initiation, Requirements, Sitemap, Wireframe & GitHub Setup | `d946761` | ✅ COMPLETE |
| **P02** | Semantic HTML5 Pages with Accessibility Landmarks | `67a29d5` | ✅ COMPLETE |
| **P03** | Responsive UI Design using CSS Grid, Flexbox & Design Tokens | `9562518` | ✅ COMPLETE |
| **P04** | JavaScript DOM Manipulation, Event Handling & Theme Switching | `75cdac7` | ✅ COMPLETE |
| **P05** | Registration Form Validation with Real-Time Feedback | `c4af09a` | ✅ COMPLETE |
| **P06** | Rendering JSON Data via Fetch API, Search, Filter & Pagination | `d193eab` | ✅ COMPLETE |
| **P07** | PHP Form Processing with Server-Side Validation & File Storage | `f3e4742` | ✅ COMPLETE |
| **P08** | MySQL Schema Design, ER Modeling & Database Connectivity | `e3be404` | ✅ COMPLETE |
| **P09** | Secure Registration with Duplicate Checks & Password Hashing | `d7148df` | ✅ COMPLETE |
| **P10** | Secure Login/Logout with Sessions, RBAC & Inactivity Timeout | `be96a7f` | ✅ COMPLETE |
| **P11** | Administrative Student Management CRUD with Search & Filters | `0ad670b` | ✅ COMPLETE |
| **P12** | Event Management CRUD with Secure Poster Image Uploads | `a14a379` | ✅ COMPLETE |
| **P13** | RESTful PHP JSON API & AJAX/Fetch-Based Asynchronous CRUD | `a25a488` | ✅ COMPLETE |
| **P14** | Admin Analytics Dashboard, Dynamic Navigation & Audit Logging | `f53d985` | ✅ COMPLETE |
| **P15** | Final Integration Testing, Deployment & Viva Prep | `[P15 Hash]` | ✅ COMPLETE |

---

## 🔒 Security Architecture Highlights
- **Password Protection:** Industry-standard BCRYPT hashing via `password_hash()` and `password_verify()`.
- **SQL Injection Elimination:** 100% Prepared Statements (`bind_param`) for all dynamic queries.
- **Session Security:** `session_regenerate_id(true)` to prevent session fixation, `HttpOnly` and `SameSite=Strict` flags, and 30-minute inactivity timeouts.
- **XSS Sanitization:** `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` on all rendered output.
- **Secure File Uploads:** Whitelist extension checks, binary MIME inspection via `finfo_file()`, 2MB size limit, and randomized filename hashing.
- **Audit Logging:** IP origin and user action recording for forensic security auditing.

---

## 📄 Academic Attribution
Developed for **ITUE203: Web Development Frameworks** at **CHARUSAT (CSPIT)**.  
Department of Computer Science & Engineering | Academic Year 2026-27.
