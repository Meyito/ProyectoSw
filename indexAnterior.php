<?php

	session_start();
	require "Aplicacion/Controlador/controlador.php";
	require "Aplicacion/Controlador/administrador.php";
	require "Aplicacion/Controlador/cliente.php";
	require "Aplicacion/Controlador/operario.php";

	$ppal=new controlador();

	//Si esta variable esta definida, el ususario esta logueado
	if(isset($_SESSION["tipo"])){

		if(isset($_POST["tipo"])){

			if($_SESSION["tipo"]=="Administrador"){
				$admin=new administrador();

				if($_POST["tipo"]=="registroCliente"){
					$admin->registrarCliente($_POST["nombre"], $_POST["cedula"], $_POST["password"], $_POST["email"], $_POST["direccion"], $_POST["tel"]);
				}else if($_POST["tipo"]=="registroOperario"){
					$admin->registrarOperario($_POST["nombre"], $_POST["cedula"], $_POST["password"], $_POST["email"], $_POST["direccion"], $_POST["tel"]);
				}if($_POST["tipo"]=="settings"){
					$admin->cambiarPassword($_POST["password"], $_POST["nuevop"], $_POST["confp"]);
				}if($_POST["tipo"]=="consultarCliente"){
					$admin->vistaConsultarClienteDNI($_POST["cedula"]);
				}if($_POST["tipo"]=="editarCliente"){
					$admin->vistaEditarCliente($_POST["dni"]);
				}if($_POST["tipo"]=="edicionCliente"){
					$admin->vistaEdicionCliente($_POST["cedula"], $_POST["email"], $_POST["direccion"]);
				}if($_POST["tipo"]=="eliminarCliente"){
					$admin->vistaEliminarCliente($_POST["dni"]);
				}if($_POST["tipo"]=="eliminoCliente"){
					$admin->vistaEliminoCliente($_POST["dni"]);
				}if($_POST["tipo"]=="canceloCliente"){
					$admin->vistaConsultarClientes();
				}if($_POST["tipo"]=="consultarOperario"){
					$admin->vistaConsultarOperarioDNI($_POST["cedula"]);
				}if($_POST["tipo"]=="editarOperario"){
					$admin->vistaEditarOperario($_POST["dni"]);
				}if($_POST["tipo"]=="edicionOperario"){
					$admin->vistaEdicionOperario($_POST["cedula"], $_POST["email"], $_POST["direccion"]);
				}if($_POST["tipo"]=="eliminarOperario"){
					$admin->vistaEliminarOperario($_POST["dni"]);
				}if($_POST["tipo"]=="eliminoOperario"){
					$admin->vistaEliminoOperario($_POST["dni"]);
				}if($_POST["tipo"]=="canceloOperario"){
					$admin->vistaConsultarOperarios();
				}

			}else if($_SESSION["tipo"]=="Operario"){
				$op=new operario();

				if($_POST["tipo"]=="settings"){
					$op->cambiarPassword($_POST["password"], $_POST["nuevop"], $_POST["confp"]);
				}if($_POST["tipo"]=="agregarDis"){
					$nombre=$ppal->procesarImagen($_FILES['imagen']['tmp_name']);
					$op->agregarImagen($nombre, $_POST["descripcion"]);
				}if($_POST["tipo"]=="editarSolicitudOperario"){
					$op->responderSolicitud($_POST["codCot"]);
				}if($_POST["tipo"]=="cancelarEdicion"){
					$x=$op->cargarSolicitudes();
					$x=$ppal->alerta($x, "LA SOLICITUD NO FUE RESPONDIDA", "");
					$ppal->mostrarVista($x);
				}if($_POST["tipo"]=="responderSolicitud"){
					$op->editarSolicitud($_SESSION["dni"], $_POST["codCot"], $_POST["precio"], $_POST["desc"]);
				}

			}else if($_SESSION["tipo"]=="Cliente"){
				$cliente=new cliente();

				if($_POST["tipo"]=="settings"){
					$cliente->cambiarPassword($_POST["password"], $_POST["nuevop"], $_POST["confp"]);
				}if($_POST["tipo"]=="solPedido"){
					$nombre=$ppal->procesarImagen($_FILES['imagen']['tmp_name']);
					$cliente->solicitarCotizacion($_SESSION["dni"], $nombre, $_POST["numJeans"], $_POST["desc"]);
				}if($_POST["tipo"]=="editarSolicitudCliente"){
					$cliente->abrirCotizacion($_POST["codCot"]);
				}if($_POST["tipo"]=="modificarSolicitud"){
					$ok=$cliente->editarSolicitud($_POST["codCot"], $_POST["cantJeans"], $_POST["urlImagen"], $_POST["desc"]);
					$plantilla=$cliente->cargarCotizaciones();
					if($ok){
						$plantilla=$ppal->alerta($plantilla, "MODIFICACION REALIZADA EXITOSAMENTE", "");
					}else{
						$plantilla=$ppal->alerta($plantilla, "FALLO AL REALIZAR LA MODIFICACION", "Por favor intentelo nuevamente");
					}
					$ppal->mostrarVista($plantilla);
				}if($_POST["tipo"]=="aceptarCotizacion"){
					$cliente->aceptarCotizacion($_POST["codCot"]);
				}if($_POST["tipo"]=="rechazarCotizacion"){
					$cliente->cancelarCotizacion($_POST["codCot"]);
				}

			}

		}else if($_SESSION["tipo"]=="Administrador"){

			$admin=new administrador();

			if(isset($_GET["accion"])){
				if($_GET["accion"]=="clientes"){
					$admin->menuClientes();
				}else if($_GET["accion"]=="operarios"){
					$admin->menuOperarios();
				}else if($_GET["accion"]=="pedidos"){
					$admin->vistaPedidos();
				}else if($_GET["accion"]=="registrarCliente"){
					$admin->vistaRegistroCliente();
				}else if($_GET["accion"]=="registrarOperario"){
					$admin->vistaRegistroOperario();
				}else if($_GET["accion"]=="consultarClientes"){
					$admin->vistaConsultarClientes();
				}else if($_GET["accion"]=="consultarOperarios"){
					$admin->vistaConsultarOperarios();
				}else if($_GET["accion"]=="logout"){
					$_SESSION["nombre"] = false;
					$_SESSION["tipoUsuario"] = false;
					session_destroy();
					header('location:index.php');
				}else if($_GET["accion"]=="settings"){
					$admin->vistaConfiguracion();
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
					$cliente->vistaConfiguracion();
				}
			}else{
				$cliente->inicioValidado();
			}

		}else if($_SESSION["tipo"]=="Operario"){

			$operario=new operario();

			if(isset($_GET["accion"])){
				if($_GET["accion"]=="pedidos"){
					$operario->vistaPedidos();
				}else if($_GET["accion"]=="disenos"){
					$operario->menuDisenos();
				}else if($_GET["accion"]=="solicitudes"){
					$operario->vistaSolicitudes();
				}else if($_GET["accion"]=="nuevoDis"){
					$operario->vistaAnadirDisenos();
				}else if($_GET["accion"]=="logout"){
					$_SESSION["nombre"] = false;
					$_SESSION["tipoUsuario"] = false;
					session_destroy();
					header('location:index.php');
				}else if($_GET["accion"]=="settings"){
					$operario->vistaConfiguracion();
				}
			}else{
				$operario->inicioValidado();
			}
		}
	}
	//Para los usuarios que no estan logueados
	else if(isset($_POST["tipo"])){
		$ppal->login($_POST["cedula"], $_POST["password"], $_POST["tipo"]);
	}

	//Muestra el inicio de la aplicacion
	else{
		$ppal->inicio();
	}
?>