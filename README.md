# 📚 BookManager — CRUD de Libros con Login (PHP + MVC + MySQL)

Aplicación web desarrollada en **PHP**, siguiendo el patrón **MVC**, que permite gestionar una biblioteca de libros mediante un CRUD completo.  
Incluye sistema de **autenticación segura**, protección CSRF, control de intentos fallidos y confirmación de eliminación con **SweetAlert2**.

---

## 🚀 Características principales
### 🔐 Autenticación segura
- Validación estricta de usuario y contraseña. 
- Protección contra ataques CSRF. 
- Regeneración periódica del ID de sesión. 
- Control de intentos fallidos de login. - Hashing seguro con `password_verify()`. 
- Prevención de _timing attacks_ mediante hash falso. 
- Cabeceras de seguridad (XSS, MIME sniffing, framing). 

### 📘 Gestión de libros (CRUD) 
- Crear, listar, editar y eliminar libros. 
- Validación completa en backend. 
- Validación en vivo con JavaScript. 
- Confirmación de eliminación con SweetAlert2. 
- Sanitización de entradas para evitar XSS. 

### 🔧 Dashboard mejorado
Dashboard con estadísticas y una tabla de los últimos libros añadidos.

### 🎨 Interfaz moderna 
- Diseño basado en **Bootstrap 5**. 
- Layout reutilizable. 
- Dashboard con tarjetas informativas. 
- Tablas responsivas. 
### 🧱 Arquitectura MVC Separación clara entre: 
- **Modelos** (acceso a datos) 
- **Controladores** (lógica) 
- **Vistas** (interfaz)

--- 

## 📂 Estructura del proyecto

```
BookManager:
│
│   127_0_0_1.sql
│   index.php
│   README.md
│   ayuda.txt (Fichero de ayuda con user y pass)
│   
│
├───config
│       auth.php
│       Database.php
│       establecer-sesion.php
│
├───controllers
│       AuthController.php
│       DashboardController.php
│       LibroController.php
│
├───models
│       Libro.php
│       User.php
│
├───public
│   │   styles.css
│   │   validarLibro.js
│   │   verificaciones.js
│   │
│   └───js
│           libros.js
│
└───views
        crear.php
        dashboard.php
        editar.php
        layout.php
        listar.php
        login.php
```

---

## 🛠️ Tecnologías utilizadas

- **PHP 8+**
- **MySQL / MariaDB**
- **PDO** (consultas preparadas)
- **Bootstrap 5**
- **JavaScript (validaciones + SweetAlert2)**

---

## 📦 Instalación

### 1️⃣ Clonar el repositorio
```
git clone https://github.com/tuusuario/BookManager.git
```

### 2️⃣ Clonar el repositorio
Importa la base de datos:
```
127_0_0_1.sql
```

### 3️⃣ Configurar credenciales
Edita config/Database.php:
```
private $host = "localhost";
private $db_name = "login-php";
private $username = "login-php";
private $password = "1234";
```

### 4️⃣ Configurar servidor local
Coloca el proyecto en:
```
/htdocs/BookManager
```

### 5️⃣ Acceder a la aplicación
```
http://localhost/BookManager/index.php
```
## 🛠️ Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- XAMPP, WAMP o similar
- Navegador moderno
- Extensión PDO habilitada

---

# 🔐 Sistema de Autenticación

El sistema de login implementado en este proyecto está diseñado para ser **seguro, robusto y resistente a ataques comunes**. A continuación se detallan todas las medidas de seguridad aplicadas.

---

## ✔️ Contraseñas seguras

- Las contraseñas se almacenan utilizando `password_hash()`.
- La verificación se realiza mediante `password_verify()`.

Esto garantiza que **ninguna contraseña se almacena en texto plano** y que el sistema es resistente a ataques de fuerza bruta y filtraciones.

---

## ✔️ Protección contra ataques

### 🔸 Prevención de SQL Injection

Todas las consultas a la base de datos se realizan mediante **consultas preparadas (PDO)**.

### 🔸 Prevención de XSS

Los datos enviados por el usuario se sanitizan con:

- `htmlspecialchars()`
- `trim()`

### 🔸 Prevención de CSRF

Cada formulario incluye un **token CSRF único por sesión**, evitando envíos maliciosos desde otros sitios.

### 🔸 Prevención de fuerza bruta

El sistema cuenta con un **contador de intentos fallidos**.  
Si se supera el límite, el usuario queda temporalmente bloqueado.

### 🔸 Regeneración de sesión

Al iniciar sesión correctamente, se ejecuta:

```php
session_regenerate_id(true);
```

Esto evita ataques de fijación de sesión.

---

# ✔️ Flujo de autenticación

- El usuario accede al formulario de login.
- Se valida el token CSRF.
- Se comprueba usuario y contraseña.
- Si las credenciales son correctas → se crea la sesión.
- Si son incorrectas → se incrementa el contador de intentos.
- Si se supera el límite → bloqueo temporal.

---

# 🛡️ Protección de rutas

El archivo `config/auth.php` protege todas las rutas del CRUD:

```php
if (!isset($_SESSION['usuario_logueado']) || $_SESSION['usuario_logueado'] !== true) {
    header("Location: index.php?action=login");
    exit();
}
```

✔️ Solo usuarios autenticados pueden acceder al CRUD
✔️ Evita accesos directos a controladores o vistas

---

# 🧼 Validación y sanitización de datos

Cada formulario del CRUD aplica:

## ✔️ Sanitización

- htmlspecialchars() → evita XSS

- trim() → elimina espacios innecesarios

- floatval() → convierte precios

- intval() → convierte IDs

- Checkbox convertido a 1 o 0

## ✔️ Validación

- Campos obligatorios

- Fechas válidas

- Precios numéricos

- Longitud mínima de texto

# 📘 CRUD de Libros

## ➕ Crear libro

- Formulario en views/crear.php

- Sanitización de datos

- Inserción mediante consultas preparadas

- Redirección a listar con mensaje

## ✏️ Editar libro

- Carga de datos existentes

- Validación y sanitización

- Actualización segura

- Redirección a listar

# 🗑️ Eliminar libro

Eliminación confirmada mediante SweetAlert2:

js

```
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar libro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "index.php?action=delete&id=" + id;
        }
    });
}
```

---

# 🎨 Estilos

El proyecto utiliza:

Bootstrap 5 para diseño responsive

SweetAlert2 para alertas modernas

---

# 🧩 Mejoras futuras

Roles de usuario (admin/lector)

Paginación de libros

Buscador avanzado

Subida de imágenes de portada

API REST

Logs de actividad

---
