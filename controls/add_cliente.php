<?php
require_once '../db.php';

$errors = [];

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = trim($_POST['cedula']);
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);

    // Validaciones del lado del servidor
    if (empty($cedula) || !preg_match('/^[0-9]{6,15}$/', $cedula)) {
        $errors[] = "La cédula debe ser numérica y tener entre 6 y 15 dígitos.";
    }

    if (empty($nombres) || !preg_match('/^[a-zA-Z\s]+$/', $nombres)) {
        $errors[] = "Los nombres sólo deben contener letras y espacios.";
    }

    if (empty($apellidos) || !preg_match('/^[a-zA-Z\s]+$/', $apellidos)) {
        $errors[] = "Los apellidos sólo deben contener letras y espacios.";
    }

    if (empty($direccion)) {
        $errors[] = "La dirección no puede estar vacía.";
    }

    if (empty($telefono) || !preg_match('/^[0-9]{7,15}$/', $telefono)) {
        $errors[] = "El teléfono debe ser numérico y tener entre 7 y 15 dígitos.";
    }

    // Verificar si la cédula ya está registrada
    if (empty($errors)) {
        $sql_check = "SELECT COUNT(*) FROM clientes WHERE cedula = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('s', $cedula);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            $errors[] = "La cédula ingresada ya está registrada.";
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO clientes (cedula, nombres, apellidos, direccion, telefono) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $cedula, $nombres, $apellidos, $direccion, $telefono);

        if ($stmt->execute()) {
            header("Location: ../views/clientes.php");
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
    <title>Agregar Cliente - PETS S.A.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .alert-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
            width: 300px;
        }
    </style>
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <header class="hero">
        <div class="container">
            <h1 class="display-4">Agregar Nuevo Cliente</h1>
            <p class="lead">Completa el formulario para agregar un nuevo cliente.</p>
        </div>
    </header>

    <main class="container my-5">
        <h2 class="text-center mb-4">Formulario de Registro de Cliente</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-floating alert-dismissible fade show" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="add_cliente.php" method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="cedula" class="form-label">Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula" required>
                <div class="invalid-feedback">
                    Por favor, ingresa una cédula válida (6-15 dígitos).
                </div>
            </div>
            <div class="col-md-6">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
                <div class="invalid-feedback">
                    Por favor, ingresa los nombres.
                </div>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                <div class="invalid-feedback">
                    Por favor, ingresa los apellidos.
                </div>
            </div>
            <div class="col-md-6">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
                <div class="invalid-feedback">
                    Por favor, ingresa la dirección.
                </div>
            </div>
            <div class="col-md-6">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
                <div class="invalid-feedback">
                    Por favor, ingresa un teléfono válido (7-15 dígitos).
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary" type="submit">Agregar Cliente</button>
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
    </script>
</body>
</html>
