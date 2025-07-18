-- ESQUEMA MEJORADO CINEPLANET CON ELIMINACIÓN EN CASCADA
CREATE DATABASE IF NOT EXISTS CINEPLANET;
USE CINEPLANET;

-- Tabla CLIENTE
CREATE TABLE CLIENTE (
    id INT AUTO_INCREMENT PRIMARY KEY
);

-- Tabla INVITADO
CREATE TABLE INVITADO(
    id_temp INT PRIMARY KEY,
    nombre_invitado VARCHAR(20),
    FOREIGN KEY(id_temp) REFERENCES CLIENTE(id) ON DELETE CASCADE
);

-- Tabla CLIENTE_REGISTRADO 
CREATE TABLE CLIENTE_REGISTRADO (
    id INT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido_paterno VARCHAR(100),
    apellido_materno VARCHAR(100),
    correo VARCHAR(100),
    password VARCHAR(255),
    tipo_documento VARCHAR(20),
    DNI VARCHAR(20) UNIQUE,
    dv VARCHAR(10),
    fecha_nacimiento DATE,
    celular VARCHAR(20),
    departamento VARCHAR(50),
    provincia VARCHAR(50),
    distrito VARCHAR(50),
    cineplanet VARCHAR(50),
    genero VARCHAR(10),
    FOREIGN KEY (id) REFERENCES CLIENTE(id) ON DELETE CASCADE
);

-- Tabla CINE
CREATE TABLE CINE(
    id_cine INT AUTO_INCREMENT PRIMARY KEY,
    CP_nombre VARCHAR(30),
    ciudad VARCHAR(30)
);

-- Tabla SALA
CREATE TABLE SALA(
    id_sala INT AUTO_INCREMENT PRIMARY KEY,
    id_cine INT NOT NULL,
    capacidad INT,
    formato VARCHAR(30),
    FOREIGN KEY (id_cine) REFERENCES CINE(id_cine) ON DELETE CASCADE
);

-- Tabla PELICULAS
CREATE TABLE peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    genero VARCHAR(100),
    duracion INT,
    director VARCHAR(255),
    fecha_estreno DATE,
    imagen VARCHAR(255),
    clasificacion VARCHAR(10),
    estado ENUM('activa', 'inactiva') DEFAULT 'activa'
);

-- Tabla FUNCION - ⚡ CAMBIO CLAVE AQUÍ
CREATE TABLE funcion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pelicula INT NOT NULL,
    id_sala INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    precio DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (id_pelicula) REFERENCES peliculas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sala) REFERENCES SALA(id_sala) ON DELETE CASCADE
);

-- Tabla ASIENTOS - ⚡ CAMBIO CLAVE AQUÍ
CREATE TABLE asientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    funcion_id INT,
    fila CHAR(1),
    numero INT,
    estado ENUM('libre', 'ocupado') DEFAULT 'libre',
    FOREIGN KEY (funcion_id) REFERENCES funcion(id) ON DELETE CASCADE
);

-- Tabla BOLETA
CREATE TABLE BOLETA (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    id_cliente INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES CLIENTE(id) ON DELETE CASCADE
);

-- Tabla RESERVAS - ⚡ CAMBIO CLAVE AQUÍ
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    asiento_id INT,
    boleta_id INT,
    fecha_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES CLIENTE(id) ON DELETE CASCADE,
    FOREIGN KEY (asiento_id) REFERENCES asientos(id) ON DELETE CASCADE,
    FOREIGN KEY (boleta_id) REFERENCES BOLETA(id) ON DELETE CASCADE
);

-- Tabla CINE_PELICULA - ⚡ CAMBIO CLAVE AQUÍ
CREATE TABLE CINE_PELICULA(
    cine_id INT,
    pelicula_id INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    PRIMARY KEY (cine_id, pelicula_id),
    FOREIGN KEY (cine_id) REFERENCES CINE(id_cine) ON DELETE CASCADE,
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id) ON DELETE CASCADE
);

-- Tabla PRODUCTOS_DULCERIA
CREATE TABLE productos_dulceria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(5,2) NOT NULL,
    imagen VARCHAR(255),
    categoria ENUM('bebidas', 'snacks', 'dulces', 'combos') DEFAULT 'snacks'
);

-- Tabla BOLETA_PRODUCTOS - ⚡ CAMBIO CLAVE AQUÍ
CREATE TABLE boleta_productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    boleta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT DEFAULT 1,
    precio_unitario DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (boleta_id) REFERENCES BOLETA(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos_dulceria(id) ON DELETE CASCADE
);

-- Tabla ADMIN
CREATE TABLE ADMIN (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100)
);