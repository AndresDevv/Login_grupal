<?php
/**
 * Dashboard - Página principal tras login
 */

session_start();

// Verificar autenticación (también cookie "recordarme")
if (empty($_SESSION['user_id']) && !empty($_COOKIE['remember_token'])) {
    require_once __DIR__ . '/models/User.php';
    try {
        $userModel = new User();
        $user = $userModel->findByRememberToken($_COOKIE['remember_token']);
        if ($user) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['user_name'];
        }
    } catch (Exception $e) {
        error_log('Auto-login error: ' . $e->getMessage());
    }
}

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$userName = htmlspecialchars($_SESSION['user_name'] ?? 'Usuario');
$userEmail = htmlspecialchars($_SESSION['user_email'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de usuario</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f2f5; color: #27344d;
            display: grid; place-items: center; padding: 32px 20px;
        }
        .dashboard {
            width: 100%; max-width: 520px;
            background: #fff; border: 9px solid #dedfe3;
            box-shadow: 0 8px 24px #26334d12; border-radius: 0;
        }
        .dashboard__header { background: #6586c5; padding: 30px 20px; text-align: center; color: #fff; }
        .dashboard__header h1 { margin: 0; font-size: 32px; font-weight: 600; }
        .dashboard__content { padding: 30px; text-align: center; }
        .dashboard__avatar {
            width: 80px; height: 80px; border-radius: 50%;
            background: #6586c5; color: #fff; font-size: 36px; font-weight: 600;
            display: grid; place-items: center; margin: 0 auto 20px;
        }
        .dashboard__name { margin: 0 0 8px; font-size: 28px; }
        .dashboard__email { margin: 0 0 30px; color: #7183aa; font-size: 16px; }
        .dashboard__actions { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .btn {
            min-width: 160px; min-height: 46px; border: 0; border-radius: 7px;
            font: inherit; font-size: 18px; cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .btn--primary { background: #6586c5; color: #fff; }
        .btn--primary:hover { background: #5275b5; }
        .btn--secondary { background: #fff; color: #6586c5; border: 2px solid #6586c5; }
        .btn--secondary:hover { background: #edf1fa; }
        .btn:focus-visible { outline: 3px solid #314f87; outline-offset: 3px; }
        @media (max-width: 480px) {
            body { padding: 16px 12px; }
            .dashboard { border-width: 6px; }
            .dashboard__header { padding: 24px 16px; }
            .dashboard__header h1 { font-size: 28px; }
            .dashboard__content { padding: 24px 18px; }
            .btn { min-width: 100%; }
        }
    </style>
</head>
<body>
    <main class="dashboard" role="main">
        <header class="dashboard__header">
            <h1>Panel de usuario</h1>
        </header>
        <div class="dashboard__content">
            <div class="dashboard__avatar" aria-hidden="true">
                <?= strtoupper($userName[0]) ?>
            </div>
            <h2 class="dashboard__name"><?= $userName ?></h2>
            <p class="dashboard__email"><?= $userEmail ?></p>
            <div class="dashboard__actions">
                <a href="controllers/logout.php" class="btn btn--secondary">Cerrar sesión</a>
                <button class="btn btn--primary" onclick="alert('Funcionalidad pendiente')">Configuración</button>
            </div>
        </div>
    </main>
</body>
</html>