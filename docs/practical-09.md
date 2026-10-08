# Practical 09: Secure User Registration with Database Insert, Duplicate Email Check, and Password Hashing

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Relational Database Registration Processing, Parameterized Duplicate Verification, BCRYPT Password Hashing, Multi-Table Transaction Management, and Security Auditing**

---

## 2. Objective
To implement an end-to-end secure student registration subsystem connecting the frontend HTML/JS form to the MySQL `studenthub` database. The backend PHP processor (`php/register.php`) enforces server-side validation, executes duplicate email checks via prepared statements, securely hashes passwords using `password_hash()`, executes a transactional dual-table insert across `users` and `students`, and records an entry in `audit_logs`.

---

## 3. Problem Definition
Improper registration workflows suffer from major security vulnerabilities: storing plaintext passwords, exposing SQL injection flaws, creating orphaned records during multi-table inserts, and allowing duplicate accounts. Practical 09 addresses this by implementing an atomic, encrypted, parameterized database registration workflow.

---

## 4. End-to-End Registration Flow

```
[ Frontend Registration Form: register.html ]
                    │
                    ▼ (POST Request)
[ Server-Side Validation & Input Sanitization ]
                    │
                    ▼ (Valid Inputs)
[ Check Duplicate Email in `users` via Prepared Query ]
                    │
            ┌───────┴────────────────────────┐
            ▼ (Email Exists)                 ▼ (Unique Email)
    [ Return 400 Error ]              [ Begin MySQL Transaction ]
                                             │
                                             ▼
                                      [ password_hash($password, PASSWORD_DEFAULT) ]
                                             │
                                             ▼
                                      [ INSERT INTO `users` (Role = 'student') ]
                                             │
                                             ▼ (Get insert_id as user_id)
                                      [ INSERT INTO `students` (user_id, profile details) ]
                                             │
                                             ▼
                                      [ INSERT INTO `audit_logs` (USER_REGISTRATION) ]
                                             │
                                             ▼
                                      [ COMMIT Transaction ]
                                             │
                                             ▼
                                      [ Render Success View with Student ID ]
```

---

## 5. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `php/register.php` | Modified | Added database integration, BCRYPT hashing, transaction handling, and audit logging |
| `php/db.php` | Referenced | Database connectivity and parameterized query execution helper |
| `docs/practical-09.md` | Created | Comprehensive laboratory practical report and viva preparation manual |

---

## 6. Test Cases & Verification Suite

| Test ID | Test Scenario | Test Action | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-09-01** | Valid Registration | Submit valid student credentials | Record inserted into `users` & `students`; audit log created | Dual insert succeeded | **PASS** |
| **TC-09-02** | Duplicate Email | Register with existing email `25cs102@charusat.edu.in` | Rejected with "account with this email already registered" | Duplicate caught | **PASS** |
| **TC-09-03** | Password Hashing | Check `password` column in `users` table | Stored value starts with `$2y$10$...` (bcrypt hash) | Hash verified | **PASS** |
| **TC-09-04** | Weak Password | Submit password `< 8` chars directly via POST | Server rejects with min length error | Server length check passed | **PASS** |
| **TC-09-05** | Password Mismatch | Submit mismatched password & confirm fields | Server rejects with confirmation mismatch error | Mismatch blocked | **PASS** |
| **TC-09-06** | Invalid Indian Phone | Submit phone "55555" | Server rejects with 10-digit Indian phone regex error | Invalid phone blocked | **PASS** |
| **TC-09-07** | Transaction Rollback | Simulate failure on second table insert | Entire transaction rolls back; no orphan user created | Rollback verified | **PASS** |
| **TC-09-08** | Audit Log Capture | Inspect `audit_logs` table after registration | New row with `action = 'USER_REGISTRATION'` and client IP | Audit log logged | **PASS** |

---

## 7. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Registration Success Page:** Browser displaying student confirmation card with new generated Student ID.
2. **Duplicate Email Error Card:** Screenshot showing user-friendly duplicate email alert.
3. **phpMyAdmin `users` Table:** Browsing records showing `password` stored as a bcrypt hash string (`$2y$10$...`).
4. **phpMyAdmin `students` Table:** Showing new student linked via `user_id`.
5. **phpMyAdmin `audit_logs` Table:** Showing new audit trail record with timestamp and client IP.

---

## 8. Viva Voce Questions & Answers

### Q1: What does `password_hash()` in PHP do under the hood?
**Answer:** `password_hash($password, PASSWORD_DEFAULT)` generates a strong, one-way cryptographic hash using the BCRYPT algorithm. It automatically creates a cryptographically secure random salt and includes cost parameters within the resulting 60-character output string.

### Q2: Why is storing plain MD5 or SHA1 hashes insecure today?
**Answer:** MD5 and SHA1 are general-purpose cryptographic hash functions designed for speed, not password security. Modern GPUs can compute billions of MD5/SHA1 hashes per second, making them vulnerable to Rainbow Table and brute-force dictionary attacks. BCRYPT is an intentionally slow, salted, adaptive algorithm.

### Q3: Why is a database transaction (`begin_transaction()` / `commit()` / `rollback()`) essential for dual-table registration?
**Answer:** Registration requires inserting into both `users` and `students`. A database transaction ensures ACID atomicity: if the second insert fails, `rollback()` cancels the first insert, preventing orphaned user records without profiles.

### Q4: How does `insert_id` in MySQLi work?
**Answer:** `$conn->insert_id` retrieves the auto-incremented primary key generated by the immediately preceding `INSERT` query on the active connection, allowing the script to link foreign keys (`user_id`) in subsequent tables.

### Q5: What is the purpose of recording IP addresses in `audit_logs`?
**Answer:** Storing client IP addresses (`$_SERVER['REMOTE_ADDR']`) provides forensic traceability for security monitoring, fraud prevention, and auditing anomalous user registration activity.

---

## 9. Conclusion
Practical 09 successfully established secure, relational MySQL registration with BCRYPT password hashing, prepared statement duplicate checks, transactional integrity, and automated security audit logging for **StudentHub**. The project is ready for Practical 10 (Secure Login/Logout with Sessions and RBAC).
