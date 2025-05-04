<?php
require_once '../config/database.php';

class Estudiante {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function crear($data, $foto) {
        $foto_path = $this->guardarFoto($foto);
        
        $sql = "INSERT INTO estudiantes (cedula, nombre, apellido, correo, genero, carrera_id, turno, foto_path) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['cedula'],
            $data['nombre'],
            $data['apellido'],
            $data['correo'],
            $data['genero'],
            $data['carrera_id'],
            $data['turno'],
            $foto_path
        ];
        
        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt->affected_rows > 0;
    }
    
    private function guardarFoto($foto) {
        $target_dir = "../assets/uploads/";
        $target_file = $target_dir . basename($foto["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Generar nombre único para la imagen
        $new_filename = uniqid() . '.' . $imageFileType;
        $new_target = $target_dir . $new_filename;
        
        // Verificar si es una imagen real
        $check = getimagesize($foto["tmp_name"]);
        if ($check === false) {
            throw new Exception("El archivo no es una imagen.");
        }
        
        // Verificar tamaño
        if ($foto["size"] > 500000) {
            throw new Exception("La imagen es demasiado grande.");
        }
        
        // Permitir ciertos formatos
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            throw new Exception("Solo se permiten formatos JPG, JPEG, PNG y GIF.");
        }
        
        if (move_uploaded_file($foto["tmp_name"], $new_target)) {
            return $new_filename;
        } else {
            throw new Exception("Error al subir la imagen.");
        }
    }
    
    public function obtenerTodos() {
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiantes e 
                JOIN carreras c ON e.carrera_id = c.carrera_id";
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiantes e 
                JOIN carreras c ON e.carrera_id = c.carrera_id 
                WHERE e.estudiante_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function buscar($termino) {
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiantes e 
                JOIN carreras c ON e.carrera_id = c.carrera_id 
                WHERE e.cedula LIKE ? OR e.nombre LIKE ? OR e.apellido LIKE ?";
        
        $params = ["%$termino%", "%$termino%", "%$termino%"];
        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}


?>