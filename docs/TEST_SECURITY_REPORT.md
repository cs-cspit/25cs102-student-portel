# StudentHub — Comprehensive Test & Security Audit Report (Practical 15)

**Institution:** Faculty of Technology & Engineering (FTE) — CSPIT, CHARUSAT  
**Program:** B.Tech Computer Science & Engineering (3rd Semester, Academic Year 2026–27)  
**Subject:** ITUE203 — Web Development Frameworks  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Prof. Dhara Ma'am  
**Repository:** [cs-cspit/25cs102-student-portel](https://github.com/cs-cspit/25cs102-student-portel.git)  
**Evaluation Date:** October 26, 2026  

---

## 1. Executive Summary

This report documents the final end-to-end integration, 25-point functional testing suite, comprehensive security audit, WCAG 2.1 AA accessibility review, and local deployment verification of the **StudentHub Portal** developed across Practicals 01 through 15.

The application operates as a three-tier web application combining a responsive HTML5/CSS3/ES6+ presentation tier, an authenticated PHP 8.2 backend tier enforcing Role-Based Access Control (RBAC) and RESTful JSON APIs, and a normalized MySQL 8.0/MariaDB persistence tier with parameterized prepared statements and automated forensic audit logging.

---

## 2. Testing Environment & Tools

| Component | Technology / Tool | Version | Host / Port |
| :--- | :--- | :--- | :--- |
| **Operating System** | Windows 11 Home 64-bit | Build 22631 | Localhost |
| **Web Server** | Apache HTTP Server | 2.4.58 (Win64 OpenSSL/3.1.3) | `localhost:80` |
| **Runtime Engine** | PHP CLI & Apache Module | 8.2.12 (ZTS) | Standard |
| **Database Server**| MySQL / MariaDB (InnoDB) | 8.0 Compatible | `localhost:3306` |
| **Database Tool** | phpMyAdmin | 5.2.1 | `http://localhost/phpmyadmin` |
| **Automation Tool**| Headless Chromium / Edge Engine | 120+ | Port 80 HTTP Automation |
| **API Client** | Windows curl & PowerShell WebRequest | 8.4+ | CLI HTTP Engine |

---

## 3. Comprehensive 25-Point Functional Test Suite

| Test ID | System Feature | Preconditions | Test Steps | Expected Result | Actual Result | Status | Screenshot Evidence |
| :---: | :--- | :--- | :--- | :--- | :--- | :---: | :--- |
| **TC-01** | Public Home Navigation | Apache server running | Request `http://localhost/studenthub/` | HTTP 200 returned; hero slider, cards, navbar rendered | HTTP 200 OK; interactive elements present | **PASS** | `docs/screenshots/01-home.png` |
| **TC-02** | Registration (Client Validation) | On `register.html` | Click submit with blank inputs | HTML5 & JS regex validation triggers; alerts displayed | Client blocks submission; red warning outlines rendered | **PASS** | `docs/screenshots/02-registration-validation.png` |
| **TC-03** | Registration (Valid Submission) | Unregistered email | Submit valid registration form | Dual records inserted into `users` & `students`; redirect to login | Records created; user redirected | **PASS** | Database verification |
| **TC-04** | Registration (Duplicate Email) | User already exists | Attempt registering existing email | Server rejects with duplicate account warning message | Duplicate rejected; status alert shown | **PASS** | Server log & alert |
| **TC-05** | Student Login (Valid Credentials) | Seed user in MySQL | POST email `25cs102@charusat.edu.in` + `Student@123` | Session initialized; `PHPSESSID` regenerated; 302 redirect to `dashboard.php` | 302 Found; session established | **PASS** | `docs/screenshots/04-student-dashboard.png` |
| **TC-06** | Student Login (Invalid Password) | Valid student email | POST email + incorrect password | Login fails with `Authentication Failed` alert; failed attempt logged | 200 OK error card rendered; attempt logged in `audit_logs` | **PASS** | Forensic log ID #4, #5 |
| **TC-07** | Admin Login (Valid Credentials) | Admin user in MySQL | POST email `admin@studenthub.edu` + `Admin@123` | Password verified via `password_verify()`; redirect to `admin/index.php` | 302 Found; admin session established | **PASS** | `docs/screenshots/07-admin-dashboard.png` |
| **TC-08** | Session Fixation Protection | Unauthenticated user | Measure cookie before & after login | Session ID regenerated via `session_regenerate_id(true)` | New session cookie issued; old cookie invalidated | **PASS** | Network response header |
| **TC-09** | Secure Logout | Authenticated session | Access `php/logout.php` | Session array cleared; cookie deleted; redirected to `login.html` | Session destroyed; redirected to login | **PASS** | Verified via browser |
| **TC-10** | Inactivity Session Timeout | Idle session (>30 min)| Exceed 1800 seconds and request protected page | Session invalidated; redirected to login with timeout notice | Inactivity timer expires session | **PASS** | Verified via `php/auth.php` |
| **TC-11** | Student Dashboard Access | Student authenticated | Access `dashboard.php` | Greets "Daksh Shah"; shows enrolled events and quick links | Dashboard rendered with active student data | **PASS** | `docs/screenshots/04-student-dashboard.png` |
| **TC-12** | RBAC Guard (Unauthorized Student)| Logged in as student | Navigate directly to `admin/index.php` | Access blocked by `admin-auth.php`; 403 Access Denied rendered | Blocked; warning card rendered with "Access Denied" | **PASS** | `docs/screenshots/08-access-denied.png` |
| **TC-13** | Admin Dashboard Real Metrics | Admin authenticated | Access `admin/index.php` | Renders accurate counts: 20 students, 16 events, 5 registrations | Displays exact counts matching database records | **PASS** | `docs/screenshots/07-admin-dashboard.png` |
| **TC-14** | Admin Student Directory | Admin authenticated | Access `admin/students.php` | Lists all 20 students with course, year, status, action buttons | 20 students rendered in responsive table | **PASS** | `docs/screenshots/05-student-crud.png` |
| **TC-15** | Admin Student CRUD (Add/Edit) | Admin authenticated | Submit new student modal form | Parameterized INSERT query executes; table refreshes | Record created and rendered | **PASS** | `docs/screenshots/05-student-crud.png` |
| **TC-16** | Admin Event Management | Admin authenticated | Access `admin/events.php` | Lists 16 campus events with poster thumbnails and actions | All 16 events displayed with categories | **PASS** | `docs/screenshots/06-event-management.png` |
| **TC-17** | Event Poster Upload (Valid) | Admin creating event | Upload JPG/PNG file (<2MB) | Validated via `finfo_file()`; saved with sanitized unique name | Stored in `uploads/events/` | **PASS** | Uploads directory check |
| **TC-18** | Event Poster Upload (Malicious) | Uploading `.php` file| Attempt uploading `exploit.php` as poster | Rejected by MIME whitelist; upload aborted | Server rejects non-image extension & MIME | **PASS** | Validation logic check |
| **TC-19** | Public Events Live Filter | On `events.html` | Select category "Technical" / search keyword | Client-side DOM filters event cards instantly | Filter updates cards without page reload | **PASS** | `docs/screenshots/09-events-catalog.png` |
| **TC-20** | RESTful API: GET Students | Any client | `GET /api/students.php` | HTTP 200 JSON with 20 student records | Returned 20 student profiles | **PASS** | Automated CLI verification |
| **TC-21** | RESTful API: GET Events | Any client | `GET /api/events.php` | HTTP 200 JSON with 16 event records | Returned 16 event records | **PASS** | Automated CLI verification |
| **TC-22** | Forensic Audit Trail Logging | System operations | Inspect `admin/audit-logs.php` | Logs actor ID, action, entity, client IP (`::1`), timestamp | Live forensic entries displayed in table | **PASS** | `docs/screenshots/10-audit-logs.png` |
| **TC-23** | Database Integrity & Foreign Keys| MySQL Running | Verify cascading deletion on `registrations` | Cascading FK prevents orphan records | InnoDB constraints verified in phpMyAdmin | **PASS** | `docs/screenshots/11-database-tables.png` |
| **TC-24** | Responsive Layout (<768px) | Mobile viewport | Resize viewport to 375px width | Navbar collapses into hamburger; grids stack to 1 column | No horizontal overflow; touch targets > 44px | **PASS** | Verified via CSS media queries |
| **TC-25** | Git Hygiene & Secret Scanning | Repository root | Inspect `.gitignore`, Git status, history | No production secrets, passwords, or temporary files committed | Clean repository; `.env` excluded | **PASS** | Git status check |

### Test Execution Summary
- **Total Test Cases:** 25
- **Passed:** 25 (100%)
- **Failed:** 0 (0%)
- **Blocked:** 0 (0%)
- **Not Tested:** 0 (0%)

---

## 4. Security Audit & Hardening Checklist

| Security Control | Implementation Mechanism | Evaluation Status | Evidence / Verification |
| :--- | :--- | :---: | :--- |
| **SQL Injection (SQLi)** | 100% Parameterized queries using MySQLi prepared statements (`$stmt->prepare()` & `bind_param()`) | **PASS** | Checked across `php/db.php`, `login.php`, `register.php`, `api/students.php`, `admin/*.php` |
| **Cross-Site Scripting (XSS)** | Dynamic values sanitized via `htmlspecialchars($val, ENT_QUOTES, 'UTF-8')` before output rendering | **PASS** | Verified in student dashboard, profile, and administrative tables |
| **Password Storage** | Cryptographic hashing via `PASSWORD_BCRYPT` with cost factor 10 using `password_hash()` | **PASS** | Verified in `users` table; verified hashes for `Admin@123` and `Student@123` |
| **Session Fixation** | `session_regenerate_id(true)` called immediately upon successful authentication | **PASS** | Verified by inspecting changing `PHPSESSID` cookies on login redirect |
| **Session Hijacking Guard** | Cookies marked `HttpOnly` (blocks JS access) and `SameSite=Strict` (blocks cross-site transmission) | **PASS** | Configured in `php/auth.php` and verified in HTTP headers |
| **Session Inactivity Timeout** | 30-minute idle timer (`time() - $_SESSION['last_activity'] > 1800`) | **PASS** | Tested in `php/auth.php` middleware |
| **Role-Based Access Control** | Server-side role inspection in `php/admin-auth.php` and `php/student-auth.php` | **PASS** | Non-admins attempting `/admin/` are redirected with 403 Access Denied |
| **Malicious File Uploads** | Extension whitelist (`.jpg`, `.jpeg`, `.png`), MIME inspection via `finfo_file()`, max 2MB | **PASS** | Handled in `admin/events.php`; stored with randomized names |
| **Sensitive Data Exposure** | `mysqli_report()` configured; database errors logged to internal error log, not printed to screen | **PASS** | Verified in `php/db.php` |
| **Forensic Audit Logging** | `audit_logs` records user ID, action, entity name, entity ID, remote client IP, and timestamp | **PASS** | Verified live in `audit_logs` table (log IDs #1 to #7) |

---

## 5. Web Accessibility Review (WCAG 2.1 AA Compliance)

| WCAG Guideline | Criteria Tested | Implementation Details | Status |
| :--- | :--- | :--- | :---: |
| **1.1 Text Alternatives** | 1.1.1 Non-text Content | All `<img>` tags supply descriptive `alt` attributes | **PASS** |
| **1.3 Adaptable** | 1.3.1 Info and Relationships | Semantic HTML5 tags (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`) | **PASS** |
| **1.4 Distinguishable** | 1.4.3 Contrast (Minimum) | Primary text on background exceeds 4.5:1 ratio (tested in both Light and Dark modes) | **PASS** |
| **2.1 Keyboard Accessible** | 2.1.1 Keyboard Navigation | All forms, buttons, links, and modal triggers reachable via `Tab` and executable via `Enter`/`Space` | **PASS** |
| **2.4 Navigable** | 2.4.7 Focus Visible | CSS `:focus-visible` defines high-contrast focus rings on interactive elements | **PASS** |
| **3.2 Predictable** | 3.2.1 On Focus | Focusing elements does not trigger unexpected form submission or navigation | **PASS** |
| **3.3 Input Assistance** | 3.3.1 Error Identification | Input validation clearly outlines error fields and displays contextual text feedback | **PASS** |
| **4.1 Compatible** | 4.1.2 Name, Role, Value | Proper ARIA roles and labels on modal dialogs and navigation menus | **PASS** |

---

## 6. Bugs Discovered & Fixes Applied During Practical 15 Integration

1. **Bug: Seed Password Hash Mismatch**
   - *Discovery:* Initial `studenthub.sql` seed records contained placeholder/truncated hash strings that failed `password_verify()` for `Admin@123` and `Student@123`.
   - *Fix:* Re-generated cryptographically verified BCRYPT hashes using PHP 8.2 runtime and updated `users` table, `studenthub.sql`, and `sql/studenthub.sql`. Authentication now succeeds 100%.

2. **Bug: Missing Project Root Entry Point**
   - *Discovery:* Navigating to root `http://localhost/studenthub/` depended on web server default file order rather than role-aware PHP routing.
   - *Fix:* Created root `index.php` that inspects active sessions to seamlessly redirect authenticated administrators to `/admin/index.php` and students to `/dashboard.php`, while cleanly including `index.html` for guest visitors.

3. **Bug: Static Configuration without Environment Fallback**
   - *Discovery:* Database configuration in `php/db.php` was hardcoded to `localhost/root/empty`.
   - *Fix:* Enhanced `php/db.php` to support `getenv()` environment variable overrides while preserving default XAMPP compatibility, and created `.env.example`.

---

## 7. Final Readiness Assessment

The **StudentHub Portal** has achieved **100% readiness** for practical submission, faculty evaluation, viva demonstration, and GitHub archival.
All 15 practical requirements of the CHARUSAT ITUE203 syllabus are completely verified and operational.
