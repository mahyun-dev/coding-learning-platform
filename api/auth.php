<?php
/**
 * Authentication API
 * Handles user login, logout, and registration
 */

define('APP_INIT', true);
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle different HTTP methods
switch ($method) {
    case 'POST':
        $action = $_POST['action'] ?? $_GET['action'] ?? '';
        
        if ($action === 'login') {
            handleLogin();
        } elseif ($action === 'register') {
            handleRegister();
        } elseif ($action === 'logout') {
            handleLogout();
        } else {
            respondError('Invalid action', 400);
        }
        break;
        
    case 'GET':
        $action = $_GET['action'] ?? '';
        
        if ($action === 'check') {
            checkAuth();
        } elseif ($action === 'logout') {
            handleLogout();
        } else {
            respondError('Invalid action', 400);
        }
        break;
        
    default:
        respondError('Method not allowed', 405);
        break;
}

/**
 * Handle user login
 */
function handleLogin() {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        respondError('Username and password are required', 400);
        return;
    }
    
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        $stmt = $db->prepare('SELECT user_id, username, password, role FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $updateStmt = $db->prepare('UPDATE users SET last_login = NOW() WHERE user_id = ?');
            $updateStmt->execute([$user['user_id']]);
            
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            respondSuccess([
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'role' => $user['role']
            ], 'Login successful');
        } else {
            respondError('Invalid username or password', 401);
        }
    } catch (PDOException $e) {
        error_log('Login error: ' . $e->getMessage());
        respondError('Login failed', 500);
    }
}

/**
 * Handle user registration
 */
function handleRegister() {
    $username = sanitizeInput($_POST['username'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        respondError('All fields are required', 400);
        return;
    }
    
    if (!validateEmail($email)) {
        respondError('Invalid email format', 400);
        return;
    }
    
    if (strlen($password) < 6) {
        respondError('Password must be at least 6 characters', 400);
        return;
    }
    
    if ($password !== $confirmPassword) {
        respondError('Passwords do not match', 400);
        return;
    }
    
    $db = getDBConnection();
    if (!$db) {
        respondError('Database connection failed', 500);
        return;
    }
    
    try {
        // Check if username or email already exists
        $stmt = $db->prepare('SELECT user_id FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);
        
        if ($stmt->fetch()) {
            respondError('Username or email already exists', 409);
            return;
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert new user
        $stmt = $db->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
        $stmt->execute([$username, $email, $hashedPassword, 'student']);
        
        $userId = $db->lastInsertId();
        
        // Set session variables
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'student';
        $_SESSION['logged_in'] = true;
        
        respondSuccess([
            'user_id' => $userId,
            'username' => $username,
            'role' => 'student'
        ], 'Registration successful');
    } catch (PDOException $e) {
        error_log('Registration error: ' . $e->getMessage());
        respondError('Registration failed', 500);
    }
}

/**
 * Handle user logout
 */
function handleLogout() {
    session_destroy();
    respondSuccess(null, 'Logout successful');
}

/**
 * Check authentication status
 */
function checkAuth() {
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        respondSuccess([
            'logged_in' => true,
            'user_id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role']
        ], 'Authenticated');
    } else {
        respondSuccess(['logged_in' => false], 'Not authenticated');
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
