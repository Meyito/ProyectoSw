<?php
$conexion = mysqli_connect("localhost","root","") or die (("Error " . mysqli_error($conexion)));
$creacion = "CREATE DATABASE Lavanderia";
mysqli_query($conexion,$creacion);
mysqli_close($conexion);

$conexion = mysqli_connect("localhost","root","","Lavanderia") or die(("Error " . mysqli_error($conexion)));
//Creacion tabla Estado
$tabla = "CREATE TABLE Estado(
	codigo varchar(5),
	nombre varchar(20) NOT NULL,
	descripcion varchar(100),
	PRIMARY KEY(codigo)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Bodega
$tabla = "CREATE TABLE Bodega(
	codigo varchar(5),
	nombre int NOT NULL,
	descripcion varchar(100),
	PRIMARY KEY(codigo)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Foto
$tabla = "CREATE TABLE Foto(
	codigo varchar(5),
	url varchar(100) NOT NULL,
	PRIMARY KEY(codigo)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Diseño
$tabla = "CREATE TABLE Disenio(
	codigo varchar(5),
	codigoFoto varchar(5) NULL,
	descripcion varchar(100),
	PRIMARY KEY(codigo),
	FOREIGN KEY(codigoFoto) REFERENCES Foto(codigo)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Usuario
$tabla = "CREATE TABLE Usuario(
	DNI varchar(10),
	password varchar(40) NOT NULL,
	nombre varchar(20) NOT NULL,
	tipo int NOT NULL,
	correo_electronico varchar(30),
	direccion varchar(30),
	PRIMARY KEY(DNI)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Cliente
$tabla = "CREATE TABLE Cliente(
	DNI_Cliente varchar(10),
	PRIMARY KEY(DNI_Cliente),
	FOREIGN KEY(DNI_Cliente) REFERENCES Usuario(DNI)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Operario
$tabla = "CREATE TABLE Operario(
	DNI_Operario varchar(10),
	privilegio int NOT NULL,
	PRIMARY KEY(DNI_Operario),
	FOREIGN KEY(DNI_Operario) REFERENCES Usuario(DNI)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Administrador
$tabla = "CREATE TABLE Administrador(
	DNI_Administrador varchar(10),
	PRIMARY KEY(DNI_Administrador),
	FOREIGN KEY(DNI_Administrador) REFERENCES Usuario(DNI)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Cotizacion
$tabla = "CREATE TABLE Cotizacion(
	codigo varchar(5),
	DNI_Cliente varchar(10) NOT NULL,
	DNI_Operario varchar(10),
	estado varchar(20) NOT NULL,
	fecha Date NOT NULL,
	precioTotal int,
	PRIMARY KEY(codigo),
	FOREIGN KEY(DNI_Cliente) REFERENCES Cliente(DNI_Cliente),
	FOREIGN KEY(DNI_Operario) REFERENCES Operario(DNI_Operario)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Pedido
$tabla = "CREATE TABLE Pedido(
	codigo varchar(5),
	estado varchar(20) NOT NULL,
	codigoCotizacion varchar(5) NOT NULL,
	fecha_Creacion Date NOT NULL,
	fecha_Recoleccion Date,
	fecha_Entrega Date,
	direccion varchar(30),
	PRIMARY KEY(codigo),
	FOREIGN KEY(codigoCotizacion) REFERENCES Cotizacion(codigo)
	)";
mysqli_query($conexion,$tabla);

//Creacion tabla Prenda
$tabla = "CREATE TABLE Prenda(
	codigo varchar(5),
	cantidad int NOT NULL,
	descripcion varchar(100),
	codigoEstado varchar(5) NOT NULL,
	codigoCotizacion varchar(5) NOT NULL,
	codigoDisenio varchar(5) NOT NULL,
	codigoBodega varchar(5),
	PRIMARY KEY(codigo),
	FOREIGN KEY(codigoEstado) REFERENCES Estado(codigo),
	FOREIGN KEY(codigoCotizacion) REFERENCES Cotizacion(codigo),
	FOREIGN KEY(codigoDisenio) REFERENCES Disenio(codigo),
	FOREIGN KEY(codigoBodega) REFERENCES Bodega(codigo)
	)";
mysqli_query($conexion,$tabla);

mysqli_close($conexion);
?>