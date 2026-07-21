# Practical Lab 2: HTML5 Semantic Skeletons & Accessibility Checklist

## 📋 Overview
- **Subject:** Web Development (CS201)
- **Practical Number:** Practical Lab 2 (PR2)
- **Student Name:** Daksh Patel
- **Roll Number / Student ID:** 25CS102
- **Topic:** Development of static HTML5 skeletons for 12 StudentHub pages using semantic elements, accessibility best practices, breadcrumb navigation, and skip-to-content links.

---

## 🔍 Key Analysis & Practical Questions

### 1. Semantic Tag Usage Verification
- **`<header>`**: Wraps global navigation bars across all 12 pages with `aria-label="Main Navigation"`.
- **`<nav>`**: Implements primary sitemap navigation as well as secondary hierarchical breadcrumb navigation using `<ol>` and `aria-label="Breadcrumb"`.
- **`<main>`**: Contains the central unique content for each page, tagged with `id="main-content"` and `tabindex="-1"` for instant focus management upon activating the skip-link.
- **`<section>`**: Encloses logical blocks such as hero areas, course catalogs, event grids, and form blocks, identified with `aria-labelledby`.
- **`<article>`**: Utilized for standalone self-contained items including course cards, event posts, notice board entries, and assignment cards.
- **`<aside>`**: Houses complementary sidebar modules like quick notices on the dashboard, quick facts on about page, and helpdesk info on contact page.
- **`<footer>`**: Contains copyright metadata, practical attribution, and policy notes consistently at the base of every page.

### 2. Accessibility Checklist (WCAG 2.1 Baseline)
- [x] **Form Field Pairing:** All input elements (`<input>`, `<select>`, `<textarea>`) are paired with explicit `<label for="...">` matching input `id` attributes.
- [x] **Aria Described-By & Required Flags:** Mandatory inputs feature `required` and `aria-required="true"`, with contextual assistance provided via `aria-describedby` linking to `.form-hint` paragraphs.
- [x] **Heading Hierarchy:** Strictly one `<h1>` per page serving as the document primary title, followed by `<h2>` and `<h3>` nested in descending order without level skipping.
- [x] **Link Accessibility:** Visual link text and explicit `aria-label` attributes prevent non-descriptive link labels (e.g. replacing generic "click here" with "View details for CS201 Web Development").
- [x] **Interactive Focus Indicator:** Distinct 3px focus ring applied globally (`:focus-visible`) across all inputs, links, and buttons.

### 3. Page Consistency & Extensions
- **Consistency:** Uniform design system, CSS variables (`var(--primary-color)`), header navbar, footer, and container grids applied across all 12 HTML pages.
- **Intermediate Extension (Breadcrumbs):** Implemented breadcrumb trail navigation (`Home > Category > Page`) with `aria-current="page"` on current location across all sub-pages.
- **Advanced Extension (Skip-to-Content & Keyboard Navigation):** Off-screen `.skip-link` positioned prior to header rendering that drops into view on keyboard `TAB`, shifting viewport focus directly to `<main id="main-content">`.

---

## 📁 Developed Pages Directory (12 Pages Total)

| Page File | Page Name | Primary Semantic Layout Elements |
| :--- | :--- | :--- |
| [`index.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/index.html) | Home / Landing | `header`, `nav`, `main`, `section`, `article`, `footer` |
| [`about.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/about.html) | About Us | `header`, `nav`, `main`, `section`, `article`, `aside`, `footer` |
| [`login.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/login.html) | Login | `header`, `nav`, `main`, `section`, `fieldset`, `legend`, `footer` |
| [`register.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/register.html) | Registration | `header`, `nav`, `main`, `section`, `form`, `footer` |
| [`dashboard.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/dashboard.html) | Dashboard | `header`, `nav`, `main`, `section`, `article`, `aside`, `footer` |
| [`courses.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/courses.html) | Course Catalog | `header`, `nav`, `main`, `section`, `article`, `footer` |
| [`course-details.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/course-details.html) | Course Specification | `header`, `nav`, `main`, `section`, `ol`, `ul`, `footer` |
| [`assignments.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/assignments.html) | Assignment Submissions | `header`, `nav`, `main`, `section`, `article`, `form`, `footer` |
| [`events.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/events.html) | Campus Events | `header`, `nav`, `main`, `section`, `article`, `footer` |
| [`resources.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/resources.html) | Resource Center & PYQs | `header`, `nav`, `main`, `section`, `article`, `footer` |
| [`notices.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/notices.html) | Notice Board | `header`, `nav`, `main`, `section`, `article`, `footer` |
| [`profile.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/profile.html) | User Profile | `header`, `nav`, `main`, `section`, `footer` |
| [`contact.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/contact.html) | Contact Helpdesk | `header`, `nav`, `main`, `section`, `aside`, `form`, `footer` |
| [`faq.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/faq.html) | FAQ | `header`, `nav`, `main`, `section`, `article`, `footer` |
| [`feedback.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/feedback.html) | Student Feedback | `header`, `nav`, `main`, `section`, `fieldset`, `form`, `footer` |
| [`admin.html`](file:///c:/Users/daksh/Documents/1.%20SEM%20-%203/web%20devlopement/dhara%20maam/admin.html) | Admin Control Panel | `header`, `nav`, `main`, `section`, `article`, `footer` |
