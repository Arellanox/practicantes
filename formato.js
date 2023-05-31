// Crear un elemento <canvas> en el DOM
var canvas = document.createElement('canvas');
document.body.appendChild(canvas);

// Obtener el contexto 2D del canvas
var context = canvas.getContext('2d');

// Obtener las dimensiones de la ventana actual
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

// Dibujar la captura de pantalla en el canvas
context.drawImage(window, 0, 0, canvas.width, canvas.height);

// Obtener la imagen en formato base64
var screenshotData = canvas.toDataURL('image/png');

// Crear un enlace para descargar la captura de pantalla
link = document.createElement('a');
link.href = screenshotData;
link.download = 'screenshot.png';
link.click();

