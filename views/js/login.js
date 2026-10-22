const form = document.getElementById('login-form');
const message = document.getElementById('login-message');

// Toggle password visibility
document.querySelectorAll('.login__toggle').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.getAttribute('aria-controls'));
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(visible));
        button.setAttribute('aria-label', `${visible ? 'Ocultar' : 'Mostrar'} contraseña`);
    });
});

// Form submission handling
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const submitButton = form.querySelector('.login__submit');
    const formData = new FormData(form);

    // Basic client-side validation
    const email = formData.get('email').trim();
    const password = formData.get('password');

    if (!email || !password) {
        message.textContent = 'Por favor completa todos los campos.';
        message.style.color = '#c0392b';
        return;
    }

    if (!email.includes('@')) {
        message.textContent = 'Por favor ingresa un correo válido.';
        message.style.color = '#c0392b';
        return;
    }

    // Show loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Entrando...';
    message.textContent = '';
    message.style.color = '#566481';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            message.textContent = 'Inicio de sesión exitoso. Redirigiendo...';
            message.style.color = '#27ae60';
            // Redirect to dashboard or home page
            setTimeout(() => {
                window.location.href = data.redirect || 'dashboard.php';
            }, 1000);
        } else {
            message.textContent = data.message || 'Credenciales incorrectas. Inténtalo de nuevo.';
            message.style.color = '#c0392b';
        }
    } catch (error) {
        console.error('Login error:', error);
        message.textContent = 'Error de conexión. Inténtalo de nuevo más tarde.';
        message.style.color = '#c0392b';
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = 'Entrar';
    }
});

// Clear message on input
form.querySelectorAll('input').forEach((input) => {
    input.addEventListener('input', () => {
        if (message.textContent) {
            message.textContent = '';
        }
    });
});