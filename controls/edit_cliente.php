<?php
require_once '../db.php';

$errors = [];

// Obtener el cliente actual
$cedula = $_GET['cedula'];
$sql = "SELECT * FROM clientes WHERE cedula = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $cedula);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);

    // Validaciones del lado del servidor
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

    if (empty($errors)) {
        $sql = "UPDATE clientes SET nombres = ?, apellidos = ?, direccion = ?, telefono = ? WHERE cedula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $nombres, $apellidos, $direccion, $telefono, $cedula);

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
    <title>Editar Cliente - PETS S.A.</title>
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
    </style>
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <header class="hero">
        <div class="container">
            <h1 class="display-4">Editar Cliente</h1>
            <p class="lead">Modifica la información del cliente.</p>
        </div>
    </header>

    <main class="container my-5">
        <h2 class="text-center mb-4">Formulario de Edición de Cliente</h2>

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

        <form action="edit_cliente.php?cedula=<?= htmlspecialchars($cedula) ?>" method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="cedula" class="form-label">Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula" value="<?= htmlspecialchars($cliente['cedula']) ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?= htmlspecialchars($cliente['nombres']) ?>" required>
                <div class="invalid-feedback">
                    Por favor, ingresa los nombres.
                </div>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($cliente['apellidos']) ?>" required>
                <div class="invalid-feedback">
                    Por favor, ingresa los apellidos.
                </div>
            </div>
            <div class="col-md-6">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($cliente['direccion']) ?>" required>
                <div class="invalid-feedback">
                    Por favor, ingresa la dirección.
                </div>
            </div>
            <div class="col-md-6">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required>
                <div class="invalid-feedback">
                    Por favor, ingresa el teléfono.
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary" type="submit">Actualizar Cliente</button>
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
