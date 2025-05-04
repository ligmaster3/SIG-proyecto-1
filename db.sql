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

-- Datos iniciales para préstamos
INSERT INTO prestamos (libro_id, estudiante_id, fecha_prestamo, fecha_devolucion_esperada, estado) VALUES
(1, 1, '2023-01-01', '2023-01-15', 'Prestado'),
(2, 2, '2023-02-01', '2023-02-15', 'Entregado'),
(3, 3, '2023-03-01', '2023-03-15', 'Vencido'),
(4, 4, '2023-04-01', '2023-04-15', 'Prestado'),
(5, 5, '2023-05-01', '2023-05-15', 'Entregado');

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

-- Datos iniciales para solicitudes de préstamo
INSERT INTO solicitudes_prestamo (estudiante_id, libro_id, estado, motivo) VALUES
(1, 1, 'pendiente', 'Necesito este libro para un proyecto de investigación.'),
(2, 2, 'aprobada', 'Requerido para un trabajo académico.'),
(3, 3, 'rechazada', 'El libro ya está prestado.'),
(4, 4, 'pendiente', 'Interesado en leer este libro por recomendación.'),
(5, 5, 'aprobada', 'Es parte de la bibliografía del curso.');

-- Datos iniciales para libros
INSERT INTO libros (titulo, autor, editorial, año_publicacion, isbn, categoria_id, estado, ubicacion) VALUES
('Cien años de soledad', 'Gabriel García Márquez', 'Sudamericana', 1967, '9788437604947', 1, 'Disponible', 'A1'),
('El origen de las especies', 'Charles Darwin', 'John Murray', 1859, '9788498920083', 2, 'Disponible', 'B2'),
('Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, '9780132350884', 3, 'Disponible', 'C3'),
('Sapiens: De animales a dioses', 'Yuval Noah Harari', 'Debate', 2011, '9788499926220', 4, 'Disponible', 'D4'),
('La historia del arte', 'E. H. Gombrich', 'Phaidon Press', 1950, '9780714833562', 5, 'Disponible', 'E5');

-- Datos iniciales para estudiantes
INSERT INTO estudiantes (cedula, nombre, apellido, correo, genero, carrera_id, turno, estado) VALUES
('1234567890', 'Juan', 'Pérez', 'juan.perez@example.com', 'M', 1, 'mañana', 'activo'),
('0987654321', 'María', 'Gómez', 'maria.gomez@example.com', 'F', 2, 'tarde', 'activo'),
('1122334455', 'Carlos', 'López', 'carlos.lopez@example.com', 'M', 3, 'noche', 'activo'),
('5566778899', 'Ana', 'Martínez', 'ana.martinez@example.com', 'F', 4, 'mañana', 'activo'),
('6677889900', 'Luis', 'Hernández', 'luis.hernandez@example.com', 'M', 5, 'tarde', 'activo');

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


