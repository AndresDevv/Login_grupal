# Vista de registro

Abrir `views/registro.php` desde un servidor PHP. Desde la raíz del proyecto:

```powershell
php -S localhost:8085
```

Visitar http://localhost:8085/views/registro.php.

La vista sigue la referencia: cabecera azul, cinco campos, controles para mostrar las contraseñas y botones Ok / Cancel. Cancel limpia los campos. Ok muestra un aviso de vista previa; no guarda datos ni envía contraseñas.

Se conserva la estructura `controller`, `model`, `views` y el `index.php` original. Los estilos usan el prefijo `registro` para facilitar la integración con otras vistas.

Para integrar posteriormente: enlazar esta vista desde el flujo del equipo, definir el `action` del formulario y retirar el listener de vista previa de `submit` en `js/registro.js`. El controlador deberá validar los datos y la confirmación, proteger la solicitud y guardar la contraseña con hash mediante el modelo. Los nombres actuales de los campos son `user_name`, `phone_number`, `email`, `password` y `password_confirmation`; acordarlos con el equipo antes de conectar.

Si se incluye esta vista desde `index.php` en lugar de acceder directamente a ella, ajustar las rutas de CSS y JS a `views/css/registro.css` y `views/js/registro.js`.
