<?php
/**
 * Controlador de restablecimiento de contraseña
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

$token = trim($_POST['token'] ?? '');
$password = $_POST['password'] ?? '';
$passwordConfirmation = $_POST['password_confirmation'] ?? '';

if (empty($token)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Token requerido']);
    exit;
}

if (empty($password) || empty($passwordConfirmation)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Ambos campos son obligatorios']);
    exit;
}

if ($password !== $passwordConfirmation) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
    exit;
}

if (strlen($password) < 8) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres']);
    exit;
}

try {
    $userModel = new User();
    $userId = $userModel->validateResetToken($token);

    if (!$userId) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Token inválido o expirado']);
        exit;
    }

    $updated = $userModel->updatePassword($userId, $password);

    if (!$updated) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar la contraseña']);
        exit;
    }

    // Consumir token (uso único)
    $userModel->consumeResetToken($token);

    echo json_encode([
        'success' => true,
        'message' => 'Contraseña actualizada correctamente'
    ]);

} catch (Exception $e) {
    error_log('Reset password error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}