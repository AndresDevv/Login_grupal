<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/registro.css">
    <script src="js/registro.js" defer></script>
</head>
<body class="registro-page">
    <main class="registro" aria-labelledby="registro-title">
        <header class="registro__header">
            <h1 id="registro-title">Register</h1>
        </header>
        <!-- Vista visual: conectar el submit al controlador cuando exista. -->
        <form id="registro-form" class="registro__form" method="post">
            <div class="registro__field">
                <label for="user_name">User Name</label>
                <input id="user_name" name="user_name" type="text" autocomplete="username" required>
            </div>
            <div class="registro__field">
                <label for="phone_number">Phone Number</label>
                <input id="phone_number" name="phone_number" type="tel" autocomplete="tel" required>
            </div>
            <div class="registro__field">
                <label for="email">Email Address</label>
                <input id="email" name="email" type="email" autocomplete="email" required>
            </div>
            <div class="registro__field">
                <label for="password">Password</label>
                <div class="registro__password">
                    <input id="password" name="password" type="password" autocomplete="new-password" required>
                    <button class="registro__toggle" type="button" aria-label="Show password" aria-controls="password" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <div class="registro__field">
                <label for="password_confirmation">Confirm Password</label>
                <div class="registro__password">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                    <button class="registro__toggle" type="button" aria-label="Show confirm password" aria-controls="password_confirmation" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <p id="registro-message" class="registro__message" role="status" aria-live="polite"></p>
            <div class="registro__actions">
                <button type="submit">Ok</button>
                <button type="reset">Cancel</button>
            </div>
        </form>
    </main>
</body>
</html>
