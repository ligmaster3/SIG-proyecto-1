<?php require_once 'views\layout\header.php'; ?>

<div class="container">
    <h1 class="my-4">Préstamos Vencidos</h1>

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        Se muestran los préstamos que no han sido devueltos en la fecha esperada.
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0">Listado de Préstamos Vencidos</h5>
                </div>
                <div class="col-md-6 text-right">
                    <a href="index.php?controller=reportes&action=exportar&tipo=vencidos&formato=pdf"
                        class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf"></i> Exportar a PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Libro</th>
                        <th>Estudiante</th>
                        <th>Fecha Préstamo</th>
                        <th>Fecha Devolución</th>
                        <th>Días de Retraso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prestamos as $prestamo): ?>
                    <tr>
                        <td><?= $prestamo['prestamo_id'] ?></td>
                        <td><?= htmlspecialchars($prestamo['libro']) ?></td>
                        <td><?= htmlspecialchars($prestamo['estudiante']) ?></td>
                        <td><?= $prestamo['fecha_prestamo'] ?></td>
                        <td class="text-danger font-weight-bold">
                            <?= $prestamo['fecha_devolucion_esperada'] ?>
                        </td>
                        <td class="text-danger font-weight-bold">
                            <?= $prestamo['dias_retraso'] ?>
                        </td>
                        <td>
                            <a href="index.php?controller=prestamos&action=devolver&id=<?= $prestamo['prestamo_id'] ?>"
                                class="btn btn-sm btn-success" onclick="return confirm('¿Marcar como devuelto?')">
                                <i class="fas fa-check"></i> Devolver
                            </a>
                            <a href="index.php?controller=prestamos&action=detalle&id=<?= $prestamo['prestamo_id'] ?>"
                                class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer text-muted">
            Total de préstamos vencidos: <?= count($prestamos) ?>
        </div>
    </div>

    <a href="index.php?controller=prestamos&action=index" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al listado general
    </a>
</div>

<?php require_once '../views/layout/footer.php'; ?>