const form = document.getElementById('registro-form');
const message = document.getElementById('registro-message');

document.querySelectorAll('.registro__toggle').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.getAttribute('aria-controls'));
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(visible));
        const label = input.id === 'password' ? 'contraseña' : 'confirmar contraseña';
        button.setAttribute('aria-label', `${visible ? 'Ocultar' : 'Mostrar'} ${label}`);
    });
});

// Conectado al controlador: POST a controllers/registro.php
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const submitButton = form.querySelector('button[type="submit"]');
    const formData = new FormData(form);

    const userName = formData.get('user_name')?.trim();
    const phoneNumber = formData.get('phone_number')?.trim();
    const email = formData.get('email')?.trim();
    const password = formData.get('password');
    const passwordConfirmation = formData.get('password_confirmation');

    // Validación cliente
    if (!userName || !phoneNumber || !email || !password || !passwordConfirmation) {
        message.textContent = 'Completa todos los campos.';
        message.style.color = '#c0392b';
        return;
    }

    if (!email.includes('@')) {
        message.textContent = 'Correo inválido.';
        message.style.color = '#c0392b';
        return;
    }

    if (password.length < 8) {
        message.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        message.style.color = '#c0392b';
        return;
    }

    if (password !== passwordConfirmation) {
        message.textContent = 'Las contraseñas no coinciden.';
        message.style.color = '#c0392b';
        return;
    }

    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Registrando...';
    message.textContent = '';
    message.style.color = '#566481';

    try {
        const response = await fetch('../controllers/registro.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            message.textContent = data.message;
            message.style.color = '#27ae60';
            setTimeout(() => {
                const projectRoot = new URL('../', window.location.href);
                window.location.href = new URL(data.redirect || 'dashboard.php', projectRoot).href;
            }, 1000);
        } else {
            message.textContent = data.message || 'Error en el registro.';
            message.style.color = '#c0392b';
        }
    } catch (error) {
        console.error('Registro error:', error);
        message.textContent = 'Error de conexión. Inténtalo de nuevo.';
        message.style.color = '#c0392b';
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    }
});

form.addEventListener('reset', () => {
    message.textContent = '';
    document.querySelectorAll('.registro__toggle').forEach((button) => {
        if (button.getAttribute('aria-pressed') === 'true') button.click();
    });
    document.getElementById('user_name').focus();
});
