<?php require_once '../views/layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Solicitudes de Préstamo</h1>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?= ($_GET['estado'] ?? '') == 'pendientes' ? 'active' : '' ?>"
                href="index.php?controller=prestamos&action=solicitudes&estado=pendientes">
                Pendientes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($_GET['estado'] ?? '') == 'aprobadas' ? 'active' : '' ?>"
                href="index.php?controller=prestamos&action=solicitudes&estado=aprobadas">
                Aprobadas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($_GET['estado'] ?? '') == 'rechazadas' ? 'active' : '' ?>"
                href="index.php?controller=prestamos&action=solicitudes&estado=rechazadas">
                Rechazadas
            </a>
        </li>
    </ul>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Libro</th>
                <th>Estudiante</th>
                <th>Fecha Solicitud</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($solicitudes as $solicitud): ?>
            <tr>
                <td><?= $solicitud['solicitud_id'] ?></td>
                <td><?= htmlspecialchars($solicitud['libro']) ?></td>
                <td><?= htmlspecialchars($solicitud['estudiante']) ?></td>
                <td><?= $solicitud['fecha_solicitud'] ?></td>
                <td>
                    <span class="badge badge-<?= 
                            $solicitud['estado'] == 'aprobada' ? 'success' : 
                            ($solicitud['estado'] == 'pendiente' ? 'warning' : 'danger') 
                        ?>">
                        <?= ucfirst($solicitud['estado']) ?>
                    </span>
                </td>
                <td>
                    <?php if ($solicitud['estado'] == 'pendiente'): ?>
                    <div class="btn-group btn-group-sm">
                        <a href="index.php?controller=prestamos&action=aprobar_solicitud&id=<?= $solicitud['solicitud_id'] ?>"
                            class="btn btn-success" onclick="return confirm('¿Aprobar esta solicitud?')">
                            <i class="fas fa-check"></i>
                        </a>
                        <a href="index.php?controller=prestamos&action=rechazar_solicitud&id=<?= $solicitud['solicitud_id'] ?>"
                            class="btn btn-danger" onclick="return confirm('¿Rechazar esta solicitud?')">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                    <a href="#" class="btn btn-info btn-sm" data-toggle="modal"
                        data-target="#detalleSolicitud<?= $solicitud['solicitud_id'] ?>">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>

            <!-- Modal Detalle Solicitud -->
            <div class="modal fade" id="detalleSolicitud<?= $solicitud['solicitud_id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalle de Solicitud #<?= $solicitud['solicitud_id'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Información del Libro</h6>
                                    <p>
                                        <strong>Título:</strong> <?= htmlspecialchars($solicitud['libro']) ?><br>
                                        <strong>ID:</strong> <?= $solicitud['libro_id'] ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Información del Estudiante</h6>
                                    <p>
                                        <strong>Nombre:</strong> <?= htmlspecialchars($solicitud['estudiante']) ?><br>
                                        <strong>Cédula:</strong> <?= $solicitud['cedula'] ?>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Fecha Solicitud:</strong> <?= $solicitud['fecha_solicitud'] ?></p>
                                    <p>
                                        <strong>Estado:</strong>
                                        <span class="badge badge-<?= 
                                                $solicitud['estado'] == 'aprobada' ? 'success' : 
                                                ($solicitud['estado'] == 'pendiente' ? 'warning' : 'danger') 
                                            ?>">
                                            <?= ucfirst($solicitud['estado']) ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <?php if ($solicitud['motivo']): ?>
                                    <p><strong>Motivo:</strong> <?= htmlspecialchars($solicitud['motivo']) ?></p>
                                    <?php endif; ?>
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

<?php require_once '../views/layout/footer.php'; ?>