<?php require_once '../views/layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Registrar Nuevo Estudiante</h1>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controller=estudiantes&action=crear" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cedula">Cédula <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="cedula" name="cedula"
                        value="<?= htmlspecialchars($_POST['cedula'] ?? '') ?>" required placeholder="Ej: 1234567890">
                    <small class="form-text text-muted">Sin guiones ni espacios</small>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required placeholder="Ej: María">
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="apellido" name="apellido"
                        value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>" required placeholder="Ej: González">
                </div>

                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo"
                        value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>"
                        placeholder="Ej: estudiante@universidad.edu">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="genero">Género <span class="text-danger">*</span></label>
                    <select class="form-control" id="genero" name="genero" required>
                        <option value="">Seleccione...</option>
                        <option value="M" <?= (($_POST['genero'] ?? '') == 'M') ? 'selected' : '' ?>>Masculino</option>
                        <option value="F" <?= (($_POST['genero'] ?? '') == 'F') ? 'selected' : '' ?>>Femenino</option>
                        <option value="O" <?= (($_POST['genero'] ?? '') == 'O') ? 'selected' : '' ?>>Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="carrera_id">Carrera <span class="text-danger">*</span></label>
                    <select class="form-control" id="carrera_id" name="carrera_id" required>
                        <option value="">Seleccione una carrera...</option>
                        <?php foreach ($carreras as $carrera): ?>
                        <option value="<?= $carrera['carrera_id'] ?>"
                            <?= (($_POST['carrera_id'] ?? '') == $carrera['carrera_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($carrera['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="turno">Turno <span class="text-danger">*</span></label>
                    <select class="form-control" id="turno" name="turno" required>
                        <option value="">Seleccione...</option>
                        <option value="mañana" <?= (($_POST['turno'] ?? '') == 'mañana') ? 'selected' : '' ?>>Mañana
                        </option>
                        <option value="tarde" <?= (($_POST['turno'] ?? '') == 'tarde') ? 'selected' : '' ?>>Tarde
                        </option>
                        <option value="noche" <?= (($_POST['turno'] ?? '') == 'noche') ? 'selected' : '' ?>>Noche
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="foto">Foto del Estudiante <span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*" required>
                        <label class="custom-file-label" for="foto">Seleccionar archivo...</label>
                    </div>
                    <small class="form-text text-muted">
                        Formatos aceptados: JPG, PNG (Máx. 500KB)
                    </small>
                </div>
            </div>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="confirmacion" required>
            <label class="form-check-label" for="confirmacion">Confirmo que los datos ingresados son correctos</label>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Registrar Estudiante
            </button>
            <a href="index.php?controller=estudiantes&action=index" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
// Muestra el nombre del archivo seleccionado
document.getElementById('foto').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});

// Validación del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    const cedula = document.getElementById('cedula').value;
    const foto = document.getElementById('foto').files[0];

    // Validar cédula (solo números)
    if (!/^\d+$/.test(cedula)) {
        alert('La cédula debe contener solo números');
        e.preventDefault();
        return;
    }

    // Validar tamaño de foto (max 500KB)
    if (foto && foto.size > 500000) {
        alert('La imagen es demasiado grande (máximo 500KB permitido)');
        e.preventDefault();
        return;
    }

    // Validar tipo de archivo
    const validTypes = ['image/jpeg', 'image/png'];
    if (foto && !validTypes.includes(foto.type)) {
        alert('Solo se permiten archivos JPG o PNG');
        e.preventDefault();
    }
});
</script>

<?php require_once '../views/layout/footer.php'; ?>