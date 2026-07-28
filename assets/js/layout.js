/**
 * StudentHub Reusable Layout Components
 * Dynamically builds and injects the header, navbar, and footer across all pages.
 * Fulfills the Advanced Extension using modular JavaScript.
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Inject Skip Link if not already present
    if (!document.querySelector('.skip-link')) {
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.className = 'skip-link';
        skipLink.textContent = 'Skip to main content';
        document.body.insertBefore(skipLink, document.body.firstChild);
    }

    // 2. Identify current page filename
    const path = window.location.pathname;
    const page = path.split('/').pop() || 'index.html';

    // 3. Inject Navbar Header
    const headerEl = document.querySelector('header');
    if (headerEl) {
        headerEl.innerHTML = `
            <nav class="navbar" aria-label="Main Navigation">
                <a href="index.html" class="logo" aria-label="StudentHub Portal Home">
                    🎓 StudentHub
                </a>
                <ul class="nav-links">
                    <li><a href="index.html" class="${page === 'index.html' ? 'active' : ''}">Home</a></li>
                    <li><a href="about.html" class="${page === 'about.html' ? 'active' : ''}">About</a></li>
                    <li><a href="dashboard.html" class="${page === 'dashboard.html' ? 'active' : ''}">Dashboard</a></li>
                    <li><a href="events.html" class="${page === 'events.html' ? 'active' : ''}">Events</a></li>
                    <li><a href="contact.html" class="${page === 'contact.html' ? 'active' : ''}">Contact</a></li>
                    <li><a href="feedback.html" class="${page === 'feedback.html' ? 'active' : ''}">Feedback</a></li>
                    <li><a href="register.html" class="${page === 'register.html' ? 'active' : ''} btn-login">Register</a></li>
                </ul>
            </nav>
        `;
    }

    // 4. Inject Footer
    const footerEl = document.querySelector('footer');
    if (footerEl) {
        footerEl.innerHTML = `
            <p>&copy; ${new Date().getFullYear()} StudentHub Portal | Responsive Lab Practical Design | CHARUSAT</p>
        `;
    }
});
