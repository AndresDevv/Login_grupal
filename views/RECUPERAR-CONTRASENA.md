# Vista de recuperar contraseña

Desde la raíz del proyecto ejecutar `php -S localhost:8085` y abrir http://localhost:8085/views/recuperar-contrasena.php.

El diseño reproduce la referencia: panel gris, campo de correo, botón azul Enviar con icono, enlace Volver y pie de página. Se adapta a pantallas pequeñas y utiliza estilos con prefijo `recuperar`.

Es solo una vista. El navegador comprueba que el correo tenga formato válido y Enviar muestra un aviso de vista previa; no se envían correos. Los términos y el nombre del pie reproducen la referencia; el texto legal real queda pendiente.

Se conserva la estructura `controller`, `model`, `views` y el `index.php` original. Volver apunta a `../index.php`, que por ahora está vacío. Al integrar el login, confirmar esa ruta con el equipo.

Para conectar el backend: definir el `action` del formulario y reemplazar el listener de `submit` en `js/recuperar-contrasena.js`. El campo se llama `email`. La validación del servidor, los tokens de recuperación y el envío de correo corresponden al controlador y al modelo.

Si la vista se incluye desde el índice, ajustar las rutas de sus recursos a `views/css/recuperar-contrasena.css` y `views/js/recuperar-contrasena.js`.
