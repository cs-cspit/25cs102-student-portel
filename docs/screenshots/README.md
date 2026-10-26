# StudentHub Portal — Practical 15 Screenshot Verification Catalog

This directory contains 15 genuine high-resolution screenshots captured from the live StudentHub portal running on Apache 2.4 and MySQL 8.0 via XAMPP (`http://localhost/studenthub/`).

| Screenshot File | Description | Tested Feature / Verification Focus |
| :--- | :--- | :--- |
| **`01-home.png`** | Dynamic Portal Home Page | Live MySQL metrics (20+ students, 16 events), role navigation, accessibility skip link |
| **`02-registration-validation.png`** | Student Registration & Validation | Client-side HTML5/regex validation and server duplicate email rejection |
| **`03-login-success.png`** | Authentication Gateway | User login with 1-click test credentials buttons, security warnings, status banners |
| **`04-student-dashboard.png`** | Student Portal Dashboard | Personalized student welcome, active enrolled campus events, academic profile links |
| **`05-student-crud.png`** | Admin Student Directory | Full CRUD table, live search & course filter, modal dialogues, CSRF hidden tokens |
| **`06-event-management.png`** | Admin Event Management | Campus event table, poster image preview, 2MB & MIME file upload validation |
| **`07-admin-dashboard.png`** | Admin Analytics Console | Dynamic real-time KPI metric cards, registration table, audit activity feed |
| **`08-access-denied.png`** | RBAC Privilege Enforcement | Unauthorized visitor intercepted and redirected from `/admin/*` to `login.html` |
| **`09-ajax-crud.png`** | Fetch API & Asynchronous Operations | Seamless student record mutation without page reload with Toast notification |
| **`10-mobile-responsive.png`** | Mobile Viewport Layout | 375x812 mobile view: stacked cards, responsive navigation drawer, zero horizontal overflow |
| **`11-database-tables.png`** | Database Schema & Seed Data | phpMyAdmin view confirming 5 normalized tables (`users`, `students`, `events`, `registrations`, `audit_logs`) |
| **`12-events-catalog.png`** | Public Event Catalog | High-resolution 16:9 banner posters, category filters (Technical, Cultural, Sports) |
| **`13-logout-session.png`** | Session Destruction & Logout | `php/logout.php` session revocation and safe redirect with `status=logged_out` |
| **`14-student-profile.png`** | Student Academic Profile | Profile viewer and editor with student details from MySQL database |
| **`15-audit-logs.png`** | Security Audit Trail Explorer | Detailed log viewer showing action types, user IDs, client IPs, and timestamps |
