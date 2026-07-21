# Low-Fidelity UI Wireframes & Layout Specifications

This document outlines the low-fidelity layout blueprints and structural organization for the key pages of the **StudentHub Portal**.

---

## 1. Global Page Layout Shell

All pages share a consistent header and footer grid shell:

```
+-----------------------------------------------------------------------+
|  [LOGO] StudentHub          Home | Dashboard | Courses | Profile   [Login]|
+-----------------------------------------------------------------------+
|                                                                       |
|                         MAIN PAGE CONTENT AREA                        |
|                                                                       |
+-----------------------------------------------------------------------+
|  (C) 2026 StudentHub Portal | Terms | Privacy | Contact Support       |
+-----------------------------------------------------------------------+
```

---

## 2. Low-Fidelity Layouts for Core Pages

### Page 1: Landing Page (`index.html`)
```
+-----------------------------------------------------------------------+
|  HEADER / NAVBAR                                                      |
+-----------------------------------------------------------------------+
|  [HERO SECTION]                                                       |
|  "Welcome to StudentHub Portal"                                       |
|  Subtitle: Your central academic management & collaboration hub       |
|  [ Get Started / Login ]  [ Explore Courses ]                        |
+-----------------------------------------------------------------------+
|  [FEATURE HIGHLIGHTS - 3 COLUMN CARDS]                                |
|  +------------------+  +------------------+  +------------------+     |
|  | Academic Tracker |  | Assignment Hub   |  | Campus Events    |     |
|  | Timetables & PYQ |  | Deadlines & Tags |  | Workshops & Tech |     |
|  +------------------+  +------------------+  +------------------+     |
+-----------------------------------------------------------------------+
|  FOOTER                                                               |
+-----------------------------------------------------------------------+
```

---

### Page 2: Authentication - Login (`login.html`)
```
+-----------------------------------------------------------------------+
|  HEADER / NAVBAR                                                      |
+-----------------------------------------------------------------------+
|                                                                       |
|                   +-------------------------------+                   |
|                   |        StudentHub Login       |                   |
|                   |                               |                   |
|                   |  Role: (o) Student ( ) Faculty|                   |
|                   |                               |                   |
|                   |  Email:    [                ] |                   |
|                   |  Password: [                ] |                   |
|                   |                               |                   |
|                   |  [   SIGN IN BUTTON   ]       |                   |
|                   |  Don't have an account? Sign Up|                   |
|                   +-------------------------------+                   |
|                                                                       |
+-----------------------------------------------------------------------+
|  FOOTER                                                               |
+-----------------------------------------------------------------------+
```

---

### Page 3: Dashboard (`dashboard.html`)
```
+-----------------------------------------------------------------------+
|  HEADER / NAVBAR                                                      |
+-----------------------------------------------------------------------+
|  [WELCOME BANNER] Welcome back, Student Name (Semester 3)             |
+-----------------------------------++----------------------------------+
|  LEFT PANEL (2/3 width)           || RIGHT PANEL (1/3 width)          |
|  +------------------------------+ || +------------------------------+ |
|  | Active Enrolled Courses      | || | Urgent Notices               | |
|  | - Web Development (CS201)    | || | - Mid-sem exam timetable out  | |
|  | - Data Structures (CS202)    | || | - Hackathon registration open| |
|  +------------------------------+ || +------------------------------+ |
|  +------------------------------+ || +------------------------------+ |
|  | Upcoming Assignment Deadlines| || | Quick Access Links           | |
|  | - Lab 1: Submission (Today)  | || | [Download PYQs] [Calendar]   | |
|  +------------------------------+ || +------------------------------+ |
+-----------------------------------++----------------------------------+
|  FOOTER                                                               |
+-----------------------------------------------------------------------+
```

---

### Page 4: Assignment Portal (`assignments.html`)
```
+-----------------------------------------------------------------------+
|  HEADER / NAVBAR                                                      |
+-----------------------------------------------------------------------+
|  PAGE TITLE: Assignment Submissions & Status                           |
+-----------------------------------------------------------------------+
|  [Filter: All | Pending | Submitted | Graded]                         |
|                                                                       |
|  +-----------------------------------------------------------------+  |
|  | Course: Web Development | Title: Practical 1 Setup               |  |
|  | Due Date: 2026-07-25  | Status: Pending                         |  |
|  | Upload File: [ Choose File ]  [ Submit Assignment ]             |  |
|  +-----------------------------------------------------------------+  |
|                                                                       |
|  +-----------------------------------------------------------------+  |
|  | Course: Data Structures | Title: Tree Traversal                  |  |
|  | Due Date: 2026-07-18  | Status: Graded (95/100)                |  |
|  +-----------------------------------------------------------------+  |
+-----------------------------------------------------------------------+
|  FOOTER                                                               |
+-----------------------------------------------------------------------+
```

---

## 3. Responsive Adaptability Blueprint

- **Desktop Viewports (>= 992px)**: Multi-column grid containers, persistent horizontal navigation menu bar, side-by-side dashboard cards.
- **Tablet Viewports (768px - 991px)**: 2-column simplified grids, collapsible mobile nav menu.
- **Mobile Viewports (< 768px)**: Single-column linear layout, hamburger navigation menu toggle, stacked action buttons.
