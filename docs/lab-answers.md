# Conceptual Analysis & Key Questions Answer Sheet

## 1. What is a URL and what are the parts of a URL?

A **URL (Uniform Resource Locator)** is a standard reference mechanism used to identify and locate a specific resource (such as an HTML document, image, script, or video) on the World Wide Web.

### Key Parts of a URL
Consider the example URL:
`https://www.studenthub.edu:443/courses/web-dev/index.html?role=student&term=3#syllabus`

1. **Scheme / Protocol (`https://`)**:
   - Specifies the protocol used to transfer data between browser and server (e.g., HTTP, HTTPS, FTP). HTTPS ensures encrypted transmission.
2. **Subdomain (`www.`)**:
   - A domain prefix used to segregate specific sections or applications of a web domain.
3. **Domain Name / Hostname (`studenthub.edu`)**:
   - The human-readable web server identifier translated into an IP address by DNS (Domain Name System).
4. **Port (`:443`)**:
   - The technical endpoint/gate on the server. Default for HTTP is `80`, and for HTTPS is `443`. Often omitted in standard web browsing.
5. **Path (`/courses/web-dev/index.html`)**:
   - The directory path on the server pointing to the exact file or resource requested.
6. **Query Parameters (`?role=student&term=3`)**:
   - Key-value pairs separated by `&` following a `?` symbol. Used to pass client-side arguments to server or page scripts.
7. **Fragment / Anchor (`#syllabus`)**:
   - Preceded by `#`. Directs the browser to scroll directly to a specific HTML element ID within the loaded document.

---

## 2. How is an HTML file processed in a web browser?

When a browser receives an HTML file from a local path or server, it undergoes a multi-step rendering process:

```
[ HTML Document ] ──► [ HTML Parser ] ──► [ DOM Tree ] ────────┐
                                                               ├─► [ Render Tree ] ──► [ Layout ] ──► [ Painting ]
[ CSS Styles ]   ──► [ CSS Parser ]  ──► [ CSSOM Tree ] ──────┘
```

1. **Bytes to Characters to Tokens**:
   - The browser reads raw bytes from disk/network, converts them to characters according to encoding (e.g., UTF-8), and tokenizes tags (`<html>`, `<body>`, `<h1>`).
2. **DOM (Document Object Model) Construction**:
   - Tokens are transformed into Nodes, creating a tree structure reflecting parent-child HTML relationships.
3. **CSSOM (CSS Object Model) Construction**:
   - When encountering `<link rel="stylesheet">` or `<style>` tags, the browser parses CSS rules and builds the CSSOM tree.
4. **Render Tree Generation**:
   - The browser combines DOM and CSSOM to form the **Render Tree**. Non-visible elements (like `<head>`, `<script>`, or elements with `display: none`) are excluded.
5. **Layout / Reflow Phase**:
   - The browser calculates exact geometry, coordinates, and sizing for each visible element relative to the browser viewport.
6. **Paint Phase**:
   - Pixels are drawn on the screen (text, colors, borders, shadows, images).
7. **JS Execution & Compositing**:
   - As scripts run, JavaScript can manipulate the DOM/CSSOM, triggering partial updates (Repaint or Reflow).

---

## 3. How will page navigation flow be managed among all HTML pages?

In this Multi-Page Application (MPA) architecture, navigation flow is managed systematically using standard web conventions:

1. **Consistent Global Header & Navigation Bar**:
   - Every page includes a uniform `<header>` with standard links: Home, Dashboard, Courses, Assignments, Events, Resources, Profile.
2. **Relative Path References**:
   - Clean relative file paths (e.g., `<a href="courses.html">`, `<a href="assignments.html">`) ensure local and deployment portability.
3. **Contextual Action Links & Buttons**:
   - Workflow transitions link logically (e.g., Course List -> `course-details.html?id=101` -> `assignments.html`).
4. **Breadcrumbs & Back Navigation**:
   - Secondary pages display hierarchical breadcrumb navigation (e.g., `Home > Courses > Web Development`) allowing users to step backward easily.
5. **State & Active Indicators**:
   - Active page links receive an `.active` CSS class to visually highlight the current section in the navbar.

---

## 4. How will GitHub commits be maintained after each practical?

To maintain a clean, traceable, and professional version history across all lab practicals:

1. **Conventional Commit Standard**:
   - Use structured prefix commit messages:
     - `feat:` New page or module feature (e.g., `feat: add assignment submission layout`)
     - `docs:` Documentation updates (e.g., `docs: update sitemap and wireframes`)
     - `style:` Styling updates without structural logic changes (e.g., `style: refine dashboard layout colors`)
     - `fix:` Bug fixes (e.g., `fix: correct broken link on navigation bar`)
2. **Practical-Wise Milestones & Tags**:
   - Commit after completing each practical task.
   - Apply Git Tags for practical checkpoints: `git tag -a practical-01 -m "Completed Lab 1: Scope & Project Setup"`.
3. **Branching Strategy (Feature Branches)**:
   - Perform work on topic branches (e.g., `feature/lab-01-setup`, `feature/wireframes`), then merge cleanly into `main`.
4. **Clean Staging & Frequent Commits**:
   - Avoid dumping all changes in one massive commit. Stage related files logically using `git add <file>`.
