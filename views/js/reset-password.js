const form = document.getElementById('reset-form');
const message = document.getElementById('reset-message');
const tokenInput = document.getElementById('reset-token');

// Obtener token de la URL
const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get('token');

if (!token) {
    message.textContent = 'Token inválido o expirado.';
    message.style.color = '#c0392b';
    form.querySelector('.reset__submit').disabled = true;
} else {
    tokenInput.value = token;
}

// Toggle password visibility
document.querySelectorAll('.reset__toggle').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.getAttribute('aria-controls'));
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(visible));
        const label = input.id === 'new-password' ? 'contraseña' : 'confirmar contraseña';
        button.setAttribute('aria-label', `${visible ? 'Ocultar' : 'Mostrar'} ${label}`);
    });
});

// Form submission
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    if (!token) return;

    const submitButton = form.querySelector('.reset__submit');
    const formData = new FormData(form);

    const password = formData.get('password');
    const passwordConfirmation = formData.get('password_confirmation');

    if (!password || !passwordConfirmation) {
        message.textContent = 'Completa ambos campos.';
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

    submitButton.disabled = true;
    submitButton.textContent = 'Guardando...';
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
            message.textContent = 'Contraseña actualizada. Redirigiendo al login...';
            message.style.color = '#27ae60';
            setTimeout(() => {
                window.location.href = '../../index.php';
            }, 1500);
        } else {
            message.textContent = data.message || 'Error al actualizar. Inténtalo de nuevo.';
            message.style.color = '#c0392b';
        }
    } catch (error) {
        console.error('Reset error:', error);
        message.textContent = 'Error de conexión. Inténtalo de nuevo más tarde.';
        message.style.color = '#c0392b';
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = 'Guardar';
    }
});

// Clear message on input
form.querySelectorAll('input[type="password"]').forEach((input) => {
    input.addEventListener('input', () => {
        if (message.textContent) message.textContent = '';
    });
});