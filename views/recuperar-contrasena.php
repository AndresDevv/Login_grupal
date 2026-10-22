<?php $pageTitle = 'Recuperar contraseña'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f2f7ff">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="css/recuperar-contrasena.css">
    <script src="js/recuperar-contrasena.js" defer></script>
</head>
<body class="recuperar-page">
    <main class="recuperar" aria-labelledby="recuperar-title">
        <section class="recuperar__card">
            <a class="recuperar__volver" href="../index.php">
                <span aria-hidden="true">←</span> Volver al inicio
            </a>

            <div class="recuperar__icon" aria-hidden="true">
                <svg viewBox="0 0 48 48" fill="none">
                    <rect x="5" y="10" width="38" height="28" rx="7" />
                    <path d="m8 15 16 12 16-12" />
                </svg>
            </div>

            <p class="recuperar__eyebrow">Recuperación de cuenta</p>
            <h1 id="recuperar-title"><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></h1>
            <p class="recuperar__intro">Introduce tu dirección de correo electrónico y te indicaremos cómo restablecer tu contraseña.</p>

            <form id="recuperar-form" class="recuperar__form" method="post">
                <label for="recuperar-email">Correo electrónico</label>
                <input id="recuperar-email" name="email" type="email" placeholder="nombre@correo.com" autocomplete="email" required>
                <button class="recuperar__enviar" type="submit">
                    Enviar instrucciones <span aria-hidden="true">→</span>
                </button>
                <p id="recuperar-message" class="recuperar__message" role="status" aria-live="polite" hidden></p>
            </form>

            <p class="recuperar__footer">¿Ya tienes tu contraseña? <a href="../index.php">Inicia sesión</a></p>
        </section>
    </main>
</body>
</html>
