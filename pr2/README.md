# StudentHub Portal - Web Development Lab Project

Welcome to the **StudentHub Portal** project repository. This repository contains the complete laboratory submissions for the **Web Development (CS201)** course, Semester 3, Computer Engineering department at CHARUSAT.

---

## 👨‍🎓 Student Details
- **Student Name:** Daksh Patel
- **Roll Number / Student ID:** 25CS102
- **Class / Branch:** Semester 3 - Computer Engineering (CE)
- **Course:** CS201 - Web Development Lab
- **Faculty Guide:** Prof. Dhara

---

## 📌 Problem Definition & Scope

The **StudentHub Portal** addresses the need for a unified academic platform where students, faculty, and administrators can seamlessly interact. The portal streamlines academic tracking, assignment submissions, campus event updates, notice dissemination, and resource sharing.

### Key Objectives
- Provide role-based access for **Students**, **Faculty/Instructors**, and **Administrators**.
- Build an intuitive, accessible navigation flow across **16 core pages** (exceeding the minimum 10 required pages).
- Incorporate HTML5 semantic tags, WCAG accessibility rules, breadcrumb navigation, and keyboard skip-links.

---

## 🧪 Completed Practicals Log

| Lab Practical | Topic / Title | Key Deliverables & Documentation |
| :--- | :--- | :--- |
| **Practical 1 (PR1)** | Scope, Setup & UI Blueprint | Sitemap, 16 Low-Fidelity UI Wireframes, Conceptual Answers ([`docs/lab-answers.md`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/docs/lab-answers.md)) |
| **Practical 2 (PR2)** | HTML5 Semantic Skeletons & Accessibility | 16 HTML5 Page Skeletons, Multi-Role Registration (Student/Faculty/Admin), Accessibility Audit ([`docs/lab-accessibility-checklist.md`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/docs/lab-accessibility-checklist.md)) |

---

## 👥 User Roles & Responsibilities

1. **Student**
   - Access course dashboard, timetables, grades, and attendance.
   - Submit assignments, download study materials, and register for campus events.
   - Profile management and feedback submissions.

2. **Faculty / Instructor**
   - Faculty account registration with Employee ID and Designation.
   - Manage assigned courses, upload syllabus, lecture notes, and practical guides.
   - Create assignments, evaluate submissions, and post announcements.

3. **Administrator**
   - Admin account registration using security tokens.
   - System-wide configuration, user role allocations, site notices, and accessibility audit logs.

---

## 🧩 Key Modules

- **Authentication & Multi-Role User Management**: Login, Register (Student, Faculty, Admin), Profile Management.
- **Academic & Course Management**: Course Catalog (`courses.html`), Detailed Specification (`course-details.html`).
- **Assignment & Submission Engine**: Assignment list, deadline trackers, and file upload interface (`assignments.html`).
- **Events & Announcement Hub**: Notice Board (`notices.html`), Campus Event Registration (`events.html`).
- **Resource Center**: E-books, Previous Year Questions (PYQs), Lecture Slides repository (`resources.html`).
- **Support & Portal Utilities**: Contact Helpdesk (`contact.html`), FAQ (`faq.html`), Feedback (`feedback.html`), Admin Panel (`admin.html`).

---

## 🗺️ Sitemap & Page Navigation Flow

```
                                      [ Index / Landing Page ]
                                                 │
                   ┌─────────────────────────────┼─────────────────────────────┐
                   ▼                             ▼                             ▼
            [ Login Page ]             [ Registration Page ]            [ About Us Page ]
                   │                             │                             │
                   └─────────────────────────────┼─────────────────────────────┘
                                                 ▼
                                      [ Student Dashboard ]
                                                 │
 ┌───────────────┬───────────────────┬───────────┴───────────┬───────────────────┬───────────────┐
 ▼               ▼                   ▼                       ▼                   ▼               ▼
[ Courses ] [ Assignments ] [ Event Registration ] [ Resource Center ] [ Helpdesk Contact ] [ Admin Panel ]
 │               │                   │                       │                   │
 ▼               ▼                   ▼                       ▼                   ▼
[ Course Details ] [ Practical Uploads ] [ Notice Board ]     [ FAQ ]            [ User Profile & Feedback ]
```

### Core Pages Breakdown (16 Developed Pages)
1. `index.html` - Landing / Home Page introducing StudentHub features.
2. `about.html` - Mission, objectives, and institutional platform capabilities.
3. `login.html` - Secure role-based login (Student, Faculty, Admin).
4. `register.html` - Multi-role registration form (Student, Faculty, Admin).
5. `dashboard.html` - Student Dashboard displaying course summaries, deadlines, and notices.
6. `courses.html` - Course list catalog with links to detailed course pages.
7. `course-details.html` - Specific course overview, module syllabus, and learning resources.
8. `assignments.html` - Practical assignment list, deadline tracker, and upload form.
9. `events.html` - Campus event listings and registration action triggers.
10. `resources.html` - Library of lecture slides and Previous Year Questions (PYQs).
11. `profile.html` - User profile, account details, and branch configurations.
12. `notices.html` - Official notice board with institutional updates.
13. `contact.html` - Helpdesk contact form and office details.
14. `faq.html` - Frequently Asked Questions and portal guidance.
15. `feedback.html` - Student portal feedback, rating system, and usability notes.
16. `admin.html` - Administrator control panel and audit log management.

---

## 📂 Project Directory Structure

```
dhara maam/
│
├── index.html               # Landing page
├── about.html               # About platform
├── login.html               # Login page
├── register.html            # Multi-Role User Registration (Student/Faculty/Admin)
├── dashboard.html           # Student/Faculty Dashboard
├── courses.html             # Course listing catalog
├── course-details.html      # Detailed course page
├── assignments.html         # Assignment submission portal
├── events.html              # Campus events & registration
├── resources.html           # Learning resources hub
├── profile.html            # User profile & settings
├── notices.html            # Notice board
├── contact.html            # Helpdesk contact form
├── faq.html                # Frequently Asked Questions
├── feedback.html           # Portal feedback form
├── admin.html              # Administrative management panel
│
├── assets/
│   ├── css/
│   │   └── style.css        # Shared beginner-friendly CSS stylesheet
│   ├── js/
│   │   └── main.js          # Core JavaScript interactions
│   └── images/              # Assets & Wireframe diagrams
│
├── docs/
│   ├── wireframes.md        # Low-Fidelity UI Wireframes & Layout Specs
│   ├── lab-answers.md       # Conceptual Q&A (URL, HTML Processing, Git Workflow)
│   └── lab-accessibility-checklist.md  # Practical 2 Accessibility Audit & Checklist
│
└── README.md                # Project documentation (this file)
```

---

## ❓ Conceptual Analysis & Key Questions

Detailed answers to lab evaluation questions can be found in [`docs/lab-answers.md`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/docs/lab-answers.md):

1. **URL & Parts of URL**: Breakdown of Scheme, Hostname, Port, Path, Query Parameters, and Anchor/Fragment.
2. **HTML Processing in Browser**: Parsing, DOM creation, CSSOM construction, Render Tree creation, Layout phase, and Painting phase.
3. **Page Navigation Flow**: Multi-Page Application (MPA) hyperlink navigation strategies, clean relative paths, breadcrumbs, and state persistence.
4. **Git Commit Maintenance**: Practical-by-practical branching, clean commit messages standard (`feat:`, `docs:`, `fix:`), and tag releases.

---

## 🚀 How to Run the Project Locally

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/25csdaksh/web-devlopment-dss-.git
   cd "dhara maam"
   ```
2. **Open in Browser / VS Code**:
   - Open the directory in **VS Code**.
   - Use **Live Server** extension or open `index.html` directly in any web browser.

---

## 🛠️ Tools & Technologies
- **Markup & Styling**: HTML5, CSS3 (Vanilla CSS, Beginner-Friendly Layouts)
- **Scripting**: JavaScript (ES6+)
- **Version Control**: Git & GitHub
- **IDE**: Visual Studio Code

---

## 📜 License & Acknowledgments
Designed and developed for the **Web Development Lab (Semester 3)** under the guidance of Prof. Dhara at CHARUSAT.
