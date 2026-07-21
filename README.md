# StudentHub Portal - Web Development Lab Project

Welcome to the **StudentHub Portal** project repository. This project is a semester-long web development laboratory assignment designed to build a comprehensive, multi-role portal for academic management, student collaboration, event registration, and resource sharing.

---

## 📌 Problem Definition & Scope

The **StudentHub Portal** addresses the need for a unified academic platform where students, faculty, and administrators can seamlessly interact. The portal streamlines academic tracking, assignment submissions, campus event updates, notice dissemination, and resource sharing.

### Key Objectives
- Provide role-based access for **Students**, **Faculty/Instructors**, and **Administrators**.
- Build an intuitive, accessible navigation flow across **10+ core pages**.
- Establish clean directory structuring, Git workflow, and frontend foundational artifacts.

---

## 👥 User Roles & Responsibilities

1. **Student**
   - Access course dashboard, timetables, grades, and attendance.
   - Submit assignments, download study materials, and register for campus events.
   - Profile management and notification preferences.

2. **Faculty / Instructor**
   - Manage assigned courses, upload syllabus and lecture notes.
   - Create assignments, evaluate student submissions, and update grades/attendance.
   - Issue announcements and notices for enrolled students.

3. **Administrator**
   - System-wide configuration, user role assignments, and batch creation.
   - Approve campus events, oversee portal notifications, and review system logs.

---

## 🧩 Key Modules

- **Authentication & User Management**: Login, Register, Profile Management, Role Selection.
- **Academic & Course Management**: Course Directory, Detailed Course Page, Timetable, Gradebook.
- **Assignment & Submission Engine**: Assignment list, Submission portal with status tracking.
- **Events & Announcement Hub**: Notice Board, Campus Event Registration, Calendar.
- **Resource Center**: E-books, Previous Year Questions (PYQs), Lecture Slides repository.

---

## 🗺️ Sitemap & Page Navigation Flow

```
                                  [ Index / Landing Page ]
                                             │
                        ┌────────────────────┴────────────────────┐
                        ▼                                         ▼
                 [ Login Page ]                         [ Registration Page ]
                        │                                         │
                        └────────────────────┬────────────────────┘
                                             ▼
                                  [ Student Dashboard ]
                                             │
      ┌────────────────┬─────────────────────┼─────────────────────┬────────────────┐
      ▼                ▼                     ▼                     ▼                ▼
[ Course Details ] [ Assignments ]  [ Event Registration ] [ Resource Center ] [ User Profile ]
      │                │                     │                     │
      └────────────────┴─────────────────────┼─────────────────────┴────────────────┘
                                             ▼
                                     [ Notice Board ]
```

### Core Pages Breakdown (16 Developed Pages)
1. `index.html` - Landing / Home Page introducing StudentHub features.
2. `about.html` - Mission, objectives, and institutional platform capabilities.
3. `login.html` - Secure role-based login (Student, Faculty, Admin).
4. `register.html` - Account registration form with field validation metadata.
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
├── register.html            # User Registration
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
│   │   └── style.css        # Shared CSS stylesheet & accessibility helpers
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

## 🎨 Low-Fidelity Wireframes

Refer to [`docs/wireframes.md`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/docs/wireframes.md) for textual layout blueprints and responsive low-fidelity wireframe representations for Desktop and Mobile viewports.

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
- **Markup & Styling**: HTML5, CSS3 (Vanilla CSS, Responsive Grid/Flexbox)
- **Scripting**: JavaScript (ES6+)
- **Version Control**: Git & GitHub
- **IDE**: Visual Studio Code

---

## 📜 License & Acknowledgments
Designed and developed for the **Web Development Lab (Semester 3)** under the guidance of Prof. Dhara.
