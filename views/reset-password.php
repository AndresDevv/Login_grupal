<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña</title>
    <link rel="stylesheet" href="css/reset-password.css">
    <script src="js/reset-password.js" defer></script>
</head>
<body class="reset-page">
    <main class="reset" aria-labelledby="reset-title">
        <header class="reset__header">
            <h1 id="reset-title">Nueva contraseña</h1>
        </header>
        <form id="reset-form" class="reset__form" method="post" action="../../controllers/reset-password.php">
            <input type="hidden" name="token" id="reset-token" value="">
            <div class="reset__field">
                <label for="new-password">Nueva contraseña</label>
                <div class="reset__password">
                    <input id="new-password" name="password" type="password" autocomplete="new-password" required placeholder="••••••••" minlength="8">
                    <button class="reset__toggle" type="button" aria-label="Mostrar contraseña" aria-controls="new-password" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <div class="reset__field">
                <label for="confirm-password">Confirmar contraseña</label>
                <div class="reset__password">
                    <input id="confirm-password" name="password_confirmation" type="password" autocomplete="new-password" required placeholder="••••••••">
                    <button class="reset__toggle" type="button" aria-label="Mostrar confirmar contraseña" aria-controls="confirm-password" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <p id="reset-message" class="reset__message" role="status" aria-live="polite"></p>
            <button type="submit" class="reset__submit">Guardar</button>
        </form>
        <footer class="reset__footer">
            <a href="../index.php">← Volver al login</a>
        </footer>
    </main>
</body>
</html>