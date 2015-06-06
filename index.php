<?php

	session_start();
	require "Aplicacion/Controlador/controlador.php";
	require "Aplicacion/Controlador/administrador.php";

	$ppal=new controlador();

	//Si esta variable esta definida, el ususario esta logueado
	if(isset($_SESSION["tipo"])){
		if($_SESSION["tipo"]=="Administrador"){
			$admin=new administrador();

			if(isset($_GET["accion"])){
				if($_GET["accion"]=="clientes"){
					$admin->menuClientes();
				}else if($_GET["accion"]=="operarios"){
					$admin->menuOperarios();
				}else if($_GET["accion"]=="pedidos"){
					$admin->vistaPedidos();
				}else{
					$admin->inicioValidado();
				}
			}else{
				$admin->inicioValidado();
			}			
		}
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