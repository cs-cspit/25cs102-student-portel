# StudentHub - Sitemap & User Navigation Flow

**Subject:** ITUE203 – Web Development Frameworks  
**Project:** StudentHub - Student Management & Campus Portal  
**Document Version:** 1.0 (Practical 01 Baseline)

---

## 1. Comprehensive System Sitemap

The StudentHub portal comprises public, student-authenticated, and administrative sections organized hierarchically:

```
StudentHub Root (/)
│
├── 1. Public & Informational Section
│   ├── index.html               [Home Page & Campus Highlights]
│   ├── about.html               [About StudentHub & Mission]
│   ├── contact.html             [Contact Support & Campus Directory]
│   ├── faq.html                 [Frequently Asked Questions & Search]
│   ├── feedback.html            [Student & Visitor Feedback]
│   ├── register.html            [New Student Registration Form]
│   └── login.html               [Secure Portal Authentication]
│
├── 2. Authenticated Student Portal
│   ├── dashboard.php            [Personalized Student Dashboard & Summary]
│   ├── events.php               [Campus Events Catalog & Registration]
│   ├── profile.php              [Student Profile & Account Settings]
│   └── php/logout.php           [Secure Session Logout Handler]
│
├── 3. Admin Management Suite (/admin)
│   ├── admin/index.php          [Administrative KPI Dashboard & Metrics]
│   ├── admin/students.php       [Student Directory CRUD Management]
│   ├── admin/events.php         [Event Publishing, Editing & Poster Upload]
│   ├── admin/registrations.php  [Participant Registration & Attendance]
│   └── admin/audit-logs.php     [System Audit & Security Activity Logs]
│
└── 4. Backend Service Endpoints & APIs
    ├── php/db.php               [Database Connection Handler]
    ├── php/auth.php             [Authentication & Role Verification Middleware]
    ├── php/register.php         [Server-Side Registration Processing]
    ├── php/login.php            [Server-Side Login Processing]
    ├── api/students.php         [RESTful JSON API for Student CRUD]
    └── api/events.php           [RESTful JSON API for Event CRUD]
```

---

## 2. Navigation Architecture & URL Mapping

| Page / File Path | Title / Function | Access Level | Primary Nav Link? |
| :--- | :--- | :---: | :---: |
| `index.html` | Home Page | Public / All | Yes |
| `about.html` | About StudentHub | Public / All | Yes |
| `events.php` / `events.html` | Events Catalog | Public / All | Yes |
| `faq.html` | FAQ & Knowledge Base | Public / All | Yes |
| `contact.html` | Contact & Inquiries | Public / All | Yes |
| `feedback.html` | Student Feedback | Public / Student | Yes (Footer) |
| `register.html` | Student Registration | Guest Only | Yes (Header CTA) |
| `login.html` | Portal Login | Guest Only | Yes (Header CTA) |
| `dashboard.php` | Student Dashboard | Student Only | Yes (Auth Header) |
| `profile.php` | My Profile | Student Only | Yes (Auth Header) |
| `admin/index.php` | Admin Overview | Admin Only | Yes (Admin Sidebar) |
| `admin/students.php` | Manage Students | Admin Only | Yes (Admin Sidebar) |
| `admin/events.php` | Manage Events | Admin Only | Yes (Admin Sidebar) |
| `admin/registrations.php` | Event Registrations | Admin Only | Yes (Admin Sidebar) |
| `admin/audit-logs.php` | Audit Logs | Admin Only | Yes (Admin Sidebar) |
| `php/logout.php` | Logout Action | Authenticated | Yes (Auth Header) |

---

## 3. User Journey & Navigation Flows

### 3.1 Public / Guest Visitor Flow
```
[ Land on index.html ] 
        │
        ├──► [ Browse about.html / faq.html / contact.html ]
        ├──► [ Explore events.php (View details only) ]
        └──► [ Click "Register Now" ] ──► [ Fill register.html ] 
                                                   │
                                          (Successful Submit)
                                                   ▼
                                         [ Redirect to login.html ]
```

### 3.2 Registered Student Flow
```
[ login.html ] ──► (Valid Credentials) ──► [ dashboard.php ]
                                                   │
        ┌───────────────────┬──────────────────────┴──────────────────────┐
        ▼                   ▼                                             ▼
[ View dashboard.php ] [ Browse events.php ]                       [ Manage profile.php ]
  - Enrolled events      - Search & filter events                    - View academic info
  - Campus notices       - Click "Register for Event"                - Edit contact details
  - Activity summary     - Instant AJAX registration                 - Update password
        │                   │                                             │
        └───────────────────┼─────────────────────────────────────────────┘
                            ▼
                    [ php/logout.php ] ──► [ Redirect to login.html ]
```

### 3.3 Campus Administrator Flow
```
[ login.html ] ──► (Admin Role Verified) ──► [ admin/index.php ]
                                                    │
        ┌────────────────────┬──────────────────────┼────────────────────┬─────────────────────┐
        ▼                    ▼                      ▼                    ▼                     ▼
[ Overview Stats ]   [ admin/students.php ] [ admin/events.php ] [ admin/registrations.php ] [ admin/audit-logs.php ]
- Total students     - Search students      - Add new event      - View attendees list       - View login history
- Total events       - Add/Edit student     - Upload poster      - Export attendance         - Audit CRUD logs
- Registration count - Deactivate student   - Toggle status      - Confirm / Cancel status   - Track IP & actions
        │                    │                      │                    │                     │
        └────────────────────┴──────────────────────┼────────────────────┴─────────────────────┘
                                                    ▼
                                            [ php/logout.php ] ──► [ Redirect to login.html ]
```

---

## 4. Breadcrumb & Fallback Navigation Rules

1. **Top Navbar:** Uniform navigation header present on all student-facing pages with active page indicators.
2. **Admin Sidebar:** Fixed collapsable sidebar with direct routes to all 5 administrative views.
3. **Skip Links:** Accessible `<a href="#main-content" class="skip-link">Skip to main content</a>` on all pages for screen reader and keyboard accessibility.
4. **403 / 404 Protection:** Direct URL attempts to unauthorized pages trigger redirection to `login.html?error=unauthorized` or an error view.
