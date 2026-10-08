# StudentHub - Requirement Analysis & Specifications

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE / IT  
**Academic Year:** 2026-27  
**Institution:** CHARUSAT (CSPIT)  
**Project:** StudentHub - Student Management & Campus Portal  
**Tagline:** *"Connect. Learn. Participate."*

---

## 1. Executive Summary & Problem Statement

### 1.1 Problem Statement
Higher education institutions conduct numerous academic, co-curricular, and extracurricular activities. However, campus operations frequently face challenges due to fragmented information channels:
- Event announcements are scattered across physical noticeboards, messaging groups, and disparate social media channels.
- Student registrations and participant tracking are recorded manually or using disconnected spreadsheets, leading to data redundancy, lost records, and inefficient administrative overhead.
- Students lack a centralized digital hub to discover campus events, manage their participation history, view academic updates, and communicate feedback.
- Administrators lack real-time visibility into student engagement metrics, event capacities, and secure audit tracking.

### 1.2 Proposed Solution: StudentHub
**StudentHub** is an integrated, secure, and responsive web portal engineered using modern web standards (HTML5, CSS3, JavaScript ES6+, PHP 8+, and MySQL). It centralizes student engagement, profile management, campus event publication, registration workflows, and administrative analytics within a single unified platform.

---

## 2. Target Users & Stakeholder Analysis

| User Persona | Description | Key Needs |
| :--- | :--- | :--- |
| **Prospective / Guest Student** | Unregistered or public campus visitor | Browse public event listings, learn about campus clubs, view FAQ, submit general inquiries. |
| **Registered Student** | Authenticated university student | Register/Login, view personalized dashboard, manage profile, register for events with one click, view registration history, submit feedback. |
| **Campus Administrator / Faculty** | Privileged campus coordinator | Manage student directory, create & edit events, upload event posters, view & approve registrations, monitor system activity logs, access statistical dashboards. |

---

## 3. User Roles & Permission Matrix (RBAC)

StudentHub enforces strict **Role-Based Access Control (RBAC)** across all endpoints and actions:

| Feature / Page | Guest / Public | Student | Administrator |
| :--- | :---: | :---: | :---: |
| Home Page (`index.html`) | Read | Read | Read |
| About Page (`about.html`) | Read | Read | Read |
| Contact & FAQ (`contact.html`, `faq.html`) | Read / Submit | Read / Submit | Read / Submit |
| Student Registration (`register.html`) | Create Account | Redirect to Dashboard | Create / Manage |
| Login / Logout (`login.html`, `php/logout.php`) | Authenticate | Authenticate / Logout | Authenticate / Logout |
| Student Dashboard (`dashboard.php`) | Denied (403/Redirect) | Read / Self | Read / Oversee |
| Student Profile (`profile.php`) | Denied (403/Redirect) | Read / Update Self | Read / Manage Any |
| Campus Events (`events.php`) | View Public | View / Register | View / Manage |
| Event Registration Actions | Denied | Self-Register / Cancel | View / Update Status |
| Feedback Submission (`feedback.html`) | Denied | Submit Feedback | View / Process |
| Admin Dashboard (`admin/index.php`) | Denied | Denied | Full Access |
| Student Management (`admin/students.php`) | Denied | Denied | Full CRUD |
| Event Management & Poster Upload (`admin/events.php`) | Denied | Denied | Full CRUD + Upload |
| Registration Oversight (`admin/registrations.php`) | Denied | Denied | View / Update / Export |
| Security Audit Logs (`admin/audit-logs.php`) | Denied | Denied | Read Only |

---

## 4. Functional Requirements (FR)

- **FR-01: User Authentication & Role Management**
  - Secure student registration with unique email validation and mobile number verification.
  - Password hashing using `password_hash()` with `PASSWORD_BCRYPT` / `PASSWORD_DEFAULT`.
  - Secure session creation with `session_regenerate_id(true)` to prevent session fixation.
  - Role-based automatic redirection (Students $\to$ `dashboard.php`, Admins $\to$ `admin/index.php`).
  - Secure session termination via `php/logout.php` with cookie invalidation.

- **FR-02: Student Profile & Self-Service**
  - Students can review their enrollment details, academic course, year of study, contact information, and account status.
  - Students can update their profile information and mobile number with server-side validation.

- **FR-03: Event Discovery & Dynamic Registration**
  - Public and authenticated users can view active campus events with details (title, date, category, description, and poster image).
  - Search, filter by category (Technical, Cultural, Sports, Workshop), and sort events dynamically.
  - Authenticated students can register for events with duplicate registration prevention.
  - Real-time display of registration status (Registered, Confirmed, Waitlisted).

- **FR-04: Administrative Student Management (CRUD)**
  - Full CRUD operations: Create new student record, Read student list with pagination, Update student details, Delete/Deactivate student.
  - Live search by student name, email, or enrollment ID.
  - Filter by course (CSE, IT, CE, EC) and academic year (1st, 2nd, 3rd, 4th).

- **FR-05: Administrative Event Management & File Upload**
  - Create, update, toggle status (Active, Upcoming, Completed, Cancelled), and delete events.
  - Secure poster upload handling JPG, JPEG, and PNG formats.
  - MIME-type verification, safe sanitized filename generation (`event_<timestamp>_<hash>.ext`), and storage in `uploads/events/`.

- **FR-06: Registration Management & Approvals**
  - View all student event registrations with timestamps and student details.
  - Ability for administrators to confirm, attend, or cancel registrations.

- **FR-07: RESTful JSON APIs for AJAX Operations**
  - Endpoints `api/students.php` and `api/events.php` providing structured JSON responses (`status`, `message`, `data`, `errors`).
  - Asynchronous CRUD operations without full-page reloads using JavaScript Fetch API.

- **FR-08: Campus Engagement & Communication**
  - Interactive Contact Form with field validation and notification handling.
  - Interactive FAQ with accordion expansion and keyword search.
  - Student Feedback submission interface for campus service quality assessment.

- **FR-09: Security Audit Logging**
  - Automated logging of critical actions (User Login, Failed Login, Student Registration, Event Creation, Event Deletion, Profile Update).
  - Storage of user ID, action name, affected entity, entity ID, client IP address, and exact timestamp in `audit_logs` table.

- **FR-10: Responsive UI & Theming**
  - Fully responsive design for mobile (320px+), tablet (768px+), laptop (1024px+), and desktop (1280px+).
  - Accessible Light / Dark theme toggle stored persistently in `localStorage`.

---

## 5. Non-Functional Requirements (NFR)

- **NFR-01: Performance & Response Time**
  - Static pages must load under 1.0 second on standard broadband.
  - Database queries must execute within 50ms using indexed columns (Foreign Keys, Email, Event Date).
  - JSON API endpoints must respond within 200ms.

- **NFR-02: Security & Data Integrity**
  - SQL Injection Prevention: 100% prepared statements (`mysqli_stmt` or PDO) with parameterized queries.
  - Cross-Site Scripting (XSS) Prevention: All dynamic outputs escaped using `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`.
  - Cross-Site Request Forgery (CSRF) Prevention: CSRF tokens for state-changing POST/PUT/DELETE requests.
  - File Upload Security: Whitelisted extensions, MIME verification (`mime_content_type`), max 2MB file limit, executable execution blocked in upload directory.
  - Session Security: `HttpOnly` and `SameSite=Strict` cookie flags, 30-minute idle session timeout.

- **NFR-03: Usability & Accessibility (WCAG 2.1 AA Compliance)**
  - Semantic HTML5 landmark structure (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<aside>`, `<footer>`).
  - Skip-to-main-content accessible navigation links for screen readers.
  - Minimum color contrast ratio of 4.5:1 for normal text and 3:1 for large text.
  - Full keyboard navigability (Tab, Shift+Tab, Enter, Space, Escape for modals).
  - Explicit `<label>` associations for all form controls.

- **NFR-04: Maintainability & Code Quality**
  - Clean separation of concerns: Presentation (HTML/CSS), Client Logic (JS), Business/Server Logic (PHP), Data Persistence (MySQL).
  - Standardized modular directory structure.
  - Comprehensive documentation and self-explanatory code comments for academic viva defense.

---

## 6. Technology Stack

- **Client Tier:** HTML5, CSS3 (Custom CSS Grid & Flexbox, CSS Variables), JavaScript ES6+ (Fetch API, DOM manipulation, Web Storage API).
- **Server Tier:** PHP 8.0+ (Vanilla procedural/modular architecture, PHP Sessions, MySQLi Prepared Statements).
- **Data Tier:** MySQL 8.0 / MariaDB, phpMyAdmin.
- **Development Environment:** VS Code, XAMPP (Apache + MySQL), Git, GitHub.
