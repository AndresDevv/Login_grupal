<?php
/**
 * Controlador de cierre de sesión
 */

session_start();

// Eliminar cookie de recordar
if (isset($_COOKIE['remember_token'])) {
    require_once __DIR__ . '/../models/User.php';
    try {
        $userModel = new User();
        $userModel->deleteRememberToken($_COOKIE['remember_token']);
    } catch (Exception $e) {
        error_log('Logout error: ' . $e->getMessage());
    }
    setcookie('remember_token', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'secure' => isset($_SERVER['HTTPS']),
        'samesite' => 'Lax'
    ]);
}

// Destruir sesión
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}
session_destroy();

header('Location: ../index.php');
exit;