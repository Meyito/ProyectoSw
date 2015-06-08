<?php
$conexion = mysqli_connect("sandbox2.ufps.edu.co","ufps_88","ufps_uy") or die (("Error " . mysqli_error($conexion)));
$creacion = "CREATE DATABASE Lavanderia";
mysqli_query($conexion,$creacion);
mysqli_close($conexion);

$conexion = mysqli_connect("sandbox2.ufps.edu.co","ufps_88","ufps_uy","Lavanderia") or die(("Error " . mysqli_error($conexion)));
//Creacion tabla Estado
$tabla = "CREATE TABLE Estado(
	codigo int AUTO_INCREMENT,
	nombre varchar(20) NOT NULL,
	descripcion varchar(100),
	PRIMARY KEY(codigo)
	)";

if(mysqli_query($conexion,$tabla))
{
	echo("Se creo la tabla Estado<br>");
}
else
{
	echo("No se creo la tabla Estado<br>");
}
//Creacion tabla Bodega
$tabla = "CREATE TABLE Bodega(
	codigo int AUTO_INCREMENT,
	nombre varchar(20) NOT NULL,
	descripcion varchar(150),
	PRIMARY KEY(codigo)
	)";

if(mysqli_query($conexion,$tabla))
{
	echo("Se creo la tabla Bodega<br>");
}
else
{
	echo("No se creo la tabla Bodega<br>");
}

//Creacion tabla Diseño
$tabla = "CREATE TABLE Disenio(
	codigo int AUTO_INCREMENT,
	url varchar(100) NULL,
	descripcion varchar(100),
	PRIMARY KEY(codigo)
	)";
if(mysqli_query($conexion,$tabla))
{
	echo("Se creo la tabla Disenio<br>");
}
else
{
	echo("No se creo la tabla Disenio<br>");
}

//Creacion tabla Usuario
$tabla = "CREATE TABLE Usuario(
	DNI varchar(10),
	password varchar(40) NOT NULL,
	nombre varchar(20) NOT NULL,
	tipo int NOT NULL,
	telefono varchar(15),
	correo_electronico varchar(30),
	direccion varchar(30),
	PRIMARY KEY(DNI)
	)";
if(mysqli_query($conexion,$tabla))
{
	echo("Se creo la tabla Usuario<br>");
}
else
{
	echo("No se creo la tabla Usuario<br>");
}

//Creacion tabla Cotizacion
$tabla = "CREATE TABLE Cotizacion(
	codigo int AUTO_INCREMENT,
	DNI_Cliente varchar(10) NOT NULL,
	DNI_Operario varchar(10),
	estado varchar(20) NOT NULL,
	fecha Date NOT NULL,
	descripcion varchar(100),
	precioTotal int,
	PRIMARY KEY(codigo),
	FOREIGN KEY(DNI_Cliente) REFERENCES Cliente(DNI_Cliente),
	FOREIGN KEY(DNI_Operario) REFERENCES Operario(DNI_Operario)
	)";
if(mysqli_query($conexion,$tabla))
{
	echo("Se creo la tabla Cotizacion<br>");
}
else
{
	echo("No se creo la tabla Cotizacion<br>");
}

//Creacion tabla Pedido
$tabla = "CREATE TABLE Pedido(
	codigo int AUTO_INCREMENT,
	estado varchar(20) NOT NULL,
	codigoCotizacion int NOT NULL,
	fecha_Creacion Date NOT NULL,
	fecha_Recoleccion Date,
	fecha_Entrega Date,
	direccion varchar(30),
	PRIMARY KEY(codigo),
	FOREIGN KEY(codigoCotizacion) REFERENCES Cotizacion(codigo),
	UNIQUE KEY(codigoCotizacion)
	)";
if(mysqli_query($conexion,$tabla))
{
	echo("Se creo la tabla Pedido<br>");
}
else
{
	echo("No se creo la tabla Pedido<br>");
}

//Creacion tabla Prenda
$tabla = "CREATE TABLE Prenda(
	codigo int AUTO_INCREMENT,
	cantidad int,
	descripcion varchar(100),
	codigoEstado int NOT NULL,
	codigoCotizacion int NOT NULL,
	codigoDisenio int NOT NULL,
	codigoBodega int NOT NULL,
	PRIMARY KEY(codigo),
	FOREIGN KEY(codigoEstado) REFERENCES Estado(codigo),
	FOREIGN KEY(codigoCotizacion) REFERENCES Cotizacion(codigo),
	FOREIGN KEY(codigoDisenio) REFERENCES Disenio(codigo),
	FOREIGN KEY(codigoBodega) REFERENCES Bodega(codigo),
	UNIQUE KEY(codigoCotizacion)
	)";
if(mysqli_query($conexion,$tabla))
{
	echo("Se creo la tabla Prenda<br>");
}
else
{
	echo("No se creo la tabla Prenda<br>");
}

mysqli_close($conexion);
?>