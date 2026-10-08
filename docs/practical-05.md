# Practical 05: Registration Form with Frontend Validation and User-Friendly Error Handling

**Subject:** ITUE203 – Web Development Frameworks  
**Semester:** 3rd Semester B.Tech CSE  
**Academic Year:** 2026-27  
**Student Name:** Daksh Shah  
**Student ID / Enrollment:** 25CS102  
**Faculty Mentor:** Dhara Ma'am  
**Status:** COMPLETED  

---

## 1. Practical Title
**Client-Side Real-Time Form Validation, Regular Expression Testing, Dynamic Password Strength Calculation, and Accessible Error Feedback**

---

## 2. Objective
To engineer a secure, accessible, real-time client-side validation engine for the **StudentHub** student registration module. The system validates all user inputs (Full Name, University Email, Indian Mobile, Password Complexity, Password Confirmation, Academic Department, Year of Study, Gender, and Terms of Service) using JavaScript Regular Expressions, updates a live password strength indicator, presents accessible error alerts with ARIA attributes, and prevents invalid form submissions.

---

## 3. Problem Definition
Submitting unvalidated form data to the server causes unnecessary network roundtrips, bad database entries, and poor user experience. Frontend validation offers immediate visual feedback as the user types, catching formatting mistakes early while keeping server-side validation as the secondary defense layer.

---

## 4. Validation Rules & Regular Expressions

| Field | Validation Criteria | Regular Expression / Logic | Error Message Displayed |
| :--- | :--- | :--- | :--- |
| **Full Name** | Required, 3-50 alphabetic characters & spaces | `/^[a-zA-Z\s]{3,50}$/` | "Name must be 3-50 letters without numbers or symbols." |
| **Email** | Required, valid university email format | `/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/` | "Please enter a valid email address." |
| **Mobile Number** | Required, 10-digit Indian phone (starts 6-9) | `/^[6-9]\d{9}$/` | "Enter a valid 10-digit Indian mobile number." |
| **Password** | Min 8 chars with complexity checks | `length >= 8`, mixed case, digits, symbols | "Password must be at least 8 characters long." |
| **Confirm Password** | Must match Password string exactly | `passwordInput.value === confirmInput.value` | "Passwords do not match. Please re-enter." |
| **Course & Year** | Must select non-empty dropdown value | `select.value !== ""` | "Please select your academic department / year." |
| **Gender** | Required radio button selection | `input[name='gender']:checked !== null` | "Please select your gender." |
| **Terms Checkbox** | Must be checked before submit | `checkbox.checked === true` | "You must accept the terms and conditions." |

---

## 5. Password Strength Meter Scoring

The password strength engine calculates a dynamic score from 0 to 4 based on four entropy criteria:
1. Length $\ge$ 8 characters (+1)
2. Combination of Lowercase & Uppercase letters (+1)
3. Contains numeric digits `0-9` (+1)
4. Contains special characters (`!@#$%^&*`) (+1)

- **Score 0-1:** Bar width `25%` (Red - "Weak")
- **Score 2-3:** Bar width `65%` (Yellow - "Medium")
- **Score 4:** Bar width `100%` (Green - "Strong")

---

## 6. Files Created & Modified

| File / Path | Action | Description |
| :--- | :--- | :--- |
| `js/validation.js` | Created | Form validation engine with real-time listeners and password scoring |
| `register.html` | Modified | Added validation markup, password meter container, and script link |
| `css/style.css` | Modified | Added styles for `.is-invalid`, `.is-valid`, and accessible `.error-message` |
| `docs/practical-05.md` | Created | Comprehensive laboratory practical report and viva preparation manual |

---

## 7. Test Cases & Verification Suite

| Test ID | Input Scenario | Test Action | Expected Result | Actual Result | Status |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **TC-05-01** | Empty Form Submission | Click "Create Student Account" on empty form | Submission blocked; first empty field focused; errors shown | Form submission blocked | **PASS** |
| **TC-05-02** | Invalid Name Format | Enter "Daksh123" | Shows error: "Name must be 3-50 letters without numbers" | Invalid name flagged | **PASS** |
| **TC-05-03** | Invalid Email Format | Enter "daksh@invalid" | Shows error: "Please enter a valid email address" | Invalid email flagged | **PASS** |
| **TC-05-04** | Invalid Mobile Number | Enter "12345" or "5876543210" | Shows error: "Enter a valid 10-digit Indian mobile number" | Invalid mobile flagged | **PASS** |
| **TC-05-05** | Short Password (<8) | Enter "Pass1" | Password strength shows "Weak (Red)"; error flagged | Weak password flagged | **PASS** |
| **TC-05-06** | Strong Password | Enter "Student@2026#Secure" | Strength bar turns Green (100% "Strong") | Strong score calculated | **PASS** |
| **TC-05-07** | Password Mismatch | Password: "Pass@123", Confirm: "Pass@999" | Shows error: "Passwords do not match" | Mismatch flagged | **PASS** |
| **TC-05-08** | Unchecked Terms | Fill valid fields but uncheck terms | Submission blocked with terms error | Terms error flagged | **PASS** |
| **TC-05-09** | Valid Form Data | Fill all valid fields and submit | All inputs turn green with `.is-valid`; form submits | Form submits successfully | **PASS** |

---

## 8. Expected Output & Screenshots to Capture

For laboratory evaluation and viva records:
1. **Invalid Form Submission:** `register.html` showing red error borders and clear error messages below each field.
2. **Password Strength Meter:** Screenshot demonstrating Weak (Red), Medium (Yellow), and Strong (Green) dynamic progress.
3. **Password Confirmation Error:** Active mismatch error message displayed under Confirm Password.
4. **Valid Form State:** All fields with valid green indicators ready for submission.

---

## 9. Viva Voce Questions & Answers

### Q1: Why is client-side validation alone insufficient for web security?
**Answer:** Client-side validation can be easily bypassed by disabling JavaScript in the browser, manipulating the DOM via DevTools, or sending direct crafted HTTP POST requests via tools like cURL or Postman. Therefore, client-side validation is for User Experience (UX), while server-side validation in PHP is mandatory for Security.

### Q2: What is a Regular Expression (RegEx)?
**Answer:** A Regular Expression is a sequence of characters that forms a search pattern used for string pattern matching and input validation (e.g. testing whether an email follows standard formatting).

### Q3: What is the purpose of `e.preventDefault()` in form submit handlers?
**Answer:** `e.preventDefault()` cancels the browser's default action of submitting the form and triggering a page refresh when validation rules fail, allowing errors to be displayed in-place.

### Q4: What is the difference between `input` and `blur` events for form validation?
**Answer:**
- **`input` event:** Fires immediately whenever the value of the input changes, allowing real-time feedback as the user types.
- **`blur` event:** Fires when the input element loses focus, suitable for validating completed fields without distracting the user mid-typing.

### Q5: How do `aria-live="polite"` and `role="alert"` assist visually impaired users during form validation?
**Answer:** They turn the error message container into an ARIA Live Region, instructing screen readers to announce new error messages to the user without interrupting current speech output.

---

## 10. Conclusion
Practical 05 successfully engineered a robust, accessible client-side form validation engine with real-time feedback, password strength evaluation, and submission guards for **StudentHub**. The project is ready for Practical 06 (JSON Fetch API, Search and Filter).
