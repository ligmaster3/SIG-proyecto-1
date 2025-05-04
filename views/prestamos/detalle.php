<?php require_once '../views/layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Detalle del Préstamo #<?= $prestamo['prestamo_id'] ?></h1>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#info" data-toggle="tab">Información</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#historial" data-toggle="tab">Historial</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Información del Libro</h5>
                            <p>
                                <strong>Título:</strong> <?= htmlspecialchars($prestamo['libro']) ?><br>
                                <strong>Autor:</strong> <?= htmlspecialchars($prestamo['autor']) ?><br>
                                <strong>Categoría:</strong> <?= htmlspecialchars($prestamo['categoria']) ?><br>
                                <strong>ISBN:</strong> <?= htmlspecialchars($prestamo['isbn']) ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h5>Información del Estudiante</h5>
                            <div class="media">
                                <img src="../assets/uploads/<?= $prestamo['foto_path'] ?>" class="mr-3 rounded"
                                    width="64" height="64" alt="<?= htmlspecialchars($prestamo['estudiante']) ?>">
                                <div class="media-body">
                                    <h6><?= htmlspecialchars($prestamo['estudiante']) ?></h6>
                                    <p class="mb-1">
                                        <strong>Cédula:</strong> <?= $prestamo['cedula'] ?><br>
                                        <strong>Carrera:</strong> <?= htmlspecialchars($prestamo['carrera']) ?><br>
                                        <strong>Turno:</strong> <?= ucfirst($prestamo['turno']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Detalles del Préstamo</h5>
                            <p>
                                <strong>Fecha Préstamo:</strong> <?= $prestamo['fecha_prestamo'] ?><br>
                                <strong>Fecha Devolución Esperada:</strong>
                                <span class="<?= 
                                    ($prestamo['estado'] == 'Prestado' && strtotime($prestamo['fecha_devolucion_esperada']) < time()) 
                                    ? 'text-danger font-weight-bold' : '' 
                                ?>">
                                    <?= $prestamo['fecha_devolucion_esperada'] ?>
                                    <?php if (isset($prestamo['dias_retraso']) && $prestamo['dias_retraso'] > 0): ?>
                                    <span class="badge badge-danger">+<?= $prestamo['dias_retraso'] ?> días</span>
                                    <?php endif; ?>
                                </span>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h5>Estado</h5>
                            <p>
                                <span class="badge badge-<?= 
                                    $prestamo['estado'] == 'Entregado' ? 'success' : 
                                    ($prestamo['estado'] == 'Prestado' ? 'warning' : 'danger') 
                                ?>">
                                    <?= $prestamo['estado'] ?>
                                </span>
                            </p>

                            <?php if ($prestamo['fecha_devolucion_real']): ?>
                            <p><strong>Fecha Devolución Real:</strong> <?= $prestamo['fecha_devolucion_real'] ?></p>
                            <?php endif; ?>

                            <?php if ($prestamo['estado'] == 'Prestado'): ?>
                            <a href="index.php?controller=prestamos&action=devolver&id=<?= $prestamo['prestamo_id'] ?>"
                                class="btn btn-success" onclick="return confirm('¿Marcar como devuelto?')">
                                <i class="fas fa-check"></i> Registrar Devolución
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="historial">
                    <h5>Historial de Préstamos</h5>
                    <p>Aquí iría el historial de préstamos de este estudiante con este libro...</p>
                    <!-- Implementar lógica para mostrar historial -->
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="index.php?controller=prestamos&action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>
</div>

<?php require_once '../views/layout/footer.php'; ?>