<?php
/**
 * Admin Panel
 */

define('APP_INIT', true);
require_once __DIR__ . '/config/config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || $_SESSION['role'] !== 'admin') {
    header('Location: /index.php');
    exit;
}

$pageTitle = 'Admin Panel - ' . APP_NAME;
?>

<?php include __DIR__ . '/templates/header.php'; ?>

<div class="row">
    <div class="col-md-3">
        <div class="admin-sidebar">
            <h5 class="mb-3">Admin Menu</h5>
            <nav class="nav flex-column">
                <a class="nav-link active" href="#problems" data-section="problems">
                    <i class="fas fa-puzzle-piece me-2"></i>Manage Problems
                </a>
                <a class="nav-link" href="#users" data-section="users">
                    <i class="fas fa-users me-2"></i>Manage Users
                </a>
                <a class="nav-link" href="#submissions" data-section="submissions">
                    <i class="fas fa-paper-plane me-2"></i>View Submissions
                </a>
                <a class="nav-link" href="#statistics" data-section="statistics">
                    <i class="fas fa-chart-bar me-2"></i>Statistics
                </a>
            </nav>
        </div>
    </div>
    
    <div class="col-md-9">
        <div id="content-area">
            <!-- Problems Management Section -->
            <div id="problems-section" class="admin-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-puzzle-piece me-2"></i>Manage Problems</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProblemModal">
                        <i class="fas fa-plus me-2"></i>Add New Problem
                    </button>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Difficulty</th>
                                        <th>Category</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="problemsTableBody">
                                    <tr>
                                        <td colspan="6" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Users Management Section -->
            <div id="users-section" class="admin-section d-none">
                <h2 class="mb-4"><i class="fas fa-users me-2"></i>Manage Users</h2>
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted">User management interface coming soon...</p>
                    </div>
                </div>
            </div>
            
            <!-- Submissions Section -->
            <div id="submissions-section" class="admin-section d-none">
                <h2 class="mb-4"><i class="fas fa-paper-plane me-2"></i>View Submissions</h2>
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted">Submissions monitoring interface coming soon...</p>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Section -->
            <div id="statistics-section" class="admin-section d-none">
                <h2 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Platform Statistics</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted">Total Users</h6>
                                <h2 class="mb-0">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted">Total Problems</h6>
                                <h2 class="mb-0">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted">Total Submissions</h6>
                                <h2 class="mb-0">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Problem Modal -->
<div class="modal fade" id="addProblemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Problem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addProblemForm">
                    <div class="mb-3">
                        <label for="problemTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="problemTitle" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="problemDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="problemDescription" name="description" rows="5" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="problemDifficulty" class="form-label">Difficulty</label>
                            <select class="form-select" id="problemDifficulty" name="difficulty" required>
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="problemCategory" class="form-label">Category</label>
                            <input type="text" class="form-control" id="problemCategory" name="category" placeholder="e.g., Array, String">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="problemTestCases" class="form-label">Test Cases (JSON)</label>
                        <textarea class="form-control" id="problemTestCases" name="test_cases" rows="3" placeholder='[{"input": [1, 2], "output": 3}]'></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="problemTemplate" class="form-label">Solution Template</label>
                        <textarea class="form-control" id="problemTemplate" name="solution_template" rows="5" placeholder="function solution() {\n    // Your code here\n}"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitProblem()">Add Problem</button>
            </div>
        </div>
    </div>
</div>

<script>
// Section navigation
document.querySelectorAll('.admin-sidebar .nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Update active link
        document.querySelectorAll('.admin-sidebar .nav-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        
        // Show corresponding section
        const section = this.dataset.section;
        document.querySelectorAll('.admin-section').forEach(s => s.classList.add('d-none'));
        document.getElementById(`${section}-section`).classList.remove('d-none');
    });
});

// Load problems on page load
document.addEventListener('DOMContentLoaded', async () => {
    const data = await Problems.getList({ per_page: 100 });
    if (data && data.problems) {
        renderProblemsTable(data.problems);
    }
});

function renderProblemsTable(problems) {
    const tbody = document.getElementById('problemsTableBody');
    
    if (problems.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No problems found</td></tr>';
        return;
    }
    
    let html = '';
    problems.forEach(problem => {
        html += `<tr>
            <td>${problem.problem_id}</td>
            <td>${App.escapeHtml(problem.title)}</td>
            <td>${App.getDifficultyBadge(problem.difficulty)}</td>
            <td>${App.escapeHtml(problem.category || 'N/A')}</td>
            <td>${App.formatDate(problem.created_at)}</td>
            <td>
                <button class="btn btn-sm btn-warning" onclick="editProblem(${problem.problem_id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteProblem(${problem.problem_id})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
}

async function submitProblem() {
    const form = document.getElementById('addProblemForm');
    const formData = new FormData(form);
    
    try {
        const response = await fetch('/api/problems.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            App.showAlert('Problem added successfully', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addProblemModal')).hide();
            form.reset();
            location.reload();
        } else {
            App.showAlert(data.message, 'danger');
        }
    } catch (error) {
        App.showAlert('Failed to add problem', 'danger');
    }
}

function editProblem(problemId) {
    // TODO: Implement edit functionality
    App.showAlert('Edit functionality coming soon', 'info');
}

async function deleteProblem(problemId) {
    if (!confirm('Are you sure you want to delete this problem?')) {
        return;
    }
    
    try {
        const response = await fetch('/api/problems.php?id=' + problemId, {
            method: 'DELETE'
        });
        
        const data = await response.json();
        
        if (data.success) {
            App.showAlert('Problem deleted successfully', 'success');
            location.reload();
        } else {
            App.showAlert(data.message, 'danger');
        }
    } catch (error) {
        App.showAlert('Failed to delete problem', 'danger');
    }
}
</script>

<?php include __DIR__ . '/templates/footer.php'; ?>
