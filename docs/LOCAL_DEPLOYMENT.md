# StudentHub — Local Deployment & Setup Guide (XAMPP Environment)

**Institution:** CSPIT, CHARUSAT — Faculty of Technology & Engineering  
**Subject:** ITUE203 — Web Development Frameworks (Practical 15)  
**Target Local URL:** `http://localhost/studenthub/`  

---

## 1. System Requirements & Prerequisites

To run StudentHub locally, ensure your machine has:
1. **XAMPP Control Panel** (v3.3.0 or higher) containing:
   - **Apache HTTP Server** 2.4+
   - **MySQL / MariaDB** 8.0+ / 10.4+
   - **PHP** 8.1 or 8.2+ with `mysqli`, `openssl`, and `fileinfo` extensions enabled.
2. Modern Web Browser (Google Chrome, Microsoft Edge, or Mozilla Firefox).
3. Text Editor or IDE (VS Code recommended).

---

## 2. Verified Local Setup (Already Performed in Current Environment)

> [!NOTE]
> On this local machine, the workspace directory has already been linked to `C:\xampp\htdocs\studenthub`, the MySQL database `studenthub` has been imported, and Apache is active. The steps below document the standard process for reproduction or submission evaluation.

---

## 3. Step-by-Step Deployment Procedure

### Step 1: Start Apache and MySQL in XAMPP
1. Open **XAMPP Control Panel** (run as Administrator if needed).
2. Click **Start** next to **Apache**.
   - Verify that the module indicator turns **green** and shows Port `80, 443`.
3. Click **Start** next to **MySQL**.
   - Verify that the module indicator turns **green** and shows Port `3306`.

---

### Step 2: Link or Place the Project in `htdocs`

The application must be accessible under `C:\xampp\htdocs\studenthub`.

#### Option A: Windows Directory Junction (Recommended — Zero Duplicate Files)
Open Command Prompt (or PowerShell) and execute:
```cmd
mklink /J "C:\xampp\htdocs\studenthub" "c:\Users\daksh\Documents\1. SEM - 3\WDF\dhara maam"
```
*Benefit: Any edits made in your workspace are instantly reflected in Apache without manual copying.*

#### Option B: Direct Copy
Copy the entire `StudentHub` project folder directly into `C:\xampp\htdocs\` and rename the folder to `studenthub`.

---

### Step 3: Create & Import the Database

#### Method 1: Via phpMyAdmin (GUI)
1. Open your browser and navigate to: `http://localhost/phpmyadmin/`
2. Click **New** in the left sidebar to create a database.
3. In the Database name field, enter: `studenthub`
4. Collation: select `utf8mb4_unicode_ci` and click **Create**.
5. With `studenthub` selected, click the **Import** tab at the top.
6. Click **Choose File** and select `studenthub.sql` from the repository root (or `sql/studenthub.sql`).
7. Scroll down and click **Import**.
8. Verify that 5 tables are created:
   - `users` (5 seed accounts)
   - `students` (20 seed student records)
   - `events` (16 campus event records)
   - `registrations` (5 seed participant records)
   - `audit_logs` (Forensic activity log)

#### Method 2: Via Command Line (Fastest)
Run the following in PowerShell:
```powershell
Get-Content "studenthub.sql" | & "C:\xampp\mysql\bin\mysql.exe" -u root
```

---

### Step 4: Configure Database Connection (`php/db.php`)

Open `php/db.php`. By default, it is configured for standard XAMPP out-of-the-box settings:
```php
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'studenthub');
if (!defined('DB_PORT')) define('DB_PORT', (int)(getenv('DB_PORT') ?: 3306));
```
If your MySQL has a root password, either set it in `php/db.php` or create a `.env` file from `.env.example`.

---

### Step 5: Launch the Application

Open your browser and navigate to:
```
http://localhost/studenthub/
```
The root entry point (`index.php`) will automatically serve the public home page.

---

## 4. Test Accounts & Default Credentials

| Role | Email Address | Password | Landing Page |
| :--- | :--- | :--- | :--- |
| **Faculty / Admin** | `admin@studenthub.edu` | `Admin@123` | `http://localhost/studenthub/admin/index.php` |
| **Student** | `25cs102@charusat.edu.in` | `Student@123` | `http://localhost/studenthub/dashboard.php` |
| **Student (Seed 2)** | `aarav.ce@charusat.edu.in` | `Student@123` | `http://localhost/studenthub/dashboard.php` |

---

## 5. RESTful API Verification Endpoints

Test that the JSON API endpoints respond with HTTP 200:
- **Students API:** `http://localhost/studenthub/api/students.php`
- **Events API:** `http://localhost/studenthub/api/events.php`

---

## 6. Troubleshooting Common Issues

### Issue 1: "Unable to connect to the database"
- **Cause:** MySQL is not running in XAMPP or the database name is incorrect.
- **Solution:** Open XAMPP Control Panel and ensure MySQL shows "Running" on Port 3306. Check in phpMyAdmin that the `studenthub` database exists.

### Issue 2: Apache Port 80 Conflict
- **Cause:** Another process (e.g., Skype, IIS, or VMware) is listening on port 80.
- **Solution:** In XAMPP Control Panel, click **Config** next to Apache -> `httpd.conf`. Search for `Listen 80` and change to `Listen 8080`. Then access via `http://localhost:8080/studenthub/`.

### Issue 3: Uploaded Event Posters Do Not Appear
- **Cause:** Missing `uploads/events/` directory or write permission issue.
- **Solution:** Ensure the folder `uploads/events/` exists and is writable by the web server process.

### Issue 4: Session Cleared Unexpectedly
- **Cause:** 30 minutes of inactivity elapsed.
- **Solution:** Log in again. This is an intentional security feature adhering to academic requirements.
