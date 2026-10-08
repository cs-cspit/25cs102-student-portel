/**
 * StudentHub - Registration Form Validation Engine (Practical 05)
 * Real-time regex validation, password strength calculation,
 * confirmation matching, accessible error messaging, and submit guard.
 */

document.addEventListener("DOMContentLoaded", () => {
    initRegistrationValidation();
});

function initRegistrationValidation() {
    const form = document.querySelector("form[action='php/register.php']");
    if (!form) return;

    const nameInput = document.getElementById("fullname");
    const emailInput = document.getElementById("email");
    const mobileInput = document.getElementById("mobile");
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("confirm_password");
    const courseSelect = document.getElementById("course");
    const yearSelect = document.getElementById("year");
    const termsCheckbox = document.getElementById("terms");

    // Real-time Event Listeners
    if (nameInput) {
        nameInput.addEventListener("input", () => validateName(nameInput));
        nameInput.addEventListener("blur", () => validateName(nameInput));
    }

    if (emailInput) {
        emailInput.addEventListener("input", () => validateEmail(emailInput));
        emailInput.addEventListener("blur", () => validateEmail(emailInput));
    }

    if (mobileInput) {
        mobileInput.addEventListener("input", () => validateMobile(mobileInput));
        mobileInput.addEventListener("blur", () => validateMobile(mobileInput));
    }

    if (passwordInput) {
        passwordInput.addEventListener("input", () => {
            validatePassword(passwordInput);
            updatePasswordStrength(passwordInput.value);
            if (confirmInput.value.length > 0) {
                validateConfirmPassword(passwordInput, confirmInput);
            }
        });
        passwordInput.addEventListener("blur", () => validatePassword(passwordInput));
    }

    if (confirmInput) {
        confirmInput.addEventListener("input", () => validateConfirmPassword(passwordInput, confirmInput));
        confirmInput.addEventListener("blur", () => validateConfirmPassword(passwordInput, confirmInput));
    }

    if (courseSelect) {
        courseSelect.addEventListener("change", () => validateSelect(courseSelect, "Please select your academic department."));
    }

    if (yearSelect) {
        yearSelect.addEventListener("change", () => validateSelect(yearSelect, "Please select your year of study."));
    }

    if (termsCheckbox) {
        termsCheckbox.addEventListener("change", () => validateTerms(termsCheckbox));
    }

    // On-Submit Validation Interceptor
    form.addEventListener("submit", (e) => {
        const isNameValid = validateName(nameInput);
        const isEmailValid = validateEmail(emailInput);
        const isMobileValid = validateMobile(mobileInput);
        const isPasswordValid = validatePassword(passwordInput);
        const isConfirmValid = validateConfirmPassword(passwordInput, confirmInput);
        const isCourseValid = validateSelect(courseSelect, "Please select your academic department.");
        const isYearValid = validateSelect(yearSelect, "Please select your year of study.");
        const isGenderValid = validateGender();
        const isTermsValid = validateTerms(termsCheckbox);

        const isFormValid = isNameValid && isEmailValid && isMobileValid &&
                            isPasswordValid && isConfirmValid && isCourseValid &&
                            isYearValid && isGenderValid && isTermsValid;

        if (!isFormValid) {
            e.preventDefault();
            // Focus on first invalid field
            const firstInvalid = form.querySelector(".is-invalid, :invalid");
            if (firstInvalid) {
                firstInvalid.focus();
            }
            displayGlobalFormError("Please correct all highlighted form errors before submitting.");
        }
    });
}

/* ==========================================================================
   Validation Rule Functions
   ========================================================================== */

function validateName(input) {
    if (!input) return false;
    const val = input.value.trim();
    const nameRegex = /^[a-zA-Z\s]{3,50}$/;

    if (val.length === 0) {
        setError(input, "Full name is required.");
        return false;
    } else if (!nameRegex.test(val)) {
        setError(input, "Name must be 3-50 letters without numbers or special symbols.");
        return false;
    }
    setSuccess(input);
    return true;
}

function validateEmail(input) {
    if (!input) return false;
    const val = input.value.trim();
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (val.length === 0) {
        setError(input, "University email is required.");
        return false;
    } else if (!emailRegex.test(val)) {
        setError(input, "Please enter a valid email address (e.g., student@charusat.edu.in).");
        return false;
    }
    setSuccess(input);
    return true;
}

function validateMobile(input) {
    if (!input) return false;
    const val = input.value.trim();
    const phoneRegex = /^[6-9]\d{9}$/;

    if (val.length === 0) {
        setError(input, "Mobile number is required.");
        return false;
    } else if (!phoneRegex.test(val)) {
        setError(input, "Enter a valid 10-digit Indian mobile number (starts with 6-9).");
        return false;
    }
    setSuccess(input);
    return true;
}

function validatePassword(input) {
    if (!input) return false;
    const val = input.value;

    if (val.length === 0) {
        setError(input, "Password is required.");
        return false;
    } else if (val.length < 8) {
        setError(input, "Password must be at least 8 characters long.");
        return false;
    }
    setSuccess(input);
    return true;
}

function validateConfirmPassword(passInput, confirmInput) {
    if (!passInput || !confirmInput) return false;
    const pass = passInput.value;
    const confirm = confirmInput.value;

    if (confirm.length === 0) {
        setError(confirmInput, "Please confirm your password.");
        return false;
    } else if (pass !== confirm) {
        setError(confirmInput, "Passwords do not match. Please re-enter.");
        return false;
    }
    setSuccess(confirmInput);
    return true;
}

function validateSelect(select, errorMsg) {
    if (!select) return false;
    if (!select.value || select.value === "") {
        setError(select, errorMsg);
        return false;
    }
    setSuccess(select);
    return true;
}

function validateGender() {
    const checkedGender = document.querySelector("input[name='gender']:checked");
    const container = document.querySelector(".radio-group");
    if (!checkedGender) {
        if (container) {
            setContainerError(container, "Please select your gender.");
        }
        return false;
    }
    if (container) {
        clearContainerError(container);
    }
    return true;
}

function validateTerms(checkbox) {
    if (!checkbox) return false;
    if (!checkbox.checked) {
        setError(checkbox, "You must accept the terms and conditions to register.");
        return false;
    }
    setSuccess(checkbox);
    return true;
}

/* ==========================================================================
   Password Strength Meter
   ========================================================================== */
function updatePasswordStrength(password) {
    const strengthBar = document.getElementById("password-strength-bar");
    const strengthText = document.getElementById("password-strength-text");
    if (!strengthBar || !strengthText) return;

    let score = 0;
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
    if (/\d/.test(password)) score++;
    if (/[^a-zA-Z0-9]/.test(password)) score++;

    if (password.length === 0) {
        strengthBar.style.width = "0%";
        strengthBar.style.backgroundColor = "transparent";
        strengthText.textContent = "";
    } else if (score <= 1) {
        strengthBar.style.width = "25%";
        strengthBar.style.backgroundColor = "#ef4444";
        strengthText.textContent = "Weak (Add uppercase letters, numbers & symbols)";
        strengthText.style.color = "#ef4444";
    } else if (score === 2 || score === 3) {
        strengthBar.style.width = "65%";
        strengthBar.style.backgroundColor = "#eab308";
        strengthText.textContent = "Medium (Good password strength)";
        strengthText.style.color = "#ca8a04";
    } else {
        strengthBar.style.width = "100%";
        strengthBar.style.backgroundColor = "#22c55e";
        strengthText.textContent = "Strong (High security rating)";
        strengthText.style.color = "#16a34a";
    }
}

/* ==========================================================================
   DOM Error & Success Helpers
   ========================================================================== */

function setError(input, message) {
    input.classList.add("is-invalid");
    input.classList.remove("is-valid");

    const group = input.closest(".form-group") || input.parentElement;
    let errorElem = group.querySelector(".error-message");
    if (!errorElem) {
        errorElem = document.createElement("span");
        errorElem.classList.add("error-message");
        errorElem.setAttribute("role", "alert");
        errorElem.setAttribute("aria-live", "polite");
        group.appendChild(errorElem);
    }
    errorElem.textContent = message;
    errorElem.style.display = "block";
}

function setSuccess(input) {
    input.classList.remove("is-invalid");
    input.classList.add("is-valid");

    const group = input.closest(".form-group") || input.parentElement;
    const errorElem = group.querySelector(".error-message");
    if (errorElem) {
        errorElem.textContent = "";
        errorElem.style.display = "none";
    }
}

function setContainerError(container, message) {
    let errorElem = container.parentElement.querySelector(".error-message");
    if (!errorElem) {
        errorElem = document.createElement("span");
        errorElem.classList.add("error-message");
        errorElem.setAttribute("role", "alert");
        errorElem.setAttribute("aria-live", "polite");
        container.parentElement.appendChild(errorElem);
    }
    errorElem.textContent = message;
    errorElem.style.display = "block";
}

function clearContainerError(container) {
    const errorElem = container.parentElement.querySelector(".error-message");
    if (errorElem) {
        errorElem.textContent = "";
        errorElem.style.display = "none";
    }
}

function displayGlobalFormError(message) {
    let alertBox = document.getElementById("form-global-alert");
    if (!alertBox) {
        alertBox = document.createElement("div");
        alertBox.id = "form-global-alert";
        alertBox.className = "alert alert-danger";
        alertBox.setAttribute("role", "alert");
        const form = document.querySelector("form[action='php/register.php']");
        form.insertBefore(alertBox, form.firstChild);
    }
    alertBox.textContent = message;
    alertBox.style.display = "block";
}
