/**
 * StudentHub - Main JavaScript Engine (Practical Lab 3)
 * Dynamic UI Components: Collapsible FAQ, Modal Popup, Content Slider,
 * Notification Banner, Hamburger Menu, and Light/Dark Theme Switcher with localStorage.
 */

window.StudentHubApp = {
    // -------------------------------------------------------------
    // 1. Light/Dark Theme Switcher (with localStorage persistence)
    // -------------------------------------------------------------
    initThemeSwitcher() {
        const themeBtn = document.getElementById('theme-toggle-btn');
        const themeIcon = document.getElementById('theme-toggle-icon');
        const themeText = document.getElementById('theme-toggle-text');

        if (!themeBtn) return;

        const updateThemeUI = (isDark) => {
            if (isDark) {
                document.body.classList.add('dark-theme');
                document.documentElement.classList.add('dark-theme');
                if (themeIcon) themeIcon.textContent = '☀️';
                if (themeText) themeText.textContent = 'Light';
                themeBtn.setAttribute('aria-label', 'Switch to Light Theme');
            } else {
                document.body.classList.remove('dark-theme');
                document.documentElement.classList.remove('dark-theme');
                if (themeIcon) themeIcon.textContent = '🌙';
                if (themeText) themeText.textContent = 'Dark';
                themeBtn.setAttribute('aria-label', 'Switch to Dark Theme');
            }
        };

        // Initialize state from body class (set early by layout.js) or localStorage
        const isCurrentlyDark = document.body.classList.contains('dark-theme');
        updateThemeUI(isCurrentlyDark);

        themeBtn.addEventListener('click', () => {
            const isDarkNow = document.body.classList.contains('dark-theme');
            const newDarkState = !isDarkNow;

            updateThemeUI(newDarkState);
            localStorage.setItem('studenthub_theme', newDarkState ? 'dark' : 'light');

            console.log(`[StudentHub UI] Theme preference updated: ${newDarkState ? 'dark' : 'light'}`);
        });
    },

    // -------------------------------------------------------------
    // 2. Hamburger Menu (Mobile Responsive Drawer)
    // -------------------------------------------------------------
    initHamburgerMenu() {
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const navLinks = document.getElementById('nav-links');

        if (!hamburgerBtn || !navLinks) return;

        const toggleMenu = (open) => {
            const isOpen = open !== undefined ? open : !hamburgerBtn.classList.contains('active');
            hamburgerBtn.classList.toggle('active', isOpen);
            navLinks.classList.toggle('active', isOpen);
            hamburgerBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        };

        hamburgerBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMenu();
        });

        // Close menu when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (!navLinks.contains(e.target) && !hamburgerBtn.contains(e.target)) {
                toggleMenu(false);
            }
        });

        // Close menu on Escape key press
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                toggleMenu(false);
            }
        });
    },

    // -------------------------------------------------------------
    // 3. Notification Banner (Dismissible with localStorage memory)
    // -------------------------------------------------------------
    initNotificationBanner() {
        const banner = document.getElementById('notification-banner');
        const closeBtn = document.getElementById('banner-close-btn');

        if (!banner || !closeBtn) return;

        closeBtn.addEventListener('click', () => {
            banner.classList.add('dismissed');
            localStorage.setItem('studenthub_banner_dismissed', 'true');
            console.log('[StudentHub UI] Notification banner dismissed and state saved to localStorage.');
        });
    },

    // -------------------------------------------------------------
    // 4. Collapsible FAQ Accordion Component
    // -------------------------------------------------------------
    initAccordion() {
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach((header) => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const content = item.querySelector('.accordion-content');
                const isOpen = item.classList.contains('active');

                // Toggle active class and aria-expanded attribute
                if (isOpen) {
                    item.classList.remove('active');
                    header.setAttribute('aria-expanded', 'false');
                    if (content) content.style.maxHeight = null;
                } else {
                    item.classList.add('active');
                    header.setAttribute('aria-expanded', 'true');
                    if (content) content.style.maxHeight = content.scrollHeight + 'px';
                }
            });
        });
    },

    // -------------------------------------------------------------
    // 5. Accessible Modal Popup System
    // -------------------------------------------------------------
    initModalSystem() {
        const backdrop = document.getElementById('global-modal-backdrop');
        const closeBtn = document.getElementById('modal-close-btn');
        const cancelBtn = document.getElementById('modal-cancel-btn');
        const titleEl = document.getElementById('modal-title-text');
        const bodyEl = document.getElementById('modal-body-text');

        this.openModal = (title, contentHtml) => {
            if (!backdrop) return;
            if (titleEl) titleEl.textContent = title;
            if (bodyEl) bodyEl.innerHTML = contentHtml;

            backdrop.classList.add('active');
            backdrop.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        };

        this.closeModal = () => {
            if (!backdrop) return;
            backdrop.classList.remove('active');
            backdrop.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        if (closeBtn) closeBtn.addEventListener('click', () => this.closeModal());
        if (cancelBtn) cancelBtn.addEventListener('click', () => this.closeModal());

        if (backdrop) {
            backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) this.closeModal();
            });
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && backdrop && backdrop.classList.contains('active')) {
                this.closeModal();
            }
        });

        // Attach listeners for any buttons with data-modal-trigger attribute
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-modal-title]');
            if (trigger) {
                e.preventDefault();
                const title = trigger.getAttribute('data-modal-title') || 'Portal Details';
                const body = trigger.getAttribute('data-modal-body') || 'Information is currently being loaded.';
                this.openModal(title, `<p>${body}</p>`);
            }
        });
    },

    // -------------------------------------------------------------
    // 6. Image / Content Slider (Carousel Component)
    // -------------------------------------------------------------
    initSlider() {
        const sliders = document.querySelectorAll('.slider-container');

        sliders.forEach((slider) => {
            const track = slider.querySelector('.slider-track');
            const slides = slider.querySelectorAll('.slide');
            const prevBtn = slider.querySelector('.slider-prev');
            const nextBtn = slider.querySelector('.slider-next');
            const dotsContainer = slider.querySelector('.slider-dots');

            if (!track || slides.length === 0) return;

            let currentIndex = 0;
            let autoSlideTimer = null;

            // Generate dot indicators dynamically if dots container exists
            if (dotsContainer && dotsContainer.children.length === 0) {
                slides.forEach((_, idx) => {
                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = `slider-dot ${idx === 0 ? 'active' : ''}`;
                    dot.setAttribute('aria-label', `Go to slide ${idx + 1}`);
                    dot.addEventListener('click', () => goToSlide(idx));
                    dotsContainer.appendChild(dot);
                });
            }

            const updateDots = () => {
                if (!dotsContainer) return;
                const dots = dotsContainer.querySelectorAll('.slider-dot');
                dots.forEach((dot, idx) => {
                    dot.classList.toggle('active', idx === currentIndex);
                });
            };

            const goToSlide = (index) => {
                if (index < 0) {
                    currentIndex = slides.length - 1;
                } else if (index >= slides.length) {
                    currentIndex = 0;
                } else {
                    currentIndex = index;
                }

                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                updateDots();
            };

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    goToSlide(currentIndex - 1);
                    resetAutoSlide();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    goToSlide(currentIndex + 1);
                    resetAutoSlide();
                });
            }

            // Auto Play Functionality
            const startAutoSlide = () => {
                autoSlideTimer = setInterval(() => {
                    goToSlide(currentIndex + 1);
                }, 5000);
            };

            const stopAutoSlide = () => {
                if (autoSlideTimer) clearInterval(autoSlideTimer);
            };

            const resetAutoSlide = () => {
                stopAutoSlide();
                startAutoSlide();
            };

            slider.addEventListener('mouseenter', stopAutoSlide);
            slider.addEventListener('mouseleave', startAutoSlide);

            // Start initial timer
            startAutoSlide();
        });
    },

    // -------------------------------------------------------------
    // 7. Reset UI Preferences (localStorage Helper)
    // -------------------------------------------------------------
    initPreferencesReset() {
        document.addEventListener('click', (e) => {
            if (e.target && e.target.id === 'reset-prefs-btn') {
                e.preventDefault();
                localStorage.removeItem('studenthub_theme');
                localStorage.removeItem('studenthub_banner_dismissed');

                if (this.openModal) {
                    this.openModal(
                        'Preferences Reset',
                        '<p>All saved UI preferences (Theme and Notification Banner status) have been cleared. The page will reload now to apply default settings.</p>'
                    );
                    setTimeout(() => {
                        window.location.reload();
                    }, 1800);
                } else {
                    alert('UI Preferences reset! Reloading page...');
                    window.location.reload();
                }
            }
        });
    }
};

// Initialize all dynamic UI components on DOM Ready
document.addEventListener('DOMContentLoaded', () => {
    StudentHubApp.initThemeSwitcher();
    StudentHubApp.initHamburgerMenu();
    StudentHubApp.initNotificationBanner();
    StudentHubApp.initAccordion();
    StudentHubApp.initModalSystem();
    StudentHubApp.initSlider();
    StudentHubApp.initPreferencesReset();

    console.log('🎉 StudentHub - Practical 3 Dynamic UI Components initialized successfully!');
});
