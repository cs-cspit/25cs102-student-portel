# Practical 12: Event Management CRUD with Poster Upload and File Validation

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Event Management CRUD Operations, Multipart Form Handling, Strict MIME Type Verification, Whitelist Validation, and Secure Media Storage**

---

## 2. Objective
To build an administrative Event Management module (`admin/events.php`) with complete CRUD functionality and a hardened media upload subsystem. The engine handles `multipart/form-data` uploads, enforces a 2MB file size ceiling, validates image MIME-types using PHP `finfo_file()`, prevents directory traversal with sanitized randomized filenames (`event_<timestamp>_<hex>.ext`), stores assets in `uploads/events/`, and updates relational database records.

---

## 3. Problem Definition
Unrestricted file uploads represent one of the most critical web vulnerabilities (OWASP #1 File Upload Flaws), allowing malicious users to upload executable PHP web shells (`shell.php`) or oversized files that overwhelm storage. Practical 12 implements strict multi-layer upload validation to guarantee that only authentic image binaries are accepted and stored safely.

---

## 4. Multi-Layer File Upload Security Pipeline

```
[ Form Submitted with enctype="multipart/form-data" ]
                    │
                    ▼
[ Check $_FILES['poster']['error'] === UPLOAD_ERR_OK ]
                    │
                    ▼
[ Layer 1: File Size Check (<= 2MB / 2,097,152 Bytes) ]
                    │
                    ▼
[ Layer 2: Extension Whitelisting (.jpg, .jpeg, .png) ]
                    │
                    ▼
[ Layer 3: True Binary MIME-Type Inspection via finfo_file() ]
  (Must match 'image/jpeg' or 'image/png')
                    │
                    ▼
[ Layer 4: Filename Sanitization: "event_" . time() . "_" . bin2hex(random_bytes(6)) . "." . $ext ]
                    │
                    ▼
[ Layer 5: Atomic Move to uploads/events/ via move_uploaded_file() ]
                    │
                    ▼
[ Save Relative Path to MySQL `events` Table via Prepared Statement ]
```

---

## 5. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `admin/events.php` | Created | Administrative Event CRUD module with secure poster upload handler |
| `uploads/events/` | Directory | Secure destination folder for sanitized event banner images |
| `docs/practical-12.md` | Created | Comprehensive laboratory practical report and viva preparation manual |

---

## 6. Test Cases & Verification Suite

| Test ID | Test Scenario | Input / File Action | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-12-01** | Event Creation with Poster | Upload valid `banner.jpg` (<2MB) | Poster saved as `event_<time>_<hex>.jpg`; event created | Event published | **PASS** |
| **TC-12-02** | Invalid File Extension | Attempt uploading `script.php` | Rejected: "Only JPG, JPEG, and PNG permitted" | Malicious upload blocked | **PASS** |
| **TC-12-03** | Fake MIME Extension | Rename `script.php` $\to$ `script.jpg` | MIME check via `finfo_file` detects non-image binary; rejected | Fake image rejected | **PASS** |
| **TC-12-04** | Oversized File | Upload 5MB image file | Rejected: "Poster file size exceeds the 2MB limit" | Oversized file blocked | **PASS** |
| **TC-12-05** | Event Directory Read | Load `admin/events.php` | 16 seeded events displayed with poster thumbnails | Catalog rendered | **PASS** |
| **TC-12-06** | Update Event Details | Update venue and seating in modal | Record updated in database; success alert shown | Record updated | **PASS** |
| **TC-12-07** | Delete Event | Confirm deletion of test event | Event record and associated registrations deleted | Event deleted | **PASS** |
| **TC-12-08** | Audit Log Capture | Publish new event | `audit_logs` records `action = 'EVENT_CREATED'` | Audit logged | **PASS** |

---

## 7. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Event Management Table:** `admin/events.php` showing event titles, categories, dates, and image thumbnails.
2. **Publish Event Modal:** Modal form showing title, date picker, category dropdown, and file upload input.
3. **Upload Error Alert:** Screenshot demonstrating rejection of disallowed file formats (`.php` or `.exe`).
4. **`uploads/events/` Folder View:** VS Code explorer showing generated sanitized filenames.
5. **Audit Logs:** Showing `EVENT_CREATED` and `EVENT_UPDATED` entries.

---

## 8. Viva Voce Questions & Answers

### Q1: Why is `enctype="multipart/form-data"` required for file uploads?
**Answer:** Standard form encoding (`application/x-www-form-urlencoded`) converts form data into URL key-value strings, which cannot handle binary data. `multipart/form-data` splits the HTTP request body into separate boundary-delimited parts for each field and binary file payload.

### Q2: Why is checking `pathinfo($name, PATHINFO_EXTENSION)` alone unsafe?
**Answer:** Attackers can easily rename malicious scripts (e.g. `backdoor.php` $\to$ `backdoor.jpg`). Only inspecting binary magic bytes using `finfo_file(FILEINFO_MIME_TYPE)` guarantees the file is a genuine image.

### Q3: What is the risk of using the user's original filename for stored files?
**Answer:** Original filenames can contain directory traversal sequences (`../../shell.php`), null bytes, or duplicate names that overwrite existing assets. Generating cryptographically random filenames (`bin2hex(random_bytes(6))`) prevents directory traversal and collisions.

### Q4: What does `move_uploaded_file()` do in PHP?
**Answer:** `move_uploaded_file($tmp_name, $destination)` verifies that the temporary file was genuinely uploaded via HTTP POST and safely moves it from PHP's system temporary directory to the specified destination path.

### Q5: How do file upload limits in `php.ini` affect web applications?
**Answer:** `upload_max_filesize` and `post_max_size` in `php.ini` enforce global server limits. If a file exceeds `upload_max_filesize`, PHP automatically sets `$_FILES['poster']['error'] = UPLOAD_ERR_INI_SIZE`.

---

## 9. Conclusion
Practical 12 successfully implemented administrative Event CRUD functionality and hardened image upload validation with MIME verification, extension whitelisting, randomized naming, and audit tracking for **StudentHub**. The project is ready for Practical 13 (PHP JSON API and Fetch AJAX CRUD).
