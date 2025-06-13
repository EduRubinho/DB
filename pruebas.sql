USE CINEPLANET;

SELECT 
    c.id AS id_cliente,
    cr.numero_identificacion,
    cr.nombre,
    cr.correo
FROM CLIENTE c
JOIN CLIENTE_REGISTRADO cr ON c.id = cr.id;

SELECT 
    c.id AS id_cliente,
    i.nombre_invitado
FROM CLIENTE c
JOIN INVITADO i ON c.id = i.id_temp;

-- Salas de un cine específico
SELECT nro_sala, capacidad, formato 
FROM SALA
WHERE id_cine = 1;


