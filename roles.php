<?php
define('ROLE_ADMIN', 'admin');
define('ROLE_MANAGER', 'manager');

function requireRole($allowedRoles) {
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    
    $userRole = $_SESSION['role'] ?? ROLE_MANAGER;
    
    if (!in_array($userRole, $allowedRoles, true)) {
        http_response_code(403);
        die("🚫 Доступ запрещён. У вас недостаточно прав.");
    }
}
?>