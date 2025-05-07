<?php
require_once 'models\Reporte.php';
require_once 'models\Estudiante.php';
require_once 'models\Libro.php';
require_once 'models\Prestamo.php';

class ReportesController {
    private $reporteModel;
    private $estudianteModel;
    private $libroModel;
    private $prestamoModel;
    
    public function __construct() {
        $this->reporteModel = new Reporte();
        $this->estudianteModel = new Estudiante();
        $this->libroModel = new Libro();
        $this->prestamoModel = new Prestamo();
    }
    
    public function index() {
        $tipo = $_GET['tipo'] ?? 'general';
        
        switch ($tipo) {
            case 'general':
                $data = $this->reporteModel->obtenerEstadisticasGenerales();
                break;
            case 'carreras':
                $data = $this->reporteModel->obtenerPrestamosPorCarrera();
                break;
            case 'categorias':
                $data = $this->reporteModel->obtenerPrestamosPorCategoria();
                break;
            case 'turnos':
                $data = $this->reporteModel->obtenerPrestamosPorTurno();
                break;
            case 'vencidos':
                $data = $this->prestamoModel->obtenerPrestamosVencidos();
                break;
            default:
                $data = $this->reporteModel->obtenerEstadisticasGenerales();
        }
        
        require_once 'views\reportes\index.php';
    }
    
    public function exportar() {
        $tipo = $_GET['tipo'] ?? 'general';
        $formato = $_GET['formato'] ?? 'pdf';
        
        // Lógica para generar reportes exportables
        // Esta es una implementación básica, deberías usar librerías como:
        // - TCPDF o Dompdf para PDF
        // - PhpSpreadsheet para Excel
        
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Reporte generado']);
    }
}
?>