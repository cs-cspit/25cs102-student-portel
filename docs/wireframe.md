# StudentHub - Low-Fidelity Wireframes & Layout Specifications

**Subject:** ITUE203 – Web Development Frameworks  
**Project:** StudentHub - Student Management & Campus Portal  
**Document Version:** 1.0 (Practical 01 Baseline)

---

## 1. Design System & Global Layout Structure

All StudentHub pages adhere to a standardized layout grid adhering to WCAG 2.1 AA accessibility guidelines and responsive design principles.

### Global Page Anatomy (Public & Student Pages)
```
+-------------------------------------------------------------------------+
| [Skip to content link (accessible)]                                      |
+-------------------------------------------------------------------------+
| [LOGO] StudentHub          [Home] [About] [Events] [FAQ] [Contact] [🌙] |
|                            [CTA: Login] [CTA: Register]                 |
+-------------------------------------------------------------------------+
|                                                                         |
|  <MAIN ID="main-content">                                               |
|  +-------------------------------------------------------------------+  |
|  | Page Header / Breadcrumb / Hero Section                           |  |
|  +-------------------------------------------------------------------+  |
|  |                                                                   |  |
|  | Primary Content Area (Grid / Cards / Form / Table)                 |  |
|  |                                                                   |  |
|  +-------------------------------------------------------------------+  |
|  </MAIN>                                                                |
|                                                                         |
+-------------------------------------------------------------------------+
| FOOTER: Quick Links | Department Info | Social Links | © 2026 StudentHub|
+-------------------------------------------------------------------------+
```

---

## 2. Low-Fidelity Wireframe: Home Page (`index.html`)

```
+-------------------------------------------------------------------------+
| StudentHub            Home  About  Events  FAQ  Contact  [Theme] [Login]|
+-------------------------------------------------------------------------+
|                                                                         |
|   HERO SECTION:                                                         |
|   "Connect. Learn. Participate."                                        |
|   Your centralized university gateway for events, workshops & academics.|
|                                                                         |
|   [ Explore Events ]      [ Student Registration ]                      |
|                                                                         |
+-------------------------------------------------------------------------+
|  KEY PILLARS / STATS COUNTER:                                           |
|  [ 1,200+ Students ]  [ 45+ Campus Events ]  [ 12 Clubs & Chapters ]   |
+-------------------------------------------------------------------------+
|  FEATURED UPCOMING EVENTS (CAROUSEL / GRID):                            |
|  +-------------------+  +-------------------+  +-------------------+    |
|  | [Poster / Image]  |  | [Poster / Image]  |  | [Poster / Image]  |    |
|  | Hackathon 2026    |  | AI/ML Workshop    |  | Cultural Fest '26 |    |
|  | Date: Oct 15, 2026|  | Date: Oct 22, 2026|  | Date: Nov 05, 2026|    |
|  | [ View & Register]|  | [ View & Register]|  | [ View & Register]|    |
|  +-------------------+  +-------------------+  +-------------------+    |
+-------------------------------------------------------------------------+
|  CAMPUS ANNOUNCEMENTS & RECENT HIGHLIGHTS                               |
|  - Mid-Semester Registration Schedule Announced                         |
|  - National Level CodeSprint registrations live                         |
+-------------------------------------------------------------------------+
| FOOTER: © 2026 StudentHub | CHARUSAT University | Privacy | Terms       |
+-------------------------------------------------------------------------+
```

---

## 3. Low-Fidelity Wireframe: Student Registration (`register.html`)

```
+-------------------------------------------------------------------------+
| StudentHub            Home  About  Events  FAQ  Contact   [Login]       |
+-------------------------------------------------------------------------+
|                                                                         |
|                   CREATE YOUR STUDENT ACCOUNT                           |
|                   Join the StudentHub campus portal                     |
|                                                                         |
|   +-----------------------------------------------------------------+   |
|   | Full Name:         [ John Doe                              ]   |   |
|   | Email Address:     [ student@charusat.edu.in               ]   |   |
|   | Mobile Number:     [ 9876543210                            ]   |   |
|   |                                                                 |   |
|   | Password:          [ ****************                      ]   |   |
|   | [Strength Meter: ■■■■□ Strong]                                  |   |
|   | Confirm Password:  [ ****************                      ]   |   |
|   |                                                                 |   |
|   | Academic Course:   [ Select Course (CSE / IT / CE / EC)  ▼ ]   |   |
|   | Academic Year:     [ Select Year (1st / 2nd / 3rd / 4th) ▼ ]   |   |
|   | Gender:            (o) Male   ( ) Female   ( ) Other           |   |
|   |                                                                 |   |
|   | [x] I agree to the Campus Terms & Code of Conduct               |   |
|   |                                                                 |   |
|   |                    [ CREATE ACCOUNT BUTTON ]                    |   |
|   |                                                                 |   |
|   | Already have an account? [ Login here ]                         |   |
|   +-----------------------------------------------------------------+   |
|                                                                         |
+-------------------------------------------------------------------------+
| FOOTER                                                                  |
+-------------------------------------------------------------------------+
```

---

## 4. Low-Fidelity Wireframe: Student Dashboard (`dashboard.php`)

```
+-------------------------------------------------------------------------+
| StudentHub (Student)       Dashboard  Events  Profile   [Hi, Daksh] [🚪]|
+-------------------------------------------------------------------------+
|                                                                         |
|  WELCOME BACK, DAKSH SHAH (25CS102)                                     |
|  Department of Computer Science & Engineering | Semester 3              |
|                                                                         |
|  +---------------------+ +---------------------+ +--------------------+ |
|  | Registered Events   | | Upcoming Events     | | Profile Status     | |
|  |      3 Active       | |    12 This Month    | |  100% Complete     | |
|  +---------------------+ +---------------------+ +--------------------+ |
|                                                                         |
|  MY ENROLLED EVENTS:                                                    |
|  +-------------------------------------------------------------------+  |
|  | Event Name           Date         Category     Status     Action   |  |
|  |-------------------------------------------------------------------|  |
|  | Web Dev Hackathon    15-Oct-2026  Technical    Confirmed  [Details]|  |
|  | Cloud Computing WS   28-Oct-2026  Workshop     Registered [Cancel] |  |
|  +-------------------------------------------------------------------+  |
|                                                                         |
|  RECOMMENDED FOR YOU:                                                   |
|  +--------------------+ +--------------------+ +--------------------+   |
|  | [Poster]           | | [Poster]           | | [Poster]           |   |
|  | CyberSecurity Expo | | UI/UX Bootcamp     | | Sports Meet 2026   |   |
|  | [ Register Now ]   | | [ Register Now ]   | | [ Register Now ]   |   |
|  +--------------------+ +--------------------+ +--------------------+   |
+-------------------------------------------------------------------------+
| FOOTER                                                                  |
+-------------------------------------------------------------------------+
```

---

## 5. Low-Fidelity Wireframe: Admin Console (`admin/index.php`)

```
+-------------------------------------------------------------------------+
| [ADMIN CONSOLE] StudentHub            [Search...]    [Admin User] [🚪]  |
+--------------------+----------------------------------------------------+
| SIDEBAR NAVIGATION | METRICS & KPI OVERVIEW                             |
|                    | +--------------+ +--------------+ +--------------+ |
| [=] Dashboard      | | Total Student| | Total Events | | Registrations| |
| [=] Students (CRUD)| |     1,248    | |      28      | |      432     | |
| [=] Events (Upload)| +--------------+ +--------------+ +--------------+ |
| [=] Registrations  |                                                    |
| [=] Audit Logs     | RECENT EVENT REGISTRATIONS:                        |
| [=] Settings       | +------------------------------------------------+ |
| [=] Logout         | | Student Name  | Event Title       | Time | Status| |
|                    | |---------------+-------------------+------+-------| |
|                    | | Aarav Patel   | AI Workshop       | 10m  | Active| |
|                    | | Diya Sharma   | Web Hackathon     | 1h   | Active| |
|                    | +------------------------------------------------+ |
|                    |                                                    |
|                    | RECENT AUDIT LOGS:                                 |
|                    | [10:45 AM] Admin created event 'Web Hackathon'     |
|                    | [09:30 AM] Student ID 102 logged in (192.168.1.15) |
+--------------------+----------------------------------------------------+
```

---

## 6. Responsive Breakpoint Strategy

- **Mobile Viewport (< 768px):** Single-column stacked layouts, collapsable off-canvas hamburger navigation, full-width form inputs, horizontally scrollable data tables.
- **Tablet Viewport (768px - 1023px):** Two-column grid layouts for cards and summary blocks, compact side navigation.
- **Desktop Viewport ($\ge$ 1024px):** Multi-column CSS Grid layouts (3-4 cards per row), fixed sidebar admin layout, advanced multi-column tables.
