<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="views/css/login.css">
    <script src="views/js/login.js" defer></script>
</head>
<body class="login-page">
    <main class="login" aria-labelledby="login-title">
        <header class="login__header">
            <h1 id="login-title">Iniciar sesión</h1>
        </header>
        <form id="login-form" class="login__form" method="post" action="controllers/login.php">
            <div class="login__field">
                <label for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" autocomplete="email" required placeholder="usuario@ejemplo.com">
            </div>
            <div class="login__field">
                <label for="password">Contraseña</label>
                <div class="login__password">
                    <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="••••••••">
                    <button class="login__toggle" type="button" aria-label="Mostrar contraseña" aria-controls="password" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <div class="login__options">
                <label class="login__remember">
                    <input type="checkbox" name="remember" id="remember" value="1">
                    <span>Recordarme</span>
                </label>
                <a class="login__forgot" href="views/recuperar-contrasena.php">¿Olvidaste tu contraseña?</a>
            </div>
            <p id="login-message" class="login__message" role="status" aria-live="polite"></p>
            <button type="submit" class="login__submit">Entrar</button>
        </form>
        <footer class="login__footer">
            <p>¿No tienes cuenta? <a href="views/registro.php">Regístrate</a></p>
        </footer>
    </main>
</body>
</html>