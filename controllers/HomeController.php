<?php
// controllers/HomeController.php

class HomeController {
    public function index() {
        // Carga la vista principal de la aplicación
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/home/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}