<?php
/**
 * Problems List Page
 */

define('APP_INIT', true);
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Problems - ' . APP_NAME;
$additionalJS = ['/js/problems.js'];
?>

<?php include __DIR__ . '/templates/header.php'; ?>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4"><i class="fas fa-puzzle-piece me-2"></i>Coding Problems</h1>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form id="filterForm" class="row g-3">
            <div class="col-md-4">
                <label for="difficulty" class="form-label">Difficulty</label>
                <select class="form-select" id="difficulty" name="difficulty">
                    <option value="">All Levels</option>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" placeholder="e.g., Math, String">
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Search by title">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i>Apply Filters
                </button>
                <button type="button" class="btn btn-secondary" onclick="resetFilters()">
                    <i class="fas fa-redo me-1"></i>Reset
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Problems List -->
<div class="card">
    <div class="card-body">
        <div id="problemsList">
            <div class="text-center my-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<nav aria-label="Problems pagination" class="mt-4">
    <ul class="pagination justify-content-center" id="pagination">
    </ul>
</nav>

<?php include __DIR__ . '/templates/footer.php'; ?>
