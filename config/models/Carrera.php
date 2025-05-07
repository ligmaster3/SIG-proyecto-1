<?php
require_once 'config\database.php';

class Carrera {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function obtenerTodas() {
        $sql = "SELECT * FROM carreras ORDER BY nombre";
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM carreras WHERE carrera_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function crear($nombre, $facultad, $descripcion) {
        $sql = "INSERT INTO carreras (nombre, facultad, descripcion) VALUES (?, ?, ?)";
        $stmt = $this->db->executeQuery($sql, [$nombre, $facultad, $descripcion]);
        return $stmt->affected_rows > 0;
    }
    
    public function actualizar($id, $nombre, $facultad, $descripcion) {
        $sql = "UPDATE carreras SET nombre = ?, facultad = ?, descripcion = ? WHERE carrera_id = ?";
        $stmt = $this->db->executeQuery($sql, [$nombre, $facultad, $descripcion, $id]);
        return $stmt->affected_rows > 0;
    }
    
    public function eliminar($id) {
        // Verificar que no haya estudiantes asociados
        $sql_check = "SELECT COUNT(*) as total FROM estudiantes WHERE carrera_id = ?";
        $stmt_check = $this->db->executeQuery($sql_check, [$id]);
        $result = $stmt_check->get_result()->fetch_assoc();
        
        if ($result['total'] > 0) {
            throw new Exception("No se puede eliminar la carrera porque tiene estudiantes asociados");
        }
        
        $sql = "DELETE FROM carreras WHERE carrera_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        return $stmt->affected_rows > 0;
    }
}
?>