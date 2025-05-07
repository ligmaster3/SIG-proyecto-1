<?php require_once 'views\layout\header.php'; ?>

<div class="container">
    <h1 class="my-4">Reportes Gerenciales</h1>

    <ul class="nav nav-tabs" id="reportTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?= ($tipo == 'general') ? 'active' : '' ?>"
                href="index.php?controller=reportes&action=index&tipo=general">
                General
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tipo == 'carreras') ? 'active' : '' ?>"
                href="index.php?controller=reportes&action=index&tipo=carreras">
                Por Carrera
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tipo == 'categorias') ? 'active' : '' ?>"
                href="index.php?controller=reportes&action=index&tipo=categorias">
                Por Categoría
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tipo == 'turnos') ? 'active' : '' ?>"
                href="index.php?controller=reportes&action=index&tipo=turnos">
                Por Turno
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tipo == 'vencidos') ? 'active' : '' ?>"
                href="index.php?controller=reportes&action=index&tipo=vencidos">
                Préstamos Vencidos
            </a>
        </li>
    </ul>

    <div class="tab-content p-3 border border-top-0 rounded-bottom">
        <div class="tab-pane fade show active">
            <?php if ($tipo == 'general'): ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Libros</div>
                        <div class="card-body">
                            <h5 class="card-title">Total: <?= $data['total_libros'] ?></h5>
                            <ul class="list-unstyled">
                                <?php foreach ($data['libros_por_estado'] as $estado): ?>
                                <li><?= $estado['estado'] ?>: <?= $estado['cantidad'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Estudiantes</div>
                        <div class="card-body">
                            <h5 class="card-title">Total: <?= $data['total_estudiantes'] ?></h5>
                            <ul class="list-unstyled">
                                <?php foreach ($data['estudiantes_por_genero'] as $genero): ?>
                                <li><?= ($genero['genero'] == 'M') ? 'Hombres' : (($genero['genero'] == 'F') ? 'Mujeres' : 'Otros') ?>:
                                    <?= $genero['cantidad'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Préstamos</div>
                        <div class="card-body">
                            <h5 class="card-title">Activos: <?= $data['prestamos_activos'] ?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <?php elseif (in_array($tipo, ['carreras', 'categorias', 'turnos'])): ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th><?= ($tipo == 'carreras') ? 'Carrera' : (($tipo == 'categorias') ? 'Categoría' : 'Turno') ?>
                        </th>
                        <th>Total de Préstamos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item[($tipo == 'carreras') ? 'carrera' : (($tipo == 'categorias') ? 'categoria' : 'turno')]) ?>
                        </td>
                        <td><?= $item['total'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php elseif ($tipo == 'vencidos'): ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Libro</th>
                        <th>Estudiante</th>
                        <th>Fecha Préstamo</th>
                        <th>Fecha Devolución</th>
                        <th>Días de Retraso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $prestamo): ?>
                    <tr>
                        <td><?= htmlspecialchars($prestamo['libro']) ?></td>
                        <td><?= htmlspecialchars($prestamo['estudiante']) ?></td>
                        <td><?= $prestamo['fecha_prestamo'] ?></td>
                        <td><?= $prestamo['fecha_devolucion_esperada'] ?></td>
                        <td class="text-danger font-weight-bold"><?= $prestamo['dias_retraso'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <div class="mt-3">
                <a href="index.php?controller=reportes&action=exportar&tipo=<?= $tipo ?>&formato=pdf"
                    class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Exportar a PDF
                </a>
                <a href="index.php?controller=reportes&action=exportar&tipo=<?= $tipo ?>&formato=excel"
                    class="btn btn-success ml-2">
                    <i class="fas fa-file-excel"></i> Exportar a Excel
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views\layout\footer.php'; ?>