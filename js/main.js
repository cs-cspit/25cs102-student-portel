/**
 * StudentHub - Interactive UI Components & DOM Manipulations (Practical 04)
 * Handles: Light/Dark Theme, FAQ Accordion, Modal Dialogs, Content Slider,
 *          Notification Banner, and Mobile Navigation.
 */

document.addEventListener("DOMContentLoaded", () => {
    initThemeToggle();
    initMobileNav();
    initFaqAccordion();
    initModalDialogs();
    initContentSlider();
    initNotificationBanner();
});

/* ==========================================================================
   1. Light / Dark Theme Toggle with localStorage Persistence
   ========================================================================== */
function initThemeToggle() {
    const themeToggleBtn = document.getElementById("theme-toggle-btn");
    const savedTheme = localStorage.getItem("studenthub_theme") || "light";

    document.documentElement.setAttribute("data-theme", savedTheme);
    updateThemeIcon(themeToggleBtn, savedTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener("click", () => {
            const currentTheme = document.documentElement.getAttribute("data-theme") || "light";
            const newTheme = currentTheme === "light" ? "dark" : "light";

            document.documentElement.setAttribute("data-theme", newTheme);
            localStorage.setItem("studenthub_theme", newTheme);
            updateThemeIcon(themeToggleBtn, newTheme);
        });
    }
}

function updateThemeIcon(btn, theme) {
    if (!btn) return;
    btn.innerHTML = theme === "dark" ? "☀️ <span class='sr-only' style='display:none;'>Light Mode</span>" : "🌙 <span class='sr-only' style='display:none;'>Dark Mode</span>";
    btn.setAttribute("aria-label", `Switch to ${theme === "dark" ? "light" : "dark"} mode`);
}

/* ==========================================================================
   2. Mobile Hamburger Menu Toggle
   ========================================================================== */
function initMobileNav() {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const mainNav = document.querySelector("nav.main-nav");

    if (hamburgerBtn && mainNav) {
        hamburgerBtn.addEventListener("click", () => {
            const isExpanded = hamburgerBtn.getAttribute("aria-expanded") === "true";
            hamburgerBtn.setAttribute("aria-expanded", !isExpanded);
            mainNav.classList.toggle("open");
        });
    }
}

/* ==========================================================================
   3. FAQ Accordion with Accessibility Support
   ========================================================================== */
function initFaqAccordion() {
    const accordionHeaders = document.querySelectorAll(".accordion-header");

    accordionHeaders.forEach((header) => {
        header.addEventListener("click", () => {
            const item = header.closest(".accordion-item");
            const isOpen = item.classList.contains("active");

            // Optional: Close other accordion items for clean UX
            document.querySelectorAll(".accordion-item").forEach((other) => {
                if (other !== item) {
                    other.classList.remove("active");
                    const otherHeader = other.querySelector(".accordion-header");
                    if (otherHeader) otherHeader.setAttribute("aria-expanded", "false");
                }
            });

            item.classList.toggle("active", !isOpen);
            header.setAttribute("aria-expanded", !isOpen);
        });
    });
}

/* ==========================================================================
   4. Accessible Modal Popup Component
   ========================================================================== */
function initModalDialogs() {
    const openButtons = document.querySelectorAll("[data-modal-target]");
    const closeButtons = document.querySelectorAll(".modal-close-btn, [data-modal-close]");

    openButtons.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const targetId = btn.getAttribute("data-modal-target");
            const modal = document.getElementById(targetId);
            if (modal) {
                // Populate dynamic content if provided in data attributes
                const modalTitle = btn.getAttribute("data-modal-title");
                const modalBody = btn.getAttribute("data-modal-body");
                if (modalTitle) {
                    const titleElem = modal.querySelector(".modal-title");
                    if (titleElem) titleElem.textContent = modalTitle;
                }
                if (modalBody) {
                    const bodyElem = modal.querySelector(".modal-body");
                    if (bodyElem) bodyElem.textContent = modalBody;
                }

                modal.classList.add("active");
                modal.setAttribute("aria-hidden", "false");
                const closeBtn = modal.querySelector(".modal-close-btn");
                if (closeBtn) closeBtn.focus();
            }
        });
    });

    closeButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const modal = btn.closest(".modal-overlay");
            if (modal) {
                closeModal(modal);
            }
        });
    });

    // Close when clicking outside modal box
    document.querySelectorAll(".modal-overlay").forEach((modal) => {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                closeModal(modal);
            }
        });
    });

    // Close on Escape key press
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            document.querySelectorAll(".modal-overlay.active").forEach((modal) => {
                closeModal(modal);
            });
        }
    });
}

function closeModal(modal) {
    modal.classList.remove("active");
    modal.setAttribute("aria-hidden", "true");
}

/* ==========================================================================
   5. Interactive Content Slider / Carousel
   ========================================================================== */
function initContentSlider() {
    const sliderContainer = document.querySelector(".slider-container");
    if (!sliderContainer) return;

    const track = sliderContainer.querySelector(".slider-track");
    const slides = sliderContainer.querySelectorAll(".slide");
    const prevBtn = sliderContainer.querySelector(".slider-prev");
    const nextBtn = sliderContainer.querySelector(".slider-next");
    const dotsContainer = sliderContainer.querySelector(".slider-dots");

    if (!track || slides.length === 0) return;

    let currentIndex = 0;
    const totalSlides = slides.length;

    // Create indicator dots
    if (dotsContainer) {
        dotsContainer.innerHTML = "";
        slides.forEach((_, idx) => {
            const dot = document.createElement("button");
            dot.classList.add("dot");
            if (idx === 0) dot.classList.add("active");
            dot.setAttribute("aria-label", `Go to slide ${idx + 1}`);
            dot.addEventListener("click", () => goToSlide(idx));
            dotsContainer.appendChild(dot);
        });
    }

    function updateSlider() {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
        if (dotsContainer) {
            const dots = dotsContainer.querySelectorAll(".dot");
            dots.forEach((d, i) => d.classList.toggle("active", i === currentIndex));
        }
    }

    function goToSlide(index) {
        currentIndex = (index + totalSlides) % totalSlides;
        updateSlider();
    }

    if (prevBtn) {
        prevBtn.addEventListener("click", () => goToSlide(currentIndex - 1));
    }
    if (nextBtn) {
        nextBtn.addEventListener("click", () => goToSlide(currentIndex + 1));
    }

    // Auto-advance every 6 seconds
    let autoPlayTimer = setInterval(() => goToSlide(currentIndex + 1), 6000);

    sliderContainer.addEventListener("mouseenter", () => clearInterval(autoPlayTimer));
    sliderContainer.addEventListener("mouseleave", () => {
        clearInterval(autoPlayTimer);
        autoPlayTimer = setInterval(() => goToSlide(currentIndex + 1), 6000);
    });
}

/* ==========================================================================
   6. Dismissible Notification Banner
   ========================================================================== */
function initNotificationBanner() {
    const banner = document.getElementById("portal-announcement-banner");
    const closeBtn = document.getElementById("banner-close-btn");

    if (banner && closeBtn) {
        const isDismissed = sessionStorage.getItem("studenthub_banner_dismissed");
        if (isDismissed === "true") {
            banner.classList.add("hidden");
        }

        closeBtn.addEventListener("click", () => {
            banner.classList.add("hidden");
            sessionStorage.setItem("studenthub_banner_dismissed", "true");
        });
    }
}
