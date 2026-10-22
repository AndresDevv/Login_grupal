<?php
/**
 * Controlador de inicio de sesión
 * Conecta con el modelo de usuarios para autenticar
 */

require_once __DIR__ . '/../models/User.php';

header('Content-Type: application/json');

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Verificar que es una petición AJAX
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Petición inválida']);
    exit;
}

// Obtener y sanitizar datos
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']) ? (bool)$_POST['remember'] : false;

// Validación básica
if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Correo y contraseña son obligatorios']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Formato de correo inválido']);
    exit;
}

try {
    $userModel = new User();
    $user = $userModel->findByEmail($email);

    if (!$user) {
        // Usar tiempo constante para evitar timing attacks
        password_verify('dummy', '$2y$10$dummy');
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
        exit;
    }

    if (!password_verify($password, $user['password_hash'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
        exit;
    }

    // Iniciar sesión
    session_start();

    // Regenerar ID de sesión para seguridad
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['user_name'];

    // Cookie "Recordarme" (30 días)
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (30 * 24 * 60 * 60); // 30 días

        $userModel->setRememberToken($user['id'], $token, $expiry);

        setcookie('remember_token', $token, [
            'expires' => $expiry,
            'path' => '/',
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']),
            'samesite' => 'Lax'
        ]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Inicio de sesión exitoso',
        'redirect' => 'dashboard.php'
    ]);

} catch (Exception $e) {
    error_log('Login error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}