<?php require_once '../views/layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Registrar Nuevo Préstamo</h1>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controller=prestamos&action=crear" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="libro_id">Libro</label>
                    <select class="form-control" id="libro_id" name="libro_id" required>
                        <option value="">Seleccione un libro</option>
                        <?php foreach ($libros as $libro): ?>
                        <option value="<?= $libro['libro_id'] ?>">
                            <?= htmlspecialchars($libro['titulo']) ?> - <?= htmlspecialchars($libro['autor']) ?>
                            (<?= $libro['estado'] ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text text-muted">Solo se muestran libros disponibles</small>
                </div>

                <div class="form-group">
                    <label for="fecha_prestamo">Fecha de Préstamo</label>
                    <input type="date" class="form-control" id="fecha_prestamo" name="fecha_prestamo"
                        value="<?= date('Y-m-d') ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="estudiante_id">Estudiante</label>
                    <select class="form-control" id="estudiante_id" name="estudiante_id" required>
                        <option value="">Seleccione un estudiante</option>
                        <?php foreach ($estudiantes as $estudiante): ?>
                        <option value="<?= $estudiante['estudiante_id'] ?>">
                            <?= htmlspecialchars($estudiante['nombre'] . ' ' . $estudiante['apellido']) ?>
                            (<?= htmlspecialchars($estudiante['cedula']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha_devolucion_esperada">Fecha de Devolución Esperada</label>
                    <input type="date" class="form-control" id="fecha_devolucion_esperada"
                        name="fecha_devolucion_esperada" value="<?= date('Y-m-d', strtotime('+15 days')) ?>" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Préstamo</button>
        <a href="index.php?controller=prestamos&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
// Validación para asegurar que la fecha de devolución sea posterior a la de préstamo
document.getElementById('fecha_devolucion_esperada').addEventListener('change', function() {
    const fechaPrestamo = new Date(document.getElementById('fecha_prestamo').value);
    const fechaDevolucion = new Date(this.value);

    if (fechaDevolucion <= fechaPrestamo) {
        alert('La fecha de devolución debe ser posterior a la fecha de préstamo');
        this.value = '';
    }
});
</script>

<?php require_once '../views/layout/footer.php'; ?>