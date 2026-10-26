# StudentHub Portal — Practical 15 Viva & Demo Guide

**Institution:** CHARUSAT — Faculty of Technology & Engineering (CSPIT)  
**Subject:** Web Development Frameworks (ITUE203)  
**Semester:** 3rd Semester, 2026–27  
**Candidate Name:** Daksh Shah  
**Student ID:** 25CS102  
**Faculty Evaluator:** Dhara Ma'am  
**Target Duration:** 5–10 Minutes  

---

## 1. Quick Evaluator Credentials

| Role | Email | Password | Quick Login Feature |
| :--- | :--- | :--- | :--- |
| **System Admin** | `admin@studenthub.edu` | `Admin@123` | On `login.html`, click **"Fill Admin Credentials"** |
| **Student** | `25cs102@charusat.edu.in` | `Student@123` | On `login.html`, click **"Fill Student Credentials"** |

---

## 2. Recommended Demonstration Flow (Step-by-Step)

### Step 1: Portal Landing Page & Dynamic Metrics (1 min)
- **URL:** [http://localhost/studenthub/index.php](http://localhost/studenthub/index.php)
- **Key Talking Points:**
  - Dynamic PHP integration: Point out that the metrics (Total Students: 20+, Campus Events: 16, Active Registrations: 5) are queried directly from MySQL on page load.
  - Session Awareness: Point out how the top navigation updates dynamically depending on whether a guest, student, or admin is browsing.
  - Accessibility: Press <kbd>Tab</kbd> immediately on load to show the visible `"Skip to main content"` bypass link.

---

### Step 2: Events Catalog & REST API Integration (1 min)
- **URL:** [http://localhost/studenthub/events.html](http://localhost/studenthub/events.html)
- **Key Talking Points:**
  - Modern ES6 Fetch Architecture: Open Browser DevTools (<kbd>F12</kbd> &rarr; Network tab) and show that events are loaded via asynchronous `fetch('api/events.php')`.
  - Filter Buttons: Click **"Technical"**, **"Cultural"**, and **"Sports"** filters to demonstrate client-side filtering without page reload.
  - Rich Media: Point out the high-resolution event banners (`event1.jpg`, `event2.jpg`, `event3.jpg`) rendered with CSS aspect-ratio and responsive cards.

---

### Step 3: Student Registration & Validation (1.5 min)
- **URL:** [http://localhost/studenthub/register.html](http://localhost/studenthub/register.html)
- **Key Talking Points:**
  - Client Validation: Submit empty fields to show client-side constraint feedback.
  - Server Validation: Enter a duplicate email (`25cs102@charusat.edu.in`) and submit. Show that the backend catches duplicate keys and returns a friendly banner alert.
  - Password Security: Explain that passwords are encrypted using PHP `password_hash()` with BCRYPT cost 10 before storage.

---

### Step 4: Role-Based Access Control (RBAC) Denial Test (30 sec)
- **Action:** Open an Incognito / Private window (no active session).
- **URL:** Attempt to access [http://localhost/studenthub/admin/index.php](http://localhost/studenthub/admin/index.php) directly.
- **Key Talking Points:**
  - Point out that `php/admin-auth.php` intercepts the request, verifies the lack of administrative privileges, and immediately redirects to `login.html?error=admin_login_required`.
  - Mention that all admin endpoints verify role enforcement on the server side, preventing privilege escalation.

---

### Step 5: Admin Console & KPI Analytics (1 min)
- **URL:** [http://localhost/studenthub/login.html](http://localhost/studenthub/login.html)
- **Action:** Click **"Fill Admin Credentials"** &rarr; Submit.
- **Key Talking Points:**
  - Session Regeneration: Point out that upon login, `session_regenerate_id(true)` is executed to defeat session fixation.
  - Admin Dashboard (`admin/index.php`): Show live KPI cards (Total Students, Active Events, Registrations, Audit Log Count) computed via MySQL queries.
  - Quick Shortcuts & Recent Registrations table.

---

### Step 6: Dual-Mode Student Management CRUD (2 min)
- **URL:** [http://localhost/studenthub/admin/students.php](http://localhost/studenthub/admin/students.php)
- **Key Talking Points:**
  - **Live Search & Filter:** Type `"Daksh"` or choose `"B.Tech CSE"` in the filter bar to demonstrate parameterized query filtering.
  - **Asynchronous AJAX Delete:** Open the DevTools console, click **"Delete"** on a test row, confirm the prompt. Observe that the row smoothly fades out and a Toast notification appears with zero page reload (`ajaxDeleteStudent` function).
  - **CSRF Protection:** Inspect the HTML form markup to show `<input type="hidden" name="csrf_token" value="...">`, proving all state changes require a cryptographic token.
  - **SQL Injection Defense:** All queries utilize `executeQuery()` with bound parameters (e.g., `$stmt->bind_param("ss", ...)`).

---

### Step 7: Event Management & Secure File Upload (1.5 min)
- **URL:** [http://localhost/studenthub/admin/events.php](http://localhost/studenthub/admin/events.php)
- **Key Talking Points:**
  - Click **"Add New Event"** modal.
  - File Upload Security: Explain the 5-step server-side validation pipeline in `admin/events.php`:
    1. Size verification: Strict &le; 2MB limit.
    2. Extension whitelist: `.jpg`, `.jpeg`, `.png` only.
    3. Binary MIME check: Inspected using PHP `finfo_file(FILEINFO_MIME_TYPE)` to prevent renamed scripts.
    4. Safe renaming: File renamed to `event_{timestamp}_{hash}.ext`.
    5. Directory execution guard: Show `uploads/.htaccess` with `php_flag engine off`, preventing execution of uploaded PHP scripts.

---

### Step 8: Audit Trail Explorer (1 min)
- **URL:** [http://localhost/studenthub/admin/audit-logs.php](http://localhost/studenthub/admin/audit-logs.php)
- **Key Talking Points:**
  - Point out that every critical action (Admin login, Student deletion, Event creation) has been automatically logged into `audit_logs`.
  - The log displays User ID, Action Type, Table Name, Record ID, IP Address (`127.0.0.1`), and Timestamp.
  - Sensitive details (passwords, session cookies) are strictly excluded from the audit log payload.

---

### Step 9: Responsive Design & Accessibility (30 sec)
- **Action:** In Browser DevTools, toggle Device Mode (<kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>M</kbd>) and select **iPhone 12 / Dimensions: 375x812**.
- **Key Talking Points:**
  - Responsive Grid: Show how cards and tables stack cleanly with zero horizontal overflow.
  - Hamburger Navigation: Toggle the responsive mobile navigation drawer.
  - Color Contrast: Text and UI badges comply with WCAG 2.1 AA color contrast standards.

---

### Step 10: Secure Logout (30 sec)
- **Action:** Click **"Logout"** in the navigation bar.
- **Key Talking Points:**
  - `php/logout.php` clears `$_SESSION`, destroys the session file on the server, expires the `PHPSESSID` cookie, and safely redirects to `login.html?status=logged_out`.
  - Pressing the browser "Back" button and clicking dashboard links redirects to login because the server-side session is fully invalidated.

---

## 3. Potential Viva Voce Questions & Model Answers

**Q1: How do you prevent SQL Injection across your portal?**  
*Answer:* We completely avoid dynamic string concatenation in SQL queries. Instead, we use MySQLi prepared statements through our helper wrapper (`executeQuery($sql, $types, $params)`). User input is treated strictly as data parameters rather than executable SQL code.

**Q2: How is CSRF mitigated in your admin operations?**  
*Answer:* We generate a cryptographically strong 32-byte pseudo-random token using `random_bytes(32)` stored in the user's session. Every mutating form includes this token as a hidden input. Before executing state modifications, the backend uses `hash_equals()` to prevent timing attacks while verifying token authenticity.

**Q3: How do you prevent malicious executable file uploads (like PHP web shells)?**  
*Answer:* We implement defense-in-depth:
1. File extension validation against a strict whitelist (`.jpg, .jpeg, .png`).
2. MIME-type validation using `finfo_file()` to inspect the binary file header.
3. Randomization of uploaded filenames so attackers cannot know or predict the path.
4. An `.htaccess` configuration inside `uploads/` that disables PHP script execution (`php_flag engine off`) and directory indexing.

**Q4: What is the difference between your Fetch API operations and traditional form submits?**  
*Answer:* Traditional forms submit multipart/form-data causing a full page refresh and 302 redirect. Our Fetch API implementation (`api/students.php` and `ajaxDeleteStudent`) uses asynchronous HTTP requests returning JSON responses, updating the DOM and displaying user feedback via Toast notifications without reloading the page.

---

*Demo guide prepared and verified for Practical 15 evaluation.*
