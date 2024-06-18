document.getElementById('formulario').addEventListener('submit', function(event) {
    let valid = true;

    // Validar nombre
    const nombre = document.getElementById('nombre');
    const errorNombre = document.getElementById('error-nombre');
    if (nombre.value.trim() === '') {
        valid = false;
        errorNombre.textContent = 'El nombre del producto es obligatorio.';
    } else {
        errorNombre.textContent = '';
    }

    // Validar precio
    const precio = document.getElementById('precio');
    const errorPrecio = document.getElementById('error-precio');
    if (!isFinite(precio.value) || precio.value <= 0) {
        valid = false;
        errorPrecio.textContent = 'El precio debe ser un número positivo.';
    } else {
        errorPrecio.textContent = '';
    }

    // Validar cantidad
    const cantidad = document.getElementById('cantidad');
    const errorCantidad = document.getElementById('error-cantidad');
    if (!isFinite(cantidad.value) || cantidad.value < 0) {
        valid = false;
        errorCantidad.textContent = 'La cantidad debe ser un número no negativo.';
    } else {
        errorCantidad.textContent = '';
    }

    if (!valid) {
        event.preventDefault();
    }
});