# Practical 01: Project Initiation, Requirement Analysis, Sitemap, Wireframe, and GitHub Setup

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Project Initiation, Requirement Analysis, Sitemap, Wireframe, and GitHub Setup for StudentHub Portal**

---

## 2. Objective
To systematically initiate the semester-long academic project **StudentHub (Student Management & Campus Portal)** by performing comprehensive requirements analysis, formulating a complete user role matrix, designing a minimum 10-page sitemap and navigation flow, establishing low-fidelity wireframes, architecting the unified project directory structure, configuring version control (`.gitignore` & Git), and preparing the GitHub deployment baseline.

---

## 3. Problem Statement
Educational institutions often suffer from fragmented communication channels where campus event notices, student registrations, profile updates, and administrative coordination are handled through disconnected tools and manual methods. The objective is to design a unified, accessible, secure, and responsive web portal (**StudentHub**) using HTML5, CSS3, JavaScript (ES6+), PHP 8+, and MySQL, built progressively across 15 structured practical phases.

---

## 4. Requirements & Scope
- **Analysis:** Define problem statement, target personas (Guests, Students, Administrators), and functional/non-functional requirements.
- **Sitemap & Navigation:** Design an interconnected multi-page site hierarchy covering at least 10 core pages and administrative routes.
- **Wireframing:** Create low-fidelity structural blueprints for key views (Home, Registration, Dashboard, Admin Console).
- **Project Structure:** Establish clean, modular directory architecture adhering to academic web development standards.
- **Version Control & Repository Setup:** Initialize Git, configure `.gitignore` to prevent committing sensitive/temporary artifacts, and establish the `main` branch GitHub remote baseline.

---

## 5. Technologies Used
- **Documentation & Design:** Markdown (GFM), ASCII Wireframing, UML/Flow Diagrams
- **Frontend Planning:** Semantic HTML5, CSS3 Grid/Flexbox design tokens, ES6+ JavaScript structure
- **Backend Architecture:** PHP 8+ procedural & modular patterns, MySQL Relational Database (DDL/DML)
- **Tooling & Environment:** VS Code, Git, GitHub, XAMPP (Apache + MySQL)

---

## 6. Implementation Summary
1. **Directory Structuring:** Formatted standard directory structure with dedicated paths for `admin/`, `api/`, `php/`, `css/`, `js/`, `data/`, `uploads/events/`, `sql/`, and `docs/`.
2. **Requirements Engineering (`docs/requirements.md`):** Formulated 10 Functional Requirements (FR-01 to FR-10) and 4 Non-Functional Requirements (NFR-01 to NFR-04), detailing RBAC permissions for Students and Administrators.
3. **Sitemap & Journey Mapping (`docs/sitemap.md`):** Designed complete navigation tree spanning 15 distinct views and documented user navigation journeys.
4. **Wireframe Architecture (`docs/wireframe.md`):** Documented ASCII wireframes specifying header landmarks, main content grids, form field layouts, and responsive breakpoints.
5. **Project README (`README.md`):** Drafted professional, comprehensive documentation covering installation, tech stack, roadmap mapping, and testing standards.
6. **Git Version Control & `.gitignore`:** Configured `.gitignore` rules for environment variables, OS artifacts, XAMPP logs, and upload caches; linked remote repository on branch `main`.

---

## 7. Files Created & Modified

| File / Path | Type | Description |
| :--- | :--- | :--- |
| `docs/requirements.md` | Markdown | Comprehensive requirements specification and RBAC matrix |
| `docs/sitemap.md` | Markdown | Complete 15-page sitemap and user flow diagrams |
| `docs/wireframe.md` | Markdown | Low-fidelity wireframes for desktop and mobile layouts |
| `docs/practical-01.md` | Markdown | Laboratory practical report and viva preparation guide |
| `README.md` | Markdown | Master project README with setup instructions and architectural overview |
| `.gitignore` | Config | Git exclusion rules for sensitive data and temporary files |
| `admin/.gitkeep` | Structure | Placeholder for administrative modules |
| `api/.gitkeep` | Structure | Placeholder for RESTful JSON API endpoints |
| `php/.gitkeep` | Structure | Placeholder for backend authentication and database scripts |
| `css/.gitkeep` | Structure | Placeholder for custom stylesheets |
| `js/.gitkeep` | Structure | Placeholder for JavaScript modules |
| `data/.gitkeep` | Structure | Placeholder for JSON data sources |
| `uploads/events/.gitkeep` | Structure | Placeholder for event poster uploads |
| `sql/.gitkeep` | Structure | Placeholder for SQL database schema scripts |

---

## 8. Test Cases & Verification

| Test ID | Feature / Component | Input / Action | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-01** | Directory Architecture | Verify folder structure against specification | All designated directories exist and are properly placed | All directories created | **PASS** |
| **TC-02** | Documentation Integrity | Inspect `docs/` for requirements, sitemap, wireframes | All 3 documents present with complete specifications | All documents verified | **PASS** |
| **TC-03** | Git Configuration | Check `git status` and `.gitignore` | Sensitive patterns ignored, repository clean | Git initialized and clean | **PASS** |
| **TC-04** | Remote Repository Link | Check `git remote -v` | Origin points to configured GitHub repository | Remote verified | **PASS** |
| **TC-05** | Branch Standardization | Check active branch name | Branch is set to `main` | Branch is `main` | **PASS** |

---

## 9. Expected Output & Screenshots to Capture

For laboratory file evaluation and viva submission, capture the following screenshots:
1. **VS Code Explorer:** Showing the expanded folder structure (`admin`, `api`, `css`, `data`, `docs`, `js`, `php`, `sql`, `uploads`).
2. **Terminal Output:** Terminal executing `git status` and `git remote -v` showing a clean working tree on branch `main`.
3. **GitHub Repository:** The GitHub repository web page showing the initial commit and rendered `README.md`.

---

## 10. Viva Voce Questions & Answers

### Q1: What is the primary purpose of Requirement Analysis in web development?
**Answer:** Requirement analysis establishes the scope, objectives, stakeholder expectations, and technical boundaries of a project before coding begins. It prevents scope creep, identifies functional dependencies (like authentication before dashboard access), and ensures non-functional benchmarks (such as security, accessibility, and sub-second response times) are planned from day one.

### Q2: What is the difference between Functional and Non-Functional Requirements?
**Answer:**
- **Functional Requirements (FR):** Define specific behaviors, features, and calculations the system must perform (e.g., "Students can register for events", "Admin can delete user records").
- **Non-Functional Requirements (NFR):** Specify quality attributes, system constraints, and performance parameters (e.g., "Passwords must be hashed using bcrypt", "Pages must adhere to WCAG 2.1 AA contrast standards", "API responses must return within 200ms").

### Q3: What is a Sitemap and why is it essential for web architecture?
**Answer:** A sitemap is a hierarchical visual or structural representation of all pages and routes within a website. It clarifies user navigation paths, URL hierarchy, page dependencies, and helps ensure that no orphan pages exist. In search engine optimization (SEO), sitemaps also facilitate complete search indexation.

### Q4: What is the difference between Low-Fidelity and High-Fidelity Wireframes?
**Answer:**
- **Low-Fidelity Wireframes:** Simple, grayscale structural sketches or ASCII block representations that focus purely on content hierarchy, grid layout, landmark placements, and functional elements without being distracted by visual styles or colors.
- **High-Fidelity Wireframes:** Pixel-precise interactive mockups with exact typography, color palettes, imagery, and UI component micro-interactions created in tools like Figma or Adobe XD.

### Q5: Why is a `.gitignore` file critical in a professional Git workflow?
**Answer:** `.gitignore` specifies untracked files that Git should deliberately ignore. It prevents accidental commits of sensitive data (passwords, `.env` files, database credentials), bulky third-party dependencies (`node_modules`), build artifacts, OS-specific files (`.DS_Store`, `Thumbs.db`), and user-uploaded media files that bloat the repository.

### Q6: What is Role-Based Access Control (RBAC) and how does it apply to StudentHub?
**Answer:** RBAC is a security mechanism where system access is restricted based on defined user roles rather than individual user identities. In StudentHub:
- **Guests:** Access public informational pages and registration.
- **Students:** Access personal dashboards, event enrollment, and profile editing.
- **Admins:** Access administrative dashboards, full student CRUD, event publishing, poster uploads, and security audit logs.

### Q7: What are semantic HTML landmarks and why should they be planned during wireframing?
**Answer:** Semantic landmarks (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<aside>`, `<footer>`) give structural meaning to web content for browsers, search engines, and assistive technologies (screen readers). Planning them during the wireframe phase ensures the HTML foundation is accessible from the start.

---

## 11. Conclusion
Practical 01 successfully laid the technical and architectural foundation for the **StudentHub** semester project. Requirements, user roles, navigation hierarchies, wireframes, project structure, and Git version control have been established in accordance with academic engineering standards, preparing the project for Practical 02 (Semantic HTML5 Pages).
