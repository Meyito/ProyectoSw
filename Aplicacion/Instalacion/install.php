<?php

	/**
 	* .............................................
 	* UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
 	*    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
 	*      LAUNDRYSOFT - LAVA RAPID JEANS S.A.S
 	*             SAN JOSE DE CUCUTA-2015
	 * ............................................
 	*/

 	/**
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	* @author Edgar Yesid Garcia Ortiz 1150967
	* @author Fernando Antonio Peñaranda Torres 1150684
	*/
	
$conexion = mysqli_connect("localhost","root","") or die (("Error " . mysqli_error($conexion)));
$creacion = "CREATE DATABASE Lavanderia";
mysqli_query($conexion,$creacion);
mysqli_close($conexion);

$conexion = mysqli_connect("localhost","root","","Lavanderia") or die(("Error " . mysqli_error($conexion)));
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
	direccion varchar(50),
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
	url varchar(100) NOT NULL,
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
	cantidad int,
	codigoDisenio int,
	PRIMARY KEY(codigo),
	FOREIGN KEY(DNI_Cliente) REFERENCES Usuario(DNI),
	FOREIGN KEY(DNI_Operario) REFERENCES Usuario(DNI),
	FOREIGN KEY(codigoDisenio) REFERENCES Disenio(codigo)
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
	codigoEstado int NOT NULL,
	codigoCotizacion int NOT NULL,
	fecha_Creacion Date NOT NULL,
	fecha_Recoleccion Date,
	fecha_Entrega Date,
	direccion varchar(30),
	codigoBodega int NOT NULL,
	PRIMARY KEY(codigo),
	FOREIGN KEY(codigoCotizacion) REFERENCES Cotizacion(codigo),
	FOREIGN KEY(codigoEstado) REFERENCES Estado(codigo),
	FOREIGN KEY(codigoBodega) REFERENCES Bodega(codigo),
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

$query = "INSERT INTO Bodega(nombre,direccion) VALUES('Bodega Principal','Av. 5 # 16N-102 Ciudadela')";
mysqli_query($conexion,$query);

$query = "INSERT INTO Estado(nombre) VALUES('En Procesamiento')";
mysqli_query($conexion,$query);

$query = "INSERT INTO Estado(nombre) VALUES('En Almacenamiento')";
mysqli_query($conexion,$query);

$query = "INSERT INTO Estado(nombre) VALUES('En Tratamiento')";
mysqli_query($conexion,$query);

$query = "INSERT INTO Estado(nombre) VALUES('Pago Pendiente')";
mysqli_query($conexion,$query);

$query = "INSERT INTO Estado(nombre) VALUES('En Despacho')";
mysqli_query($conexion,$query);

$query = "INSERT INTO Estado(nombre) VALUES('Producto Entregado')";
mysqli_query($conexion,$query);

$query = "INSERT INTO Usuario VALUES('1090484841','".sha1('1234')."','Daniel Vega',1,'3043430740','daniel.dvs95@hotmail.com','Calle 2n #14e-28 Villa Prado')";
mysqli_query($conexion,$query);

mysqli_close($conexion);
?>