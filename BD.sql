CREATE DATABASE if not exists CINEPLANET;
USE CINEPLANET;

CREATE TABLE CLIENTE (
    id int auto_increment primary key
    
    
);


CREATE TABLE INVITADO(
	id_temp int primary key,
    nombre_invitado varchar(20),
	foreign key(id_temp) references CLIENTE(id)
);


CREATE TABLE CLIENTE_REGISTRADO (
    id int primary key,
    numero_identificacion varchar(20) not null unique,
    nombre varchar(100),
    correo varchar(100),
    foreign key (id) references CLIENTE(id)
);

CREATE TABLE CINE(
    id_cine int auto_increment primary key,
    CP_nombre varchar(30),
    ciudad varchar(30)
);


CREATE TABLE PELICULA(
	id_pelicula int primary key,
    titulo varchar(30),
    genero varchar(30)
);


CREATE TABLE FUNCION(
	id_funcion int primary key,
    nombre_funcion varchar(30),
    pelicula_id int,
    foreign key(pelicula_id) references PELICULA(id_pelicula)
);



CREATE TABLE CINE_PELICULA(
	cine_id int,
    pelicula_id int,
    fecha_inicio date,
    fecha_fin date,
    
    primary key (cine_id, pelicula_id),
    foreign key (cine_id) references CINE(id_cine),
    foreign key (pelicula_id) references PELICULA(id_pelicula)
    
);


CREATE TABLE VISITA(

	numero_compras_dia int,
    cine_id int,
    cliente_id int,
    primary key (cine_id, cliente_id),
    foreign key (cine_id) references CINE(id_cine),
    foreign key (cliente_id) references CLIENTE(id)    
);


CREATE TABLE BOLETA (
    id int auto_increment primary key,
    fecha datetime not null,
    id_cliente int not null,
    total decimal(10,2) not null,
	foreign key (id_cliente) references CLIENTE(id)
);


    

CREATE TABLE SALA(
    id_sala int,
    id_cine int not null,
    
    capacidad int,
    formato varchar(30),
    foreign key (id_cine) references CINE(id_cine),
    primary key (id_cine, nro_sala)
);