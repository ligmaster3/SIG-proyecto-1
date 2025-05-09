<?php

require_once "config/database.php";

class Estudiante
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function crear($data, $foto)
    {
        try {
            $foto_path = $this->guardarFoto($foto);
        } catch (Exception $e) {
            throw new Exception("Error al guardar foto: " . $e->getMessage());
        }

        $sql = "INSERT INTO estudiantes 
                (cedula, nombre, apellido, correo, genero, carrera_id, turno, foto_path) 
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

        if ($stmt->affected_rows <= 0) {
            throw new Exception("No se insertó ningún registro.");
        }
        return $stmt->affected_rows > 0;
    }

    public function editar($id, $data)
    {
        $sql = "UPDATE estudiantes SET 
                cedula = ?, nombre = ?, apellido = ?, correo = ?, genero = ?, carrera_id = ?, turno = ? 
                WHERE estudiante_id = ?";
        $params = [
            $data['cedula'],
            $data['nombre'],
            $data['apellido'],
            $data['correo'],
            $data['genero'],
            $data['carrera_id'],
            $data['turno'],
            $id
        ];

        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt && $stmt->affected_rows > 0;
    }
    
    public function actualizar($id, array $data, ?array $foto = null): bool {
        // Cargar datos actuales
        $actual = $this->obtenerPorId($id);
        if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
            $newPath = $this->guardarFoto($foto);
            $data['foto_path'] = $newPath;
            // eliminar anterior
            $oldFile = 'assets/uploads/' . $actual['foto_path'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        unset($data['estudiante_id']);
        $fields = [];
        $params = [];
        foreach ($data as $k => $v) {
            $fields[] = "$k = ?";
            $params[] = $v;
        }
        $sql = "UPDATE estudiantes SET " . implode(', ', $fields) . " WHERE estudiante_id = ?";
        $params[] = $id;
        $stmt = $this->db->executeQuery($sql, $params);
        return $stmt->affected_rows > 0;
    }

    
   
    public function guardarFoto($foto)
    {
        $target_dir = "assets/uploads/";
        $imageFileType = strtolower(pathinfo($foto["name"], PATHINFO_EXTENSION));

        // Generar nombre único para la imagen
        $new_filename = uniqid() . '.' . $imageFileType;
        $new_target = $target_dir . $new_filename;

        // Verificar si es una imagen real
        $check = getimagesize($foto["tmp_name"]);
        if ($check === false) {
            throw new Exception("El archivo no es una imagen.");
        }

        // Verificar tamaño (500KB máximo)
        if ($foto["size"] > 500000) {
            throw new Exception("La imagen es demasiado grande. Máximo 500KB permitidos.");
        }

        // Permitir ciertos formatos
        $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            throw new Exception("Solo se permiten formatos: " . implode(', ', $allowed_types));
        }

        if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0755, true)) {
                throw new Exception("No se pudo crear el directorio de destino.");
            }
        }

        // Mover el archivo subido
        if (!move_uploaded_file($foto["tmp_name"], $new_target)) {

            throw new Exception("Error al subir la imagen.");
        }

        return $new_filename;
    }

    public function eliminar($id): bool {
        // cargar para path
        $est = $this->obtenerPorId($id);
        $sql = "DELETE FROM estudiantes WHERE estudiante_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        if ($stmt->affected_rows > 0) {
            $file = 'assets/uploads/' . $est['foto_path'];
            if (file_exists($file)) unlink($file);
            return true;
        }
        return false;
    }
    
    public function obtenerTodos()
    {
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiantes e 
                JOIN carreras c ON e.carrera_id = c.carrera_id
                ORDER BY e.apellido, e.nombre";
        $stmt = $this->db->executeQuery($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiantes e 
                JOIN carreras c ON e.carrera_id = c.carrera_id 
                WHERE e.estudiante_id = ?";
        $stmt = $this->db->executeQuery($sql, [$id]);
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Estudiante no encontrado");
        }

        return $result->fetch_assoc();
    }

    public function buscar($termino)
    {
        $sql = "SELECT e.*, c.nombre as carrera FROM estudiantes e 
                JOIN carreras c ON e.carrera_id = c.carrera_id 
                WHERE e.cedula LIKE ? OR e.nombre LIKE ? OR e.apellido LIKE ?
                ORDER BY e.apellido, e.nombre";

        $searchTerm = "%$termino%";
        $stmt = $this->db->executeQuery($sql, [$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}