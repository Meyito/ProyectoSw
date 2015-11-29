<?php
	session_start();
	require "Aplicacion/Controlador2/controlador.php";
	require "Aplicacion/Controlador2/administrador.php";
	//require "Aplicacion/Controlador2/cliente.php";
	//require "Aplicacion/Controlador2/operario.php";

	$ppal=new controlador();

	//Si esta variable esta definida, el ususario esta logueado
	if(isset($_SESSION["tipo"])){

		if($_SESSION["tipo"]=="Administrador"){
			
			$admin=new Administrador();
			
			if(isset($_POST["tipo"])){

				if($_POST["tipo"]=="registroCliente"){

					$admin->registrarCliente($_POST["nombre"], $_POST["cedula"], $_POST["password"], $_POST["email"], $_POST["direccion"], $_POST["tel"]);

				}else if($_POST["tipo"]=="editarCliente"){

					$admin->vistaEditarCliente($_POST["dni"]);

				}else if($_POST["tipo"]=="edicionCliente"){

					$admin->editarCliente($_POST["cedula"], $_POST["email"], $_POST["direccion"]);

				}else if($_POST["tipo"]=="eliminarCliente"){

					$admin->vistaEliminarCliente($_POST["dni"]);

				}else if($_POST["tipo"]=="eliminoCliente"){

					$admin->eliminarCliente($_POST["dni"]);

				}else if($_POST["tipo"]=="canceloCliente"){

					$admin->vistaConsultarClientes();

				}else if($_POST["tipo"]=="registroOperario"){

					$admin->registrarOperario($_POST["nombre"], $_POST["cedula"], $_POST["password"], $_POST["email"], $_POST["direccion"], $_POST["tel"]);

				}else if($_POST["tipo"]=="editarOperario"){

					$admin->vistaEditarOperario($_POST["dni"]);

				}else if($_POST["tipo"]=="edicionOperario"){

					$admin->editarOperario($_POST["cedula"], $_POST["email"], $_POST["direccion"]);

				}else if($_POST["tipo"]=="eliminarOperario"){

					$admin->vistaEliminarOperario($_POST["dni"]);

				}else if($_POST["tipo"]=="eliminoOperario"){

					$admin->eliminarOperario($_POST["dni"]);

				}else if($_POST["tipo"]=="canceloOperario"){

					$admin->vistaConsultarOperarios();

				}else if($_POST["tipo"]=="settings"){

					$admin->cambiarPassword($_POST["password"], $_POST["nuevop"], $_POST["confp"]);
				
				}

			}else if(isset($_GET["accion"])){

				if($_GET["accion"]=="clientes"){

					$admin->menuClientes();

				}else if($_GET["accion"]=="operarios"){

					$admin->menuOperarios();

				}else if($_GET["accion"]=="pedidos"){

					$admin->vistaPedidos();

				}else if($_GET["accion"]=="consultarClientes"){

					$admin->vistaConsultarClientes();

				}else if($_GET["accion"]=="consultarOperarios"){

					$admin->vistaConsultarOperarios();

				}else if($_GET["accion"]=="registrarCliente"){

					$admin->mostrarRegistroC();

				}else if($_GET["accion"]=="registrarOperario"){

					$admin->mostrarRegistroO();

				}else if($_GET["accion"]=="settings"){

					$admin->vistaConfiguracion();

				}else if($_GET["accion"]=="logout"){

					$_SESSION["username"] = false;
					$_SESSION["dni"] = false;
					$_SESSION["tipo"] = false;
					$_SESSION["img"] = false;
					session_destroy();
					header('location:index.php');
				}
			}else{
				$admin->index();
			}
		}
	}
	//Para los usuarios que no estan logueados
	else if(isset($_POST["accion"])){
		$ppal->login($_POST["cedula"], $_POST["password"]);
	}

	//Muestra el inicio de la aplicacion
	else{
		$ppal->inicio();
	}
?>