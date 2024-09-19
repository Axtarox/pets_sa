
<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <div class="container">
        <p>&copy; <?php echo date("Y"); ?> PETS S.A. Todos los derechos reservados.</p>
        <ul class="list-unstyled d-inline-flex">
            <li class="mx-2"><a href="clientes.php" class="text-white text-decoration-none">Clientes</a></li>
            <li class="mx-2"><a href="mascotas.php" class="text-white text-decoration-none">Mascotas</a></li>
            <li class="mx-2"><a href="medicamentos.php" class="text-white text-decoration-none">Medicamentos</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li class="mx-2"><a href="auth/logout.php" class="text-white text-decoration-none" onclick="return confirm('¿Estás seguro de cerrar sesión?')">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </div>
</footer>

<!-- Archivos JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
