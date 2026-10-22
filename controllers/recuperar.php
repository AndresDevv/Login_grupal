<?php
/**
 * Controlador de solicitud de recuperación de contraseña
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

$email = trim($_POST['email'] ?? '');

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Correo inválido']);
    exit;
}

try {
    $userModel = new User();
    $user = $userModel->findByEmail($email);

    // Siempre responder éxito por seguridad (no revelar si el email existe)
    $message = 'Si el correo existe, recibirás instrucciones para restablecer tu contraseña.';

    if ($user) {
        $token = $userModel->createResetToken($user['id']);
        $resetLink = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/../views/reset-password.php?token=' . $token;

        // TODO: Enviar email real
        // mail($email, 'Recuperar contraseña', "Enlace: $resetLink", $headers);
        error_log("Password reset token for {$email}: {$resetLink}");
    }

    echo json_encode(['success' => true, 'message' => $message]);

} catch (Exception $e) {
    error_log('Recuperar error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}