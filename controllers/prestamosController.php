<?php
require_once 'models\Prestamo.php';
require_once 'models\Libro.php';
require_once 'models\Estudiante.php';

class PrestamosController {
    private $prestamoModel;
    private $libroModel;
    private $estudianteModel;
    
    public function __construct() {
        $this->prestamoModel = new Prestamo();
        $this->libroModel = new Libro();
        $this->estudianteModel = new Estudiante();
    }
    
    public function index() {
        $prestamos = $this->prestamoModel->obtenerTodos();
        require_once 'views\prestamos\index.php';
    }
    
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'libro_id' => $_POST['libro_id'],
                'estudiante_id' => $_POST['estudiante_id'],
                'fecha_prestamo' => date('Y-m-d'),
                'fecha_devolucion_esperada' => date('Y-m-d', strtotime('+15 days')),
                'estado' => 'Prestado'
            ];
            
            if ($this->prestamoModel->crear($data)) {
                // Actualizar estado del libro
                $this->libroModel->cambiarEstado($data['libro_id'], 'Prestado');
                
                header('Location: index.php?controller=prestamos&action=index&success=1');
            } else {
                $error = "Error al registrar el préstamo";
                $libros = $this->libroModel->obtenerDisponibles();
                $estudiantes = $this->estudianteModel->obtenerTodos();
                require_once 'views\prestamos\crear.php';
            }
        } else {
            $libros = $this->libroModel->obtenerDisponibles();
            $estudiantes = $this->estudianteModel->obtenerTodos();
            require_once 'views\prestamos\crear.php';
        }
    }
    
    public function devolver() {
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $prestamo = $this->prestamoModel->obtenerPorId($id);
            
            if ($prestamo && $prestamo['estado'] !== 'Entregado') {
                $data = [
                    'fecha_devolucion_real' => date('Y-m-d'),
                    'estado' => 'Entregado'
                ];
                
                if ($this->prestamoModel->actualizar($id, $data)) {
                    // Actualizar estado del libro
                    $this->libroModel->cambiarEstado($prestamo['libro_id'], 'Disponible');
                    
                    header('Location: index.php?controller=prestamos&action=index&success=1');
                    exit;
                }
            }
        }
        
        header('Location: index.php?controller=prestamos&action=index&error=1');
    }
    
    public function reportes() {
        $reporte = $_GET['tipo'] ?? 'general';
        
        switch ($reporte) {
            case 'vencidos':
                $data = $this->prestamoModel->obtenerTodos();
                break;
            case 'carreras':
                $data = $this->prestamoModel->obtenerTodos();
                break;
            case 'categorias':
                $data = $this->prestamoModel->obtenerTodos();
                break;
            default:
                $data = $this->prestamoModel->obtenerEstadisticasGenerales();
        }
        
        require_once 'views\reportes\index.php';
    }
}
?>