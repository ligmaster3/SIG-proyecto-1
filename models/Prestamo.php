<?php
require_once 'config\database.php';

class Prestamo {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function crear($data) {
        $sql = "INSERT INTO prestamos (libro_id, estudiante_id, fecha_prestamo, fecha_devolucion_esperada, estado) 
                VALUES (?, ?, ?, ?, ?)";
        
        $params = [
            $data['libro_id'],
            $data['estudiante_id'],
            $data['fecha_prestamo'],
            $data['fecha_devolucion_esperada'],
            $data['estado']
        ];
        
        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt->affected_rows > 0;
    }
    
    public function obtenerTodos() {
        $sql = "SELECT p.*, l.titulo as libro, e.nombre as estudiante, e.cedula
                FROM prestamos p
                JOIN libros l ON p.libro_id = l.libro_id
                JOIN estudiantes e ON p.estudiante_id = e.estudiante_id
                ORDER BY p.fecha_prestamo DESC";
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT p.*, l.titulo as libro, e.nombre as estudiante, e.cedula
                FROM prestamos p
                JOIN libros l ON p.libro_id = l.libro_id
                JOIN estudiantes e ON p.estudiante_id = e.estudiante_id
                WHERE p.prestamo_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function actualizar($id, $data) {
        $sql = "UPDATE prestamos SET 
                fecha_devolucion_real = ?,
                estado = ?
                WHERE prestamo_id = ?";
        
        $params = [
            $data['fecha_devolucion_real'],
            $data['estado'],
            $id
        ];
        
        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt->affected_rows > 0;
    }
    
    public function obtenerPrestamosActivos() {
        $sql = "SELECT p.*, l.titulo as libro, e.nombre as estudiante
                FROM prestamos p
                JOIN libros l ON p.libro_id = l.libro_id
                JOIN estudiantes e ON p.estudiante_id = e.estudiante_id
                WHERE p.estado = 'Prestado'";
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerPrestamosVencidos() {
        $sql = "SELECT p.*, l.titulo as libro, e.nombre as estudiante,
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