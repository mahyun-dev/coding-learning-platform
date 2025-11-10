<?php
/**
 * Problem Detail and Submission Page
 */

define('APP_INIT', true);
require_once __DIR__ . '/config/config.php';

// Get problem ID
$problemId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$problemId) {
    header('Location: /problems.php');
    exit;
}

$pageTitle = 'Problem #' . $problemId . ' - ' . APP_NAME;
$additionalJS = ['/js/problem-solve.js'];
?>

<?php include __DIR__ . '/templates/header.php'; ?>

<div class="row">
    <div class="col-12 mb-3">
        <a href="/problems.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Problems
        </a>
    </div>
</div>

<div class="row">
    <!-- Problem Description -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Problem Description</h5>
            </div>
            <div class="card-body" id="problemContent">
                <div class="text-center my-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Instructions -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Instructions</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Write your solution in the code editor</li>
                    <li>Click "Run Code" to test with sample inputs</li>
                    <li>Click "Submit" to submit your solution</li>
                    <li>You can submit multiple times</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Code Editor and Submission -->
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-code me-2"></i>Code Editor</h5>
            </div>
            <div class="card-body p-0">
                <div class="code-editor">
                    <textarea id="codeEditor" class="form-control" style="min-height: 400px;"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <select class="form-select form-select-sm" id="languageSelect">
                            <option value="javascript">JavaScript</option>
                            <option value="python">Python</option>
                            <option value="java">Java</option>
                            <option value="cpp">C++</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-sm btn-outline-primary" onclick="runCode()">
                                    <i class="fas fa-play me-1"></i>Run Code
                                </button>
                                <button class="btn btn-sm btn-primary" onclick="submitCode()">
                                    <i class="fas fa-paper-plane me-1"></i>Submit
                                </button>
                            </div>
                        <?php else: ?>
                            <a href="/login.php" class="btn btn-sm btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-1"></i>Login to Submit
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Output Panel -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="fas fa-terminal me-2"></i>Output</h6>
            </div>
            <div class="card-body">
                <div id="outputPanel">
                    <p class="text-muted mb-0">Run your code to see output here...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Results Modal -->
<div class="modal fade" id="resultsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submission Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="resultsContent">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Pass problem ID to JavaScript
    const problemId = <?php echo $problemId; ?>;
</script>

<?php include __DIR__ . '/templates/footer.php'; ?>
