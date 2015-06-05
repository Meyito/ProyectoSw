<?php
	session_start();
	require "Aplicacion/Controlador/controlador.php";

	$ppal=new controlador();

	//Si esta variable esta definida, el ususario esta logueado
	if(isset($_SESSION["tipoUsuario"])){
		echo "Haga algo";
	}
	//Para los usuarios que no estan logueados
	else if(isset($_POST["tipo"])){
		$ppal->login($_POST["cedula"], $_POST["password"]);
	}

	//Muestra el inicio de la aplicacion
	else{
		$ppal->inicio();
	}
?>