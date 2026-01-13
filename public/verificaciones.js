// -----------------------------
// VALIDACIÓN EN VIVO
// -----------------------------
document.getElementById("user").addEventListener("input", validarUser);
document.getElementById("pass").addEventListener("input", validarPass);

// -----------------------------
// VALIDACIÓN AL ENVIAR FORMULARIO
// -----------------------------
document.getElementById("form").addEventListener("submit", function (event) {
    const okUser = validarUser();
    const okPass = validarPass();

    if (!okUser || !okPass) {
        event.preventDefault();
    }
});

// -----------------------------
// VALIDACIÓN DE USUARIO
// -----------------------------
function validarUser() {
    const user = document.getElementById("user").value.trim();
    limpiarError("user");

    let correcto = true;

    // 1. Caracteres peligrosos SIEMPRE se validan
    const forbidden = /[<>"'{}()\\\/]/;
    if (forbidden.test(user)) {
        marcarError("user", "No se permiten caracteres peligrosos (< > \" ' { } ( ) \\ /).");
        correcto = false;
    }

    // 2. Longitud mínima
    if (user.length < 8) {
        marcarError("user", "Debe tener al menos 8 caracteres.");
        return false; // NO seguimos validando hasta que cumpla lo básico
    }

    // 3. Longitud máxima
    if (user.length > 15) {
        marcarError("user", "No puede superar los 15 caracteres.");
        correcto = false;
    }

    // 4. Mayúscula obligatoria (solo si ya tiene 8+ caracteres)
    if (!/[A-Z]/.test(user)) {
        marcarError("user", "Debe incluir al menos una letra mayúscula.");
        correcto = false;
    }

    return correcto;
}


// -----------------------------
// VALIDACIÓN DE CONTRASEÑA
// -----------------------------
function validarPass() {
    const pass = document.getElementById("pass").value;
    limpiarError("pass");

    let correcto = true;

    // 1. Longitud mínima primero
    if (pass.length < 8) {
        marcarError("pass", "Debe tener al menos 8 caracteres.");
        return false;
    }

    // 2. Longitud máxima
    if (pass.length > 15) {
        marcarError("pass", "No puede superar los 15 caracteres.");
        correcto = false;
    }

    // 3. Caracteres peligrosos
    const forbidden = /[<>"'{}()\\\/]/;
    if (forbidden.test(pass)) {
        marcarError("pass", "No se permiten caracteres peligrosos (< > \" ' { } ( ) \\ /).");
        correcto = false;
    }

    // 4. Mayúscula
    if (!/[A-Z]/.test(pass)) {
        marcarError("pass", "Debe incluir al menos una letra mayúscula.");
        correcto = false;
    }

    // 5. Minúscula
    if (!/[a-z]/.test(pass)) {
        marcarError("pass", "Debe incluir al menos una letra minúscula.");
        correcto = false;
    }

    // 6. Número
    if (!/[0-9]/.test(pass)) {
        marcarError("pass", "Debe incluir un número.");
        correcto = false;
    }

    // 7. Carácter especial permitido
    if (!/[!@#$%^&*_\-+.,?:;]/.test(pass)) {
        marcarError("pass", "Debe incluir un carácter especial permitido (!@#$%^&*_-+.,?:;).");
        correcto = false;
    }

    return correcto;
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
