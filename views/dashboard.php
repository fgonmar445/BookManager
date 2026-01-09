<?php require_once __DIR__ . '/../config/auth.php'; ?>

<?php
// views/dashboard.php

if (!isset($_SESSION['usuario_logueado'])) {
    header("Location: index.php?action=login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
        }

        .sidebar {
            height: 100vh;
            background: #0d6efd;
            color: white;
            padding-top: 30px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            margin-bottom: 5px;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            transition: 0.2s;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-3 col-md-2 sidebar">
                <h4 class="text-center mb-4">Mi Panel</h4>

                <a href="#">🏠 Inicio</a>
                <a href="#">📊 Estadísticas</a>
                <a href="#">👤 Perfil</a>
                <a href="#">⚙ Configuración</a>
                <a href="index.php?action=logout" class="mt-4">🚪 Cerrar sesión</a>
            </div>

            <!-- Contenido principal -->
            <div class="col-9 col-md-10 p-4">

                <!-- Navbar superior -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Bienvenido, <?= htmlspecialchars($_SESSION['idusuario']) ?></h2>
                    <span class="badge bg-primary p-3">Usuario activo</span>
                </div>

                <!-- Tarjetas de estadísticas -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card shadow card-hover">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios activos</h5>
                                <p class="display-6 text-primary">128</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow card-hover">
                            <div class="card-body">
                                <h5 class="card-title">Tareas completadas</h5>
                                <p class="display-6 text-success">342</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card shadow card-hover">
                            <div class="card-body">
                                <h5 class="card-title">Notificaciones</h5>
                                <p class="display-6 text-danger">7</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección inferior -->
                <div class="card shadow">
                    <div class="card-body">
                        <h4>Resumen general</h4>
                        <p>
                            Este es tu panel de control. Desde aquí podrás gestionar tu cuenta, revisar estadísticas,
                            acceder a configuraciones y mucho más.
                        </p>
                        <button class="btn btn-primary">Ver más detalles</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>