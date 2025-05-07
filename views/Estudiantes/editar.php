<?php require_once 'views\layout\header.php'; ?>

<div class="container">
    <h1 class="my-4">Editar Estudiante</h1>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controller=estudiantes&action=editar&id=<?= $estudiante['estudiante_id'] ?>" method="post"
        enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cedula">Cédula</label>
                    <input type="text" class="form-control" id="cedula" name="cedula"
                        value="<?= htmlspecialchars($estudiante['cedula']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="<?= htmlspecialchars($estudiante['nombre']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido"
                        value="<?= htmlspecialchars($estudiante['apellido']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo"
                        value="<?= htmlspecialchars($estudiante['correo'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="genero">Género</label>
                    <select class="form-control" id="genero" name="genero" required>
                        <option value="M" <?= ($estudiante['genero'] == 'M') ? 'selected' : '' ?>>Masculino</option>
                        <option value="F" <?= ($estudiante['genero'] == 'F') ? 'selected' : '' ?>>Femenino</option>
                        <option value="O" <?= ($estudiante['genero'] == 'O') ? 'selected' : '' ?>>Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="carrera_id">Carrera</label>
                    <select class="form-control" id="carrera_id" name="carrera_id" required>
                        <?php foreach ($carreras as $carrera): ?>
                        <option value="<?= $carrera['carrera_id'] ?>"
                            <?= ($carrera['carrera_id'] == $estudiante['carrera_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($carrera['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="turno">Turno</label>
                    <select class="form-control" id="turno" name="turno" required>
                        <option value="mañana" <?= ($estudiante['turno'] == 'mañana') ? 'selected' : '' ?>>Mañana
                        </option>
                        <option value="tarde" <?= ($estudiante['turno'] == 'tarde') ? 'selected' : '' ?>>Tarde</option>
                        <option value="noche" <?= ($estudiante['turno'] == 'noche') ? 'selected' : '' ?>>Noche</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="foto">Foto del Estudiante</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
                        <label class="custom-file-label" for="foto">Seleccionar nueva foto (opcional)</label>
                    </div>
                    <small class="form-text text-muted">
                        Foto actual:
                        <?php if ($estudiante['foto_path']): ?>
                        <a href="assets/uploads/<?= $estudiante['foto_path'] ?>" target="_blank">Ver foto</a>
                        <?php else: ?>
                        No tiene foto registrada
                        <?php endif; ?>
                    </small>
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_activo" value="activo"
                            <?= ($estudiante['estado'] == 'activo') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="estado_activo">Activo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_inactivo" value="inactivo"
                            <?= ($estudiante['estado'] == 'inactivo') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="estado_inactivo">Inactivo</label>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?controller=estudiantes&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
// Muestra el nombre del archivo seleccionado en el input file
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("foto").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});

// Validación básica del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    const cedula = document.getElementById('cedula').value;
    if (!/^\d+$/.test(cedula)) {
        alert('La cédula debe contener solo números');
        e.preventDefault();
    }
});
</script>

<?php require_once 'views\layout\footer.php'; ?>