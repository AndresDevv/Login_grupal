<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="css/recuperar-contrasena.css">
    <script src="js/recuperar-contrasena.js" defer></script>
</head>
<body class="recuperar-page">
    <main class="recuperar">
        <form id="recuperar-form" class="recuperar__form" method="post">
            <label for="recuperar-email">Introduce tu dirección de correo electrónico</label>
            <input id="recuperar-email" name="email" type="email" autocomplete="email" required>
            <button class="recuperar__enviar" type="submit">
                <span class="recuperar__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="m21 3-7 18-4-7-7-4L21 3Z"/><path d="m10 14 11-11"/></svg>
                </span>
                <span class="recuperar__button-text">Enviar</span>
            </button>
            <p id="recuperar-message" class="recuperar__message" role="status" aria-live="polite" hidden></p>
            <a class="recuperar__volver" href="../index.php">Volver</a>
        </form>
        <footer class="recuperar__footer">
            <p>© 2023 Wolters Kluwer. Todos los derechos reservados. <button id="recuperar-terms-toggle" type="button" aria-expanded="false" aria-controls="recuperar-terms">Términos de uso</button></p>
            <p id="recuperar-terms" hidden>Los términos de uso estarán disponibles cuando se integre el contenido del proyecto.</p>
        </footer>
    </main>
</body>
</html>
