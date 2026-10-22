const recuperarForm = document.getElementById('recuperar-form');
const recuperarMessage = document.getElementById('recuperar-message');

// Conectado al controlador: POST a controllers/recuperar.php
recuperarForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    const submitButton = recuperarForm.querySelector('.recuperar__enviar');
    const formData = new FormData(recuperarForm);
    const email = formData.get('email')?.trim();

    if (!email || !email.includes('@')) {
        recuperarMessage.hidden = false;
        recuperarMessage.textContent = 'Introduce un correo válido.';
        recuperarMessage.style.color = '#c0392b';
        return;
    }

    const originalContent = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.textContent = 'Enviando...';
    recuperarMessage.hidden = true;
    recuperarMessage.textContent = '';

    try {
        const response = await fetch('../controllers/recuperar.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        recuperarMessage.hidden = false;
        if (response.ok && data.success) {
            recuperarMessage.textContent = data.message;
            recuperarMessage.style.color = '#27ae60';
            recuperarForm.reset();
        } else {
            recuperarMessage.textContent = data.message || 'Error al solicitar recuperación.';
            recuperarMessage.style.color = '#c0392b';
        }
    } catch (error) {
        console.error('Recuperar error:', error);
        recuperarMessage.hidden = false;
        recuperarMessage.textContent = 'Error de conexión. Inténtalo de nuevo.';
        recuperarMessage.style.color = '#c0392b';
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalContent;
    }
});

const recuperarTermsToggle = document.getElementById('recuperar-terms-toggle');
const recuperarTerms = document.getElementById('recuperar-terms');
recuperarTermsToggle?.addEventListener('click', () => {
    const expanded = recuperarTermsToggle.getAttribute('aria-expanded') === 'true';
    recuperarTermsToggle.setAttribute('aria-expanded', String(!expanded));
    recuperarTerms.hidden = expanded;
});

// Estilo para spinner
const style = document.createElement('style');
style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
document.head.appendChild(style);
