<?php
require_once '../db.php';

// Verificamos si el ID está presente en la URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];  // Convertir el ID a entero
} else {
    echo "Error: ID de la mascota no proporcionado.";
    exit;
}

// Obtener los datos de la mascota por su ID
$sql = "SELECT * FROM mascotas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$mascota = $result->fetch_assoc();

// Obtener las cédulas de clientes
$clientes_sql = "SELECT cedula, nombres FROM clientes";
$clientes_result = $conn->query($clientes_sql);
$clientes = [];
if ($clientes_result->num_rows > 0) {
    while ($row = $clientes_result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

// Obtener los IDs de medicamentos
$medicamentos_sql = "SELECT id, nombre FROM medicamentos";
$medicamentos_result = $conn->query($medicamentos_sql);
$medicamentos = [];
if ($medicamentos_result->num_rows > 0) {
    while ($row = $medicamentos_result->fetch_assoc()) {
        $medicamentos[] = $row;
    }
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Obtener los valores del formulario
    $nombre = trim($_POST['nombre']);
    $raza = trim($_POST['raza']);
    $edad = isset($_POST['edad']) ? (int)$_POST['edad'] : 0;
    $peso = isset($_POST['peso']) ? (float)$_POST['peso'] : 0.0;
    $id_medicamento = isset($_POST['id_medicamento']) ? (int)$_POST['id_medicamento'] : 0;
    $cedula_cliente = isset($_POST['cedula_cliente']) ? (int)$_POST['cedula_cliente'] : 0;

    // Validaciones del lado del servidor
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

    // Si no hay errores, actualizamos los datos de la mascota
    if (empty($errors)) {
        $sql = "UPDATE mascotas SET nombre = ?, raza = ?, edad = ?, peso = ?, id_medicamento = ?, cedula_cliente = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiddii', $nombre, $raza, $edad, $peso, $id_medicamento, $cedula_cliente, $id);

        if ($stmt->execute()) {
            header("Location: ../views/mascotas.php");
            exit();
        } else {
            $errors[] = "Error al actualizar la mascota: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mascota - PETS S.A.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://images.unsplash.com/photo-1548191265-cc70d3d45ba1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
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
            <h1 class="display-4">Editar Información de Mascota</h1>
            <p class="lead">Modifica los datos de la mascota.</p>
        </div>
    </header>

    <main class="container my-5">
        <h2 class="text-center mb-4">Formulario de Edición de Mascota</h2>

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

        <form action="edit_mascota.php?id=<?= $id ?>" method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($mascota['nombre']) ?>" required>
                <div class="invalid-feedback">
                    Por favor, ingresa el nombre de la mascota.
                </div>
            </div>
            <div class="col-md-6">
                <label for="raza" class="form-label">Raza</label>
                <input type="text" class="form-control" id="raza" name="raza" value="<?= htmlspecialchars($mascota['raza']) ?>">
            </div>
            <div class="col-md-6">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" class="form-control" id="edad" name="edad" value="<?= htmlspecialchars($mascota['edad']) ?>" min="1" required>
            </div>
            <div class="col-md-6">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="<?= htmlspecialchars($mascota['peso']) ?>" min="0.01" required>
            </div>
            <div class="col-md-6">
                <label for="id_medicamento" class="form-label">ID Medicamento</label>
                <select id="id_medicamento" name="id_medicamento" class="form-select" required>
                    <option value="">Selecciona un medicamento...</option>
                    <?php foreach ($medicamentos as $medicamento): ?>
                        <option value="<?= htmlspecialchars($medicamento['id']) ?>" <?= $mascota['id_medicamento'] == $medicamento['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($medicamento['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona un medicamento.
                </div>
            </div>
            <div class="col-md-6">
                <label for="cedula_cliente" class="form-label">Cédula del Cliente</label>
                <select id="cedula_cliente" name="cedula_cliente" class="form-select" required>
                    <option value="">Selecciona un cliente...</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= htmlspecialchars($cliente['cedula']) ?>" <?= $mascota['cedula_cliente'] == $cliente['cedula'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cliente['nombres']) ?> (Cédula: <?= htmlspecialchars($cliente['cedula']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona un cliente.
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary w-100" type="submit">Actualizar Mascota</button>
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
