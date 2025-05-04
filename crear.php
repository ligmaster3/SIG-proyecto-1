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
                    <label for="cedula">Cédula</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" required>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>

                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="genero">Género</label>
                    <select class="form-control" id="genero" name="genero" required>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="O">Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="carrera_id">Carrera</label>
                    <select class="form-control" id="carrera_id" name="carrera_id" required>
                        <?php foreach ($carreras as $carrera): ?>
                            <option value="<?= $carrera['carrera_id'] ?>"><?= htmlspecialchars($carrera['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="turno">Turno</label>
                    <select class="form-control" id="turno" name="turno" required>
                        <option value="mañana">Mañana</option>
                        <option value="tarde">Tarde</option>
                        <option value="noche">Noche</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="foto">Foto del Estudiante</label>
                    <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php?controller=estudiantes&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once '../views/layout/footer.php'; ?>