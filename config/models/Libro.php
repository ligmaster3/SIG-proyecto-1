<?php
require_once 'config/database.php';

class Libro {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function crear($data) {
        $sql = "INSERT INTO libros (titulo, autor, editorial, año_publicacion, isbn, categoria_id, estado, ubicacion) 
                VALUES (?, ?, ?, ?, ?, ?, 'Disponible', ?)";
        
        $params = [
            $data['titulo'],
            $data['autor'],
            $data['editorial'],
            $data['año_publicacion'],
            $data['isbn'],
            $data['categoria_id'],
            $data['ubicacion']
        ];
        
        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt->affected_rows > 0;
    }
    
    public function obtenerTodos() {
        $sql = "SELECT l.*, c.nombre as categoria FROM libros l 
                JOIN categorias c ON l.categoria_id = c.categoria_id";
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT l.*, c.nombre as categoria FROM libros l 
                JOIN categorias c ON l.categoria_id = c.categoria_id 
                WHERE l.libro_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function actualizar($id, $data) {
        $sql = "UPDATE libros SET 
                titulo = ?, autor = ?, editorial = ?, año_publicacion = ?, 
                isbn = ?, categoria_id = ?, ubicacion = ? 
                WHERE libro_id = ?";
        
        $params = [
            $data['titulo'],
            $data['autor'],
            $data['editorial'],
            $data['año_publicacion'],
            $data['isbn'],
            $data['categoria_id'],
            $data['ubicacion'],
            $id
        ];
        
        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt->affected_rows > 0;
    }
    
    public function eliminar($id) {
        $sql = "DELETE FROM libros WHERE libro_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        return $stmt->affected_rows > 0;
    }
    
    public function buscar($termino) {
        $sql = "SELECT l.*, c.nombre as categoria FROM libros l 
                JOIN categorias c ON l.categoria_id = c.categoria_id 
                WHERE l.titulo LIKE ? OR l.autor LIKE ? OR l.isbn = ?";
        
        $params = ["%$termino%", "%$termino%", $termino];
        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE libros SET estado = ? WHERE libro_id = ?";
        $stmt = $this->db->executeQuery($sql, [$estado, $id]);
        return $stmt->affected_rows > 0;
    }
}
?>