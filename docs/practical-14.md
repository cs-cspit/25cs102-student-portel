# Practical 14: Admin Dashboard with Role-Based Access Control, Dynamic Menu, and Audit Log

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Executive Administrative Analytics Dashboard, SQL KPI Aggregations, Role-Based Dynamic Navigation, Attendee Roster Oversight, and Security Audit Logging**

---

## 2. Objective
To build the complete Administrative Management Suite (`admin/index.php`, `admin/registrations.php`, and `admin/audit-logs.php`) for **StudentHub**. The suite aggregates live university metrics (Total Students, Active Events, Registrations, Accounts) using SQL `COUNT()` aggregations, visualizes monthly participation trends, manages student event registration statuses (Confirmed, Waitlisted, Cancelled), tracks security audit logs with IP origins, and enforces strict RBAC via `php/admin-auth.php`.

---

## 3. Problem Definition
Campus administrators require a centralized management command center to monitor real-time university activity, oversee student event attendance, and conduct security audits. Without dynamic aggregation and audit trails, administrators cannot track system mutations or detect unauthorized attempts.

---

## 4. Admin Management Suite Architecture

```
[ Authenticated Admin Session ] ──► [ admin/index.php (Overview) ]
                                          │
        ┌───────────────────┬─────────────┴─────────────┬───────────────────┐
        ▼                   ▼                           ▼                   ▼
[ admin/students.php ] [ admin/events.php ] [ admin/registrations.php ] [ admin/audit-logs.php ]
- Enrolled Students    - Publish Events     - Manage Rosters           - Security Audit Trail
- Student CRUD         - Poster Uploads     - Confirm / Waitlist       - Filter by Action
- Department Filter    - Seating Capacities - Delete Enrollment        - Track IP & Timestamp
```

---

## 5. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `admin/index.php` | Modified | KPI overview dashboard with live SQL metrics and visual participation chart |
| `admin/registrations.php` | Created | Attendee roster management with status editing (Confirmed/Waitlisted) |
| `admin/audit-logs.php` | Created | Security audit log explorer with action filtering and IP tracing |
| `docs/practical-14.md` | Created | Comprehensive laboratory practical report and viva preparation manual |

---

## 6. Test Cases & Verification Suite

| Test ID | Admin Feature | Action / Input | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-14-01** | Admin Authentication | Open `admin/index.php` as Admin | Dashboard renders with admin greeting and statistics | Admin access granted | **PASS** |
| **TC-14-02** | Student Rejection | Open `admin/index.php` as Student | Blocked; redirected to dashboard with 403 alert | Student access blocked | **PASS** |
| **TC-14-03** | Live SQL Metrics | Query total counts | Shows exact counts for students, events, registrations | Live stats rendered | **PASS** |
| **TC-14-04** | Monthly Trends Chart | Inspect participation bar chart | Visual graph renders monthly student engagement | Chart active | **PASS** |
| **TC-14-05** | Update Registration Status | Change status from "Waitlisted" $\to$ "Confirmed" | Registration status updated in MySQL; audit log recorded | Status updated | **PASS** |
| **TC-14-06** | Cancel Registration | Click Remove on registration #3 | Record deleted from `registrations` table | Registration canceled | **PASS** |
| **TC-14-07** | Audit Log Filtering | Filter logs by `USER_AUTHENTICATION` | Table displays only user authentication entries | Filter applied | **PASS** |
| **TC-14-08** | Client IP Recording | Inspect IP column in audit logs | Displays client IP address (`192.168.1.45` / `127.0.0.1`) | IP recorded | **PASS** |

---

## 7. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Admin KPI Overview:** `admin/index.php` showing 4 statistic cards and monthly trends chart.
2. **Registration Management View:** `admin/registrations.php` showing attendee roster and status selector dropdowns.
3. **Audit Log Explorer:** `admin/audit-logs.php` showing chronological system audit trails with client IPs.
4. **Role-Based Navigation:** Admin top navbar showing direct links to Dashboard, Students, Events, Registrations, and Audit Logs.

---

## 8. Viva Voce Questions & Answers

### Q1: How do SQL aggregate functions like `COUNT()` work?
**Answer:** `COUNT(*)` counts the total number of rows matching the query criteria without needing to fetch and transmit all individual record rows into PHP memory, making aggregation instantaneous even on large datasets.

### Q2: What is an Audit Trail and why is it crucial for enterprise web applications?
**Answer:** An audit trail is an immutable, chronological record of system activities (who did what, when, to which entity, and from what IP address). It enables forensic investigation of security breaches, regulatory compliance, and operational accountability.

### Q3: How is Role-Based Access Control enforced across subdirectories in PHP?
**Answer:** By including a centralized security guard script (`require_once '../php/admin-auth.php'`) at the very top of every admin page before any HTML or sensitive data is rendered.

### Q4: Why is it important to display recent activity feeds on administrative dashboards?
**Answer:** Recent activity feeds provide immediate operational awareness to administrators upon login, highlighting new registrations, published events, or unusual login attempts at a glance.

### Q5: How do status badges with distinct visual colors improve usability?
**Answer:** Color-coded badges (Green for `Confirmed`, Yellow for `Waitlisted`, Red for `Cancelled`) provide immediate visual scanning cues, enabling administrators to identify pending approvals without reading full text descriptions.

---

## 9. Conclusion
Practical 14 successfully delivered the complete Administrative Management Suite for **StudentHub** with real-time KPI metrics, visual participation charts, registration roster management, and security audit log tracing. The project is now ready for the final milestone: Practical 15 (Final Integration, Testing, Documentation, and Local Deployment).
