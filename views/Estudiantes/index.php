<?php require_once 'views\layout\header.php'; ?>

<div class="container">
    <h1 class="my-4">Gestión de Estudiantes</h1>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Operación realizada con éxito</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Ocurrió un error al realizar la operación</div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-6">
            <a href="index.php?controller=estudiantes&action=crear" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Estudiante
            </a>
        </div>
        <div class="col-md-6">
            <form class="form-inline float-right" method="get" action="index.php">
                <input type="hidden" name="controller" value="estudiantes">
                <input type="hidden" name="action" value="buscar">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Buscar estudiantes..."
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Turno</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudiantes as $estudiante): ?>
            <tr>
                <td><?= $estudiante['estudiante_id'] ?></td>
                <td><?= htmlspecialchars($estudiante['cedula']) ?></td>
                <td><?= htmlspecialchars($estudiante['nombre'] . ' ' . $estudiante['apellido']) ?></td>
                <td><?= htmlspecialchars($estudiante['carrera']) ?></td>
                <td><?= ucfirst(htmlspecialchars($estudiante['turno'])) ?></td>
                <td>
                    <a href="index.php?controller=estudiantes&action=editar&id=<?= $estudiante['estudiante_id'] ?>"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?controller=estudiantes&action=eliminar&id=<?= $estudiante['estudiante_id'] ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('¿Está seguro de eliminar este estudiante?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views\layout\footer.php'; ?>