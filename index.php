<?php
	session_start();
	require_once "Aplicacion/Controlador/controlador.php";
	require_once "Aplicacion/Controlador/administrador.php";
	require_once "Aplicacion/Controlador/cliente.php";
	require_once "Aplicacion/Controlador/operario.php";

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
		}else if($_SESSION["tipo"]=="Cliente"){

			$cliente=new Cliente();

			if(isset($_POST["tipo"])){

				if($_POST["tipo"]=="settings"){

					$cliente->cambiarPassword($_POST["password"], $_POST["nuevop"], $_POST["confp"]);

				}else if($_POST["tipo"]=="solPedido"){

					$nombre=$ppal->procesarImagen($_FILES['imagen']['tmp_name']);
					$cliente->solicitarCotizacion($_SESSION["dni"], $nombre, $_POST["numJeans"], $_POST["desc"]);

				}else if($_POST["tipo"]=="editarSolicitudCliente"){

					$cliente->abrirCotizacion($_POST["codCot"]);

				}else if($_POST["tipo"]=="modificarSolicitud"){

					$cliente->editarSolicitud($_POST["codCot"], $_POST["cantJeans"], $_POST["urlImagen"], $_POST["desc"]);

				}else if($_POST["tipo"]=="aceptarCotizacion"){

					$cliente->aceptarCotizacion($_POST["codCot"]);

				}if($_POST["tipo"]=="rechazarCotizacion"){

					$cliente->cancelarCotizacion($_POST["codCot"]);

				}

			}else if(isset($_GET["accion"])){

				if($_GET["accion"]=="settings"){

					$cliente->vistaConfiguracion();

				}else if($_GET["accion"]=="logout"){

					$_SESSION["nombre"] = false;
					$_SESSION["tipoUsuario"] = false;
					session_destroy();
					header('location:index.php');

				}else if($_GET["accion"]=="pedidos"){

					$cliente->vistaPedidos();

				}else if($_GET["accion"]=="cotizaciones"){

					$cliente->vistaCotizaciones();

				}else if($_GET["accion"]=="solicitarPedido"){

					$cliente->vistaCrearPedido();

				}

			}else{
				$cliente->index();
			}
		}else if($_SESSION["tipo"]=="Operario"){

			$operario=new Operario();

			if(isset($_POST["tipo"])){

				if($_POST["tipo"]=="settings"){

					$operario->cambiarPassword($_POST["password"], $_POST["nuevop"], $_POST["confp"]);

				}else if($_POST["tipo"]=="agregarDis"){

					$nombre=$ppal->procesarImagen($_FILES['imagen']['tmp_name']);
					$operario->agregarImagen($nombre, $_POST["descripcion"]);

				}else if($_POST["tipo"]=="responderSolicitud"){

					$operario->editarSolicitud($_SESSION["dni"], $_POST["codCot"], $_POST["precio"], $_POST["desc"]);
				
				}else if($_POST["tipo"]=="editarSolicitudOperario"){

					$operario->responderSolicitud($_POST["codCot"]);

				}else if($_POST["tipo"]=="cancelarEdicion"){

					$operario->cancelarEdicion();
					
				}

			}else if(isset($_GET["accion"])){

				if($_GET["accion"]=="pedidos"){

					$operario->vistaPedidos();

				}else if($_GET["accion"]=="logout"){

					$_SESSION["nombre"] = false;
					$_SESSION["tipoUsuario"] = false;
					session_destroy();
					header('location:index.php');

				}else if($_GET["accion"]=="disenos"){

					$operario->menuDisenos();

				}else if($_GET["accion"]=="solicitudes"){

					$operario->vistaSolicitudes();

				}else if($_GET["accion"]=="settings"){

					$operario->vistaConfiguracion();

				}else if($_GET["accion"]=="nuevoDis"){

					$operario->vistaAnadirDisenos();

				}

			}else{

				$operario->index();

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