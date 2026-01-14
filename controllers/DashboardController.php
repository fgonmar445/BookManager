<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Libro.php';

class DashboardController {

    public function index() {

        $database = new Database();
        $db = $database->getConnection();

        $libro = new Libro($db);   // 👈 IMPORTANTE

        $stats = [
            'total'        => $libro->contarLibros(),
            'disponibles'  => $libro->contarDisponibles(),
            'promedio'     => $libro->precioPromedio(),
            'caro'         => $libro->libroMasCaro(),
            'recientes'    => $libro->ultimosLibros()
        ];

        require __DIR__ . '/../views/dashboard.php';
    }
}
