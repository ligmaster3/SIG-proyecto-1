<?php
// filepath: c:\Users\eniga\OneDrive\Documentos\GitHub\SIG-proyecto\controllers\librosController.php
require_once 'models\Libro.php';    

class LibrosController {
    private $model;
    
    public function __construct() {
        $this->model = new Libro();
    }
    
    public function index() {
        $libros = $this->model->obtenerTodos();
        require_once 'views\Libros\index.php';
    }
    
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titulo' => $_POST['titulo'],
                'autor' => $_POST['autor'],
                'editorial' => $_POST['editorial'],
                'año_publicacion' => $_POST['año_publicacion'],
                'isbn' => $_POST['isbn'],
                'categoria_id' => $_POST['categoria_id'],
                'ubicacion' => $_POST['ubicacion']
            ];
            
            if ($this->model->crear($data)) {
                header('Location: index.php?controller=libros&action=index&success=1');
            } else {
                $error = "Error al crear el libro";
                require_once 'views\Libros\crear.php';
            }
        } else {
            require_once 'views\Libros\crear.php';
        }
    }
    
    public function editar() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: index.php?controller=libros&action=index');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titulo' => $_POST['titulo'],
                'autor' => $_POST['autor'],
                'editorial' => $_POST['editorial'],
                'año_publicacion' => $_POST['año_publicacion'],
                'isbn' => $_POST['isbn'],
                'categoria_id' => $_POST['categoria_id'],
                'ubicacion' => $_POST['ubicacion']
            ];
            
            if ($this->model->actualizar($id, $data)) {
                header('Location: index.php?controller=libros&action=index&success=1');
            } else {
                $error = "Error al actualizar el libro";
                $libro = $this->model->obtenerPorId($id);
                require_once 'views\Libros\editar.php';
            }
        } else {
            $libro = $this->model->obtenerPorId($id);
           require_once 'views\Libros\editar.php';
        }
    }
    
    public function eliminar() {
        $id = $_GET['id'] ?? null;
        
        if ($id && $this->model->eliminar($id)) {
            header('Location: index.php?controller=libros&action=index&success=1');
        } else {
            header('Location: index.php?controller=libros&action=index&error=1');
        }
    }
    
    public function buscar() {
        $termino = $_GET['q'] ?? '';
        $libros = $this->model->buscar($termino);
        require_once 'views\Libros\index.php';
    }
}
?>