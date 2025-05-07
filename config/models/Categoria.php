<?php
require_once 'config\database.php';

class Categoria {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function obtenerTodas() {
        $sql = "SELECT * FROM categorias ORDER BY nombre";
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function crear($nombre, $descripcion) {
        $sql = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->db->executeQuery($sql, [$nombre, $descripcion]);
        return $stmt->affected_rows > 0;
    }
    
    public function actualizar($id, $nombre, $descripcion) {
        $sql = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE categoria_id = ?";
        $stmt = $this->db->executeQuery($sql, [$nombre, $descripcion, $id]);
        return $stmt->affected_rows > 0;
    }
    
    public function eliminar($id) {
        // Verificar que no haya libros asociados
        $sql_check = "SELECT COUNT(*) as total FROM libros WHERE categoria_id = ?";
        $stmt_check = $this->db->executeQuery($sql_check, [$id]);
        $result = $stmt_check->get_result()->fetch_assoc();
        
        if ($result['total'] > 0) {
            throw new Exception("No se puede eliminar la categoría porque tiene libros asociados");
        }
        
        $sql = "DELETE FROM categorias WHERE categoria_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        return $stmt->affected_rows > 0;
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM categorias WHERE categoria_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        return $stmt->get_result()->fetch_assoc();
    }
}
?>