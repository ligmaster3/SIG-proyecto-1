<?php require_once 'views\layout\header.php'; ?>

<div class="container">
    <h1 class="my-4">Gestión de Préstamos</h1>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Operación realizada con éxito</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Ocurrió un error al realizar la operación</div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-6">
            <a href="index.php?controller=prestamos&action=crear" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Préstamo
            </a>
        </div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="index.php?controller=prestamos&action=index&estado=activos"
                    class="btn btn-<?= ($_GET['estado'] ?? '') == 'activos' ? 'info' : 'outline-info' ?>">
                    Activos
                </a>
                <a href="index.php?controller=prestamos&action=index&estado=vencidos"
                    class="btn btn-<?= ($_GET['estado'] ?? '') == 'vencidos' ? 'danger' : 'outline-danger' ?>">
                    Vencidos
                </a>
                <a href="index.php?controller=prestamos&action=index&estado=finalizados"
                    class="btn btn-<?= ($_GET['estado'] ?? '') == 'finalizados' ? 'success' : 'outline-success' ?>">
                    Finalizados
                </a>
                <a href="index.php?controller=prestamos&action=index"
                    class="btn btn-<?= !isset($_GET['estado']) ? 'secondary' : 'outline-secondary' ?>">
                    Todos
                </a>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Libro</th>
                <th>Estudiante</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamos as $prestamo): ?>
            <tr>
                <td><?= $prestamo['prestamo_id'] ?></td>
                <td><?= htmlspecialchars($prestamo['libro']) ?></td>
                <td>
                    <?= htmlspecialchars($prestamo['estudiante']) ?>
                    <small class="text-muted d-block"><?= $prestamo['cedula'] ?></small>
                </td>
                <td><?= $prestamo['fecha_prestamo'] ?></td>
                <td>
                    <?= $prestamo['fecha_devolucion_esperada'] ?>
                    <?php if (isset($prestamo['dias_retraso']) && $prestamo['dias_retraso'] > 0): ?>
                    <span class="badge badge-danger">+<?= $prestamo['dias_retraso'] ?> días</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge badge-<?= 
                            $prestamo['estado'] == 'Entregado' ? 'success' : 
                            ($prestamo['estado'] == 'Prestado' ? 'warning' : 'danger') 
                        ?>">
                        <?= $prestamo['estado'] ?>
                    </span>
                </td>
                <td>
                    <?php if ($prestamo['estado'] == 'Prestado'): ?>
                    <a href="index.php?controller=prestamos&action=devolver&id=<?= $prestamo['prestamo_id'] ?>"
                        class="btn btn-sm btn-success" onclick="return confirm('¿Marcar como devuelto?')">
                        <i class="fas fa-check"></i> Devolver
                    </a>
                    <?php endif; ?>
                    <a href="#" class="btn btn-sm btn-info" data-toggle="modal"
                        data-target="#detallePrestamo<?= $prestamo['prestamo_id'] ?>">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>

            <!-- Modal Detalle Préstamo -->
            <div class="modal fade" id="detallePrestamo<?= $prestamo['prestamo_id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalle del Préstamo #<?= $prestamo['prestamo_id'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Información del Libro</h6>
                                    <p>
                                        <strong>Título:</strong> <?= htmlspecialchars($prestamo['libro']) ?><br>
                                        <strong>ID:</strong> <?= $prestamo['libro_id'] ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Información del Estudiante</h6>
                                    <p>
                                        <strong>Nombre:</strong> <?= htmlspecialchars($prestamo['estudiante']) ?><br>
                                        <strong>Cédula:</strong> <?= $prestamo['cedula'] ?>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Fecha Préstamo:</strong> <?= $prestamo['fecha_prestamo'] ?></p>
                                    <p><strong>Fecha Devolución Esperada:</strong>
                                        <?= $prestamo['fecha_devolucion_esperada'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <?php if ($prestamo['fecha_devolucion_real']): ?>
                                    <p><strong>Fecha Devolución Real:</strong> <?= $prestamo['fecha_devolucion_real'] ?>
                                    </p>
                                    <?php endif; ?>
                                    <p>
                                        <strong>Estado:</strong>
                                        <span class="badge badge-<?= 
                                                $prestamo['estado'] == 'Entregado' ? 'success' : 
                                                ($prestamo['estado'] == 'Prestado' ? 'warning' : 'danger') 
                                            ?>">
                                            <?= $prestamo['estado'] ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views\layout\footer.php'; ?>