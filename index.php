<?php
/**
 * Homepage - Coding Learning Platform
 */

define('APP_INIT', true);
require_once __DIR__ . '/config/config.php';

$pageTitle = 'Home - ' . APP_NAME;
?>

<?php include __DIR__ . '/templates/header.php'; ?>

<!-- Hero Section -->
<div class="jumbotron bg-light p-5 rounded-lg mb-4">
    <h1 class="display-4">Welcome to Coding Learning Platform</h1>
    <p class="lead">Enhance your programming skills through hands-on practice and real-world challenges.</p>
    <hr class="my-4">
    <p>Start your coding journey today! Practice problems, submit solutions, and track your progress.</p>
    <div class="mt-4">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <a class="btn btn-primary btn-lg me-2" href="/problems.php" role="button">
                <i class="fas fa-puzzle-piece me-2"></i>Browse Problems
            </a>
            <a class="btn btn-success btn-lg" href="/dashboard.php" role="button">
                <i class="fas fa-chart-line me-2"></i>My Dashboard
            </a>
        <?php else: ?>
            <a class="btn btn-primary btn-lg me-2" href="/register.php" role="button">
                <i class="fas fa-user-plus me-2"></i>Get Started
            </a>
            <a class="btn btn-outline-primary btn-lg" href="/problems.php" role="button">
                <i class="fas fa-eye me-2"></i>View Problems
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Features Section -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-code fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Interactive Coding</h5>
                <p class="card-text">Write, test, and submit your code directly in the browser with our integrated code editor.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                <h5 class="card-title">Track Progress</h5>
                <p class="card-text">Monitor your learning journey with detailed statistics and achievement tracking.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                <h5 class="card-title">Challenges</h5>
                <p class="card-text">Test your skills with problems ranging from beginner to advanced levels.</p>
            </div>
        </div>
    </div>
</div>

<!-- Problem Categories -->
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Problem Categories</h2>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-leaf me-2"></i>Easy</h5>
                <p class="card-text">Perfect for beginners</p>
                <a href="/problems.php?difficulty=easy" class="btn btn-light btn-sm">View Problems</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-fire me-2"></i>Medium</h5>
                <p class="card-text">Challenge yourself</p>
                <a href="/problems.php?difficulty=medium" class="btn btn-light btn-sm">View Problems</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-rocket me-2"></i>Hard</h5>
                <p class="card-text">For advanced users</p>
                <a href="/problems.php?difficulty=hard" class="btn btn-light btn-sm">View Problems</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-list me-2"></i>All</h5>
                <p class="card-text">Browse everything</p>
                <a href="/problems.php" class="btn btn-light btn-sm">View All</a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section (if logged in) -->
<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
<div class="row">
    <div class="col-12">
        <h2 class="mb-3">Your Statistics</h2>
    </div>
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <h6 class="text-muted">Problems Solved</h6>
                <h2 class="mb-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span id="solvedCount">0</span>
                </h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <h6 class="text-muted">Total Submissions</h6>
                <h2 class="mb-0">
                    <i class="fas fa-paper-plane text-primary me-2"></i>
                    <span id="submissionCount">0</span>
                </h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <h6 class="text-muted">Success Rate</h6>
                <h2 class="mb-0">
                    <i class="fas fa-percentage text-warning me-2"></i>
                    <span id="successRate">0</span>%
                </h2>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/templates/footer.php'; ?>
