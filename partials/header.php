<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETS S.A. - Gestión Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="../index.php">PETS S.A.</a> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../views/clientes.php">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/mascotas.php">Mascotas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/medicamentos.php">Medicamentos</a>
                </li>
               
            </ul>
        </div>
    </div>
</nav>
