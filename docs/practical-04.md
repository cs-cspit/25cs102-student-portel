# Practical 04: JavaScript DOM Manipulation, Event Handling, and UI Interactivity

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Client-Side DOM Manipulation, Custom Event Handling, Dynamic UI Components, and LocalStorage State Persistence**

---

## 2. Objective
To build dynamic, accessible, and asynchronous client-side interactive modules for **StudentHub** using modern Vanilla JavaScript (ES6+). The implementation covers an interactive FAQ accordion, accessible modal popup dialogs, a multi-slide announcement carousel, dismissible notification banners, hamburger navigation, and a persistent Light/Dark theme switcher utilizing the browser's `localStorage` API.

---

## 3. Problem Definition
Static web pages provide limited user engagement and require full-page reloads for simple state modifications. To deliver modern web application experiences, client-side JavaScript must handle user events, modify the Document Object Model (DOM) dynamically, toggle accessibility attributes (`aria-expanded`, `aria-hidden`), and retain user interface preferences across browser sessions without page flickering.

---

## 4. Interactive Components & Logic Implementation

### 4.1 Persistent Light / Dark Mode Toggle
- Reads existing preference from `localStorage.getItem("studenthub_theme")`.
- Toggles `data-theme="dark"` attribute on the `<html>` root element.
- Dynamically updates icon state (☀️/🌙) and updates `localStorage` instantly.

### 4.2 Accessible FAQ Accordion
- Attaches click event listeners to `.accordion-header` buttons.
- Toggles `.active` on parent `.accordion-item` and dynamically updates `aria-expanded="true/false"`.
- Closes previously opened sibling items for clean UI focus.

### 4.3 Content Slider / Carousel
- Computes track transformation using `transform: translateX(-N * 100%)`.
- Dynamic dot generation linked to slide indices.
- Auto-play rotation every 6 seconds with pause-on-hover mechanics and next/prev button handling.

### 4.4 Modal Dialog Architecture
- Listens for clicks on `[data-modal-target]` triggers.
- Injects dynamic announcement titles and text via dataset attributes.
- Traps user attention, closes via close button, backdrop click, or the `Escape` keyboard key.

### 4.5 Dismissible Announcement Banner
- Provides instant dismissal and saves banner state in `sessionStorage` to prevent reappearance during the browsing session.

---

## 5. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `js/main.js` | Created | Vanilla ES6+ interactivity module (Theme, Accordion, Modal, Slider, Banner) |
| `css/style.css` | Modified | Added dark theme variables, modal overlay, accordion styling, and slider transitions |
| `faq.html` | Modified | Updated with interactive accordion markup and ARIA states |
| `index.html` | Modified | Integrated announcement carousel slider and modal dialog container |
| All HTML pages | Modified | Linked `<script src="js/main.js" defer></script>` |
| `docs/practical-04.md` | Created | Comprehensive laboratory practical report and viva preparation manual |

---

## 6. Test Cases & Verification Suite

| Test ID | Interactive Feature | Action / Input | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-04-01** | Theme Toggle | Click theme toggle button | Toggles dark mode; changes root `data-theme` attribute | Theme toggles instantly | **PASS** |
| **TC-04-02** | Theme Persistence | Reload page after selecting Dark Theme | Page renders directly in Dark Mode from `localStorage` | Dark theme preserved | **PASS** |
| **TC-04-03** | Accordion Expand | Click closed FAQ accordion header | Opens panel; sets `aria-expanded="true"` | Accordion expands | **PASS** |
| **TC-04-04** | Accordion Single Focus | Click second accordion item | Expands second item; collapses first item | Sibling item collapsed | **PASS** |
| **TC-04-05** | Modal Dialog Open | Click "View Exam Schedule" trigger | Modal opens with dim backdrop blur | Modal active & centered | **PASS** |
| **TC-04-06** | Modal Escape Close | Press `Escape` key while modal is active | Modal dialog closes and focus restored | Modal closed via Escape | **PASS** |
| **TC-04-07** | Carousel Navigation | Click slider next & prev buttons | Track transforms to next slide; active dot updates | Smooth slide transition | **PASS** |
| **TC-04-08** | Banner Dismissal | Click notification banner close (X) | Banner closes and sets `sessionStorage` flag | Banner dismissed | **PASS** |

---

## 7. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Light vs Dark Mode:** Side-by-side screenshots of the home page in Light Mode and Dark Mode.
2. **Interactive FAQ Accordion:** `faq.html` showing one accordion expanded with arrow rotated and content visible.
3. **Modal Dialog Open:** `index.html` showing active modal popup with dark blurred backdrop.
4. **Announcement Slider:** Carousel in action with active indicator dot.
5. **DevTools LocalStorage:** Application tab in DevTools showing `studenthub_theme: dark`.

---

## 8. Viva Voce Questions & Answers

### Q1: What is the Document Object Model (DOM)?
**Answer:** The DOM is a platform- and language-neutral programming interface that represents an HTML document as a structured tree of objects/nodes. JavaScript uses the DOM API (`querySelector`, `addEventListener`, `classList`) to dynamically read, modify, and style document content without reloading.

### Q2: How does `localStorage` differ from `sessionStorage` and Cookies?
**Answer:**
- **`localStorage`:** Persists data indefinitely until explicitly cleared by the user or script; data is scoped to the origin and survives browser restarts.
- **`sessionStorage`:** Persists data only for the lifetime of the specific browser tab session; data is wiped when the tab is closed.
- **`Cookies`:** Smaller capacity (4KB) storage sent back and forth to the server in HTTP headers on every request.

### Q3: What is Event Bubbling and Event Delegation?
**Answer:**
- **Event Bubbling:** When an event occurs on a DOM element, the event first runs handlers on that element, then bubbles up through its parent elements to the root.
- **Event Delegation:** A pattern where a single event listener is attached to a parent element to handle events on current and dynamically added child elements using `e.target`.

### Q4: Why is `defer` recommended when including `<script>` tags in the `<head>`?
**Answer:** The `defer` attribute tells the browser to download the JavaScript file asynchronously in the background while continuing to parse the HTML document. The script is only executed after the HTML document is fully parsed, eliminating render-blocking delays.

### Q5: How do `classList.add()`, `classList.remove()`, and `classList.toggle()` function?
**Answer:** They are modern DOMTokenList methods used to manipulate CSS classes on an element safely without overwriting the entire `className` string. `toggle()` adds the class if absent and removes it if present.

---

## 9. Conclusion
Practical 04 successfully integrated dynamic DOM manipulation, accessible modal dialogs, interactive accordion components, content sliders, and persistent client-side theming into the **StudentHub** platform. The project is ready for Practical 05 (Registration Form Validation).
