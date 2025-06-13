USE CINEPLANET;
DELETE FROM CLIENTE_REGISTRADO WHERE id > 0;
-- o cualquier condición que seleccione todos los registros
DELETE FROM INVITADO WHERE id_temp>0;
DELETE FROM CLIENTE WHERE id > 0;

INSERT INTO CLIENTE VALUES ();
SET @id1 = LAST_INSERT_ID();
INSERT INTO INVITADO (id_temp, nombre_invitado) VALUES (@id1, 'Pedro');

INSERT INTO CLIENTE VALUES ();
SET @id2 = LAST_INSERT_ID();
INSERT INTO INVITADO (id_temp, nombre_invitado) VALUES (@id2, 'Luis');

INSERT INTO CLIENTE VALUES ();
SET @id3 = LAST_INSERT_ID();
INSERT INTO INVITADO (id_temp, nombre_invitado) VALUES (@id3, 'Ana');

-- Insertar 3 clientes registrados
INSERT INTO CLIENTE VALUES ();
SET @id4 = LAST_INSERT_ID();
INSERT INTO CLIENTE_REGISTRADO (id, numero_identificacion, nombre, correo)
VALUES (@id4, '12345678', 'Lucía Fernández', 'lucia@example.com');

INSERT INTO CLIENTE VALUES ();
SET @id5 = LAST_INSERT_ID();
INSERT INTO CLIENTE_REGISTRADO (id, numero_identificacion, nombre, correo)
VALUES (@id5, '23456789', 'Jorge Soto', 'jorge@example.com');

INSERT INTO CLIENTE VALUES ();
SET @id6 = LAST_INSERT_ID();
INSERT INTO CLIENTE_REGISTRADO (id, numero_identificacion, nombre, correo)
VALUES (@id6, '34567890', 'Sandra Ruiz', 'sandra@example.com');


insert into CINE (CP_nombre, ciudad) values 
('CinePlanet Lima', 'Lima'),
('CineStar Arequipa', 'Arequipa');

insert into SALA (id_cine, nro_sala, capacidad, formato) VALUES 
(1, 1, 120, '2D'),
(1, 2, 80, '3D'),
(1, 3, 200, 'IMAX');

-- Insertar salas para el segundo cine
INSERT INTO SALA (id_cine, nro_sala, capacidad, formato) VALUES 
(2, 1, 150, '2D'),
(2, 2, 100, '4DX');