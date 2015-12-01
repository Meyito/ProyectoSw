<?php

	/**
 	* .............................................
 	* UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
 	*    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
 	*      LAUNDRYSOFT - LAVA RAPID JEANS S.A.S
 	*             SAN JOSE DE CUCUTA-2015
	 * ............................................
 	*/


	require_once "Aplicacion/Controlador/controlador.php";
	include_once "Aplicacion/Modelo/clienteBD.php";

	/**
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	* @author Edgar Yesid Garcia Ortiz 1150967
	* @author Fernando Antonio Peñaranda Torres 1150684
	*/

	class Cliente extends Controlador{

	/* VISTAS */

		public function index(){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/cliente-home.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaConfiguracion(){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/settings.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaPedidos(){
			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarPedidosCliente($_SESSION["dni"], "");
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaPedidos.html");
			$plantilla=$this->cargarTabla($plantilla, $workspace, $datos);
			$this->mostrarVista($plantilla);
		}

		public function vistaCotizaciones(){
			$clBD=new ClienteBD();
			$datos=$clBD->visualizarCotizaciones($_SESSION["dni"],"respuesta");
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaCotizaciones.html");
			$workspace =$this->reemplazar($workspace, "{{algo}}", "");
			$workspace =$this->reemplazar($workspace, "{{algo2}}", "ES");
			$plantilla=$this->cargarTablaCotizaciones($plantilla, $workspace, $datos);
			$this->mostrarVista($plantilla);
		}

		public function vistaCrearPedido(){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/crearPedido.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}


	/* PROCESAMIENTO */

		public function solicitarCotizacion($dni, $nombre, $cant, $desc){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/crearPedido.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);

			if($cant>=1){

				$cBD=new ClienteBD();

				$this->registrarDisenios($nombre,"");
				$codImagen=$this->consultarCodDis($nombre);
				$ok=$cBD->generarCotizacion($dni,$desc,$cant,$codImagen);

				if($ok){
					$plantilla=$this->alerta($plantilla, "SOLICITUD ENVIADA EXITOSAMENTE", "");
				}else{
					$plantilla=$this->alerta($plantilla, "FALLO AL PROCESAR LA SOLICITUD", "Por favor intentelo nuevamente");
				}

			}else{
				$plantilla=$this->alerta($plantilla, "SOLICITUD NO ENVIADA", "Por favor revise la cantidad de Jeans <br> ingresada.");
			}
			$this->mostrarVista($plantilla);
		}

		public function abrirCotizacion($codCot){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);

			$clBD=new ClienteBD();
			$datos=$clBD->getCotizacion($codCot);
			$img=$clBD->getDisenio($datos[0][8]);

			
			$workspace = $this->leerPlantilla("Aplicacion/Vista/responderSolicitudCliente.html");

			$workspace=$this->reemplazar($workspace, "{{foto}}", $img[0][1]);
			$workspace=$this->reemplazar($workspace, "{{numJeans}}", $datos[0][7]);
			$workspace=$this->reemplazar($workspace, "{{precio}}", $datos[0][6]);
			$workspace=$this->reemplazar($workspace, "{{editable1}}", "required");
			$workspace=$this->reemplazar($workspace, "{{editable2}}", "readonly");
			$workspace=$this->reemplazar($workspace, "{{desc}}", $datos[0][5]);
			$workspace=$this->reemplazar($workspace, "{{accion}}", "modificarSolicitud");
			$workspace=$this->reemplazar($workspace, "{{codigoCot}}", $codCot);
			$workspace=$this->reemplazar($workspace, "{{depende}}", "MODIFICAR");
			$workspace=$this->reemplazar($workspace, "{{accion2}}", "rechazarCotizacion");
			$workspace=$this->reemplazar($workspace, "{{otro}}", "RECHAZAR");

			$workspace=$this->reemplazar($workspace, "{{class}}", "boton3");
			
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);

		}

		public function registrarDisenios($nombre,$desc){
			$cBD=new ClienteBD();
			$cBD->registrarDisenios($nombre,$desc);
			return;
		}

		public function consultarCodDis($nombre){
			$cBD=new ClienteBD();
			$cod=$cBD->obtenerCodigoDisenio($nombre);
			return $cod[0][0];
		}

		public function cambiarPassword($actual, $nueva, $confirmacion){
			$nueva2=$this->encriptarPassword($nueva);
			$confirmacion2=$this->encriptarPassword($confirmacion);

			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/settings.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);


			if($nueva2==$confirmacion2){
				$actual2=$this->encriptarPassword($actual);
				$cliente=new ClienteBD();
				$ok=$cliente->cambiarContrasenia($_SESSION["dni"],$actual2,$nueva2);
				if($ok){
					$plantilla=$this->alerta($plantilla, "Contraseña actual cambiada exitosamente", "");
				}else{
					$plantilla=$this->alerta($plantilla, "ERROR", "Contraseña incorrecta");
				}
			}else{
				$plantilla=$this->alerta($plantilla, "ERROR", "Las contraseñas no son iguales");
			}

			$this->mostrarVista($plantilla);
		}

		public function editarSolicitud($codigoCotizacion, $cantidad, $urlImagen, $descripcion){
			$clBD=new ClienteBD();
			$codigoDisenio=$clBD->obtenerCodigoDisenio($urlImagen);
			$ok=$clBD->modificarCotizacion($codigoCotizacion,$cantidad,$codigoDisenio[0][0],$descripcion);
			
			$this->mostrarMensaje($ok);
		}

		public function aceptarCotizacion($cod){
			$clBD=new ClienteBD();
			$ok=$clBD->responderCotizacion($cod, "aceptada");
			$this->vistaCotizaciones();
		}

		public function cancelarCotizacion($cod){
			$clBD=new ClienteBD();
			$ok=$clBD->responderCotizacion($cod, "rechazada");
			$this->vistaCotizaciones();
		}

	/* AUXILIARES */

		public function mostrarMensaje($ok){
			$clBD=new ClienteBD();
			$datos=$clBD->visualizarCotizaciones($_SESSION["dni"],"respuesta");
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");
			$plantilla = $this -> init($barLat);
			$workspace=$this->leerPlantilla("Aplicacion/Vista/tablaCotizaciones.html");
			$workspace =$this->reemplazar($workspace, "{{algo}}", "");
			$workspace =$this->reemplazar($workspace, "{{algo2}}", "ES");
			$plantilla=$this->cargarTablaCotizaciones($plantilla, $workspace, $datos);

			if($ok){
				$plantilla=$this->alerta($plantilla, "MODIFICACION REALIZADA EXITOSAMENTE", "");
			}else{
				$plantilla=$this->alerta($plantilla, "FALLO AL REALIZAR LA MODIFICACION", "Por favor intentelo nuevamente");
			}
		
			$this->mostrarVista($plantilla);
		}

		public function cargarTabla($plantilla, $workspace, $datos){
			$filaP=$this->leerPlantilla("Aplicacion/Vista/filaTablaPedidos.html");
			$info="";

			for($i=0; $i<count($datos); $i++){
				$aux=$filaP;
				$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
				$aux=$this->reemplazar($aux, "{{estado}}", $datos[$i][1]);
				$aux=$this->reemplazar($aux, "{{cliente}}", $datos[$i][2]);
				$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][3]);
				$aux=$this->reemplazar($aux, "{{operario}}", $datos[$i][4]);
				$aux=$this->reemplazar($aux, "{{precio}}", $datos[$i][5]);
				$info.=$aux;
			}
			$workspace=$this->reemplazar($workspace, "{{filas}}", $info);
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function cargarTablaCotizaciones($plantilla, $workspace, $datos){
			$filaP=$this->leerPlantilla("Aplicacion/Vista/filaTablaCotizaciones.html");
			$info="";
			for($i=0; $i<count($datos); $i++){
				$aux=$filaP;
				$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
				$aux=$this->reemplazar($aux, "{{nombre}}", $datos[$i][1]);
				$aux=$this->reemplazar($aux, "{{tel}}", $datos[$i][2]);
				$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][3]);
				$aux=$this->reemplazar($aux, "{{quien}}", "Cliente");
				$aux=$this->reemplazar($aux, "{{haceAlgo}}", "ABRIR");

				$info.=$aux;
			}
			$workspace=$this->reemplazar($workspace, "{{filas}}", $info);
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

	}
?>