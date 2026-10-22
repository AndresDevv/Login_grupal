<?php
/**
 * Controlador de registro
 */

require_once __DIR__ . '/../models/User.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Petición inválida']);
    exit;
}

$userName = trim($_POST['user_name'] ?? '');
$phoneNumber = trim($_POST['phone_number'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$passwordConfirmation = $_POST['password_confirmation'] ?? '';

// Validaciones
$errors = [];

if (empty($userName)) $errors[] = 'El nombre de usuario es obligatorio';
if (empty($phoneNumber)) $errors[] = 'El teléfono es obligatorio';
if (empty($email)) $errors[] = 'El correo es obligatorio';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Formato de correo inválido';
if (empty($password)) $errors[] = 'La contraseña es obligatoria';
elseif (strlen($password) < 8) $errors[] = 'La contraseña debe tener al menos 8 caracteres';
if ($password !== $passwordConfirmation) $errors[] = 'Las contraseñas no coinciden';

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
    exit;
}

try {
    $userModel = new User();
    $userId = $userModel->create($userName, $phoneNumber, $email, $password);

    if ($userId === false) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'El correo ya está registrado']);
        exit;
    }

    // Auto-login después del registro
    session_start();
    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $userName;

    echo json_encode([
        'success' => true,
        'message' => 'Registro exitoso. Bienvenido!',
        'redirect' => 'dashboard.php'
    ]);

} catch (Exception $e) {
    error_log('Registro error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}