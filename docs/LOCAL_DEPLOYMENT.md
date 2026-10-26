# StudentHub Portal — Local Deployment Guide (XAMPP Environment)

**Institution:** CHARUSAT — Faculty of Technology & Engineering (CSPIT)  
**Subject:** Web Development Frameworks (ITUE203)  
**Semester:** 3rd Semester, 2026–27  
**Student:** Daksh Shah (25CS102)  
**Guide:** Dhara Ma'am  
**Practical:** 15 — Local Deployment Verification  

---

## 1. System Requirements & Prerequisites

Ensure the following prerequisites are installed and operational on your system:

- **Operating System:** Windows 10/11, macOS, or Ubuntu Linux
- **XAMPP Control Panel:** v3.3.0 or higher
- **Web Server:** Apache 2.4+ (Standard Port: `80` or `8080`)
- **PHP Runtime:** PHP 8.1 or PHP 8.2 (Tested on **PHP 8.2.12**)
  - Enabled PHP Extensions: `mysqli`, `pdo_mysql`, `fileinfo`, `session`, `json`, `curl`
- **Database Server:** MySQL 8.0+ or MariaDB 10.4+ (Standard Port: `3306`)
- **Web Browser:** Google Chrome, Microsoft Edge, Mozilla Firefox, or Safari (Modern ES6+ compatible)

---

## 2. Step-by-Step Installation & Deployment

### Step 1: Clone or Place Project in `htdocs`

1. Open your XAMPP installation directory (default: `C:\xampp\`).
2. Navigate to the `htdocs` directory: `C:\xampp\htdocs\`.
3. Create a folder named `studenthub` or create a directory symbolic link:
   ```cmd
   mklink /J "C:\xampp\htdocs\studenthub" "C:\Users\daksh\Documents\1. SEM - 3\WDF\pr 15"
   ```
4. Verify that `C:\xampp\htdocs\studenthub\index.php` is accessible.

---

### Step 2: Start Apache and MySQL Services

1. Open the **XAMPP Control Panel**.
2. Click **Start** next to **Apache**. (Ensure the indicator turns green on Port 80, 443).
3. Click **Start** next to **MySQL**. (Ensure the indicator turns green on Port 3306).

---

### Step 3: Create & Import the Database

You can import the database using either phpMyAdmin (GUI) or the MySQL Command Line.

#### Option A: Using phpMyAdmin (Recommended for Browser)
1. Open your browser and navigate to: [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
2. In the left sidebar, click **New**.
3. Set the database name to: `studenthub`
4. Set the collation to: `utf8mb4_unicode_ci` and click **Create**.
5. Select the newly created `studenthub` database from the left list.
6. Click the **Import** tab on the top menu bar.
7. Click **Choose File** and browse to select `studenthub.sql` (located at the root of the project: `C:\xampp\htdocs\studenthub\studenthub.sql`).
8. Leave all default options and click **Import** at the bottom of the page.
9. Verify that all 5 tables (`users`, `students`, `events`, `registrations`, `audit_logs`) are created and populated.

#### Option B: Using Command Line (PowerShell / Command Prompt)
Run the following commands:
```powershell
# Create database
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS studenthub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Import schema and seed records
C:\xampp\mysql\bin\mysql.exe -u root studenthub < "C:\xampp\htdocs\studenthub\studenthub.sql"
```

---

### Step 4: Verify Database Connection Configuration

The application database configuration is centralized in `php/db.php`:

```php
// File: php/db.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // Default XAMPP root password is empty
define('DB_NAME', 'studenthub');
define('DB_PORT', 3306);
```

If your local MySQL uses a custom password or port, edit `php/db.php` accordingly. A copy of `.env.example` is also provided in the repository for environment documentation.

---

### Step 5: Configure Permissions & Directories

Ensure the following upload and data folders exist and have write permissions:
- `uploads/events/` (Contains event banner images)
- `uploads/avatars/` (Student profile avatars)
- `data/` (Contains fallback JSON caches)

> **Security Note:** An `.htaccess` configuration is automatically placed in `uploads/` to prevent execution of `.php` scripts inside uploaded directories.

---

## 3. Verified Demo Accounts & Credentials

The database comes pre-seeded with tested accounts. All passwords have been hashed with PHP's native `PASSWORD_BCRYPT`:

| Role | Email Address | Password | Permissions & Features |
| :--- | :--- | :--- | :--- |
| **System Administrator** | `admin@studenthub.edu` | `Admin@123` | Full Admin Console, KPI Analytics, Student CRUD, Event CRUD, File Uploads, Audit Trail Explorer |
| **Registered Student** | `25cs102@charusat.edu.in` | `Student@123` | Student Dashboard, Enrolled Events, Profile Editor, Event Registration |
| **Staff Member** | `faculty@charusat.edu.in` | `Faculty@123` | Campus Event Coordinator access |

---

## 4. Local Portal Endpoints & URLs

| Portal Section | URL | Access Level | Description |
| :--- | :--- | :--- | :--- |
| **Portal Home** | [http://localhost/studenthub/index.php](http://localhost/studenthub/index.php) | Public | Dynamic landing page, live statistics, quick links |
| **Event Catalog** | [http://localhost/studenthub/events.html](http://localhost/studenthub/events.html) | Public | Campus events directory with category filters |
| **Student Registration**| [http://localhost/studenthub/register.html](http://localhost/studenthub/register.html) | Public | New student onboarding form with client validation |
| **Authentication** | [http://localhost/studenthub/login.html](http://localhost/studenthub/login.html) | Public | Sign-in portal with 1-click test credentials buttons |
| **Student Dashboard** | [http://localhost/studenthub/dashboard.php](http://localhost/studenthub/dashboard.php) | Student | Personalized academic dashboard and enrollments |
| **Admin Console** | [http://localhost/studenthub/admin/index.php](http://localhost/studenthub/admin/index.php) | Admin Only | Administrative overview, real-time metrics |
| **Student Directory**| [http://localhost/studenthub/admin/students.php](http://localhost/studenthub/admin/students.php) | Admin Only | Full CRUD table with async Fetch & traditional POST |
| **Event Management** | [http://localhost/studenthub/admin/events.php](http://localhost/studenthub/admin/events.php) | Admin Only | Create/edit events and upload poster banners |
| **Audit Logs** | [http://localhost/studenthub/admin/audit-logs.php](http://localhost/studenthub/admin/audit-logs.php) | Admin Only | Security audit trail with parameterized filters |
| **REST API (Students)** | [http://localhost/studenthub/api/students.php](http://localhost/studenthub/api/students.php) | Public/Admin | JSON API supporting GET, POST, PUT, DELETE |
| **REST API (Events)** | [http://localhost/studenthub/api/events.php](http://localhost/studenthub/api/events.php) | Public | JSON API for event catalog with search queries |

---

## 5. Verification Checklist & Actual Local Results

| Verification Check | Target Component | Method | Result | Status |
| :--- | :--- | :--- | :--- | :--- |
| **Web Server Binding** | Apache 2.4 | Port 80 Listener | Responds with HTTP 200 | **VERIFIED** |
| **Database Listener** | MySQL / MariaDB | Port 3306 Socket | Handshake & authentication OK | **VERIFIED** |
| **Database Schema** | `studenthub` | SQL Query | 5 tables created, foreign keys valid | **VERIFIED** |
| **Seed Records** | `students`, `events` | `SELECT COUNT(*)` | 20 students, 16 events, 5 users | **VERIFIED** |
| **Password Verification**| `users` table | `password_verify()` | Validates `Admin@123` & `Student@123` | **VERIFIED** |
| **RBAC Protection** | `/admin/*` routes | Unauthenticated GET | Redirects 302 to `login.html` | **VERIFIED** |
| **API Endpoints** | `/api/students.php` | Headless GET | Returns 200 OK with JSON array | **VERIFIED** |
| **File Upload Pipeline** | `admin/events.php` | Valid JPEG Upload | Saves to `uploads/events/` | **VERIFIED** |
| **CSRF Defense** | Admin forms | POST without token | Fails safely with security alert | **VERIFIED** |

---

## 6. Troubleshooting Common Issues

### Issue 1: Apache Port 80 Conflict (e.g., with IIS or Skype)
- **Symptom:** Apache fails to start in XAMPP with error `Port 80 in use by PID ...`.
- **Solution:** 
  1. In XAMPP, click **Config** next to Apache &rarr; **httpd.conf**.
  2. Search for `Listen 80` and change to `Listen 8080`.
  3. Search for `ServerName localhost:80` and change to `ServerName localhost:8080`.
  4. Access portal at: `http://localhost:8080/studenthub/`.

### Issue 2: MySQL Connection Refused / Access Denied
- **Symptom:** `Database connection error: Access denied for user 'root'@'localhost'`.
- **Solution:** 
  1. Check if a password is set on your local MySQL root user.
  2. Open `php/db.php` and update `define('DB_PASS', 'your_password_here');`.

### Issue 3: Poster Upload Directory Permissions
- **Symptom:** "Failed to upload image. Please check directory permissions."
- **Solution:** Ensure `uploads/events` exists. On Linux/macOS, execute:
  ```bash
  chmod -R 775 uploads/
  ```

---

*Local deployment verified and certified for Practical 15 on October 26, 2026.*
