/**
 * StudentHub - Dynamic Events Engine via Fetch API (Practical 06)
 * Asynchronously loads data/events.json, applies real-time search,
 * category filtering, sorting, client pagination, and UI state handling.
 */

document.addEventListener("DOMContentLoaded", () => {
    initEventsEngine();
});

function initEventsEngine() {
    const container = document.getElementById("events-grid-container");
    const searchInput = document.getElementById("event-search-input");
    const categorySelect = document.getElementById("event-category-select");
    const sortSelect = document.getElementById("event-sort-select");
    const paginationContainer = document.getElementById("events-pagination");
    const resultCountElem = document.getElementById("events-count-text");

    if (!container) return;

    let allEvents = [];
    let filteredEvents = [];
    let currentPage = 1;
    const itemsPerPage = 6;

    // Show Loading State
    container.innerHTML = `
        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem;">
            <p style="font-size: 1.15rem; color: var(--primary-600); font-weight: 600;">⏳ Loading campus events catalog...</p>
        </div>
    `;

    // Fetch Events via Fetch API
    fetch("data/events.json")
        .then((res) => {
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            return res.json();
        })
        .then((data) => {
            allEvents = data;
            filteredEvents = [...allEvents];
            applyFiltersAndRender();
        })
        .catch((err) => {
            console.error("Failed to load events data:", err);
            container.innerHTML = `
                <div class="card" style="grid-column: 1 / -1; text-align: center; border-color: #fecaca; background-color: #fef2f2; padding: 2.5rem;">
                    <h3 style="color: #dc2626;">⚠️ Unable to Load Events Catalog</h3>
                    <p style="color: #7f1d1d;">Could not retrieve events from the local JSON data source. Please ensure data/events.json exists.</p>
                </div>
            `;
        });

    // Event Listeners for Live Filtering
    if (searchInput) {
        searchInput.addEventListener("input", () => {
            currentPage = 1;
            applyFiltersAndRender();
        });
    }

    if (categorySelect) {
        categorySelect.addEventListener("change", () => {
            currentPage = 1;
            applyFiltersAndRender();
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener("change", () => {
            currentPage = 1;
            applyFiltersAndRender();
        });
    }

    function applyFiltersAndRender() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
        const category = categorySelect ? categorySelect.value : "all";
        const sortBy = sortSelect ? sortSelect.value : "date-asc";

        // 1. Filter using Array.prototype.filter()
        filteredEvents = allEvents.filter((event) => {
            const matchesQuery = event.title.toLowerCase().includes(query) ||
                                 event.description.toLowerCase().includes(query) ||
                                 event.venue.toLowerCase().includes(query);
            const matchesCategory = category === "all" || event.category.toLowerCase() === category.toLowerCase();
            return matchesQuery && matchesCategory;
        });

        // 2. Sort using Array.prototype.sort()
        filteredEvents.sort((a, b) => {
            if (sortBy === "date-asc") return new Date(a.date) - new Date(b.date);
            if (sortBy === "date-desc") return new Date(b.date) - new Date(a.date);
            if (sortBy === "title-asc") return a.title.localeCompare(b.title);
            if (sortBy === "title-desc") return b.title.localeCompare(a.title);
            return 0;
        });

        // Update Counter
        if (resultCountElem) {
            resultCountElem.textContent = `Showing ${filteredEvents.length} campus event${filteredEvents.length === 1 ? "" : "s"}`;
        }

        renderEventsPage();
        renderPagination();
    }

    function renderEventsPage() {
        if (filteredEvents.length === 0) {
            container.innerHTML = `
                <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem 1.5rem;">
                    <h3>🔍 No Matching Events Found</h3>
                    <p>Try refining your search keyword or selecting a different category.</p>
                    <button type="button" class="btn btn-secondary btn-sm" id="reset-filters-btn">Reset All Filters</button>
                </div>
            `;
            const resetBtn = document.getElementById("reset-filters-btn");
            if (resetBtn) {
                resetBtn.addEventListener("click", () => {
                    if (searchInput) searchInput.value = "";
                    if (categorySelect) categorySelect.value = "all";
                    if (sortSelect) sortSelect.value = "date-asc";
                    currentPage = 1;
                    applyFiltersAndRender();
                });
            }
            return;
        }

        // Slice for pagination
        const startIndex = (currentPage - 1) * itemsPerPage;
        const pageItems = filteredEvents.slice(startIndex, startIndex + itemsPerPage);

        // Render Cards using Array.prototype.map()
        container.innerHTML = pageItems.map((event) => `
            <article class="card event-card">
                <img src="${event.poster}" onerror="this.src='pr2/html/assets/images/event1.jpg'" alt="${escapeHtml(event.title)}" class="event-poster">
                <div class="event-content">
                    <span class="event-badge">${escapeHtml(event.category)}</span>
                    <h3>${escapeHtml(event.title)}</h3>
                    <div class="event-meta">
                        <span>📅 <strong>Date:</strong> ${formatDate(event.date)}</span>
                        <span>⏰ <strong>Time:</strong> ${escapeHtml(event.time)}</span>
                        <span>📍 <strong>Venue:</strong> ${escapeHtml(event.venue)}</span>
                        <span>👥 <strong>Capacity:</strong> ${event.seats} Seats Available</span>
                    </div>
                    <p>${escapeHtml(event.description)}</p>
                    <div class="event-actions">
                        <a href="register.html" class="btn btn-primary btn-sm" style="width: 100%;">Register for Event</a>
                    </div>
                </div>
            </article>
        `).join("");
    }

    function renderPagination() {
        if (!paginationContainer) return;
        const totalPages = Math.ceil(filteredEvents.length / itemsPerPage);

        if (totalPages <= 1) {
            paginationContainer.innerHTML = "";
            return;
        }

        let html = `<div style="display: flex; gap: 0.5rem; justify-content: center; align-items: center; margin-top: 2rem;">`;

        // Previous Button
        html += `<button type="button" class="btn btn-secondary btn-sm" ${currentPage === 1 ? "disabled style='opacity:0.5; cursor:not-allowed;'" : ""} id="page-prev-btn">&laquo; Previous</button>`;

        // Page Numbers
        for (let i = 1; i <= totalPages; i++) {
            const isActive = i === currentPage;
            html += `<button type="button" class="btn btn-sm ${isActive ? 'btn-primary' : 'btn-secondary'}" data-page="${i}">${i}</button>`;
        }

        // Next Button
        html += `<button type="button" class="btn btn-secondary btn-sm" ${currentPage === totalPages ? "disabled style='opacity:0.5; cursor:not-allowed;'" : ""} id="page-next-btn">Next &raquo;</button>`;

        html += `</div>`;
        paginationContainer.innerHTML = html;

        // Attach pagination click handlers
        const pageBtns = paginationContainer.querySelectorAll("[data-page]");
        pageBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                currentPage = parseInt(btn.getAttribute("data-page"), 10);
                renderEventsPage();
                renderPagination();
                window.scrollTo({ top: container.offsetTop - 100, behavior: "smooth" });
            });
        });

        const prevBtn = document.getElementById("page-prev-btn");
        if (prevBtn && currentPage > 1) {
            prevBtn.addEventListener("click", () => {
                currentPage--;
                renderEventsPage();
                renderPagination();
            });
        }

        const nextBtn = document.getElementById("page-next-btn");
        if (nextBtn && currentPage < totalPages) {
            nextBtn.addEventListener("click", () => {
                currentPage++;
                renderEventsPage();
                renderPagination();
            });
        }
    }
}

function formatDate(dateStr) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateStr).toLocaleDateString('en-US', options);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
