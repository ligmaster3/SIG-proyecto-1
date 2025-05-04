-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS biblioteca_cruba;
USE biblioteca_cruba;

-- Tabla de categorías
CREATE TABLE categorias (
    categoria_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Tabla de carreras
CREATE TABLE carreras (
    carrera_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    facultad VARCHAR(100),
    descripcion TEXT
);

-- Tabla de libros
CREATE TABLE libros (
    libro_id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    editorial VARCHAR(100),
    año_publicacion INT,
    isbn VARCHAR(20) UNIQUE,
    categoria_id INT,
    estado ENUM('Disponible', 'Prestado', 'Vencido') DEFAULT 'Disponible',
    ubicacion VARCHAR(50),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(categoria_id)
);

-- Tabla de estudiantes
CREATE TABLE estudiantes (
    estudiante_id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE,
    genero ENUM('M', 'F', 'O') NOT NULL,
    carrera_id INT,
    turno ENUM('mañana', 'tarde', 'noche') NOT NULL,
    foto_path VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    FOREIGN KEY (carrera_id) REFERENCES carreras(carrera_id)
);

-- Tabla de préstamos
CREATE TABLE prestamos (
    prestamo_id INT AUTO_INCREMENT PRIMARY KEY,
    libro_id INT NOT NULL,
    estudiante_id INT NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion_esperada DATE NOT NULL,
    fecha_devolucion_real DATE,
    estado ENUM('Prestado', 'Entregado', 'Vencido') DEFAULT 'Prestado',
    FOREIGN KEY (libro_id) REFERENCES libros(libro_id),
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(estudiante_id)
);

-- Tabla de solicitudes de préstamo
CREATE TABLE solicitudes_prestamo (
    solicitud_id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'aprobada', 'rechazada') DEFAULT 'pendiente',
    motivo TEXT,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(estudiante_id),
    FOREIGN KEY (libro_id) REFERENCES libros(libro_id)
);

-- Datos iniciales
INSERT INTO categorias (nombre, descripcion) VALUES 
('Literatura', 'Obras literarias, novelas, poesía, etc.'),
('Ciencias', 'Libros sobre ciencias naturales y exactas'),
('Tecnología', 'Libros sobre tecnología e informática'),
('Historia', 'Libros sobre historia universal y local'),
('Arte', 'Libros sobre arte, música y cultura');

INSERT INTO carreras (nombre, facultad) VALUES 
('Ingeniería de Sistemas', 'Ingeniería'),
('Medicina', 'Ciencias de la Salud'),
('Derecho', 'Ciencias Jurídicas'),
('Administración', 'Ciencias Económicas'),
('Psicología', 'Ciencias Sociales');