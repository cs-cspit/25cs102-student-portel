# Practical 13: PHP JSON API and AJAX/Fetch-Based CRUD without Page Reload

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**RESTful PHP JSON API Architecture, Asynchronous AJAX/Fetch Client Integration, HTTP Status Codes, and Single-Page Non-Reload CRUD Workflows**

---

## 2. Objective
To engineer a RESTful JSON API backend in PHP (`api/students.php` and `api/events.php`) and build a reusable client-side Fetch API asynchronous module (`js/api.js`). The API processes standard HTTP verbs (`GET`, `POST`, `PUT`, `DELETE`), enforces server-side payload validation, handles CORS headers, returns uniform JSON response contracts with accurate HTTP status codes (`200 OK`, `201 Created`, `400 Bad Request`, `404 Not Found`, `500 Internal Error`), and executes seamless CRUD operations without browser page refreshes.

---

## 3. Problem Definition
Traditional web applications reload the entire HTML page upon every form submission or record modification, causing visual flickering, wasted bandwidth, and disconnected user experiences. Decoupling backend business logic into RESTful JSON APIs consumed asynchronously via JavaScript Fetch API creates instantaneous, reactive user interfaces.

---

## 4. RESTful API Architecture & Status Codes

| Endpoint | HTTP Method | Action / Purpose | Expected Status Code | Response Payload Schema |
| :--- | :---: | :--- | :---: | :--- |
| `/api/students.php` | `GET` | Retrieve student list or search results | `200 OK` | `{"success": true, "data": [...]}` |
| `/api/students.php?id=1` | `GET` | Fetch single student profile | `200 OK` / `404 Not Found` | `{"success": true, "data": {...}}` |
| `/api/students.php` | `POST` | Create new student record | `201 Created` / `400 Bad Request` | `{"success": true, "message": "..."}` |
| `/api/students.php` | `PUT` | Update student details | `200 OK` / `400 Bad Request` | `{"success": true, "data": {...}}` |
| `/api/students.php` | `DELETE` | Remove student record | `200 OK` / `404 Not Found` | `{"success": true, "message": "..."}` |
| `/api/events.php` | `GET` | Retrieve active events catalog | `200 OK` | `{"success": true, "data": [...]}` |
| `/api/events.php` | `POST` | Create new event | `201 Created` | `{"success": true, "message": "..."}` |

---

## 5. Unified JSON Response Contract
```json
{
  "success": true,
  "message": "Student created successfully",
  "data": {
    "id": 101,
    "name": "Daksh Shah",
    "email": "25cs102@charusat.edu.in",
    "course": "B.Tech CSE"
  },
  "errors": null,
  "timestamp": "2026-10-09 01:04:18"
}
```

---

## 6. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `api/students.php` | Created | RESTful JSON API endpoint for student CRUD operations |
| `api/events.php` | Created | RESTful JSON API endpoint for campus events CRUD operations |
| `js/api.js` | Created | Asynchronous client-side wrapper module (`StudentHubAPI`) |
| `docs/practical-13.md` | Created | Comprehensive laboratory practical report and viva preparation manual |

---

## 7. Test Cases & Verification Suite

| Test ID | Method / Action | Endpoint | Expected Result | Actual Result | Status |
| :--- | :---: | :--- | :--- | :--- | :---: |
| **TC-13-01** | `GET` | `/api/students.php` | Returns `200 OK` with JSON array of student records | `200 OK` received | **PASS** |
| **TC-13-02** | `GET` (Search) | `/api/students.php?q=Daksh` | Returns filtered student record with `200 OK` | Match returned | **PASS** |
| **TC-13-03** | `GET` (Single) | `/api/students.php?id=9999` | Returns `404 Not Found` with clear error message | `404 Not Found` | **PASS** |
| **TC-13-04** | `POST` (Valid) | `/api/students.php` | Inserts new student; returns `201 Created` with new ID | `201 Created` | **PASS** |
| **TC-13-05** | `POST` (Invalid) | `/api/students.php` | Empty name/email returns `400 Bad Request` with field errors | `400 Bad Request` | **PASS** |
| **TC-13-06** | `PUT` (Update) | `/api/students.php` | Updates student mobile; returns `200 OK` | `200 OK` updated | **PASS** |
| **TC-13-07** | `DELETE` | `/api/students.php` | Deletes student by ID; returns `200 OK` | `200 OK` deleted | **PASS** |
| **TC-13-08** | `OPTIONS` Preflight | `/api/students.php` | Returns `200 OK` with CORS allowed headers | CORS preflight pass | **PASS** |

---

## 8. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Network Tab GET Request:** DevTools Network panel showing `200 OK` JSON response from `api/students.php`.
2. **Postman / REST Client POST:** Sending JSON payload to `api/students.php` and receiving `201 Created`.
3. **Response Headers Inspection:** Showing `Content-Type: application/json; charset=UTF-8`.
4. **Validation Error Response:** Showing `400 Bad Request` JSON error object for invalid data.

---

## 9. Viva Voce Questions & Answers

### Q1: What is a RESTful API?
**Answer:** Representational State Transfer (REST) is an architectural style for web services. RESTful APIs use standard HTTP verbs (`GET`, `POST`, `PUT`, `DELETE`) to perform stateless operations on resources identified by uniform URIs, returning structured representations (typically JSON).

### Q2: Why is `header("Content-Type: application/json")` essential in PHP APIs?
**Answer:** It tells the client browser or consumer application that the response payload is structured JSON data rather than an HTML document, enabling automatic JSON parsing.

### Q3: How do you read JSON payloads sent via `PUT` or `POST` in PHP?
**Answer:** Because `$_POST` only populates on `multipart/form-data` or form-encoded POST requests, raw JSON request bodies must be read from the input stream using `file_get_contents("php://input")` and decoded with `json_decode(..., true)`.

### Q4: Explain the meanings of HTTP status codes 200, 201, 400, 404, and 500.
**Answer:**
- **200 OK:** Request succeeded.
- **201 Created:** Request succeeded and created a new resource.
- **400 Bad Request:** Client-side validation failure or malformed payload.
- **404 Not Found:** Requested resource ID does not exist.
- **500 Internal Server Error:** Server-side database or script execution exception.

### Q5: What is CORS and why are preflight `OPTIONS` requests sent?
**Answer:** Cross-Origin Resource Sharing (CORS) is a browser security mechanism that restricts cross-origin HTTP requests. For state-modifying requests (`PUT`, `DELETE`) or custom headers, browsers automatically send an `OPTIONS` preflight request to verify server permissions before sending the actual request.

---

## 10. Conclusion
Practical 13 successfully built a decoupled, standards-compliant RESTful JSON API layer and asynchronous Fetch client wrapper for **StudentHub**. The project is ready for Practical 14 (Admin Dashboard and Audit Logs).
