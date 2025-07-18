-- POBLAR BASE DE DATOS CINEPLANET
USE CINEPLANET;

-- =====================================================
-- 🏢 TABLA CINE (10 cines en diferentes ciudades)
-- =====================================================
INSERT INTO CINE (CP_nombre, ciudad) VALUES
('Cineplanet Centro Lima', 'Lima'),
('Cineplanet Jockey Plaza', 'Lima'),
('Cineplanet Mall Aventura', 'Lima'),
('Cineplanet San Miguel', 'Lima'),
('Cineplanet Arequipa Center', 'Arequipa'),
('Cineplanet Plaza Norte', 'Lima'),
('Cineplanet Cusco', 'Cusco'),
('Cineplanet Trujillo Mall', 'Trujillo'),
('Cineplanet Chiclayo', 'Chiclayo'),
('Cineplanet Piura', 'Piura');

-- =====================================================
-- 🎪 TABLA SALA (40 salas distribuidas en los cines)
-- =====================================================
INSERT INTO SALA (id_cine, capacidad, formato) VALUES
-- Cine 1: Centro Lima (4 salas)
(1, 120, '2D Estándar'),
(1, 150, '3D'),
(1, 80, 'VIP'),
(1, 200, 'IMAX'),

-- Cine 2: Jockey Plaza (5 salas)
(2, 140, '2D Estándar'),
(2, 160, '3D'),
(2, 90, 'VIP'),
(2, 220, 'IMAX'),
(2, 110, '4DX'),

-- Cine 3: Mall Aventura (4 salas)
(3, 130, '2D Estándar'),
(3, 145, '3D'),
(3, 85, 'VIP'),
(3, 180, 'IMAX'),

-- Cine 4: San Miguel (3 salas)
(4, 100, '2D Estándar'),
(4, 120, '3D'),
(4, 70, 'VIP'),

-- Cine 5: Arequipa Center (4 salas)
(5, 110, '2D Estándar'),
(5, 135, '3D'),
(5, 75, 'VIP'),
(5, 190, 'IMAX'),

-- Cine 6: Plaza Norte (5 salas)
(6, 125, '2D Estándar'),
(6, 155, '3D'),
(6, 95, 'VIP'),
(6, 210, 'IMAX'),
(6, 115, '4DX'),

-- Cine 7: Cusco (3 salas)
(7, 95, '2D Estándar'),
(7, 115, '3D'),
(7, 65, 'VIP'),

-- Cine 8: Trujillo Mall (4 salas)
(8, 105, '2D Estándar'),
(8, 125, '3D'),
(8, 80, 'VIP'),
(8, 175, 'IMAX'),

-- Cine 9: Chiclayo (3 salas)
(9, 90, '2D Estándar'),
(9, 110, '3D'),
(9, 60, 'VIP'),

-- Cine 10: Piura (3 salas)
(10, 85, '2D Estándar'),
(10, 105, '3D'),
(10, 55, 'VIP');

-- =====================================================
-- 🎬 TABLA PELICULAS (30 películas variadas)
-- =====================================================
INSERT INTO peliculas (titulo, descripcion, genero, duracion, director, fecha_estreno, imagen, clasificacion, estado) VALUES
-- Estrenos 2024
('Avatar: El Camino del Agua', 'Jake Sully vive con su nueva familia formada en el planeta Pandora. Cuando una amenaza familiar regresa para terminar lo que empezó anteriormente, Jake debe trabajar con Neytiri y el ejército de la raza Navi para proteger su planeta.', 'Ciencia Ficción', 192, 'James Cameron', '2024-01-15', 'avatar2.jpg', 'PG-13', 'activa'),

('Top Gun: Maverick', 'Después de más de 30 años de servicio como uno de los mejores aviadores de la Marina, Pete "Maverick" Mitchell está donde pertenece, empujando los límites como un valiente piloto de prueba.', 'Acción', 130, 'Joseph Kosinski', '2024-01-20', 'topgun.jpg', 'PG-13', 'activa'),

('Black Panther: Wakanda Forever', 'La reina Ramonda, Shuri, MBaku, Okoye y las Dora Milaje luchan por proteger su nación de la intervención de las potencias mundiales tras la muerte del rey TChalla.', 'Superhéroes', 161, 'Ryan Coogler', '2024-02-01', 'blackpanther2.jpg', 'PG-13', 'activa'),

('Minions: El Origen de Gru', 'La historia no contada de un fanboy de 12 años llamado Gru, que sueña con convertirse en un supervillano.', 'Animación', 87, 'Kyle Balda', '2024-02-10', 'minions2.jpg', 'G', 'activa'),

('Doctor Strange: Multiverso de la Locura', 'El Dr. Stephen Strange continúa su investigación sobre la Gema del Tiempo. Pero un viejo amigo convertido en enemigo pone fin a sus planes y hace que Strange desate un mal indescriptible.', 'Superhéroes', 126, 'Sam Raimi', '2024-02-15', 'drstrange2.jpg', 'PG-13', 'activa'),

('Jurassic World: Dominion', 'Cuatro años después de la destrucción de Isla Nublar, los dinosaurios ahora viven y cazan junto a los humanos en todo el mundo.', 'Aventura', 147, 'Colin Trevorrow', '2024-03-01', 'jurassic3.jpg', 'PG-13', 'activa'),

('Thor: Amor y Trueno', 'Thor emprende un viaje diferente a todo lo que ha enfrentado: una búsqueda de la paz interior. Pero su retiro se ve interrumpido por un asesino galáctico conocido como Gorr el Carnicero de Dioses.', 'Superhéroes', 119, 'Taika Waititi', '2024-03-10', 'thor4.jpg', 'PG-13', 'activa'),

('Lightyear', 'La historia de origen definitiva de Buzz Lightyear, el héroe que inspiró el juguete, siguiendo al legendado Space Ranger después de ser varado en un planeta hostil con su comandante y su tripulación.', 'Animación', 105, 'Angus MacLane', '2024-03-15', 'lightyear.jpg', 'G', 'activa'),

('Morbius', 'Bioquímico Michael Morbius trata de curarse de una rara enfermedad de la sangre, pero inadvertidamente se infecta con una forma de vampirismo.', 'Horror', 104, 'Daniel Espinosa', '2024-04-01', 'morbius.jpg', 'PG-13', 'activa'),

('Sonic 2: La Película', 'Después de establecerse en Green Hills, Sonic está ansioso por demostrar que tiene lo necesario para ser un verdadero héroe.', 'Aventura', 122, 'Jeff Fowler', '2024-04-10', 'sonic2.jpg', 'G', 'activa'),

-- Películas de Terror
('Scream 6', 'Los hermanos Carpenter y sus amigos se convierten en los nuevos objetivos de Ghostface.', 'Horror', 123, 'Matt Bettinelli-Olpin', '2024-04-15', 'scream6.jpg', 'R', 'activa'),

('El Conjuro 4', 'Ed y Lorraine Warren se enfrentan a uno de los casos más terroríficos de sus carreras.', 'Horror', 112, 'Michael Chaves', '2024-05-01', 'conjuring4.jpg', 'R', 'activa'),

('M3GAN', 'Una ingeniera en robótica de una empresa de juguetes construye una muñeca realista que comienza a tomar vida propia.', 'Horror', 102, 'Gerard Johnstone', '2024-05-10', 'm3gan.jpg', 'PG-13', 'activa'),

-- Comedias
('La Sirenita', 'Una joven sirena que sueña con la vida en la superficie intercambia su voz por piernas humanas.', 'Musical', 135, 'Rob Marshall', '2024-05-20', 'sirenita.jpg', 'G', 'activa'),

('Guardianes de la Galaxia Vol. 3', 'Peter Quill, aún conmocionado por la pérdida de Gamora, debe reunir a su equipo para defender el universo.', 'Superhéroes', 150, 'James Gunn', '2024-06-01', 'guardianes3.jpg', 'PG-13', 'activa'),

('Fast X', 'Dom Toretto y su familia se enfrentan al oponente más letal que jamás hayan enfrentado.', 'Acción', 141, 'Louis Leterrier', '2024-06-10', 'fastx.jpg', 'PG-13', 'activa'),

('Spider-Man: A Través del Spider-Verso', 'Miles Morales regresa para la próxima aventura en la saga ganadora del Oscar.', 'Animación', 140, 'Joaquim Dos Santos', '2024-06-15', 'spiderverse2.jpg', 'PG', 'activa'),

('Indiana Jones 5', 'El arqueólogo más famoso del mundo regresa en una nueva aventura.', 'Aventura', 154, 'James Mangold', '2024-07-01', 'indiana5.jpg', 'PG-13', 'activa'),

('Transformers: El Despertar de las Bestias', 'Los Autobots y Decepticons regresan en una nueva épica batalla.', 'Acción', 127, 'Steven Caple Jr.', '2024-07-10', 'transformers7.jpg', 'PG-13', 'activa'),

('Misión Imposible 7', 'Ethan Hunt y su equipo del FMI emprenden su misión más peligrosa hasta la fecha.', 'Acción', 163, 'Christopher McQuarrie', '2024-07-15', 'misionimposible7.jpg', 'PG-13', 'activa'),

-- Dramas
('Oppenheimer', 'La historia del físico teórico J. Robert Oppenheimer y su papel en el desarrollo de la bomba atómica.', 'Drama', 180, 'Christopher Nolan', '2024-08-01', 'oppenheimer.jpg', 'R', 'activa'),

('Barbie', 'Barbie vive en Barbieland donde todo es perfecto y rosa. Un día, comienza a tener pensamientos sobre la muerte.', 'Comedia', 114, 'Greta Gerwig', '2024-08-10', 'barbie.jpg', 'PG-13', 'activa'),

('El Exorcista: El Creyente', 'Cuando dos niñas desaparecen en un bosque y regresan tres días después sin recordar lo que pasó, sus padres buscan respuestas.', 'Horror', 111, 'David Gordon Green', '2024-08-15', 'exorcista2023.jpg', 'R', 'activa'),

('Saw X', 'John Kramer regresa en la secuela más retorcida de la franquicia.', 'Horror', 118, 'Kevin Greutert', '2024-09-01', 'sawx.jpg', 'R', 'activa'),

('El Nun 2', 'La hermana Irene regresa para enfrentar a la malévola fuerza demoníaca Valak.', 'Horror', 110, 'Michael Chaves', '2024-09-10', 'nun2.jpg', 'R', 'activa'),

-- Películas familiares
('Elemental', 'En una ciudad donde conviven residentes de fuego, agua, tierra y aire, una joven ardiente y un chico fluido descubrirán algo elemental.', 'Animación', 103, 'Peter Sohn', '2024-09-15', 'elemental.jpg', 'G', 'activa'),

('Super Mario Bros: La Película', 'Una película animada basada en el popular videojuego, que sigue las aventuras de Mario y Luigi.', 'Animación', 92, 'Aaron Horvath', '2024-10-01', 'mario.jpg', 'G', 'activa'),

('Dungeons & Dragons: Honor Among Thieves', 'Un ladrón encantador y una banda de aventureros improbables emprenden una épica búsqueda para recuperar una reliquia perdida.', 'Aventura', 134, 'Jonathan Goldstein', '2024-10-10', 'dungeons.jpg', 'PG-13', 'activa'),

('John Wick 4', 'John Wick descubre un camino para derrotar a la Mesa Alta. Pero antes de ganar su libertad, Wick debe enfrentarse a un nuevo enemigo.', 'Acción', 169, 'Chad Stahelski', '2024-10-15', 'johnwick4.jpg', 'R', 'activa'),

('Creed III', 'Adonis Creed ha prosperado tanto en su carrera como en su vida familiar. Cuando emerge del pasado un amigo de la infancia y antiguo prodigio del boxeo, el enfrentamiento es más que una pelea.', 'Drama', 116, 'Michael B. Jordan', '2024-11-01', 'creed3.jpg', 'PG-13', 'activa');

-- =====================================================
-- 🍿 TABLA PRODUCTOS_DULCERIA (50 productos variados)
-- =====================================================
INSERT INTO productos_dulceria (nombre, precio, imagen, categoria) VALUES
-- 🥤 BEBIDAS (15 productos)
('Coca Cola Personal 350ml', 4.50, 'coca_cola_350.jpg', 'bebidas'),
('Coca Cola Mediana 500ml', 6.50, 'coca_cola_500.jpg', 'bebidas'),
('Coca Cola Grande 750ml', 8.50, 'coca_cola_750.jpg', 'bebidas'),
('Sprite Personal 350ml', 4.50, 'sprite_350.jpg', 'bebidas'),
('Sprite Mediana 500ml', 6.50, 'sprite_500.jpg', 'bebidas'),
('Fanta Personal 350ml', 4.50, 'fanta_350.jpg', 'bebidas'),
('Fanta Mediana 500ml', 6.50, 'fanta_500.jpg', 'bebidas'),
('Inca Kola Personal 350ml', 4.50, 'inca_350.jpg', 'bebidas'),
('Inca Kola Mediana 500ml', 6.50, 'inca_500.jpg', 'bebidas'),
('Inca Kola Grande 750ml', 8.50, 'inca_750.jpg', 'bebidas'),
('Agua San Luis 500ml', 3.50, 'agua_sanluis.jpg', 'bebidas'),
('Powerade Azul 500ml', 5.50, 'powerade_azul.jpg', 'bebidas'),
('Powerade Rojo 500ml', 5.50, 'powerade_rojo.jpg', 'bebidas'),
('Jugo Frugos Durazno', 4.00, 'frugos_durazno.jpg', 'bebidas'),
('Jugo Frugos Manzana', 4.00, 'frugos_manzana.jpg', 'bebidas'),

-- 🍿 SNACKS (15 productos)
('Canchita Personal', 8.50, 'canchita_personal.jpg', 'snacks'),
('Canchita Mediana', 12.50, 'canchita_mediana.jpg', 'snacks'),
('Canchita Grande', 16.50, 'canchita_grande.jpg', 'snacks'),
('Canchita Familiar', 22.00, 'canchita_familiar.jpg', 'snacks'),
('Canchita Dulce Personal', 9.50, 'canchita_dulce_pers.jpg', 'snacks'),
('Canchita Dulce Mediana', 13.50, 'canchita_dulce_med.jpg', 'snacks'),
('Nachos con Queso', 11.50, 'nachos_queso.jpg', 'snacks'),
('Nachos Supreme', 15.50, 'nachos_supreme.jpg', 'snacks'),
('Hot Dog Clásico', 12.00, 'hotdog_clasico.jpg', 'snacks'),
('Hot Dog Premium', 16.00, 'hotdog_premium.jpg', 'snacks'),
('Hamburguesa Cinema', 18.50, 'hamburguesa_cinema.jpg', 'snacks'),
('Salchipapa', 14.50, 'salchipapa.jpg', 'snacks'),
('Papas Fritas Personales', 7.50, 'papas_personales.jpg', 'snacks'),
('Papas Fritas Medianas', 10.50, 'papas_medianas.jpg', 'snacks'),
('Tequeños (6 unidades)', 13.50, 'tequenos.jpg', 'snacks'),

-- 🍬 DULCES (10 productos)
('M&Ms Chocolate 45g', 6.50, 'mms_chocolate.jpg', 'dulces'),
('M&Ms Maní 45g', 6.50, 'mms_mani.jpg', 'dulces'),
('Snickers 50g', 5.50, 'snickers.jpg', 'dulces'),
('Kit Kat 42g', 5.00, 'kitkat.jpg', 'dulces'),
('Twix 50g', 5.50, 'twix.jpg', 'dulces'),
('Skittles 61g', 6.00, 'skittles.jpg', 'dulces'),
('Haribo Ositos 100g', 7.50, 'haribo_ositos.jpg', 'dulces'),
('Chicles Trident', 3.50, 'trident.jpg', 'dulces'),
('Pastillas Tic Tac', 4.00, 'tictac.jpg', 'dulces'),
('Chocolate Sublime', 4.50, 'sublime.jpg', 'dulces'),

-- 🎁 COMBOS (10 productos)
('Combo Personal: Canchita + Bebida', 15.50, 'combo_personal.jpg', 'combos'),
('Combo Mediano: Canchita + Bebida', 21.50, 'combo_mediano.jpg', 'combos'),
('Combo Grande: Canchita + Bebida', 27.50, 'combo_grande.jpg', 'combos'),
('Combo Familiar: Canchita + 2 Bebidas', 35.50, 'combo_familiar.jpg', 'combos'),
('Combo Dulce: Canchita Dulce + Bebida', 22.50, 'combo_dulce.jpg', 'combos'),
('Combo Hot Dog: Hot Dog + Papas + Bebida', 25.50, 'combo_hotdog.jpg', 'combos'),
('Combo Hamburguesa: Hamburguesa + Papas + Bebida', 32.50, 'combo_hamburguesa.jpg', 'combos'),
('Combo Nachos: Nachos + Bebida', 19.50, 'combo_nachos.jpg', 'combos'),
('Combo Pareja: 2 Canchitas + 2 Bebidas + Dulces', 45.50, 'combo_pareja.jpg', 'combos'),
('Combo Súper: Canchita Grande + 2 Bebidas + Hot Dog', 55.50, 'combo_super.jpg', 'combos');
