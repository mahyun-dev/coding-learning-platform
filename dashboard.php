<?php
/**
 * User Dashboard
 */

define('APP_INIT', true);
require_once __DIR__ . '/config/config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: /login.php');
    exit;
}

$pageTitle = 'Dashboard - ' . APP_NAME;
?>

<?php include __DIR__ . '/templates/header.php'; ?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="mb-3">
            <i class="fas fa-chart-line me-2"></i>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </h1>
        <p class="text-muted">Track your progress and continue learning</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Problems Solved</h6>
                        <h2 class="mb-0" id="solvedCount">0</h2>
                    </div>
                    <i class="fas fa-check-circle fa-3x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Submissions</h6>
                        <h2 class="mb-0" id="submissionCount">0</h2>
                    </div>
                    <i class="fas fa-paper-plane fa-3x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Success Rate</h6>
                        <h2 class="mb-0" id="successRate">0%</h2>
                    </div>
                    <i class="fas fa-percentage fa-3x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Rank</h6>
                        <h2 class="mb-0" id="userRank">-</h2>
                    </div>
                    <i class="fas fa-trophy fa-3x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <h3 class="mb-3">Quick Actions</h3>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-puzzle-piece fa-3x text-primary mb-3"></i>
                <h5>Practice Problems</h5>
                <p class="text-muted">Start solving coding challenges</p>
                <a href="/problems.php" class="btn btn-primary">Browse Problems</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-history fa-3x text-success mb-3"></i>
                <h5>Recent Submissions</h5>
                <p class="text-muted">View your submission history</p>
                <a href="/submissions.php" class="btn btn-success">View History</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-user fa-3x text-info mb-3"></i>
                <h5>Profile Settings</h5>
                <p class="text-muted">Update your profile information</p>
                <a href="/profile.php" class="btn btn-info">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <h3 class="mb-3">Recent Activity</h3>
        <div class="card">
            <div class="card-body">
                <div id="recentActivity">
                    <p class="text-center text-muted">No recent activity</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/templates/footer.php'; ?>
