# StudentHub Portal - Web Development Lab Project

Welcome to the **StudentHub Portal** project repository. This repository contains the complete laboratory submissions for the **Web Development (CS201)** course, Semester 3, Computer Engineering department at CHARUSAT.

---

## 👨‍🎓 Student Details
- **Student Name:** Daksh Soni
- **Roll Number / Student ID:** 25CS102
- **Class / Branch:** Semester 3 - Computer Engineering (CE)
- **Course:** CS201 - Web Development Lab
- **Faculty Guide:** Prof. Dhara

---

## 📌 Problem Definition & Scope

The **StudentHub Portal** addresses the need for a unified academic platform where students, faculty, and administrators can seamlessly interact. The portal streamlines academic tracking, assignment submissions, campus event updates, notice dissemination, dynamic client-side interactivity, and resource sharing.

### Key Objectives
- Provide role-based access for **Students**, **Faculty/Instructors**, and **Administrators**.
- Build an intuitive, accessible navigation flow across core portal pages.
- Incorporate HTML5 semantic tags, WCAG accessibility rules, breadcrumb navigation, and keyboard skip-links.
- Deliver dynamic client-side interactivity using **JavaScript ES6+**, CSS custom properties, and **localStorage** persistence.

---

## 🧪 Completed Practicals Log

| Lab Practical | Topic / Title | Key Deliverables & Documentation |
| :--- | :--- | :--- |
| **Practical 1 (PR1)** | Scope, Setup & UI Blueprint | Sitemap, 16 Low-Fidelity UI Wireframes, Conceptual Answers ([`docs/lab-answers.md`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/docs/lab-answers.md)) |
| **Practical 2 (PR2)** | HTML5 Semantic Skeletons & Accessibility | HTML5 Page Skeletons, Multi-Role Registration (Student/Faculty/Admin), Accessibility Audit ([`docs/lab-accessibility-checklist.md`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/docs/lab-accessibility-checklist.md)) |
| **Practical 3 (PR3)** | Dynamic UI Components & LocalStorage | Light/Dark Theme Switcher, Hamburger Navigation Menu, Dismissible Notification Banner, Collapsible FAQ Accordion, Modal Popup System, Image/Content Slider Carousel, Micro-animations & LocalStorage Persistence |

---

## ⚡ Dynamic JavaScript UI Components (Practical 3 Implementation)

### 1. Light / Dark Theme Switcher
- **DOM Selection & Manipulation:** Selects `#theme-toggle-btn`, updates icon and text, toggles `.dark-theme` class on `document.body` & `document.documentElement`.
- **LocalStorage Persistence:** Remembers user theme preference (`studenthub_theme`). Automatically applies the saved theme on DOM load without flickering.

### 2. Responsive Hamburger Menu
- **DOM Logic & Event Handling:** Attaches click listener to `#hamburger-btn` to toggle `.active` class on `.nav-links`.
- **Accessibility:** Toggles `aria-expanded` between `"true"` and `"false"`. Closes drawer automatically on `Escape` key press or outside click.

### 3. Notification Banner
- **Dismissible Alert:** Renders top notification banner bar with close button (`&times;`).
- **State Memory:** Saves dismissal state in `localStorage.setItem('studenthub_banner_dismissed', 'true')` with smooth CSS slide/fade exit.

### 4. Collapsible FAQ Accordion
- **Dynamic Content Heights:** Accordion buttons toggle active state and calculate `scrollHeight` for smooth CSS height transitions.
- **Accessibility Compliance:** Operates with keyboard (`Enter`/`Space`), managing `aria-expanded` and `aria-controls` attributes.

### 5. Accessible Modal Popup System
- **Global Modal Controller:** Function `window.StudentHubApp.openModal(title, htmlContent)` creates accessible backdrop overlays (`aria-modal="true"`, `role="dialog"`).
- **Dismiss Triggers:** Closes via close button (✕), backdrop click, or `Escape` key press.

### 6. Image / Content Slider (Carousel Component)
- **Controls & Pagination:** Previous/Next slide buttons, dot indicator synchronization, touch/keyboard navigation.
- **Auto-Play:** Auto-slides every 5 seconds, pausing automatically on mouse hover.

---

## 🎓 Key Questions / Analysis & Evaluation Strategy

1. **How are DOM elements selected and modified?**
   - Elements are selected using `document.getElementById`, `querySelector`, and `querySelectorAll`. Attributes and class lists are updated using `classList.toggle()`, `classList.add()`, `setAttribute()`, and `style.maxHeight`.

2. **Are event listeners attached correctly?**
   - Event listeners (`addEventListener('click')`, `'keydown'`, `'mouseenter'`, `'mouseleave'`) are initialized cleanly on `DOMContentLoaded` without inline event clutter or duplicate bindings.

3. **Is localStorage used for remembering theme choice & UI preferences?**
   - Yes! User theme choice (`studenthub_theme`) and notification banner dismissal status (`studenthub_banner_dismissed`) are stored in `localStorage` and retrieved on page load. A "Reset UI Preferences" option is available in the footer.

4. **Does interactivity improve usability without breaking accessibility?**
   - Accessibility is fully preserved with ARIA state announcements (`aria-expanded`, `aria-hidden`, `aria-modal`), keyboard focus handling, high-contrast HSL color tokens, and `Escape` key listeners.

---

## 📁 Repository Structure

```
dhara maam/
├── pr2/
│   ├── index.html               # Main Portal Landing Page (Slider, Quick FAQs, Hero)
│   ├── about.html               # Mission, Vision, and Core Capabilities
│   ├── dashboard.html           # Student Dashboard & Course Progress
│   ├── courses.html             # Course Directory Catalog
│   ├── course-details.html      # Course Specification & Syllabus
│   ├── assignments.html         # Lab Practical Upload & Submissions
│   ├── events.html              # Campus Events Slider & Modal Registration
│   ├── login.html               # Institutional Multi-Role Login
│   ├── register.html            # Role-based Account Registration
│   ├── resources.html           # Learning Resources & PYQ Library
│   ├── profile.html            # User Profile Settings & Edit Modal
│   ├── notices.html            # Official Notice Board & Circular Modals
│   ├── contact.html            # Helpdesk Contact Form & Support
│   ├── faq.html                # Collapsible FAQ Accordion Page
│   ├── feedback.html           # Portal Feedback Form
│   ├── admin.html              # System Administrator Control Panel
│   │
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css        # Design Tokens, Dark Theme & Component Animations
│   │   ├── js/
│   │   │   ├── layout.js        # Reusable Layout Component Injector
│   │   │   └── main.js          # Dynamic UI Component JS Engine
│   │   └── images/
│   │
│   └── README.md                # Project documentation
```

---

## 🚀 How to Run the Project Locally

1. **Open in Browser**:
   - Open `index.html` directly in any modern web browser (Chrome, Edge, Firefox, Safari).
2. **Test Dynamic UI Components**:
   - **Theme Switcher:** Click 🌙 Dark / ☀️ Light in top navbar.
   - **Hamburger Menu:** Resize browser window to mobile width (<768px) and click ☰.
   - **Collapsible FAQ:** Visit `faq.html` or `index.html` and click question headers.
   - **Modal Popups:** Click "Register Event", "Details", or "View Exam Schedule".
   - **Notification Banner:** Click ✕ on the top banner and refresh the page to verify `localStorage` persistence.
   - **Reset UI Preferences:** Click "Reset UI Preferences" link in the footer.

---

## 🛠️ Tools & Technologies
- **Markup & Styling**: HTML5, CSS3 (Vanilla CSS, CSS Custom Variables, Animations)
- **Scripting**: JavaScript ES6+ (DOM Selection, Event Handling, LocalStorage, Modals, Accordions, Carousels)
- **Version Control**: Git & GitHub
- **IDE**: Visual Studio Code

---

## 📜 License & Acknowledgments
Designed and developed for the **Web Development Lab (Semester 3)** under the guidance of Prof. Dhara at CHARUSAT.
