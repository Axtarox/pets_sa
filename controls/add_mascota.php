<?php
require_once '../db.php';

$errors = [];
$clientes = [];
$medicamentos = [];

// Obtener cédulas de clientes
$clientes_sql = "SELECT cedula, nombres FROM clientes";
$clientes_result = $conn->query($clientes_sql);
if ($clientes_result->num_rows > 0) {
    while ($row = $clientes_result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

// Obtener IDs de medicamentos
$medicamentos_sql = "SELECT id, nombre FROM medicamentos";
$medicamentos_result = $conn->query($medicamentos_sql);
if ($medicamentos_result->num_rows > 0) {
    while ($row = $medicamentos_result->fetch_assoc()) {
        $medicamentos[] = $row;
    }
}

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identificacion = trim($_POST['identificacion']);
    $nombre = trim($_POST['nombre']);
    $raza = trim($_POST['raza']);
    $edad = isset($_POST['edad']) ? (int)$_POST['edad'] : 0;
    $peso = isset($_POST['peso']) ? (float)$_POST['peso'] : 0.0;
    $id_medicamento = isset($_POST['id_medicamento']) ? (int)$_POST['id_medicamento'] : 0;
    $cedula_cliente = isset($_POST['cedula_cliente']) ? (int)$_POST['cedula_cliente'] : 0;

    // Validaciones del lado del servidor
    if (empty($identificacion)) {
        $errors[] = "La identificación no puede estar vacía.";
    }

    if (empty($nombre)) {
        $errors[] = "El nombre no puede estar vacío.";
    }

    if (empty($cedula_cliente) || !preg_match('/^[0-9]+$/', $cedula_cliente)) {
        $errors[] = "La cédula del cliente debe ser numérica.";
    }

    if ($edad <= 0) {
        $errors[] = "La edad debe ser un número positivo.";
    }

    if ($peso <= 0) {
        $errors[] = "El peso debe ser un número positivo.";
    }

    if ($id_medicamento <= 0) {
        $errors[] = "El ID del medicamento debe ser un número positivo.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO mascotas (identificacion, nombre, raza, edad, peso, id_medicamento, cedula_cliente) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssiddi', $identificacion, $nombre, $raza, $edad, $peso, $id_medicamento, $cedula_cliente);

        if ($stmt->execute()) {
            header("Location: ../views/mascotas.php");
            exit();
        } else {
            $errors[] = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Mascota - PETS S.A.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://images.unsplash.com/photo-1574158622682-e40e69881006?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <header class="hero">
        <div class="container">
            <h1 class="display-4">Agregar Nueva Mascota</h1>
            <p class="lead">Completa el formulario para agregar una nueva mascota.</p>
        </div>
    </header>

    <main class="container my-5">
        <h2 class="text-center mb-4">Formulario de Registro de Mascota</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="add_mascota.php" method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="identificacion" class="form-label">Identificación</label>
                <input type="text" class="form-control" id="identificacion" name="identificacion" required>
                <div class="invalid-feedback">
                    Por favor, ingresa la identificación de la mascota.
                </div>
            </div>
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
                <div class="invalid-feedback">
                    Por favor, ingresa el nombre de la mascota.
                </div>
            </div>
            <div class="col-md-6">
                <label for="raza" class="form-label">Raza</label>
                <input type="text" class="form-control" id="raza" name="raza">
            </div>
            <div class="col-md-6">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" class="form-control" id="edad" name="edad" min="1">
            </div>
            <div class="col-md-6">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" step="0.01" class="form-control" id="peso" name="peso" min="0.01">
            </div>
            <div class="col-md-6">
                <label for="id_medicamento" class="form-label">Medicamento</label>
                <select id="id_medicamento" name="id_medicamento" class="form-select" required>
                    <option value="">Selecciona un medicamento...</option>
                    <?php foreach ($medicamentos as $medicamento): ?>
                        <option value="<?= htmlspecialchars($medicamento['id']) ?>">
                            <?= htmlspecialchars($medicamento['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona un medicamento.
                </div>
            </div>
            <div class="col-md-6">
                <label for="cedula_cliente" class="form-label">Cliente</label>
                <select id="cedula_cliente" name="cedula_cliente" class="form-select" required>
                    <option value="">Selecciona un cliente...</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= htmlspecialchars($cliente['cedula']) ?>">
                            <?= htmlspecialchars($cliente['nombres']) ?> (Cédula: <?= htmlspecialchars($cliente['cedula']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona un cliente.
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary" type="submit">Agregar Mascota</button>
            </div>
        </form>
    </main>

    <?php include '../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
