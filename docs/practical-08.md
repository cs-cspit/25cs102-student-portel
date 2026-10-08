# Practical 08: MySQL Schema Design, ER Model, Database Connectivity and Prepared Statements

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Relational MySQL Database Architecture, 3NF Schema Design, ER Modeling, MySQLi Connection Layer, and Parameterized Prepared Statements**

---

## 2. Objective
To design and deploy a normalized (3NF) relational database schema (`studenthub`) comprising 5 core tables (`users`, `students`, `events`, `registrations`, `audit_logs`) with primary keys, foreign key constraints (`ON DELETE CASCADE`), indexes, and realistic seed data in `sql/studenthub.sql`. Additionally, to construct a secure database abstraction script (`php/db.php`) using PHP MySQLi prepared statements to eliminate SQL Injection vulnerabilities.

---

## 3. Problem Definition
Flat-file data stores lack transactional atomicity, referential integrity, and efficient querying capabilities under concurrent user load. Transitioning to a relational DBMS like MySQL with normalized schemas and parameterized prepared statements guarantees data consistency, prevents data redundancy, and eliminates SQL injection threats.

---

## 4. Relational Database Schema Architecture

```
                    ┌─────────────────────────┐
                    │          USERS          │
                    ├─────────────────────────┤
                    │ PK  id                  │
                    │     name                │
                    │     email (UNIQUE)      │
                    │     password (BCRYPT)   │
                    │     role (student/admin)│
                    └────────────┬────────────┘
                                 │ 1:1
                                 ▼
┌─────────────────────────┐ 1:N ┌─────────────────────────┐ 1:N ┌─────────────────────────┐
│       AUDIT_LOGS        │◄────┤        STUDENTS         │◄────┤      REGISTRATIONS      │
├─────────────────────────┤     ├─────────────────────────┤     ├─────────────────────────┤
│ PK  id                  │     │ PK  id                  │     │ PK  id                  │
│ FK  user_id             │     │ FK  user_id             │     │ FK  student_id          │
│     action              │     │     name                │     │ FK  event_id ───────────┼──────┐
│     entity              │     │     email (UNIQUE)      │     │     registration_date   │      │
│     entity_id           │     │     mobile              │     │     status              │      │
│     ip_address          │     │     course              │     └─────────────────────────┘      │
│     created_at          │     │     year                │                                      │
└─────────────────────────┘     │     gender              │                                      │
                                │     status              │                                      │
                                └─────────────────────────┘                                      │
                                                                                                 │ N:1
                                                                ┌─────────────────────────┐      │
                                                                │         EVENTS          │◄─────┘
                                                                ├─────────────────────────┤
                                                                │ PK  id                  │
                                                                │     title               │
                                                                │     description         │
                                                                │     event_date          │
                                                                │     time_slot           │
                                                                │     venue               │
                                                                │     category            │
                                                                │     poster              │
                                                                │     seats               │
                                                                │     status              │
                                                                └─────────────────────────┘
```

---

## 5. Table Schemas & Relationships

| Table Name | Purpose | Primary Key | Foreign Keys & Constraints |
| :--- | :--- | :--- | :--- |
| **`users`** | Authentication credentials & roles | `id` | Unique index on `email`, role enum (`student`, `admin`) |
| **`students`** | Detailed student profile details | `id` | `user_id` $\to$ `users(id)` ON DELETE CASCADE |
| **`events`** | University events & workshops | `id` | Indexed on `event_date`, `category`, `status` |
| **`registrations`**| Student event enrollment link | `id` | `student_id` $\to$ `students(id)`, `event_id` $\to$ `events(id)`, `UNIQUE(student_id, event_id)` |
| **`audit_logs`** | Security audit trails | `id` | `user_id` $\to$ `users(id)`, stores action, IP, timestamp |

---

## 6. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `sql/studenthub.sql` | Created | Complete MySQL DDL schema, foreign keys, constraints, and 20+ seed records |
| `php/db.php` | Created | Secure MySQLi connection with `utf8mb4`, exception handling, and `executeQuery()` prepared statement helper |
| `docs/practical-08.md` | Created | Comprehensive laboratory practical report and viva preparation guide |

---

## 7. Test Cases & Verification Suite

| Test ID | Requirement / Action | Test Scenario | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-08-01** | Database DDL Syntax | Execute `sql/studenthub.sql` script | All 5 tables created without SQL syntax errors | Tables created cleanly | **PASS** |
| **TC-08-02** | Foreign Key Cascading | Delete a user in `users` table | Associated student profile deleted via cascade | Cascade verified | **PASS** |
| **TC-08-03** | Unique Email Constraint | Attempt inserting duplicate email into `users` | MySQL rejects with Duplicate Key Error 1062 | Unique constraint enforced | **PASS** |
| **TC-08-04** | Unique Registration Pair | Register student #1 for event #1 twice | MySQL rejects duplicate pair `(student_id, event_id)` | Duplicate registration blocked | **PASS** |
| **TC-08-05** | Database Connection | Call `require 'php/db.php'` | Successful MySQLi connection object created | Connection established | **PASS** |
| **TC-08-06** | Prepared Statement Helper | Run `executeQuery($conn, "SELECT * FROM events WHERE category = ?", "s", ["technical"])` | Returns parameter-bound results without string interpolation | Prepared statement passed | **PASS** |
| **TC-08-07** | SQL Injection Defense | Test `' OR '1'='1` in parameterized query | Input treated strictly as literal string parameter; injection averted | SQLi blocked | **PASS** |
| **TC-08-08** | Audit Trail Insertion | Call `logAuditEvent(...)` | Audit record inserted with client IP address | Audit log persisted | **PASS** |

---

## 8. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **phpMyAdmin Database Structure:** Showing `studenthub` database with all 5 tables (`users`, `students`, `events`, `registrations`, `audit_logs`).
2. **phpMyAdmin Designer / ER View:** Visual representation of table relationships and foreign keys.
3. **Table Data Browsing:** Screenshot of `events` table showing 16 seeded event records.
4. **VS Code Database Script:** `sql/studenthub.sql` open in VS Code showing DDL definitions.

---

## 9. Viva Voce Questions & Answers

### Q1: What is a Prepared Statement and why does it prevent SQL Injection?
**Answer:** A prepared statement pre-compiles the SQL query template on the database server before user parameters are bound. The database engine treats parameter values strictly as data literals, never as executable SQL commands, completely neutralizing SQL injection attacks.

### Q2: What is Referential Integrity and how is it enforced in MySQL?
**Answer:** Referential integrity ensures that relationships between tables remain consistent (e.g. a registration cannot reference a non-existent student). It is enforced in MySQL InnoDB using Foreign Key constraints with actions like `ON DELETE CASCADE` or `ON DELETE RESTRICT`.

### Q3: Why is the `utf8mb4` character set recommended over `utf8` in MySQL?
**Answer:** MySQL's historic `utf8` charset only supports up to 3 bytes per character, failing on 4-byte characters like emojis or special Unicode symbols. `utf8mb4` provides full 4-byte UTF-8 encoding support.

### Q4: Explain the difference between DDL and DML in SQL.
**Answer:**
- **DDL (Data Definition Language):** Statements that define and modify database structure (`CREATE`, `ALTER`, `DROP`, `TRUNCATE`).
- **DML (Data Manipulation Language):** Statements that manage and manipulate data within tables (`SELECT`, `INSERT`, `UPDATE`, `DELETE`).

### Q5: What is Database Normalization and why is 3NF standard for web applications?
**Answer:** Normalization is the systematic process of organizing database tables to reduce data redundancy and eliminate anomalies (Insertion, Update, Deletion anomalies). Third Normal Form (3NF) ensures every non-key column is directly dependent on the primary key and nothing else.

---

## 10. Conclusion
Practical 08 successfully established the relational database layer for **StudentHub** with normalized tables, foreign key constraints, robust seed data, and a secure prepared statement abstraction module in PHP. The project is ready for Practical 09 (Secure User Registration with MySQL Insert).
