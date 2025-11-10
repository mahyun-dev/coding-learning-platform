/**
 * Problems Page JavaScript
 */

let currentPage = 1;
let currentFilters = {};

/**
 * Load problems list
 */
async function loadProblems(page = 1, filters = {}) {
    const problemsList = document.getElementById('problemsList');
    App.showLoading(problemsList);
    
    const params = {
        page: page,
        per_page: 10,
        ...filters
    };
    
    const data = await Problems.getList(params);
    
    if (data && data.problems) {
        renderProblems(data.problems);
        renderPagination(data.pagination);
        currentPage = page;
        currentFilters = filters;
    } else {
        problemsList.innerHTML = '<p class="text-center text-muted">No problems found.</p>';
    }
}

/**
 * Render problems list
 */
function renderProblems(problems) {
    const problemsList = document.getElementById('problemsList');
    
    if (problems.length === 0) {
        problemsList.innerHTML = '<p class="text-center text-muted">No problems found.</p>';
        return;
    }
    
    let html = '<div class="table-responsive"><table class="table table-hover">';
    html += '<thead><tr>';
    html += '<th>ID</th>';
    html += '<th>Title</th>';
    html += '<th>Difficulty</th>';
    html += '<th>Category</th>';
    html += '<th>Action</th>';
    html += '</tr></thead><tbody>';
    
    problems.forEach(problem => {
        html += '<tr>';
        html += `<td>${problem.problem_id}</td>`;
        html += `<td><strong>${App.escapeHtml(problem.title)}</strong></td>`;
        html += `<td>${App.getDifficultyBadge(problem.difficulty)}</td>`;
        html += `<td>${App.escapeHtml(problem.category || 'N/A')}</td>`;
        html += `<td><a href="/problem.php?id=${problem.problem_id}" class="btn btn-sm btn-primary">Solve</a></td>`;
        html += '</tr>';
    });
    
    html += '</tbody></table></div>';
    problemsList.innerHTML = html;
}

/**
 * Render pagination
 */
function renderPagination(pagination) {
    const paginationElement = document.getElementById('pagination');
    
    if (!pagination || pagination.total_pages <= 1) {
        paginationElement.innerHTML = '';
        return;
    }
    
    let html = '';
    
    // Previous button
    if (pagination.page > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadProblems(${pagination.page - 1}, currentFilters); return false;">Previous</a></li>`;
    }
    
    // Page numbers
    for (let i = 1; i <= pagination.total_pages; i++) {
        if (i === pagination.page) {
            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
        } else if (i === 1 || i === pagination.total_pages || (i >= pagination.page - 2 && i <= pagination.page + 2)) {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="loadProblems(${i}, currentFilters); return false;">${i}</a></li>`;
        } else if (i === pagination.page - 3 || i === pagination.page + 3) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }
    
    // Next button
    if (pagination.page < pagination.total_pages) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadProblems(${pagination.page + 1}, currentFilters); return false;">Next</a></li>`;
    }
    
    paginationElement.innerHTML = html;
}

/**
 * Reset filters
 */
function resetFilters() {
    document.getElementById('filterForm').reset();
    loadProblems(1, {});
}

// Filter form submission
document.getElementById('filterForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const filters = {};
    const difficulty = document.getElementById('difficulty').value;
    const category = document.getElementById('category').value;
    const search = document.getElementById('search').value;
    
    if (difficulty) filters.difficulty = difficulty;
    if (category) filters.category = category;
    if (search) filters.search = search;
    
    loadProblems(1, filters);
});

// Load problems on page load
document.addEventListener('DOMContentLoaded', () => {
    // Get filters from URL if any
    const urlParams = new URLSearchParams(window.location.search);
    const filters = {};
    
    if (urlParams.has('difficulty')) {
        filters.difficulty = urlParams.get('difficulty');
        document.getElementById('difficulty').value = filters.difficulty;
    }
    
    if (urlParams.has('category')) {
        filters.category = urlParams.get('category');
        document.getElementById('category').value = filters.category;
    }
    
    loadProblems(1, filters);
});
