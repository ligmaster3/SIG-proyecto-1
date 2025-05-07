<?php require_once 'views\layout\header.php'; ?>

<div class="container">
    <h1 class="my-4">Gestión de Libros</h1>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Operación realizada con éxito</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Ocurrió un error al realizar la operación</div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-6">
            <a href="index.php?controller=libros&action=crear" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Libro
            </a>
        </div>
        <div class="col-md-6">
            <form class="form-inline float-right" method="get" action="index.php">
                <input type="hidden" name="controller" value="libros">
                <input type="hidden" name="action" value="buscar">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Buscar libros..."
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
                <th>Título</th>
                <th>Autor</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro): ?>
            <tr>
                <td><?= $libro['libro_id'] ?></td>
                <td><?= htmlspecialchars($libro['titulo']) ?></td>
                <td><?= htmlspecialchars($libro['autor']) ?></td>
                <td><?= htmlspecialchars($libro['categoria']) ?></td>
                <td>
                    <span class="badge badge-<?= 
                            $libro['estado'] == 'Disponible' ? 'success' : 
                            ($libro['estado'] == 'Prestado' ? 'warning' : 'danger') 
                        ?>">
                        <?= $libro['estado'] ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?controller=libros&action=editar&id=<?= $libro['libro_id'] ?>"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?controller=libros&action=eliminar&id=<?= $libro['libro_id'] ?>"
                        class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este libro?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views\layout\footer.php'; ?>