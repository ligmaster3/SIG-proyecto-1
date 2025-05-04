<?php require_once 'views\layout\header.php'; ?>


<div class="container">
    <h1 class="my-4">Editar Libro: <?= htmlspecialchars($libro['titulo']) ?></h1>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controller=libros&action=editar&id=<?= $libro['libro_id'] ?>" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="titulo">Título <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required
                        value="<?= htmlspecialchars($libro['titulo']) ?>">
                </div>

                <div class="form-group">
                    <label for="autor">Autor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="autor" name="autor" required
                        value="<?= htmlspecialchars($libro['autor']) ?>">
                </div>

                <div class="form-group">
                    <label for="editorial">Editorial</label>
                    <input type="text" class="form-control" id="editorial" name="editorial"
                        value="<?= htmlspecialchars($libro['editorial']) ?>">
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" class="form-control" id="isbn" name="isbn"
                        value="<?= htmlspecialchars($libro['isbn']) ?>">
                    <small class="form-text text-muted">Formato: 978-XXXXXXXXX</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="año_publicacion">Año de Publicación</label>
                    <input type="number" class="form-control" id="año_publicacion" name="año_publicacion"
                        value="<?= htmlspecialchars($libro['año_publicacion']) ?>" min="1900" max="<?= date('Y') ?>">
                </div>

                <div class="form-group">
                    <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                    <select class="form-control" id="categoria_id" name="categoria_id" required>
                        <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['categoria_id'] ?>"
                            <?= ($categoria['categoria_id'] == $libro['categoria_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicación <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required
                        value="<?= htmlspecialchars($libro['ubicacion']) ?>">
                </div>

                <div class="form-group">
                    <label>Estado Actual</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_disponible"
                            value="Disponible" <?= ($libro['estado'] == 'Disponible') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="estado_disponible">Disponible</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_prestado" value="Prestado"
                            <?= ($libro['estado'] == 'Prestado') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="estado_prestado">Prestado</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_vencido" value="Vencido"
                            <?= ($libro['estado'] == 'Vencido') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="estado_vencido">Vencido</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <a href="index.php?controller=libros&action=index" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <a href="index.php?controller=libros&action=eliminar&id=<?= $libro['libro_id'] ?>"
                class="btn btn-danger float-right"
                onclick="return confirm('¿Está seguro de eliminar este libro? Esta acción no se puede deshacer.')">
                <i class="fas fa-trash"></i> Eliminar Libro
            </a>
        </div>
    </form>
</div>

<script>
// Validación básica del ISBN
document.getElementById('isbn').addEventListener('blur', function() {
    const isbn = this.value;
    if (isbn && !/^978-\d{10}$/.test(isbn)) {
        alert('El ISBN debe tener el formato 978- seguido de 10 dígitos');
        this.focus();
    }
});

// Validación del año de publicación
document.getElementById('año_publicacion').addEventListener('change', function() {
    const year = parseInt(this.value);
    const currentYear = new Date().getFullYear();
    if (year && (year < 1900 || year > currentYear)) {
        alert('El año debe estar entre 1900 y ' + currentYear);
        this.value = '';
    }
});

// Confirmación antes de eliminar
document.querySelector('.btn-danger').addEventListener('click', function(e) {
    if (!confirm('¿Está seguro de eliminar este libro permanentemente?')) {
        e.preventDefault();
    }
});
</script>



<?php require_once 'views\layout\footer.php'; ?>