<?php
require_once 'models\Estudiante.php';
require_once 'models\Carrera.php';

class EstudiantesController {
    private $model;
    private $carreraModel;
    
    public function __construct() {
        $this->model = new Estudiante();
        $this->carreraModel = new Carrera();
    }
    
    public function index() {
        $estudiantes = $this->model->obtenerTodos();
        require_once 'views\Estudiantes\index.php';
    }
    
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'cedula' => $_POST['cedula'],
                    'nombre' => $_POST['nombre'],
                    'apellido' => $_POST['apellido'],
                    'correo' => $_POST['correo'],
                    'genero' => $_POST['genero'],
                    'carrera_id' => $_POST['carrera_id'],
                    'turno' => $_POST['turno']
                ];
                
                if ($this->model->crear($data, $_FILES['foto'])) {
                    header('Location: index.php?controller=estudiantes&action=index&success=1');
                } else {
                    $error = "Error al crear el estudiante";
                    $carreras = $this->carreraModel->obtenerTodas();
                    require_once 'views\Estudiantes\crear.php';
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
                $carreras = $this->carreraModel->obtenerTodas();
                require_once 'views\Estudiantes\crear.php';
            }
        } else {
            $carreras = $this->carreraModel->obtenerTodas();
            require_once 'views\Estudiantes\crear.php';
        }
    }
    

    public function editar() {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            header('Location: index.php?controller=estudiantes&action=index');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'cedula' => $_POST['cedula'],
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'correo' => $_POST['correo'],
                'genero' => $_POST['genero'],
                'carrera_id' => $_POST['carrera_id'],
                'turno' => $_POST['turno']
            ];
    
            $foto = $_FILES['foto'] ?? null;
    
            if ($this->model->actualizar($id, $data, $foto)) {
                header("Location: index.php?controller=estudiantes&action=index&success=1");
            } else {
                $error = "Error al actualizar.";
                $estudiante = $this->model->obtenerPorId($id);
                $carreras = $this->carreraModel->obtenerTodas();
                require_once 'views/Estudiantes/editar.php';
            }
        }
    
        $estudiante = $this->model->obtenerPorId($id);
        $carreras = $this->carreraModel->obtenerTodas();
        require_once 'views/Estudiantes/editar.php';
    }
    
        
        public function eliminar() {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) throw new Exception('ID no proporcionado');
            $this->model->eliminar($id);
            header('Location: index.php?controller=estudiantes&action=index&success=1'); exit;
        } catch (Exception $e) {
            header('Location: index.php?controller=estudiantes&action=index&error=1'); exit;
        }
    }
    
    public function buscar() {
        $termino = $_GET['q'] ?? '';
        $estudiantes = $this->model->buscar($termino);
        require_once 'views\Estudiantes\index.php';
    }
}
?>