# Practical 02: Semantic HTML5 Pages with Accessibility-Ready Structure

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Semantic HTML5 Architecture and Accessibility-Ready Page Structuring for the StudentHub Portal**

---

## 2. Objective
To construct a standards-compliant, semantic HTML5 foundation for the **StudentHub** platform across 11 interconnected public, student, and administrative views. The objective emphasizes structural semantics (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`), strict heading hierarchy (`<h1>` to `<h3>`), full form accessibility (`<label>`, `<fieldset>`, `<legend>`), keyboard accessibility (skip-to-content link, focus landmarks), and zero broken links.

---

## 3. Problem Definition
Traditional web applications frequently rely on generic, unsemantic `<div>` and `<span>` wrappers without landmark semantics or accessible relationships. This creates severe barriers for screen readers, hinders keyboard navigation, impairs SEO indexation, and leads to inaccessible form validation. Practical 02 addresses this by building an accessible HTML5 foundation before introducing advanced CSS styling and JavaScript interactivity in subsequent practicals.

---

## 4. Pages Created & Site Architecture

| Page File | Page Title | Primary Role & Semantic Landmarks |
| :--- | :--- | :--- |
| `index.html` | Home Page | Hero banner, key platform pillars, featured upcoming events grid, call-to-action block. |
| `about.html` | About StudentHub | Mission statement, system objectives grid, stakeholder analysis, and academic attribution. |
| `register.html` | Student Registration | Accessible student signup form with grouped fieldsets, radio groups, and terms checkbox. |
| `login.html` | Account Login | Authentication portal with email/password controls and remember-me checkbox. |
| `dashboard.html` | Student Dashboard | Welcome greeting banner, KPI metric counters, enrolled events table, and campus notices. |
| `events.html` | Campus Events | Search/filter controls form and dynamic event catalog `<article>` cards with meta tags. |
| `profile.html` | Student Profile | Academic identity table, profile badge, and contact information update form. |
| `contact.html` | Contact Support | Campus directory address landmark and multi-field support message form. |
| `faq.html` | FAQ & Knowledge Base | Categorized question/answer articles for accounts, events, and technical support. |
| `feedback.html` | Student Feedback | Satisfaction rating radio groups, feedback category selector, and comments textarea. |
| `admin/index.html` | Admin Console | Privileged navigation, KPI stats cards, student CRUD preview, event oversight, and audit logs. |

---

## 5. Semantic Elements & Landmarks Used
- `<header class="site-header">`: Top navigation banner housing university branding and role links.
- `<nav aria-label="...">`: Clearly labeled navigation landmarks for primary, breadcrumb, and administrative menus.
- `<main id="main-content">`: Central landmark containing unique page content, targetable by skip links.
- `<section aria-labelledby="...">`: Thematic grouping of content labeled by explicit section headings.
- `<article>`: Self-contained composition blocks used for event listings, notices, and FAQ items.
- `<fieldset>` & `<legend>`: Form controls grouped logically by category (Personal Info, Academic Details, Security).
- `<address>`: Standard contact information landmark on the contact page.
- `<footer class="site-footer">`: Uniform bottom navigation, department metadata, and copyright landmarks.

---

## 6. Accessibility (a11y) Features Implemented
1. **Document Declarations:** Standard `<!DOCTYPE html>`, `<html lang="en">`, and `<meta charset="UTF-8">`.
2. **Responsive Viewport:** `<meta name="viewport" content="width=device-width, initial-scale=1.0">`.
3. **Skip-to-Content Mechanism:** Hidden accessible link `<a href="#main-content" class="skip-link">Skip to main content</a>` positioned as the first focusable element.
4. **Strict Heading Hierarchy:** Exactly one `<h1>` per page representing the core page topic, followed sequentially by `<h2>` and `<h3>` without skipping levels.
5. **Explicit Form Labels:** Every `<input>`, `<select>`, and `<textarea>` is tied to a corresponding `<label>` using matching `id` and `for` attributes.
6. **Descriptive Image Alt Text:** All images contain meaningful descriptions (e.g., `alt="Students collaborating at CodeSprint Hackathon 2026"`).
7. **Semantic Interactive Buttons:** All triggers use `<button type="...">` or `<a href="...">` rather than click handlers on non-interactive `<div>` tags.

---

## 7. Files Created & Modified

| File / Path | Action | Purpose |
| :--- | :--- | :--- |
| `index.html` | Created | Public portal home page |
| `about.html` | Created | About and academic framework page |
| `register.html` | Created | Accessible student registration form |
| `login.html` | Created | Portal authentication view |
| `dashboard.html` | Created | Static student dashboard layout |
| `events.html` | Created | Campus events catalog & filters |
| `profile.html` | Created | Student profile & academic identity |
| `contact.html` | Created | Campus directory and inquiry form |
| `faq.html` | Created | Semantic FAQ knowledge base |
| `feedback.html` | Created | Experience and rating feedback form |
| `admin/index.html` | Created | Admin console overview with audit logs |
| `css/style.css` | Created | Accessible base stylesheet with focus rings and landmarks |
| `docs/practical-02.md` | Created | Lab manual, test suite, and viva preparation report |

---

## 8. Test Cases & Verification Suite

| Test ID | Requirement / Feature | Verification Action | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-02-01** | Page Existence | Check presence of all 11 HTML pages | All 11 files present in directory tree | All 11 files verified | **PASS** |
| **TC-02-02** | Navigation Consistency | Test all navbar links across all pages | Every link navigates to an existing valid page | No broken links found | **PASS** |
| **TC-02-03** | Page Metadata & Titles | Inspect `<title>` and `<meta name="description">` | Unique descriptive titles across all pages | All pages have unique titles | **PASS** |
| **TC-02-04** | Document Language | Inspect root element across all files | Contains `<html lang="en">` | Verified on all 11 pages | **PASS** |
| **TC-02-05** | Form Label Associations | Check every input for explicit `<label for="...">` | 100% inputs have matching label IDs | All form inputs associated | **PASS** |
| **TC-02-06** | Image Text Alternatives | Check all `<img>` tags for `alt` attribute | All images contain meaningful alt text | Alt text verified | **PASS** |
| **TC-02-07** | Skip-to-Content Link | Keyboard Tab focus on page load | Skip link appears and targets `#main-content` | Focus jumps to main landmark | **PASS** |
| **TC-02-08** | Heading Hierarchy | Check document outline for `h1` $\to$ `h2` $\to$ `h3` | Exactly one `h1`, no skipped heading levels | Clean hierarchical outline | **PASS** |
| **TC-02-09** | Keyboard Navigation | Tab through interactive elements | Visible focus rings on links, inputs, buttons | Outline visible via `:focus-visible` | **PASS** |
| **TC-02-10** | Table Landmarks | Check data tables in dashboard & admin | Tables utilize `<thead>`, `<tbody>`, `<th> scope` | Standard tabular semantics | **PASS** |

---

## 9. Expected Output & Screenshots to Capture

For laboratory viva submission and practical portfolio verification, capture:
1. **Home Page (`index.html`):** Browser rendering showing header, hero section, event cards, and footer.
2. **Registration Form (`register.html`):** Showing fieldsets, radio buttons, dropdowns, and label alignments.
3. **Accessibility Inspection (DevTools):** Chrome/Edge DevTools > Elements > Accessibility tree showing landmark roles (`banner`, `navigation`, `main`, `contentinfo`).
4. **Skip-Link Activation:** Focus state showing the "Skip to main content" button at the top-left of the viewport.
5. **Admin Console (`admin/index.html`):** Admin view showing KPI cards, tabular student listings, and audit log table.

---

## 10. Viva Voce Questions & Answers

### Q1: What is the significance of Semantic HTML5 elements over generic `<div>` tags?
**Answer:** Semantic elements (like `<header>`, `<nav>`, `<main>`, `<article>`, `<section>`, and `<footer>`) clearly describe their meaning to both the browser and the developer. They create accessibility landmarks for screen readers, enhance search engine indexing (SEO), and make the codebase modular and maintainable.

### Q2: What is the role of a "Skip to main content" link and how does it work?
**Answer:** A skip link allows keyboard and screen reader users to bypass repetitive top-level navigation headers and jump directly to the primary page content (`#main-content`). It is visually hidden until focused via the `Tab` key, preventing tedious keystrokes on every page navigation.

### Q3: Why is explicit `<label>` association mandatory for accessible forms?
**Answer:** Associating a `<label for="email">` with `<input id="email">` ensures that screen readers announce the field name when focused. Furthermore, clicking on the text label automatically focuses the input field or toggles checkboxes/radio buttons, increasing the clickable target area.

### Q4: When should you use `<fieldset>` and `<legend>`?
**Answer:** `<fieldset>` groups related form controls together (such as Personal Details, Academic Records, or a set of Radio buttons for Gender), while `<legend>` provides a descriptive caption for the group. Screen readers announce the legend when entering the fieldset, giving essential context to the user.

### Q5: What is the difference between `<section>` and `<article>`?
**Answer:**
- `<article>` represents a complete, self-contained piece of content that could theoretically be distributed or syndicated independently (e.g., a single event card, a blog post, an FAQ item).
- `<section>` represents a generic standalone section of a document that groups related content thematically, typically accompanied by an `<h2>` heading.

### Q6: Why should heading levels (`<h1>` to `<h6>`) never be skipped?
**Answer:** Assistive technologies construct a table of contents from heading tags. Skipping from `<h1>` directly to `<h3>` creates confusion for screen reader users by implying that an intermediate hierarchical topic is missing.

### Q7: What is the purpose of the `scope` attribute in `<th>` table header elements?
**Answer:** The `scope="col"` or `scope="row"` attribute explicitly tells screen readers whether a header cell relates to the entire vertical column or the horizontal row, enabling visually impaired users to understand tabular data relationships.

---

## 11. Conclusion
Practical 02 successfully established a robust, accessible, and semantic HTML5 foundation for the entire **StudentHub** platform across 11 unified pages. All landmark semantics, accessible form controls, skip navigation links, and document metadata conform to modern web standards, perfectly positioning the project for Practical 03 (Responsive CSS UI Design).
