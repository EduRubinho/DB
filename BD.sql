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
    FOREIGN KEY(id_temp) REFERENCES CLIENTE(id)
);

-- Tabla CLIENTE_REGISTRADO 
CREATE TABLE CLIENTE_REGISTRADO (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    cineplanet BOOLEAN,
    genero VARCHAR(10),
    FOREIGN KEY (id) REFERENCES CLIENTE(id)
);

-- Tabla CINE
CREATE TABLE CINE(
    id_cine INT AUTO_INCREMENT PRIMARY KEY,
    CP_nombre VARCHAR(30),
    ciudad VARCHAR(30)
);

-- Tabla PELICULA
CREATE TABLE PELICULA(
    id_pelicula INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(30),
    genero VARCHAR(30),
	descripcion TEXT,
	duracion TIME,
	clasificacion VARCHAR(10),
	idioma VARCHAR(30),
	portada VARCHAR(255) -- URL o ruta local de imagen
);

-- Tabla FUNCION
CREATE TABLE FUNCION(
    id_funcion INT AUTO_INCREMENT PRIMARY KEY,
    nombre_funcion VARCHAR(30),
    pelicula_id INT,
    FOREIGN KEY(pelicula_id) REFERENCES PELICULA(id_pelicula)
);

-- Tabla CINE_PELICULA
CREATE TABLE CINE_PELICULA(
    cine_id INT,
    pelicula_id INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    PRIMARY KEY (cine_id, pelicula_id),
    FOREIGN KEY (cine_id) REFERENCES CINE(id_cine),
    FOREIGN KEY (pelicula_id) REFERENCES PELICULA(id_pelicula)
);

-- Tabla VISITA
CREATE TABLE VISITA(
    numero_compras_dia INT,
    cine_id INT,
    cliente_id INT,
    PRIMARY KEY (cine_id, cliente_id),
    FOREIGN KEY (cine_id) REFERENCES CINE(id_cine),
    FOREIGN KEY (cliente_id) REFERENCES CLIENTE(id)
);

-- Tabla BOLETA
CREATE TABLE BOLETA (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    id_cliente INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES CLIENTE(id)
);

-- Tabla SALA
CREATE TABLE SALA(
    id_sala INT,
    id_cine INT NOT NULL,
    capacidad INT,
    formato VARCHAR(30),
    PRIMARY KEY (id_cine, id_sala),
    FOREIGN KEY (id_cine) REFERENCES CINE(id_cine)
);


CREATE TABLE IF NOT EXISTS ADMIN (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100)
);
