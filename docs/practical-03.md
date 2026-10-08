# Practical 03: Responsive UI Design using CSS Grid, Flexbox, and Media Queries

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Responsive UI Architecture, CSS Grid Layouts, Flexbox Alignments, and Media Queries for StudentHub**

---

## 2. Objective
To engineer a mobile-first, fully responsive design system for **StudentHub** utilizing modern CSS3 features including CSS Custom Properties (Design Tokens), Flexbox layout modules, 2D CSS Grid systems, and structured media queries. The interface must dynamically adapt across mobile smartphones (< 768px), tablets (768px - 1023px), and desktops ($\ge$ 1024px) with high readability and touch-friendly controls.

---

## 3. Problem Definition
Without responsive design, web portals fail to scale across mobile devices, leading to horizontal overflow, unreadable text, broken grid columns, and unclickable form elements. Practical 03 solves this by establishing a centralized design token system (`css/style.css`), a modular responsive layer (`css/responsive.css`), and admin styles (`css/admin.css`) that ensure seamless viewport adaptability without relying on heavy external CSS frameworks.

---

## 4. Key Design System Tokens & Responsive Techniques

### 4.1 CSS Custom Properties (Design Tokens)
- **Harmonious Palette:** 10-shade HSL blue primary scale (`--primary-50` to `--primary-900`), neutral slate scales (`--secondary-50` to `--secondary-900`), and semantic indicators (`--accent`, `--success`, `--warning`, `--danger`).
- **Typography & Radii:** Fluid sizing scale, border radius standards (`--radius-sm: 6px`, `--radius-md: 10px`, `--radius-lg: 16px`), and elevation shadows (`--shadow-xs` through `--shadow-lg`).

### 4.2 Multi-Column CSS Grid & Flexbox Alignment
- **Header & Navbar:** Flexbox layout with space-between brand alignment and wrapped navigation buttons.
- **Content Cards:** CSS Grid (`grid-2`, `grid-3`, `grid-4`) automatically collapsing to 2 columns on tablets and 1 single column on mobile.
- **Form Containers:** Centered auto-scaling card layout with flexible grouped inputs and stacked radio/checkbox controls on mobile.
- **Data Tables:** Enclosed in `.table-responsive` containers with smooth horizontal momentum scrolling on touch devices.

---

## 5. Responsive Breakpoint Architecture

| Viewport Category | Width Range | Layout Behavior |
| :--- | :--- | :--- |
| **Mobile Smartphones** | `< 768px` | Single-column stacked layouts, stacked navbar, full-width CTA buttons, touch-friendly touch targets ($\ge 44\text{px}$). |
| **Tablets & Small Screens** | `768px - 1023px` | 2-column card grids, compact hero padding, adjusted typography scale (`h1: 2rem`). |
| **Standard Desktop** | `1024px - 1279px` | 3-column event grid, 2-column dashboard layout, multi-column footer. |
| **Large Desktop Screens** | `\ge 1280px` | Centered 1200px max-width container with elevated shadow depth. |

---

## 6. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `css/style.css` | Modified | Core design system tokens, typography, buttons, cards, forms, and table styles |
| `css/responsive.css` | Created | Mobile, tablet, and desktop media queries for adaptive scaling |
| `css/admin.css` | Created | Admin console sidebar, badges, and management panel styles |
| `index.html` through `feedback.html` | Modified | Linked `css/responsive.css` across all public and student pages |
| `admin/index.html` | Modified | Linked `css/responsive.css` and `css/admin.css` in admin header |
| `docs/practical-03.md` | Created | Practical 03 laboratory report and viva voce documentation |

---

## 7. Test Cases & Verification Suite

| Test ID | Requirement / Feature | Verification Action | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-03-01** | Mobile Layout (<768px) | Emulate iPhone 14 (390px) in Chrome DevTools | Cards stack vertically to 1 column, zero horizontal overflow | Layout stacks cleanly | **PASS** |
| **TC-03-02** | Tablet Layout (768px-1023px) | Emulate iPad Air (820px) | Grid displays 2 columns for event cards and metric blocks | 2-column layout active | **PASS** |
| **TC-03-03** | Desktop Layout ($\ge$1024px) | Inspect on 1920x1080 viewport | 3-column event cards, centered 1200px container | 3-column grid verified | **PASS** |
| **TC-03-04** | Responsive Tables | View dashboard/admin tables on mobile (<500px) | Table scrolls horizontally without breaking outer container | Table scroll verified | **PASS** |
| **TC-03-05** | Form Control Scaling | Inspect registration form on mobile | Form fields expand to 100% width with touch-friendly spacing | 100% width verified | **PASS** |
| **TC-03-06** | Touch Targets | Measure button heights across views | All interactive buttons meet minimum 40px - 48px height | Touch targets compliant | **PASS** |
| **TC-03-07** | Hero Banner Scaling | Test hero section on 320px screen | Hero text scales down gracefully without line overlap | Clean mobile hero | **PASS** |
| **TC-03-08** | CSS Token Consistency | Inspect computed styles in DevTools | Backgrounds and buttons reference CSS variables | Token variables verified | **PASS** |

---

## 8. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Desktop Home Page View ($\ge$ 1200px):** Full-width 3-column event cards and wide hero banner.
2. **Tablet Responsive View (768px):** 2-column grid layout on iPad viewport.
3. **Mobile Responsive View (375px):** Stacked mobile navbar, full-width CTA buttons, and 1-column cards.
4. **Mobile Registration View:** Form controls spanning 100% width with accessible spacing.
5. **Mobile Table Scroll:** Responsive enrolled events table showing horizontal touch scrollbar.

---

## 9. Viva Voce Questions & Answers

### Q1: What is the primary difference between CSS Grid and Flexbox?
**Answer:**
- **CSS Grid** is a two-dimensional layout system capable of handling both rows and columns simultaneously, making it ideal for complex page layouts and card grids.
- **Flexbox** is a one-dimensional layout system designed for aligning content along a single axis (either horizontally as a row or vertically as a column), making it ideal for navbars, toolbars, and button groups.

### Q2: What is the Mobile-First design approach?
**Answer:** In mobile-first development, base styles are written for small mobile viewports first without media queries. Progressive enhancements and multi-column grids are then introduced for larger screens using `@media (min-width: ...)` queries, ensuring optimal performance on resource-constrained mobile devices.

### Q3: What is the purpose of the `viewport` meta tag?
**Answer:** `<meta name="viewport" content="width=device-width, initial-scale=1.0">` instructs the mobile browser to set the viewport width equal to the physical screen width of the device and sets the initial zoom level to 1.0, preventing mobile browsers from rendering desktop-scaled pages.

### Q4: How do CSS Custom Properties (Variables) improve maintainability?
**Answer:** CSS Variables (defined using `--variable-name` on `:root`) centralize design tokens like colors, fonts, shadows, and radii in one place. Changing a single token instantly updates the entire website and enables easy light/dark theme switching.

### Q5: How do you make HTML data tables responsive on mobile screens?
**Answer:** By wrapping the `<table>` in a container `<div>` with `overflow-x: auto` and `-webkit-overflow-scrolling: touch`. On narrow mobile screens, the table scrolls smoothly horizontally inside the container without causing the entire page body to break.

---

## 10. Conclusion
Practical 03 successfully implemented a responsive, mobile-first CSS architecture across all 11 StudentHub pages using CSS Grid, Flexbox, and media queries. The portal is fully adaptable and ready for Practical 04 (JavaScript DOM Manipulation & Interactivity).
