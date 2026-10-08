# Practical 06: Rendering External JSON Data using Fetch API, Search and Filter

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Asynchronous External JSON Data Ingestion via Fetch API, Real-Time Search, Multi-Criteria Filtering, Dynamic Sorting, and Client-Side Pagination**

---

## 2. Objective
To build an asynchronous data visualization engine for the **StudentHub** events catalog by consuming structured external JSON files (`data/events.json`, `data/students.json`, `data/faqs.json`) containing 15+ realistic university records. The engine demonstrates ES6+ Promise workflows (`fetch()`, `.then()`, `.catch()`), functional array operations (`filter()`, `map()`, `sort()`, `slice()`), live search, category filtering, sorting, client pagination, and resilient UI state handling (Loading, Error, Empty, and Active).

---

## 3. Problem Definition
Hardcoding dynamic data into static HTML files requires cumbersome manual updates every time a new event or student record is created. Consuming structured JSON data feeds asynchronously via JavaScript Fetch API decouples data from presentation, reduces page load payload, and empowers client-side real-time filtering without roundtrip server requests.

---

## 4. Datasets & Asynchronous Processing

### 4.1 Created JSON Data Sources
1. **`data/events.json`:** 16 detailed records (id, title, description, category, date, time, venue, poster, seats, status).
2. **`data/students.json`:** 16 realistic student profiles (id, name, email, mobile, course, year, gender, status).
3. **`data/faqs.json`:** 15 categorized FAQ questions and comprehensive answers.

### 4.2 Array Processing Pipeline
```
[ fetch("data/events.json") ]
            │
            ▼ (JSON Parsed Array)
[ Array.prototype.filter() ] ──► Applies keyword query & category matching
            │
            ▼
[ Array.prototype.sort() ]   ──► Sorts by Date (Asc/Desc) or Title (A-Z)
            │
            ▼
[ Array.prototype.slice() ]  ──► Paginates 6 items per view
            │
            ▼
[ Array.prototype.map() ]    ──► Generates accessible HTML event cards
```

---

## 5. UI State Management

| State | Trigger Condition | Visual Presentation |
| :--- | :--- | :--- |
| **Loading State** | Initial network request before response | `⏳ Loading campus events catalog...` animated indicator |
| **Success State** | JSON resolved with $\ge 1$ matching records | Responsive 3-column CSS Grid with event posters & metadata |
| **Empty State** | Search/Filter query produces 0 matches | `🔍 No Matching Events Found` card with "Reset All Filters" button |
| **Error State** | Network failure or 404 resource error | `⚠️ Unable to Load Events Catalog` error banner |

---

## 6. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `data/events.json` | Created | 16 campus event records with dates, venues, categories, and seating |
| `data/students.json` | Created | 16 student directory records with academic departments and years |
| `data/faqs.json` | Created | 15 categorized FAQ records for portal inquiries |
| `js/events.js` | Created | Asynchronous Fetch API engine for search, filter, sort, and pagination |
| `events.html` | Modified | Integrated search/category/sort selectors and dynamic grid container |
| `docs/practical-06.md` | Created | Comprehensive laboratory report and viva voce documentation |

---

## 7. Test Cases & Verification Suite

| Test ID | Feature / Action | Input / Scenario | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-06-01** | Async Data Fetch | Open `events.html` | JSON loaded asynchronously; initial 6 cards rendered | Events fetched & displayed | **PASS** |
| **TC-06-02** | Keyword Search | Type "hackathon" in search input | Grid updates instantly to show hackathon events | Live search filtered | **PASS** |
| **TC-06-03** | Category Filter | Select "Sports" category dropdown | Displays only sports tournaments | Sports events isolated | **PASS** |
| **TC-06-04** | Title Sort (A-Z) | Select "Title: A to Z" | Events reordered alphabetically by title | Alphabetical sorting active | **PASS** |
| **TC-06-05** | Date Sort (Latest) | Select "Date: Latest First" | Events ordered from latest date to earliest | Chronological sort active | **PASS** |
| **TC-06-06** | Pagination | Click page "2" button | Displays next 6 events (items 7-12) | Page 2 rendered | **PASS** |
| **TC-06-07** | Empty State | Search "nonexistent_query_xyz" | Displays "No Matching Events Found" with Reset button | Empty state displayed | **PASS** |
| **TC-06-08** | Reset Filter | Click "Reset All Filters" button | Restores all inputs and displays all 16 events | Full catalog restored | **PASS** |

---

## 8. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Dynamic Events Catalog:** `events.html` showing first 6 events rendered via Fetch API with active pagination.
2. **Real-Time Search In Action:** Search bar with "hackathon" query showing filtered hackathon cards.
3. **Category Dropdown Filter:** "Technical" filter active with counter showing matching events count.
4. **DevTools Network Tab:** Network panel showing successful 200 OK GET request for `data/events.json`.
5. **Empty State Card:** Screenshot of "No Matching Events Found" card upon invalid search query.

---

## 9. Viva Voce Questions & Answers

### Q1: What is the Fetch API and how does it differ from XMLHttpRequest (XHR)?
**Answer:** The Fetch API is a modern, promise-based JavaScript interface for executing asynchronous HTTP network requests. Unlike callback-heavy `XMLHttpRequest`, `fetch()` returns Promises that allow clean `.then()` chaining, async/await syntax, and native streaming body readers.

### Q2: Why is `res.json()` necessary after a `fetch()` call?
**Answer:** `fetch()` resolves to a `Response` object representing the raw HTTP response headers. `res.json()` is an asynchronous method that reads the response body stream to completion and parses the JSON text into a native JavaScript object or array.

### Q3: Explain the role of `filter()`, `map()`, `sort()`, and `slice()` in this practical.
**Answer:**
- **`filter()`:** Returns a new array containing only elements that satisfy search and category conditions.
- **`sort()`:** Sorts the array elements in place based on comparator functions (date timestamps or `localeCompare` string titles).
- **`slice(start, end)`:** Extracts a shallow copy of the current page's subset of items for pagination.
- **`map()`:** Transforms each event object into an accessible HTML string for DOM injection.

### Q4: What is JSON and why is it the industry standard for web data?
**Answer:** JSON (JavaScript Object Notation) is a lightweight, human-readable text data interchange format. It is language-independent, natively parsable in JavaScript without external libraries, and significantly more compact than XML.

### Q5: How do you handle network errors in Fetch API?
**Answer:** `fetch()` only rejects a Promise on network failure or if request permissions fail. HTTP errors (such as 404 or 500) still resolve the Promise, so developers must explicitly check `if (!res.ok) throw new Error(...)` before parsing JSON, catching failures in `.catch()`.

---

## 10. Conclusion
Practical 06 successfully implemented asynchronous JSON data ingestion, live search, multi-criteria filtering, dynamic sorting, and client-side pagination for the **StudentHub** portal. The project is ready for Practical 07 (PHP Form Processing).
