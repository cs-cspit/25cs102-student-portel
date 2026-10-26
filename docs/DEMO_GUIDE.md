# StudentHub — Practical 15 Viva & Demo Evaluation Guide

**Subject:** ITUE203 — Web Development Frameworks  
**Candidate Name:** Daksh Shah (Roll No: 25CS102)  
**Evaluator:** Prof. Dhara Ma'am  
**Target Duration:** 5 to 7 Minutes  

---

## 1. Quick Demonstration Workflow (5–7 Minute Sequence)

Follow this structured sequence to demonstrate the complete full-stack portal to the practical examiner:

### Minute 1: Public Portal, Layout & Client Interactivity
1. Open `http://localhost/studenthub/` in the browser.
2. Highlight:
   - Semantic HTML5 structure (Header, Nav, Hero, Stats, Footer).
   - Theme toggle in the navbar (Toggle between **Light Mode** and **Dark Mode** to show CSS custom property variables and `localStorage` persistence).
   - Responsive mobile navigation (hamburger menu).
3. Navigate to `events.html`:
   - Type a keyword (e.g. "Hackathon") in the search bar to demonstrate real-time client-side DOM filtering.
   - Click category filter chips ("Workshop", "Sports", "Technical") to show dynamic categorization without page reloads.

### Minute 2: Student Registration & Client-Side Regex Validation
1. Click **Register** (`register.html`).
2. Demonstrate Client-Side Validation:
   - Click the "Create Student Account" button with blank inputs. Show the red outline highlighting and contextual warning badges.
   - Enter an invalid email format (e.g., `invalid-email`). Show the real-time regex validation rejecting it.
   - Enter a weak password (e.g., `123`). Show the password strength meter indicator.
3. Explain that client validation enhances UX, while server-side validation in `php/register.php` acts as the mandatory security gatekeeper.

### Minute 3: Student Authentication & Student Dashboard
1. Click **Login** (`login.html`).
2. Demonstrate failed authentication:
   - Enter `25cs102@charusat.edu.in` with an incorrect password. Show the secure "Authentication Failed" error screen and mention that the attempt is captured in `audit_logs`.
3. Demonstrate successful authentication:
   - Enter `25cs102@charusat.edu.in` and password `Student@123`.
   - Click **Login**. Show the 302 redirect landing on `dashboard.php`.
4. Point out student-specific features:
   - Greeting banner displaying "Daksh Shah (25CS102)".
   - Enrolled events list populated dynamically from the `registrations` MySQL table.
   - Quick actions to edit profile (`profile.php`).

### Minute 4: Role-Based Access Control (RBAC) Security Proof
1. While still logged in as the student, attempt to manually navigate to:
   `http://localhost/studenthub/admin/index.php`
2. Show that `php/admin-auth.php` immediately intercepts the request, blocks access, and renders a 403 **"Access Denied"** security page.
3. Click **Logout** (`php/logout.php`) to demonstrate complete session destruction and cookie clearing.

### Minute 5: Administrator Console & Management CRUD
1. Log in with Administrator credentials:
   - Email: `admin@studenthub.edu`
   - Password: `Admin@123`
2. Lands on `admin/index.php`:
   - Point out real-time KPI counter cards: **20 Students, 16 Events, 5 Registrations, 5 User Accounts** sourced live from MySQL queries.
3. Navigate to **Students** (`admin/students.php`):
   - Show the 20 registered students.
   - Demonstrate the search box filtering by name or course.
   - Open the "Add New Student" modal to show the parameterized prepared statement form.
4. Navigate to **Events** (`admin/events.php`):
   - Show the campus event catalog with poster thumbnails.
   - Explain file upload security: binary MIME verification via `finfo_file()`, extension whitelisting, 2MB size limit, and randomized filenames.

### Minute 6: Forensic Audit Trail & RESTful JSON APIs
1. Navigate to **Audit Logs** (`admin/audit-logs.php`):
   - Point out the immutable audit table displaying recent `USER_LOGIN`, `FAILED_LOGIN`, and event registrations, including the client IP address (`::1` or `127.0.0.1`) and exact timestamp.
2. Demonstrate RESTful JSON API:
   - Open a new browser tab to `http://localhost/studenthub/api/students.php`.
   - Show the standardized JSON payload (`{ "success": true, "data": [...] }`) with 20 student profiles.
   - Open `http://localhost/studenthub/api/events.php` to show the 16 event records.

---

## 2. Master Viva Voce Questions & Answers (Examiner Favorites)

### Q1: What architecture does StudentHub follow?
**Answer:** StudentHub follows a classic 3-Tier Web Architecture:
- **Presentation Tier:** Semantic HTML5, CSS3 Grid/Flexbox design tokens, and Vanilla ES6+ JavaScript.
- **Application / Business Tier:** PHP 8.2 modular controllers with Session RBAC, RESTful JSON APIs, and secure file upload handling.
- **Database Persistence Tier:** MySQL 8.0 normalized relational schema (3NF) using InnoDB, foreign keys with cascading actions, and parameterized prepared statements via MySQLi.

### Q2: How does the application prevent SQL Injection attacks?
**Answer:** All dynamic queries throughout the portal (in `php/db.php`, `login.php`, `register.php`, `admin/*.php`, and `api/*.php`) strictly utilize parameterized prepared statements (`$stmt->prepare()` and `$stmt->bind_param()`). User inputs are treated solely as literal values and are never directly concatenated into SQL query strings.

### Q3: How do you protect against Session Fixation and Session Hijacking?
**Answer:**
1. **Session Fixation Prevention:** We invoke `session_regenerate_id(true)` immediately upon credential verification during login, issuing a fresh session identifier and destroying the old one.
2. **Session Hijacking Defenses:** Session cookies are configured with `HttpOnly=true` (disallowing client-side JavaScript access via XSS) and `SameSite=Strict` (preventing CSRF transmission).
3. **Inactivity Expiration:** A 30-minute inactivity timer (`$_SESSION['last_activity']`) automatically invalidates abandoned sessions.

### Q4: How is Cross-Site Scripting (XSS) mitigated?
**Answer:** Any user-supplied data or database fields displayed within HTML pages are encoded using `htmlspecialchars($data, ENT_QUOTES, 'UTF-8')`. This converts dangerous characters such as `<`, `>`, `"`, and `'` into harmless HTML character entities.

### Q5: How do the RESTful API endpoints decouple frontend and backend?
**Answer:** The endpoints in `/api/` return standardized JSON responses with standard HTTP status codes (`200 OK`, `201 Created`, `400 Bad Request`, `404 Not Found`). This allows client-side JavaScript to perform asynchronous CRUD operations using `fetch()` without full page reloads, and enables future expansion to native mobile apps.

### Q6: What security controls exist on the event poster file upload?
**Answer:**
1. Server-side extension check strictly limited to `.jpg`, `.jpeg`, and `.png`.
2. Binary content inspection using PHP's `finfo_file(FILEINFO_MIME_TYPE)` to verify the actual file MIME type.
3. 2MB file size ceiling.
4. Storage in a dedicated directory (`uploads/events/`) with cryptographically randomized filenames (`event_<timestamp>_<hex>.ext`) to prevent arbitrary script execution or filename collision.

### Q7: What is the purpose of the `audit_logs` table?
**Answer:** It provides accountability and forensic traceability. Whenever sensitive actions occur (successful logins, failed login attempts, profile changes, student creations, or event deletions), the system records the actor user ID, action name, target entity, client IP address, and timestamp.
