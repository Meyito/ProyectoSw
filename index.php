<?php

	session_start();
	require "Aplicacion/Controlador/controlador.php";
	require "Aplicacion/Controlador/administrador.php";
	require "Aplicacion/Controlador/cliente.php";

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
				}else if($_GET["accion"]=="logout"){
					$_SESSION["nombre"] = false;
					$_SESSION["tipoUsuario"] = false;
					session_destroy();
					header('location:index.php');
				}else if($_GET["accion"]=="settings"){
					echo "hace algo admin";
				}
			}else{
				$admin->inicioValidado();
			}			
		}else if($_SESSION["tipo"]=="Cliente"){
			$cliente=new cliente();

			if(isset($_GET["accion"])){
				if($_GET["accion"]=="pedidos"){
					$cliente->vistaPedidos();
				}else if($_GET["accion"]=="cotizaciones"){
					$cliente->vistaCotizaciones();
				}else if($_GET["accion"]=="solicitarPedido"){
					$cliente->crearPedido();
				}else if($_GET["accion"]=="logout"){
					$_SESSION["nombre"] = false;
					$_SESSION["tipoUsuario"] = false;
					session_destroy();
					header('location:index.php');
				}else if($_GET["accion"]=="settings"){
					echo "hace algo cliente";
				}
			}else{
				$cliente->inicioValidado();
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