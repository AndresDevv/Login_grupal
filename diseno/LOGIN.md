# Diseño de Login

## Referencia visual
La imagen de referencia se encuentra en: `diseno/Gemini_Generated_Image_ulbcruulbcruulbc.jpeg`

## Estructura del diseño

### Pantalla principal
- **Fondo**: Gris claro `#f1f2f5`
- **Tarjeta central**: Blanca con borde de 9px `#dedfe3` y sombra suave
- **Ancho máximo**: 420px
- **Altura mínima**: 100vh centrado vertical y horizontalmente

### Cabecera (Header)
- **Fondo**: Azul `#6586c5`
- **Padding**: 30px 20px
- **Texto**: "Iniciar sesión" en blanco, 36px, peso 600, centrado

### Formulario
- **Padding**: 26px 30px 30px
- **Campos**:
  - Correo electrónico (tipo email, autocompletado)
  - Contraseña (tipo password, con botón toggle para mostrar/ocultar)
- **Etiquetas**: Centradas, 18px, color `#566481`
- **Inputs**: 
  - Alto: 53px
  - Borde: 2px `#8795b4`, radio 13px
  - Foco: Borde `#4f73b6` + sombra `#6586c525`
  - Placeholder gris

### Botón toggle contraseña
- Posición absoluta a la derecha del input
- 43x43px, SVG ojo 25x25px
- Hover/activo: Fondo `#edf1fa`, color `#3c609f`

### Opciones (Recordarme / Olvidé contraseña)
- Flexbox: checkbox a la izquierda, enlace a la derecha
- Checkbox nativo con `accent-color: #6586c5`
- Enlace "¿Olvidaste tu contraseña?" → `views/recuperar-contrasena.php`
- Color `#6586c5`, subrayado en hover

### Mensaje de estado
- Altura mínima 20px, centrado, 14px
- Rojo `#c0392b` para errores, verde `#27ae60` para éxito

### Botón Entrar
- Ancho completo, 46px alto
- Fondo `#6586c5`, texto blanco 23px
- Radio 7px, hover `#5275b5`
- Focus-visible: outline 3px `#314f87`

### Pie de página (Footer)
- Padding: 20px 30px 30px
- Texto: "¿No tienes cuenta? Regístrate"
- Enlace "Regístrate" → `views/registro.php`
- Color `#6586c5`, peso 500, subrayado en hover

## Responsive (≤480px)
- Padding página: 16px 12px
- Borde tarjeta: 6px
- Header padding: 24px 16px, título 32px
- Form padding: 24px 18px
- Opciones en columna, gap 10px
- Botón submit: 20px

## Accesibilidad
- Labels asociados con `for`/`id`
- `aria-label` en botones toggle
- `aria-live="polite"` en mensaje de estado
- Focus-visible en todos los elementos interactivos
- Contraste AA en todos los textos
- Navegación por teclado completa

## Integración
- CSS: `views/css/login.css`
- JS: `views/js/login.js`
- Controlador: `controllers/login.php`
- Modelo: `models/User.php`
- Form action: `controllers/login.php` (AJAX)
- Redirección exitosa: `dashboard.php`

## Flujo de usuario
1. Usuario ingresa email y contraseña
2. Opcional: marca "Recordarme" (cookie 30 días)
3. Click "Entrar" → validación cliente → AJAX POST
4. Servidor verifica credenciales (bcrypt)
5. Éxito: crea sesión, redirige a dashboard
6. Error: muestra mensaje en `#login-message`
7. Enlaces a Registro y Recuperar contraseña funcionan sin JS