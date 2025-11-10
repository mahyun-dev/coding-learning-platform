<?php
/**
 * Submissions API
 * Handles code submission and evaluation
 */

define('APP_INIT', true);
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

// Check authentication
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    respondError('Authentication required', 401);
}

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        $action = $_GET['action'] ?? 'list';
        
        if ($action === 'list') {
            listSubmissions();
        } elseif ($action === 'get' && isset($_GET['id'])) {
            getSubmission($_GET['id']);
        } else {
            respondError('Invalid action or missing parameters', 400);
        }
        break;
        
    case 'POST':
        submitCode();
        break;
        
    default:
        respondError('Method not allowed', 405);
        break;
}

/**
 * Submit code for evaluation
 */
function submitCode() {
    $problemId = intval($_POST['problem_id'] ?? 0);
    $code = $_POST['code'] ?? '';
    $language = sanitizeInput($_POST['language'] ?? 'javascript');
    
    if (!$problemId || empty($code)) {
        respondError('Problem ID and code are required', 400);
        return;
    }
    
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        // Verify problem exists
        $stmt = $db->prepare('SELECT problem_id FROM problems WHERE problem_id = ?');
        $stmt->execute([$problemId]);
        
        if (!$stmt->fetch()) {
            respondError('Problem not found', 404);
            return;
        }
        
        // In production, code would be evaluated here
        // For now, we'll simulate evaluation
        $status = simulateEvaluation($code);
        $executionTime = rand(10, 500); // milliseconds
        $memoryUsed = rand(10, 100); // MB
        
        // Insert submission
        $stmt = $db->prepare(
            'INSERT INTO submissions (user_id, problem_id, code, language, status, execution_time, memory_used) 
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $_SESSION['user_id'],
            $problemId,
            $code,
            $language,
            $status,
            $executionTime,
            $memoryUsed
        ]);
        
        $submissionId = $db->lastInsertId();
        
        respondSuccess([
            'submission_id' => $submissionId,
            'status' => $status,
            'execution_time' => $executionTime,
            'memory_used' => $memoryUsed
        ], 'Code submitted successfully');
        
    } catch (PDOException $e) {
        error_log('Submit code error: ' . $e->getMessage());
        respondError('Failed to submit code', 500);
    }
}

/**
 * Simulate code evaluation
 * In production, this would use a secure sandboxed environment
 */
function simulateEvaluation($code) {
    // Simple heuristic for demo purposes
    if (strlen($code) < 10) {
        return 'error';
    }
    
    // 70% acceptance rate for demo
    $rand = rand(1, 10);
    
    if ($rand <= 7) {
        return 'accepted';
    } elseif ($rand <= 9) {
        return 'wrong_answer';
    } else {
        return 'timeout';
    }
}

/**
 * List submissions for current user
 */
function listSubmissions() {
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        $problemId = isset($_GET['problem_id']) ? intval($_GET['problem_id']) : null;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = isset($_GET['per_page']) ? min(100, max(1, intval($_GET['per_page']))) : 20;
        $offset = ($page - 1) * $perPage;
        
        // Build query
        $query = 'SELECT s.*, p.title as problem_title 
                  FROM submissions s
                  JOIN problems p ON s.problem_id = p.problem_id
                  WHERE s.user_id = ?';
        $params = [$_SESSION['user_id']];
        
        if ($problemId) {
            $query .= ' AND s.problem_id = ?';
            $params[] = $problemId;
        }
        
        $query .= ' ORDER BY s.created_at DESC LIMIT ? OFFSET ?';
        $params[] = $perPage;
        $params[] = $offset;
        
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $submissions = $stmt->fetchAll();
        
        // Get total count
        $countQuery = 'SELECT COUNT(*) as total FROM submissions WHERE user_id = ?';
        $countParams = [$_SESSION['user_id']];
        
        if ($problemId) {
            $countQuery .= ' AND problem_id = ?';
            $countParams[] = $problemId;
        }
        
        $countStmt = $db->prepare($countQuery);
        $countStmt->execute($countParams);
        $total = $countStmt->fetch()['total'];
        
        respondSuccess([
            'submissions' => $submissions,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => ceil($total / $perPage)
            ]
        ], 'Submissions retrieved successfully');
        
    } catch (PDOException $e) {
        error_log('List submissions error: ' . $e->getMessage());
        respondError('Failed to retrieve submissions', 500);
    }
}

/**
 * Get single submission
 */
function getSubmission($id) {
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        $stmt = $db->prepare(
            'SELECT s.*, p.title as problem_title 
             FROM submissions s
             JOIN problems p ON s.problem_id = p.problem_id
             WHERE s.submission_id = ? AND s.user_id = ?'
        );
        $stmt->execute([intval($id), $_SESSION['user_id']]);
        $submission = $stmt->fetch();
        
        if ($submission) {
            respondSuccess(['submission' => $submission], 'Submission retrieved successfully');
        } else {
            respondError('Submission not found', 404);
        }
        
    } catch (PDOException $e) {
        error_log('Get submission error: ' . $e->getMessage());
        respondError('Failed to retrieve submission', 500);
    }
}

/**
 * Send success response
 */
function respondSuccess($data, $message = 'Success') {
    echo json_encode([
        'success' => true,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

/**
 * Send error response
 */
function respondError($message, $code = 400) {
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'message' => $message
    ]);
    exit;
}
