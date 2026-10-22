const recuperarForm = document.getElementById('recuperar-form');
const recuperarMessage = document.getElementById('recuperar-message');

recuperarForm.addEventListener('submit', (event) => {
    event.preventDefault();
    recuperarMessage.hidden = false;
    recuperarMessage.textContent = 'La pantalla está lista, pero el envío de instrucciones requiere conectar el servidor de recuperación.';
});
