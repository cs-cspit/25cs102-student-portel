# STUDENTHUB
### Student Management & Campus Portal
> *"Connect. Learn. Participate."*

---

## 📌 Academic Project Overview

| Attribute | Details |
| :--- | :--- |
| **Course Code & Title** | **ITUE203 – Web Development Frameworks** |
| **Semester** | 3rd Semester B.Tech Computer Science Engineering |
| **Academic Year** | 2026–27 |
| **Institution** | Chandubhai S. Patel Institute of Technology (CSPIT), CHARUSAT |
| **Project Type** | Continuous 15-Phase Progressive Web Development Project |
| **Student Name** | Daksh Shah |
| **Student ID / Roll** | 25CS102 |
| **Faculty Mentor** | Dhara Ma'am |
| **GitHub Repository** | [cs-cspit/25cs102-student-portel](https://github.com/cs-cspit/25cs102-student-portel.git) |
| **Branch** | `main` |
| **Project Status** | **15/15 Practicals Complete (100% Verified)** |

---

## 🎯 Executive Summary & Problem Statement

### Problem Statement
Higher education institutions conduct numerous academic, co-curricular, and extracurricular activities. Traditionally, campus operations suffer from fragmented announcement boards, spreadsheet-based event registrations, lack of student self-service portals, and absence of security audit tracking.

### Solution: StudentHub
**StudentHub** is an integrated, secure, and responsive web application engineered using modern standards (HTML5, CSS3, JavaScript ES6+, PHP 8.2, and MySQL). It unifies campus event publishing, student registration workflows, profile management, RESTful JSON APIs, administrative CRUD operations, and security audit logs into an enterprise-ready academic portal.

---

## 🛠️ Technology Stack

- **Frontend Tier:** Semantic HTML5 (WCAG 2.1 AA Compliant), Vanilla CSS3 (Custom Responsive Grid, CSS Variables, Light/Dark Theming), Vanilla JavaScript ES6+ (Fetch API, DOM Manipulation, Toast UI, Web Storage API). *Zero external CSS/JS frameworks used; built entirely from vanilla fundamentals.*
- **Backend Tier:** PHP 8.2 (Modular Architecture, Session Regeneration, Inactivity Timeout, Synchronizer Token CSRF Defense, Brute-Force Throttling, RBAC Middleware).
- **Database Tier:** MySQL 8.0 / MariaDB (Normalized 3NF Schema, InnoDB Engine, Foreign Keys with Cascading Actions, Prepared Parameterized Statements via MySQLi).
- **Local Server Stack:** Apache HTTP Server & MySQL via XAMPP (Port 80 / 3306).
- **Testing & QA Tooling:** PHP CLI automated test runner (`tests/run_functional_tests.php`), Headless Browser test suite, phpMyAdmin.

---

## 📁 Complete Project Directory Tree

```
StudentHub/
│
├── index.php                # Dynamic Home Page with Live MySQL Metrics & Role Badges
├── index.html               # Public Home Page Fallback with Content Slider
├── about.html               # Mission, Objectives & Academic Framework
├── register.html            # Student Registration with Real-Time Regex Validation
├── login.html               # User Authentication Gateway with 1-Click Test Credentials
├── dashboard.php            # Authenticated Student Dashboard & Enrolled Events
├── events.html              # Dynamic Campus Events Catalog with Fetch API Search & Filter
├── profile.php              # Authenticated Student Academic Profile Management
├── contact.html             # Contact Directory & Support Inquiry Form
├── faq.html                 # Interactive Accordion FAQ Knowledge Base
├── feedback.html            # Student Feedback & Satisfaction Rating Form
│
├── admin/                   # Administrative Management Console (Admin Role Only)
│   ├── index.php            # Admin Overview KPI Dashboard & Live Statistics
│   ├── students.php         # Student Directory CRUD (Dual-Mode: Fetch AJAX & POST with CSRF)
│   ├── events.php           # Event Publishing, Seating CRUD & Secure Poster Upload
│   ├── registrations.php    # Participant Roster Oversight & Status Updates
│   └── audit-logs.php       # Security Activity Audit Trail with Parameterized Filters
│
├── php/                     # Server-Side Business Logic & Security Guards
│   ├── db.php               # Database Connection & Parameterized Query Helpers
│   ├── register.php         # Server-Side Registration Processor & Dual Table Insert
│   ├── login.php            # Secure Login Processor with Password Verification & Throttling
│   ├── logout.php           # Secure Session Destruction & Cookie Clear
│   ├── auth.php             # Unified Auth Middleware, CSRF Helpers & Rate Limiter
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
│   ├── main.js              # Theme Switcher, Accordions, Modals, Sliders, Focus Management
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
│   ├── .htaccess            # Prohibits PHP Script Execution in Uploads
│   └── events/              # Sanitized Uploaded Event Posters (JPG, PNG)
│
├── studenthub.sql           # Root Database Export with Clean Bcrypt Hashes & 20+ Students
├── sql/
│   └── studenthub.sql       # SQL Directory Mirror for Portability
│
├── tests/                   # Automated Quality Assurance Test Suite
│   ├── run_functional_tests.php # 25-Point Comprehensive Regression Test Runner
│   ├── create_session.php   # Test Session Authentication Helper
│   └── test_results.json    # Machine-Readable 100% Pass Execution Results
│
├── docs/                    # Laboratory Practical Manuals & Submission Reports
│   ├── TEST_SECURITY_REPORT.md # Master 25-Case Test & Security Audit Report
│   ├── LOCAL_DEPLOYMENT.md  # Detailed XAMPP Local Deployment Guide
│   ├── DEMO_GUIDE.md        # Practical 15 Viva Voce & Demonstration Walkthrough
│   ├── screenshots/         # 15 Genuine Screenshots of Running Application
│   │   ├── 01-home.png
│   │   ├── 02-registration-validation.png
│   │   ├── 03-login-success.png
│   │   ├── 04-student-dashboard.png
│   │   ├── 05-student-crud.png
│   │   ├── 06-event-management.png
│   │   ├── 07-admin-dashboard.png
│   │   ├── 08-access-denied.png
│   │   ├── 09-ajax-crud.png
│   │   ├── 10-mobile-responsive.png
│   │   ├── 11-database-tables.png
│   │   ├── 12-events-catalog.png
│   │   ├── 13-logout-session.png
│   │   ├── 14-student-profile.png
│   │   └── 15-audit-logs.png
│   ├── requirements.md      # Functional & Non-Functional Specifications
│   ├── sitemap.md           # 15-Page Sitemap & User Navigation Flows
│   ├── wireframe.md         # Low-Fidelity Layout Wireframes
│   └── practical-01.md to practical-15.md # Lab 01 to Lab 15 Practical Reports
│
├── .env.example             # Safe Environment Configuration Template
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
- Install [XAMPP](https://www.apachefriends.org/) (PHP 8.1+ and MySQL).
- Install [Git](https://git-scm.com/) and [VS Code](https://code.visualstudio.com/).

### Step-by-Step Installation
1. **Clone or Link the Repository into XAMPP Web Root:**
   ```bash
   cd C:/xampp/htdocs
   git clone https://github.com/cs-cspit/25cs102-student-portel.git studenthub
   cd studenthub
   ```
   *(Or create a Windows directory junction pointing to the workspace folder: `mklink /J "C:\xampp\htdocs\studenthub" "C:\path\to\pr 15"`)*

2. **Start Apache & MySQL:**
   - Launch the **XAMPP Control Panel**.
   - Start the **Apache** and **MySQL** services.

3. **Import Database in phpMyAdmin:**
   - Open browser at `http://localhost/phpmyadmin/`.
   - Create a new database named `studenthub` (Collation: `utf8mb4_unicode_ci`).
   - Navigate to the **Import** tab and select `studenthub.sql`.
   - Click **Import** to execute DDL schema and seed all tables.

4. **Verify Database Connection:**
   - Database credentials in `php/db.php`:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'studenthub');
     ```

5. **Launch Application:**
   - Open browser and visit: [http://localhost/studenthub/](http://localhost/studenthub/)

---

## 👤 Default Demo Credentials

| User Role | Email Address | Password | Landing Dashboard |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@studenthub.edu` | `Admin@123` | Admin Console (`/admin/index.php`) |
| **Student** | `25cs102@charusat.edu.in` | `Student@123` | Student Dashboard (`/dashboard.php`) |

> 💡 **Quick Login:** On `login.html`, click the helper buttons **"Fill Admin Credentials"** or **"Fill Student Credentials"** to populate the form instantly.

---

## 🧪 Comprehensive Quality Assurance & Test Results

An automated test suite (`tests/run_functional_tests.php`) exercises all 25 required functional and security test cases against the live local Apache server:

```powershell
C:\xampp\php\php.exe tests\run_functional_tests.php
```

### Test Suite Execution Summary
- **Total Test Cases:** 25
- **Passed:** **25 (100.0%)**
- **Failed:** **0 (0.0%)**
- **Blocked:** **0 (0.0%)**
- **Not Tested:** **0 (0.0%)**

Detailed test descriptions, execution steps, expected results, and actual assertions are recorded in [`docs/TEST_SECURITY_REPORT.md`](docs/TEST_SECURITY_REPORT.md).

---

## 🗺️ Complete 15-Practical Roadmap & Commit Mapping

| Lab | Milestone Title | Practical Focus | Status |
| :---: | :--- | :--- | :---: |
| **P01** | Project Initiation, Requirements, Sitemap, Wireframe & GitHub Setup | Architecture & Git Initial Setup | ✅ COMPLETE |
| **P02** | Semantic HTML5 Pages with Accessibility Landmarks | Semantic HTML & WCAG 2.1 AA | ✅ COMPLETE |
| **P03** | Responsive UI Design using CSS Grid, Flexbox & Design Tokens | Responsive Layouts & Variables | ✅ COMPLETE |
| **P04** | JavaScript DOM Manipulation, Event Handling & Theme Switching | Dynamic Interactivity & Dark Mode | ✅ COMPLETE |
| **P05** | Registration Form Validation with Real-Time Feedback | Regex Validation & Password Meter | ✅ COMPLETE |
| **P06** | Rendering JSON Data via Fetch API, Search, Filter & Pagination | Async Data Fetching & Rendering | ✅ COMPLETE |
| **P07** | PHP Form Processing with Server-Side Validation & File Storage | PHP Back-End Form Handlers | ✅ COMPLETE |
| **P08** | MySQL Schema Design, ER Modeling & Database Connectivity | MySQLi Database Abstraction | ✅ COMPLETE |
| **P09** | Secure Registration with Duplicate Checks & Password Hashing | BCRYPT Password Encryption | ✅ COMPLETE |
| **P10** | Secure Login/Logout with Sessions, RBAC & Inactivity Timeout | Session Management & Access Guards | ✅ COMPLETE |
| **P11** | Administrative Student Management CRUD with Search & Filters | MySQL Prepared Statements & CRUD | ✅ COMPLETE |
| **P12** | Event Management CRUD with Secure Poster Image Uploads | MIME Check & Safe File Uploads | ✅ COMPLETE |
| **P13** | RESTful PHP JSON API & AJAX/Fetch-Based Asynchronous CRUD | Dual-Mode Fetch & REST Endpoints | ✅ COMPLETE |
| **P14** | Admin Analytics Dashboard, Dynamic Navigation & Audit Logging | Live KPI Metrics & Security Logs | ✅ COMPLETE |
| **P15** | Final Integration Testing, Security Hardening, Docs & Deployment | 25 Test Cases, CSRF, Reports & Git | ✅ COMPLETE |

---

## 🔒 Security Architecture Highlights

- **Password Protection:** Industry-standard BCRYPT hashing via `password_hash()` and `password_verify()`.
- **SQL Injection Elimination:** 100% Parameterized Prepared Statements (`bind_param`) across all dynamic queries.
- **CSRF Defense:** Synchronizer Token Pattern implemented with `random_bytes(32)` tokens and `hash_equals()` validation on all state-changing admin forms.
- **Brute-Force Rate Limiting:** Sliding-window login throttling locking accounts after 5 failed attempts.
- **Session Security:** `session_regenerate_id(true)` to defeat session fixation, 30-minute inactivity timeouts, and clean destruction upon logout.
- **XSS Sanitization:** `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` applied to all dynamic outputs.
- **Secure File Uploads:** Whitelist extension checks, binary MIME inspection via `finfo_file()`, 2MB size limit, randomized filename hashing, and `uploads/.htaccess` prohibiting PHP script execution.
- **Audit Logging:** Comprehensive activity and security trail stored in `audit_logs` without storing sensitive secrets.

---

## 📄 Academic Attribution
Developed for **ITUE203: Web Development Frameworks** at **CHARUSAT (CSPIT)**.  
Department of Computer Science & Engineering | Academic Year 2026–27.  
*Candidate:* Daksh Shah (25CS102) | *Faculty Guide:* Dhara Ma'am
