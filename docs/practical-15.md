# Practical 15: Final Integration, Testing, Documentation, and Local Deployment

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED (15/15 Milestones Achieved)  

---

## 1. Practical Title
**Full-Stack End-to-End System Integration, Security Auditing, Comprehensive 24-Point Test Suite Verification, Project Documentation, and Local Apache/MySQL Deployment**

---

## 2. Objective
To perform final full-stack integration, automated and manual verification, security validation, documentation consolidation, and deployment of the **StudentHub** semester-long project. The process verifies seamless interoperation between Semantic HTML5 pages, CSS Grid/Flexbox layouts, Vanilla ES6+ DOM interactivity, client/server validation, RESTful JSON APIs, PHP Session RBAC, relational MySQL 3NF schemas, secure media uploads, and audit logging.

---

## 3. Comprehensive 24-Point Verification Test Matrix

| Test ID | System Domain | Test Scenario & Action | Expected Result | Actual Result | Status |
| :---: | :--- | :--- | :--- | :--- | :---: |
| **TC-15-01** | Frontend Auth | Registration success with valid details | User record created in `users` & `students`; redirected to login | Dual insert succeeded | **PASS** |
| **TC-15-02** | Frontend Auth | Registration failure with empty fields | Client & server reject submission; display field alerts | Submission blocked | **PASS** |
| **TC-15-03** | Frontend Auth | Registration with duplicate email | Server rejects with duplicate account alert | Duplicate blocked | **PASS** |
| **TC-15-04** | Authentication | Login success as Student | Password verified via `password_verify`; lands on `dashboard.php` | Student login passed | **PASS** |
| **TC-15-05** | Authentication | Login failure with wrong password | Error screen rendered; failed attempt logged in `audit_logs` | Rejected & logged | **PASS** |
| **TC-15-06** | Authentication | Logout execution | Session destroyed; `PHPSESSID` wiped; redirected to `login.html` | Session destroyed | **PASS** |
| **TC-15-07** | Session Security| Inactivity Timeout (>30 min) | Session auto-expires; subsequent request prompts login | Inactivity timeout passed | **PASS** |
| **TC-15-08** | RBAC Guard | Student access to `dashboard.php` | Allowed; renders student greeting and enrolled events | Access granted | **PASS** |
| **TC-15-09** | RBAC Guard | Admin access to `admin/index.php` | Allowed; renders administrative metrics and console | Access granted | **PASS** |
| **TC-15-10** | RBAC Guard | Student attempts accessing `/admin` | Blocked by `admin-auth.php`; redirected with 403 alert | Unauthorized access blocked | **PASS** |
| **TC-15-11** | Admin CRUD | Student CRUD Operations | Admin can Add, View, Edit, and Delete student records | Full CRUD functional | **PASS** |
| **TC-15-12** | Admin CRUD | Event CRUD Operations | Admin can Publish, View, Edit, and Delete campus events | Full CRUD functional | **PASS** |
| **TC-15-13** | File Upload | Valid Event Poster Upload | Image saved in `uploads/events/` with sanitized filename | Image uploaded safely | **PASS** |
| **TC-15-14** | File Upload | Malicious / Invalid Poster Upload | Non-image binaries (`.php`, `.exe`) rejected via `finfo_file` | Malicious file blocked | **PASS** |
| **TC-15-15** | Live Search | Live search in Events Catalog | Asynchronous filtering without page refresh | Real-time search passed | **PASS** |
| **TC-15-16** | Live Filter | Category filter in Events Catalog | Filters by Technical, Workshop, Cultural, Sports | Category filter passed | **PASS** |
| **TC-15-17** | RESTful API | `GET /api/students.php` | Returns `200 OK` JSON array of student profiles | `200 OK` JSON returned | **PASS** |
| **TC-15-18** | RESTful API | `POST /api/students.php` | Creates student record; returns `201 Created` | `201 Created` returned | **PASS** |
| **TC-15-19** | RESTful API | `PUT /api/students.php` | Updates student details; returns `200 OK` | `200 OK` returned | **PASS** |
| **TC-15-20** | RESTful API | `DELETE /api/students.php` | Deletes student by ID; returns `200 OK` | `200 OK` returned | **PASS** |
| **TC-15-21** | Security Audit | Automated Audit Logging | Log entries created with actor ID, action, entity, IP | Forensic audit logged | **PASS** |
| **TC-15-22** | Responsive UI | Mobile Viewport (<768px) | 1-column responsive layout, stacked navbar, touch targets | Mobile UI passed | **PASS** |
| **TC-15-23** | Responsive UI | Tablet Viewport (768px-1023px) | 2-column grid cards, scaled typography | Tablet UI passed | **PASS** |
| **TC-15-24** | Responsive UI | Desktop Viewport ($\ge$1024px) | 3-column event grid, centered 1200px container | Desktop UI passed | **PASS** |

---

## 4. Final System Architecture Summary

```
+-----------------------------------------------------------------------------------+
|                                  STUDENTHUB PORTAL                                |
+-----------------------------------------------------------------------------------+
| FRONTEND TIER                                                                     |
|  - Semantic HTML5 Landmarks (<header>, <nav>, <main>, <section>, <article>, <footer>)
|  - CSS3 Grid & Flexbox Responsive Design System with Light/Dark Mode Theming      |
|  - Vanilla JavaScript ES6+ (Fetch API, DOM Modals, Sliders, Accordions, Regex)    |
+-----------------------------------------------------------------------------------+
| BACKEND & API TIER                                                                |
|  - PHP 8+ Modular Business Logic & Secure Session RBAC Middleware                |
|  - RESTful JSON API Endpoints (/api/students.php, /api/events.php)                |
|  - Multi-Layer File Upload Security (MIME Verification, Sanitized Hashing)        |
+-----------------------------------------------------------------------------------+
| DATABASE & PERSISTENCE TIER                                                       |
|  - MySQL 8.0 3NF Relational Database (users, students, events, registrations, logs)|
|  - 100% Prepared Statements via MySQLi with Cascading Foreign Keys                |
|  - Automated Audit Trail Logging with Client IP Addresses                         |
+-----------------------------------------------------------------------------------+
```

---

## 5. Master Viva Voce Preparation Guide (10 Core Questions)

### Q1: What makes StudentHub a complete full-stack web application?
**Answer:** StudentHub integrates all three architectural tiers: a responsive, accessible presentation tier (HTML5/CSS3/ES6+ JS), an authenticated business logic and API tier (PHP 8+ sessions and RESTful JSON endpoints), and a secure relational persistence tier (MySQL 3NF schema with prepared statements and audit logging).

### Q2: How does the application protect against SQL Injection?
**Answer:** 100% of dynamic database queries use parameterized prepared statements (`$stmt->prepare()` and `$stmt->bind_param()`), ensuring that user inputs are treated strictly as data literals and cannot alter the SQL statement structure.

### Q3: How is Cross-Site Scripting (XSS) mitigated?
**Answer:** All dynamic outputs rendered from user input or database records are escaped using `htmlspecialchars($data, ENT_QUOTES, 'UTF-8')`, converting dangerous HTML control characters (`<`, `>`, `&`, `"`, `'`) into harmless HTML entities.

### Q4: Explain the session security mechanisms implemented in StudentHub.
**Answer:**
1. `session_regenerate_id(true)` upon login to prevent session fixation.
2. `HttpOnly` cookie flag to prevent JavaScript cookie theft via XSS.
3. `SameSite=Strict` cookie flag to defend against Cross-Site Request Forgery (CSRF).
4. 30-minute inactivity timer that auto-destroys abandoned sessions.

### Q5: How does client-side validation interact with server-side validation?
**Answer:** Client-side JavaScript validation provides instant visual feedback to improve user experience (UX) and reduce server load. Server-side PHP validation is the mandatory security gatekeeper that guarantees data integrity even if client-side validation is bypassed or disabled.

### Q6: What is the purpose of the RESTful API endpoints in `/api`?
**Answer:** They decouple the data access layer from the presentation layer, allowing asynchronous AJAX/Fetch CRUD operations without full-page reloads and enabling future extensions to mobile applications or third-party campus systems.

### Q7: How does the file upload system prevent malicious PHP script execution?
**Answer:**
1. Extension whitelisting (`.jpg`, `.jpeg`, `.png`).
2. Binary MIME verification via `finfo_file()`.
3. 2MB file size ceiling.
4. Cryptographically randomized filename generation (`event_<time>_<hex>.ext`).
5. Storage in dedicated `uploads/events/` directory.

### Q8: What role do database Foreign Keys play in StudentHub?
**Answer:** Foreign keys enforce referential integrity across tables. With `ON DELETE CASCADE`, deleting a student automatically cleans up all corresponding event registrations, preventing orphan records and database inconsistency.

### Q9: How does the Light/Dark mode theme toggle work?
**Answer:** The JavaScript theme switcher modifies the `data-theme` attribute on the `<html>` root element, triggering CSS custom property overrides, and stores the user's choice in browser `localStorage` to persist across page reloads.

### Q10: What is the purpose of the `audit_logs` table?
**Answer:** It maintains an immutable audit trail of critical actions (logins, logouts, student/event creations, edits, and deletions) along with actor user IDs, affected entity IDs, client IP addresses, and exact timestamps for security compliance.

---

## 6. Conclusion
The **StudentHub** semester-long practical project for subject **ITUE203: Web Development Frameworks** has been built progressively and verified across all 15 practical milestones. The project conforms to academic and industry software engineering standards, featuring clean architecture, responsive accessibility, robust security, and full GitHub version history.
