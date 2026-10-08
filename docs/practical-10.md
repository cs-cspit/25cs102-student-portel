# Practical 10: Secure Login/Logout with Sessions, Role-Based Access, Timeout, and Remember-Me

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**PHP Session-Based Authentication, Password Verification (`password_verify`), Session Hijacking & Fixation Defenses, Role-Based Access Control (RBAC), Inactivity Timeouts, and Secure Logout**

---

## 2. Objective
To build a secure session-based authentication and Role-Based Access Control (RBAC) architecture for **StudentHub**. The system implements credential verification via `password_verify()`, session regeneration (`session_regenerate_id(true)`), 30-minute idle session timeouts, role-based routing (Students $\to$ `dashboard.php`, Admins $\to$ `admin/index.php`), route protection guards (`php/student-auth.php` and `php/admin-auth.php`), and complete session destruction on logout.

---

## 3. Problem Definition
Unprotected web applications are vulnerable to credential interception, session hijacking, privilege escalation, and session fixation attacks. Practical 10 implements server-side session guards and role enforcement to guarantee that unauthenticated visitors cannot access student dashboards and students cannot access privileged administrative controls.

---

## 4. RBAC & Session Security Architecture

```
[ User Submits login.html ] ──► [ php/login.php ]
                                      │
                                      ▼
                        [ SELECT password FROM users WHERE email = ? ]
                                      │
              ┌───────────────────────┴───────────────────────┐
              ▼ (Hash Match)                                  ▼ (Mismatch)
[ session_regenerate_id(true) ]                     [ Log Failed Attempt in audit_logs ]
              │                                               │
              ▼                                               ▼
[ Initialize $_SESSION ]                            [ Return Error View ]
  - user_id, user_name, user_role, last_activity
              │
              ├───────────────────────────────────────────────┐
              ▼ (role === 'student')                          ▼ (role === 'admin')
     [ dashboard.php ]                                 [ admin/index.php ]
   (Guarded by student-auth.php)                      (Guarded by admin-auth.php)
```

---

## 5. Security & Session Defenses

| Security Mechanism | Implementation in Code | Threat Mitigated |
| :--- | :--- | :--- |
| **Password Verification** | `password_verify($password, $user['password'])` | Protects plaintext credentials |
| **Session Fixation Defense** | `session_regenerate_id(true)` | Prevents pre-session hijacking |
| **Session Inactivity Timeout** | `if (time() - $_SESSION['last_activity'] > 1800)` | Auto-expires unattended sessions |
| **HttpOnly & SameSite Flags**| `ini_set('session.cookie_httponly', 1)` | Prevents XSS cookie theft |
| **Role-Based Guards** | `requireStudent()` / `requireAdmin()` | Blocks horizontal & vertical privilege escalation |
| **Complete Destruction** | `session_destroy()` + Cookie invalidation | Cleans all authentication residue |

---

## 6. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `php/auth.php` | Created | Core session middleware, timeout checkers, and role verification helpers |
| `php/login.php` | Created | Authentication handler verifying passwords and dispatching roles |
| `php/logout.php` | Created | Session termination and cookie invalidation script |
| `php/student-auth.php` | Created | Role guard for student-only views |
| `php/admin-auth.php` | Created | Role guard for admin-only views |
| `dashboard.php` | Created | Dynamic authenticated student dashboard |
| `profile.php` | Created | Dynamic authenticated student profile |
| `admin/index.php` | Created | Dynamic authenticated admin dashboard |
| `docs/practical-10.md` | Created | Comprehensive laboratory report and viva preparation manual |

---

## 7. Test Cases & Verification Suite

| Test ID | Test Scenario | Action / Input | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-10-01** | Student Login | Login: `25cs102@charusat.edu.in` / `Student@123` | Redirected to `dashboard.php` with student name | Logged in & routed | **PASS** |
| **TC-10-02** | Admin Login | Login: `admin@studenthub.edu` / `Admin@123` | Redirected to `admin/index.php` with admin controls | Logged in & routed | **PASS** |
| **TC-10-03** | Invalid Password | Enter incorrect password | Error screen rendered; failed attempt logged in `audit_logs` | Rejected & logged | **PASS** |
| **TC-10-04** | Direct Dashboard Access | Open `dashboard.php` in incognito window | Redirected to `login.html?error=session_expired` | Unauthorized access blocked | **PASS** |
| **TC-10-05** | Student Access to Admin | Log in as student and open `admin/index.php` | Access blocked; redirected with 403 error | Admin area protected | **PASS** |
| **TC-10-06** | Session Fixation | Compare session ID before and after login | `session_id()` changes upon successful authentication | ID regenerated | **PASS** |
| **TC-10-07** | Session Inactivity Timeout| Simulate 31 minutes inactivity | Subsequent request forces re-authentication | Timeout expired | **PASS** |
| **TC-10-08** | Secure Logout | Click "Sign Out" | Session destroyed, cookie wiped, redirected to login | Session terminated | **PASS** |

---

## 8. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Student Dashboard (`dashboard.php`):** Logged-in view displaying student name "Daksh Shah (25CS102)" and enrolled events.
2. **Admin Dashboard (`admin/index.php`):** Logged-in view showing admin badge and system metric totals.
3. **Unauthorized Redirection:** Opening `admin/index.php` in a fresh browser session redirecting to `login.html`.
4. **DevTools Cookies Inspection:** Inspecting `PHPSESSID` cookie with `HttpOnly` and `SameSite=Strict` flags checked.
5. **Audit Logs After Login:** `audit_logs` table showing `USER_LOGIN` and `USER_LOGOUT` timestamps.

---

## 9. Viva Voce Questions & Answers

### Q1: What is a PHP Session and how does it maintain state across HTTP requests?
**Answer:** Because HTTP is a stateless protocol, PHP Sessions assign each client a unique session identifier stored in a client-side cookie (`PHPSESSID`). On subsequent requests, the server matches this ID to temporary server-side storage where user variables (`$_SESSION`) are maintained.

### Q2: What is Session Fixation and how does `session_regenerate_id(true)` prevent it?
**Answer:** In a session fixation attack, an attacker forces a victim to use a known session ID. `session_regenerate_id(true)` replaces the current session ID with a brand new cryptographically random ID upon login and deletes the old session file, invalidating any pre-authentication IDs held by attackers.

### Q3: How does `password_verify()` function?
**Answer:** `password_verify($password, $hash)` extracts the algorithm, cost, and salt parameters from the stored bcrypt hash, hashes the provided plaintext password using those identical parameters, and performs a timing-attack-safe string comparison.

### Q4: What is the difference between Authentication and Authorization?
**Answer:**
- **Authentication:** Verifying the identity of the user (e.g., "Are you Daksh Shah with the correct password?").
- **Authorization (RBAC):** Determining what permissions or resources an authenticated user is allowed to access (e.g., "Daksh is a Student and cannot delete other student accounts in `/admin`").

### Q5: Why is `session_destroy()` alone insufficient for complete logout?
**Answer:** `session_destroy()` clears data on the server, but does not unset the `$_SESSION` global array in memory for the current script execution nor clear the client-side session cookie. Complete logout requires `$_SESSION = []`, cookie expiration via `setcookie()`, and `session_destroy()`.

---

## 10. Conclusion
Practical 10 successfully deployed a hardened session authentication and Role-Based Access Control subsystem for **StudentHub** with bcrypt validation, session regeneration, inactivity timeouts, and route guards. The project is ready for Practical 11 (Student Management CRUD).
