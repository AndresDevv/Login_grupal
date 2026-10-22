const recuperarForm = document.getElementById('recuperar-form');
const recuperarMessage = document.getElementById('recuperar-message');

// Vista previa: sustituir este listener al conectar el controlador.
recuperarForm.addEventListener('submit', (event) => {
    event.preventDefault();
    recuperarMessage.hidden = false;
    recuperarMessage.textContent = 'Vista previa: el envío del correo de recuperación aún no está conectado.';
});

const recuperarTermsToggle = document.getElementById('recuperar-terms-toggle');
const recuperarTerms = document.getElementById('recuperar-terms');
recuperarTermsToggle.addEventListener('click', () => {
    const expanded = recuperarTermsToggle.getAttribute('aria-expanded') === 'true';
    recuperarTermsToggle.setAttribute('aria-expanded', String(!expanded));
    recuperarTerms.hidden = expanded;
});
