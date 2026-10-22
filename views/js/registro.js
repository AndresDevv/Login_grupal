const form = document.getElementById('registro-form');
const message = document.getElementById('registro-message');

document.querySelectorAll('.registro__toggle').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.getAttribute('aria-controls'));
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(visible));
        const label = input.id === 'password' ? 'password' : 'confirm password';
        button.setAttribute('aria-label', `${visible ? 'Hide' : 'Show'} ${label}`);
    });
});

form.addEventListener('submit', (event) => {
    event.preventDefault();
    message.textContent = 'Visual preview only. Registration is not connected yet.';
});

form.addEventListener('reset', () => {
    message.textContent = '';
    document.querySelectorAll('.registro__toggle').forEach((button) => {
        if (button.getAttribute('aria-pressed') === 'true') button.click();
    });
    document.getElementById('user_name').focus();
});
