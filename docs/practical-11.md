# Practical 11: Student Management CRUD with Search and Filter

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Administrative Student Directory CRUD Architecture, Parameterized Search Filters, Multi-Table Data Synchronization, and Confirmation Safeguards**

---

## 2. Objective
To engineer a complete administrative Student Management subsystem (`admin/students.php`) implementing full **CRUD (Create, Read, Update, Delete)** operations. The module enables administrators to enroll students into the database, browse 20+ seeded student records with dynamic keyword search and department filters, update academic details in modal dialogs, safely delete records with client confirmations and cascading deletes, and record all CRUD actions in `audit_logs`.

---

## 3. Problem Definition
Campus administrators need real-time tools to manage student enrollment rosters, update department transfers, correct contact details, and remove graduated or inactive students. Practical 11 delivers a responsive management interface with robust server-side validation and prepared statement queries.

---

## 4. CRUD Operations & Query Matrix

| Operation | Trigger | SQL Statement Executed | Security / Logic |
| :--- | :--- | :--- | :--- |
| **CREATE** | "Save Student" Modal | `INSERT INTO users (...)` + `INSERT INTO students (...)` | Transactional dual-table insert; default bcrypt password |
| **READ** | Directory Load / Filter | `SELECT * FROM students WHERE 1=1 AND (name LIKE ? OR ...) AND course = ?` | Parameterized search & filter queries |
| **UPDATE** | "Update Record" Modal | `UPDATE students SET name=?, mobile=?, course=?, year=?, status=? WHERE id=?` | Parameterized update; validates student ID |
| **DELETE** | "Delete" Button | `DELETE FROM users WHERE id=?` | Triggers Foreign Key cascade delete to students & registrations |

---

## 5. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `admin/students.php` | Created | Administrative Student CRUD panel with modals, search, filter, and audit logs |
| `docs/practical-11.md` | Created | Comprehensive laboratory practical report and viva preparation manual |

---

## 6. Test Cases & Verification Suite

| Test ID | CRUD Action | Input / Scenario | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-11-01** | Student Directory Read | Load `admin/students.php` | 20 seeded student records displayed in tabular grid | Records rendered | **PASS** |
| **TC-11-02** | Keyword Search | Search "Aarav" | Table filters to show only student Aarav Patel | Search filtered | **PASS** |
| **TC-11-03** | Department Filter | Filter by "B.Tech IT" | Table shows only Information Technology students | Department isolated | **PASS** |
| **TC-11-04** | Create Student | Add "Kunal Joshi" with CSE details | New student created with generated ID; audit logged | Student created | **PASS** |
| **TC-11-05** | Duplicate Email Guard | Add new student with existing email | Rejection alert: "user with this email already exists" | Duplicate blocked | **PASS** |
| **TC-11-06** | Edit Student Details | Update mobile number of student #102 | Database record updated; success alert displayed | Update verified | **PASS** |
| **TC-11-07** | Delete Confirmation | Click Delete button on student record | Browser prompt confirms intent before submission | Prompt triggered | **PASS** |
| **TC-11-08** | Delete Execution | Confirm deletion of test record | Student record and associated registrations deleted | Record removed | **PASS** |

---

## 7. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Student Directory Table:** `admin/students.php` showing populated student table with status badges and action buttons.
2. **Add Student Modal:** Open modal dialog with enrollment fields.
3. **Search & Department Filter:** Filtered view displaying "B.Tech CSE" students.
4. **Edit Student Modal:** Prefilled edit form updating a student's contact mobile number.
5. **Delete Confirmation Dialog:** Browser alert box confirming deletion.

---

## 8. Viva Voce Questions & Answers

### Q1: What does the acronym CRUD represent in Web Development?
**Answer:** CRUD stands for the four basic persistent storage functions: **Create** (`INSERT`), **Read** (`SELECT`), **Update** (`UPDATE`), and **Delete** (`DELETE`).

### Q2: Why should Delete operations use HTTP POST instead of GET?
**Answer:** GET requests are meant to be idempotent and safe (no state change). Using GET for deletions (`students.php?delete=5`) exposes the system to CSRF vulnerabilities, search bot crawlers accidentally deleting data, and browser link prefetching risks. POST requires explicit intentional state mutation.

### Q3: How does SQL `LIKE` with wildcards (`%`) operate in parameterized queries?
**Answer:** The wildcard characters `%` are placed inside the bound parameter variable (e.g. `"%".$query."%"`) rather than in the SQL query string itself, allowing safe pattern matching without risking SQL injection.

### Q4: What is the purpose of a JavaScript confirmation dialog before deletion?
**Answer:** `confirm('Are you sure you want to delete this student?')` prevents catastrophic accidental deletions by requiring the administrator to explicitly confirm destructive actions before the form is dispatched.

### Q5: How does Foreign Key cascading (`ON DELETE CASCADE`) support student deletions?
**Answer:** When a user or student record is deleted, the database engine automatically removes all associated child records (such as event registrations) without leaving broken orphan references.

---

## 9. Conclusion
Practical 11 successfully implemented full administrative Student Management CRUD capabilities with real-time search, department filtering, modal dialogs, and cascading data integrity for **StudentHub**. The project is ready for Practical 12 (Event Management CRUD and Poster Upload).
