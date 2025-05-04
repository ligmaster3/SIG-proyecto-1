<?php require_once 'views\layout\header.php'; ?>


<div class="container">
    <h1 class="my-4">Registrar Nuevo Libro</h1>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controller=libros&action=crear" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="titulo">Título <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required
                        value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>" placeholder="Ej: Cien años de soledad">
                </div>

                <div class="form-group">
                    <label for="autor">Autor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="autor" name="autor" required
                        value="<?= htmlspecialchars($_POST['autor'] ?? '') ?>" placeholder="Ej: Gabriel García Márquez">
                </div>

                <div class="form-group">
                    <label for="editorial">Editorial</label>
                    <input type="text" class="form-control" id="editorial" name="editorial"
                        value="<?= htmlspecialchars($_POST['editorial'] ?? '') ?>" placeholder="Ej: Sudamericana">
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" class="form-control" id="isbn" name="isbn"
                        value="<?= htmlspecialchars($_POST['isbn'] ?? '') ?>" placeholder="Ej: 978-0307474278">
                    <small class="form-text text-muted">Formato: 978-XXXXXXXXX</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="año_publicacion">Año de Publicación</label>
                    <input type="number" class="form-control" id="año_publicacion" name="año_publicacion"
                        value="<?= htmlspecialchars($_POST['año_publicacion'] ?? '') ?>" min="1900"
                        max="<?= date('Y') ?>" placeholder="Ej: 1967">
                </div>

                <div class="form-group">
                    <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                    <select class="form-control" id="categoria_id" name="categoria_id" required>
                        <option value="">Seleccione una categoría...</option>
                        <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['categoria_id'] ?>"
                            <?= (($_POST['categoria_id'] ?? '') == $categoria['categoria_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicación <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required
                        value="<?= htmlspecialchars($_POST['ubicacion'] ?? '') ?>"
                        placeholder="Ej: Estante 4, Sección B">
                    <small class="form-text text-muted">Indique dónde se encuentra físicamente el libro</small>
                </div>

                <div class="form-group">
                    <label>Estado Inicial</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_disponible"
                            value="Disponible" checked>
                        <label class="form-check-label" for="estado_disponible">Disponible</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_prestado" value="Prestado"
                            disabled>
                        <label class="form-check-label text-muted" for="estado_prestado">Prestado (no aplica para
                            nuevos)</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Registrar Libro
            </button>
            <a href="index.php?controller=libros&action=index" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
// Validación básica del ISBN (formato simplificado)
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
</script>

<?php require_once 'views\layout\footer.php'; ?>