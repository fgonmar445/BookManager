// -----------------------------
// VALIDACIÓN EN VIVO
// -----------------------------
document.getElementById("titulo").addEventListener("input", validarTitulo);
document.getElementById("autor").addEventListener("input", validarAutor);
document.getElementById("fecha_publicacion").addEventListener("input", validarFecha);
document.getElementById("precio").addEventListener("input", validarPrecio);

// -----------------------------
// VALIDACIÓN AL ENVIAR FORMULARIO
// -----------------------------
document.getElementById("formLibro").addEventListener("submit", function (event) {

    const okTitulo = validarTitulo();
    const okAutor = validarAutor();
    const okFecha = validarFecha();
    const okPrecio = validarPrecio();

    if (!okTitulo || !okAutor || !okFecha || !okPrecio) {
        event.preventDefault();
    }
});

// -----------------------------
// VALIDACIÓN DE TÍTULO
// -----------------------------
function validarTitulo() {
    const titulo = document.getElementById("titulo").value.trim();
    limpiarError("titulo");

    let ok = true;

    const forbidden = /[<>"'{}()\\\/]/;
    if (forbidden.test(titulo)) {
        marcarError("titulo", "No se permiten caracteres peligrosos.");
        ok = false;
    }

    if (titulo.length < 3) {
        marcarError("titulo", "Debe tener al menos 3 caracteres.");
        return false;
    }

    if (titulo.length > 100) {
        marcarError("titulo", "No puede superar los 100 caracteres.");
        ok = false;
    }

    return ok;
}

// -----------------------------
// VALIDACIÓN DE AUTOR
// -----------------------------
function validarAutor() {
    const autor = document.getElementById("autor").value.trim();
    limpiarError("autor");

    let ok = true;

    const forbidden = /[<>"'{}()\\\/]/;
    if (forbidden.test(autor)) {
        marcarError("autor", "No se permiten caracteres peligrosos.");
        ok = false;
    }

    if (autor.length < 3) {
        marcarError("autor", "Debe tener al menos 3 caracteres.");
        return false;
    }

    if (autor.length > 60) {
        marcarError("autor", "No puede superar los 60 caracteres.");
        ok = false;
    }

    return ok;
}

// -----------------------------
// VALIDACIÓN DE FECHA
// -----------------------------
function validarFecha() {
    const fecha = document.getElementById("fecha_publicacion").value;
    limpiarError("fecha_publicacion");

    if (!fecha) {
        marcarError("fecha_publicacion", "Debe seleccionar una fecha.");
        return false;
    }

    const hoy = new Date().toISOString().split("T")[0];

    if (fecha > hoy) {
        marcarError("fecha_publicacion", "La fecha no puede ser futura.");
        return false;
    }

    return true;
}

// -----------------------------
// VALIDACIÓN DE PRECIO
// -----------------------------
function validarPrecio() {
    const precio = document.getElementById("precio").value;
    limpiarError("precio");

    let ok = true;

    if (precio === "" || isNaN(precio)) {
        marcarError("precio", "Debe ser un número válido.");
        return false;
    }

    const valor = parseFloat(precio);

    if (valor <= 0) {
        marcarError("precio", "Debe ser mayor que 0.");
        ok = false;
    }

    if (valor > 9999.99) {
        marcarError("precio", "El precio no puede superar 9999.99 €.");
        ok = false;
    }

    return ok;
}

// -----------------------------
// FUNCIONES DE ERRORES
// -----------------------------
function limpiarError(id) {
    document.getElementById(id).style.borderColor = "#dee2e6";
    const help = document.getElementById(id + "Help");
    help.style.visibility = "hidden";
    help.innerHTML = "";
}

function marcarError(id, mensaje) {
    const help = document.getElementById(id + "Help");
    help.style.visibility = "visible";
    help.innerHTML += mensaje + "<br>";
    document.getElementById(id).style.borderColor = "red";
}
