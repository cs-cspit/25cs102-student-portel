 /**
 * StudentHub Reusable Layout Components
 * Dynamically builds and injects the header, navbar, notification banner,
 * theme toggle, hamburger menu, global modal, and footer across all pages.
 */

(function () {
    // Apply saved dark theme immediately on execution to prevent theme flash on page load
    const savedTheme = localStorage.getItem('studenthub_theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark-theme');
        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('dark-theme');
        });
    }
})();

document.addEventListener('DOMContentLoaded', () => {
    // 1. Inject Skip to Main Content Link
    if (!document.querySelector('.skip-link')) {
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.className = 'skip-link';
        skipLink.textContent = 'Skip to main content';
        document.body.insertBefore(skipLink, document.body.firstChild);
    }

    // 2. Inject Top Notification Banner (if not dismissed in localStorage)
    const isBannerDismissed = localStorage.getItem('studenthub_banner_dismissed') === 'true';
    if (!isBannerDismissed && !document.querySelector('.notification-banner')) {
        const bannerEl = document.createElement('div');
        bannerEl.className = 'notification-banner';
        bannerEl.id = 'notification-banner';
        bannerEl.setAttribute('role', 'alert');
        bannerEl.innerHTML = `
            <div class="notification-content">
                <span>📢 <strong>Semester Announcement:</strong> Registration for Practical Lab Examinations is now open!</span>
                <button type="button" class="btn btn-secondary" style="padding: 3px 10px; font-size: 12px; background: rgba(255,255,255,0.2); border-color: transparent; color: #fff;" onclick="if(window.StudentHubApp) StudentHubApp.openModal('Semester Registration', '<p>Practical examination slots are open for Semester 3 Computer Engineering students. Please verify your submitted assignments before final deadline.</p>')">Details</button>
            </div>
            <button type="button" class="banner-close-btn" id="banner-close-btn" aria-label="Dismiss Announcement Banner">&times;</button>
        `;
        document.body.insertBefore(bannerEl, document.body.firstChild);
    }

    // 3. Determine current page filename
    const path = window.location.pathname;
    const page = path.split('/').pop() || 'index.html';

    // 4. Inject Header Navbar
    const headerEl = document.querySelector('header');
    if (headerEl) {
        headerEl.innerHTML = `
            <nav class="navbar" aria-label="Main Navigation">
                <a href="index.html" class="logo" aria-label="StudentHub Portal Home">
                    🎓 StudentHub
                </a>

                <ul class="nav-links" id="nav-links">
                    <li><a href="index.html" class="${page === 'index.html' ? 'active' : ''}" ${page === 'index.html' ? 'aria-current="page"' : ''}>Home</a></li>
                    <li><a href="about.html" class="${page === 'about.html' ? 'active' : ''}" ${page === 'about.html' ? 'aria-current="page"' : ''}>About</a></li>
                    <li><a href="dashboard.html" class="${page === 'dashboard.html' ? 'active' : ''}" ${page === 'dashboard.html' ? 'aria-current="page"' : ''}>Dashboard</a></li>
                    <li><a href="events.html" class="${page === 'events.html' ? 'active' : ''}" ${page === 'events.html' ? 'aria-current="page"' : ''}>Events</a></li>
                    <li><a href="faq.html" class="${page === 'faq.html' ? 'active' : ''}" ${page === 'faq.html' ? 'aria-current="page"' : ''}>FAQ</a></li>
                    <li><a href="contact.html" class="${page === 'contact.html' ? 'active' : ''}" ${page === 'contact.html' ? 'aria-current="page"' : ''}>Contact</a></li>
                    <li><a href="feedback.html" class="${page === 'feedback.html' ? 'active' : ''}" ${page === 'feedback.html' ? 'aria-current="page"' : ''}>Feedback</a></li>
                    <li><a href="register.html" class="${page === 'register.html' ? 'active' : ''} btn-login">Register</a></li>
                </ul>

                <div class="nav-controls">
                    <button type="button" class="theme-toggle-btn" id="theme-toggle-btn" aria-label="Toggle Light and Dark Theme">
                        <span id="theme-toggle-icon">🌙</span>
                        <span id="theme-toggle-text">Dark</span>
                    </button>

                    <button type="button" class="hamburger-btn" id="hamburger-btn" aria-expanded="false" aria-controls="nav-links" aria-label="Toggle Navigation Menu">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>
            </nav>
        `;
    }

    // 5. Inject Global Reusable Modal Container (if not present)
    if (!document.getElementById('global-modal-backdrop')) {
        const modalBackdrop = document.createElement('div');
        modalBackdrop.className = 'modal-backdrop';
        modalBackdrop.id = 'global-modal-backdrop';
        modalBackdrop.setAttribute('aria-hidden', 'true');
        modalBackdrop.innerHTML = `
            <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title-text" id="global-modal-dialog">
                <div class="modal-header">
                    <h2 id="modal-title-text">Notice</h2>
                    <button type="button" class="modal-close-btn" id="modal-close-btn" aria-label="Close Modal">&times;</button>
                </div>
                <div class="modal-body" id="modal-body-text">
                    <p>Modal content goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Close</button>
                </div>
            </div>
        `;
        document.body.appendChild(modalBackdrop);
    }

    // 6. Inject Footer Component
    const footerEl = document.querySelector('footer');
    if (footerEl) {
        footerEl.innerHTML = `
            <p>&copy; ${new Date().getFullYear()} StudentHub Portal | Practical Lab 3 JavaScript UI Components | CHARUSAT</p>
            <p style="font-size: 12px; margin-top: 5px;">
                <a id="reset-prefs-btn" href="javascript:void(0);">Reset UI Preferences (Theme & Notification Banner)</a>
            </p>
        `;
    }
});
