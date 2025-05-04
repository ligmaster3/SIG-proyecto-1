<?php
require_once 'config\database.php';

class Reporte {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function obtenerEstadisticasGenerales() {
        $stats = [];
        
        // Total de libros
        $sql = "SELECT COUNT(*) as total FROM libros";
        $stmt = $this->db->executeQuery($sql);
        $stats['total_libros'] = $stmt->get_result()->fetch_assoc()['total'];
        
        // Libros por estado
        $sql = "SELECT estado, COUNT(*) as cantidad FROM libros GROUP BY estado";
        $stmt = $this->db->executeQuery($sql);
        $stats['libros_por_estado'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        // Total de estudiantes
        $sql = "SELECT COUNT(*) as total FROM estudiantes";
        $stmt = $this->db->executeQuery($sql);
        $stats['total_estudiantes'] = $stmt->get_result()->fetch_assoc()['total'];
        
        // Estudiantes por género
        $sql = "SELECT genero, COUNT(*) as cantidad FROM estudiantes GROUP BY genero";
        $stmt = $this->db->executeQuery($sql);
        $stats['estudiantes_por_genero'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        // Préstamos activos
        $sql = "SELECT COUNT(*) as total FROM prestamos WHERE estado = 'Prestado'";
        $stmt = $this->db->executeQuery($sql);
        $stats['prestamos_activos'] = $stmt->get_result()->fetch_assoc()['total'];
        
        return $stats;
    }
    
    public function obtenerPrestamosPorCarrera() {
        $sql = "SELECT c.nombre as carrera, COUNT(p.prestamo_id) as total 
                FROM prestamos p
                JOIN estudiantes e ON p.estudiante_id = e.estudiante_id
                JOIN carreras c ON e.carrera_id = c.carrera_id
                GROUP BY c.nombre
                ORDER BY total DESC";
        
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerPrestamosPorCategoria() {
        $sql = "SELECT cat.nombre as categoria, COUNT(p.prestamo_id) as total 
                FROM prestamos p
                JOIN libros l ON p.libro_id = l.libro_id
                JOIN categorias cat ON l.categoria_id = cat.categoria_id
                GROUP BY cat.nombre
                ORDER BY total DESC";
        
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerPrestamosPorTurno() {
        $sql = "SELECT e.turno, COUNT(p.prestamo_id) as total 
                FROM prestamos p
                JOIN estudiantes e ON p.estudiante_id = e.estudiante_id
                GROUP BY e.turno
                ORDER BY total DESC";
        
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerPrestamosVencidos() {
        $sql = "SELECT p.*, l.titulo, e.nombre as estudiante, 
                DATEDIFF(CURDATE(), p.fecha_devolucion_esperada) as dias_retraso
                FROM prestamos p
                JOIN libros l ON p.libro_id = l.libro_id
                JOIN estudiantes e ON p.estudiante_id = e.estudiante_id
                WHERE p.estado = 'Prestado' 
                AND p.fecha_devolucion_esperada < CURDATE()";
        
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>