<?php
/**
 * Problems Management API
 * Handles CRUD operations for coding problems
 */

define('APP_INIT', true);
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        $action = $_GET['action'] ?? 'list';
        
        if ($action === 'list') {
            listProblems();
        } elseif ($action === 'get' && isset($_GET['id'])) {
            getProblem($_GET['id']);
        } else {
            respondError('Invalid action or missing parameters', 400);
        }
        break;
        
    case 'POST':
        if (!isAdmin()) {
            respondError('Unauthorized: Admin access required', 403);
            return;
        }
        createProblem();
        break;
        
    case 'PUT':
        if (!isAdmin()) {
            respondError('Unauthorized: Admin access required', 403);
            return;
        }
        parse_str(file_get_contents('php://input'), $_PUT);
        updateProblem($_PUT);
        break;
        
    case 'DELETE':
        if (!isAdmin()) {
            respondError('Unauthorized: Admin access required', 403);
            return;
        }
        parse_str(file_get_contents('php://input'), $_DELETE);
        deleteProblem($_DELETE);
        break;
        
    default:
        respondError('Method not allowed', 405);
        break;
}

/**
 * List all problems
 */
function listProblems() {
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        $difficulty = $_GET['difficulty'] ?? null;
        $category = $_GET['category'] ?? null;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = isset($_GET['per_page']) ? min(100, max(1, intval($_GET['per_page']))) : 20;
        $offset = ($page - 1) * $perPage;
        
        // Build query
        $query = 'SELECT problem_id, title, description, difficulty, category, created_at, updated_at FROM problems WHERE 1=1';
        $params = [];
        
        if ($difficulty) {
            $query .= ' AND difficulty = ?';
            $params[] = $difficulty;
        }
        
        if ($category) {
            $query .= ' AND category = ?';
            $params[] = $category;
        }
        
        $query .= ' ORDER BY problem_id DESC LIMIT ? OFFSET ?';
        $params[] = $perPage;
        $params[] = $offset;
        
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $problems = $stmt->fetchAll();
        
        // Get total count
        $countQuery = 'SELECT COUNT(*) as total FROM problems WHERE 1=1';
        $countParams = [];
        
        if ($difficulty) {
            $countQuery .= ' AND difficulty = ?';
            $countParams[] = $difficulty;
        }
        
        if ($category) {
            $countQuery .= ' AND category = ?';
            $countParams[] = $category;
        }
        
        $countStmt = $db->prepare($countQuery);
        $countStmt->execute($countParams);
        $total = $countStmt->fetch()['total'];
        
        respondSuccess([
            'problems' => $problems,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => ceil($total / $perPage)
            ]
        ], 'Problems retrieved successfully');
    } catch (PDOException $e) {
        error_log('List problems error: ' . $e->getMessage());
        respondError('Failed to retrieve problems', 500);
    }
}

/**
 * Get single problem by ID
 */
function getProblem($id) {
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        $stmt = $db->prepare('SELECT * FROM problems WHERE problem_id = ?');
        $stmt->execute([intval($id)]);
        $problem = $stmt->fetch();
        
        if ($problem) {
            respondSuccess(['problem' => $problem], 'Problem retrieved successfully');
        } else {
            respondError('Problem not found', 404);
        }
    } catch (PDOException $e) {
        error_log('Get problem error: ' . $e->getMessage());
        respondError('Failed to retrieve problem', 500);
    }
}

/**
 * Create new problem
 */
function createProblem() {
    $title = sanitizeInput($_POST['title'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    $difficulty = sanitizeInput($_POST['difficulty'] ?? 'easy');
    $category = sanitizeInput($_POST['category'] ?? '');
    $testCases = $_POST['test_cases'] ?? '';
    $solutionTemplate = $_POST['solution_template'] ?? '';
    
    if (empty($title) || empty($description)) {
        respondError('Title and description are required', 400);
        return;
    }
    
    if (!in_array($difficulty, ['easy', 'medium', 'hard'])) {
        respondError('Invalid difficulty level', 400);
        return;
    }
    
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        $stmt = $db->prepare(
            'INSERT INTO problems (title, description, difficulty, category, test_cases, solution_template) 
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$title, $description, $difficulty, $category, $testCases, $solutionTemplate]);
        
        $problemId = $db->lastInsertId();
        
        respondSuccess([
            'problem_id' => $problemId
        ], 'Problem created successfully');
    } catch (PDOException $e) {
        error_log('Create problem error: ' . $e->getMessage());
        respondError('Failed to create problem', 500);
    }
}

/**
 * Update existing problem
 */
function updateProblem($data) {
    $problemId = intval($data['problem_id'] ?? 0);
    
    if (!$problemId) {
        respondError('Problem ID is required', 400);
        return;
    }
    
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        // Build update query dynamically
        $updates = [];
        $params = [];
        
        if (isset($data['title'])) {
            $updates[] = 'title = ?';
            $params[] = sanitizeInput($data['title']);
        }
        
        if (isset($data['description'])) {
            $updates[] = 'description = ?';
            $params[] = sanitizeInput($data['description']);
        }
        
        if (isset($data['difficulty']) && in_array($data['difficulty'], ['easy', 'medium', 'hard'])) {
            $updates[] = 'difficulty = ?';
            $params[] = $data['difficulty'];
        }
        
        if (isset($data['category'])) {
            $updates[] = 'category = ?';
            $params[] = sanitizeInput($data['category']);
        }
        
        if (isset($data['test_cases'])) {
            $updates[] = 'test_cases = ?';
            $params[] = $data['test_cases'];
        }
        
        if (isset($data['solution_template'])) {
            $updates[] = 'solution_template = ?';
            $params[] = $data['solution_template'];
        }
        
        if (empty($updates)) {
            respondError('No fields to update', 400);
            return;
        }
        
        $params[] = $problemId;
        $query = 'UPDATE problems SET ' . implode(', ', $updates) . ' WHERE problem_id = ?';
        
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        
        respondSuccess(null, 'Problem updated successfully');
    } catch (PDOException $e) {
        error_log('Update problem error: ' . $e->getMessage());
        respondError('Failed to update problem', 500);
    }
}

/**
 * Delete problem
 */
function deleteProblem($data) {
    $problemId = intval($data['problem_id'] ?? $_GET['id'] ?? 0);
    
    if (!$problemId) {
        respondError('Problem ID is required', 400);
        return;
    }
    
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        $stmt = $db->prepare('DELETE FROM problems WHERE problem_id = ?');
        $stmt->execute([$problemId]);
        
        if ($stmt->rowCount() > 0) {
            respondSuccess(null, 'Problem deleted successfully');
        } else {
            respondError('Problem not found', 404);
        }
    } catch (PDOException $e) {
        error_log('Delete problem error: ' . $e->getMessage());
        respondError('Failed to delete problem', 500);
    }
}

/**
 * Check if current user is admin
 */
function isAdmin() {
    return isset($_SESSION['logged_in']) && 
           $_SESSION['logged_in'] === true && 
           $_SESSION['role'] === 'admin';
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
