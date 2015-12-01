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
	include_once "Aplicacion/Modelo/operarioBD.php";

	/**
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	* @author Edgar Yesid Garcia Ortiz 1150967
	* @author Fernando Antonio Peñaranda Torres 1150684
	*/
	
	class Operario extends Controlador{

	/* VISTAS */

		public function index(){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barraLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/op-home.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaPedidos(){
			$opBD=new OperarioBD();
			$datos=$opBD->visualizarPedidos("");
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaPedidos.html");
			$plantilla=$this->cargarTabla($plantilla, $workspace, $datos);
			$this->mostrarVista($plantilla);
		}

		public function menuDisenos(){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/op-gestionD.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaSolicitudes(){
			$opBD=new OperarioBD();
			$datos=$opBD->visualizarCotizaciones("pendiente");
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaSolicitudes.html");
			$plantilla=$this->cargarTablaSolicitudes($plantilla, $workspace, $datos);
			$this->mostrarVista($plantilla);
		}

		public function vistaConfiguracion(){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/settings.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaAnadirDisenos(){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/nuevoDis.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

	/* PROCESAMIENTO */

		public function responderSolicitud($codigo){
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);

			$opBD=new OperarioBD();
			$datos=$opBD->getCotizacion($codigo);
			$img=$opBD->getDisenio($datos[0][8]);

			$workspace = $this->leerPlantilla("Aplicacion/Vista/responderSolicitudOperario.html");


			$workspace=$this->reemplazar($workspace, "{{foto}}", $img[0][1]);
			$workspace=$this->reemplazar($workspace, "{{numJeans}}", $datos[0][7]);
			$workspace=$this->reemplazar($workspace, "{{precio}}", $datos[0][6]);
			$workspace=$this->reemplazar($workspace, "{{editable1}}", "readonly");
			$workspace=$this->reemplazar($workspace, "{{editable2}}", "required");
			$workspace=$this->reemplazar($workspace, "{{desc}}", $datos[0][5]);
			$workspace=$this->reemplazar($workspace, "{{accion}}", "responderSolicitud");
			$workspace=$this->reemplazar($workspace, "{{codigoCot}}", $codigo);
			$workspace=$this->reemplazar($workspace, "{{depende}}", "RESPONDER");
			$workspace=$this->reemplazar($workspace, "{{class}}", "");
			$workspace=$this->reemplazar($workspace, "{{boton}}", "");
			$workspace=$this->reemplazar($workspace, "{{accion2}}", "cancelarEdicion");
			$workspace=$this->reemplazar($workspace, "{{otro}}", "CANCELAR");

			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);

			$this->mostrarVista($plantilla);
		}

		public function editarSolicitud($codOp, $codCot, $precio, $desc){
			$opBD=new OperarioBD();

			$ok=$opBD->responderCotizacion($codOp,$codCot,$precio, $desc);

			$datos=$opBD->visualizarCotizaciones("pendiente");
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaSolicitudes.html");
			$plantilla=$this->cargarTablaSolicitudes($plantilla, $workspace, $datos);
			$this->mostrarVista($plantilla);

			if($ok){
				$plantilla=$this->alerta($plantilla, "COTIZACION ENVIADA EXITOSAMENTE", "");
			}else{
				$plantilla=$this->alerta($plantilla, "COTIZACION NO ENVIADA", "Por favor intentelo nuevamente");
			}

			$this->mostrarVista($plantilla);
		}

		public function cancelarEdicion(){

			$opBD=new OperarioBD();
			$datos=$opBD->visualizarCotizaciones("pendiente");
			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaSolicitudes.html");
			$plantilla=$this->cargarTablaSolicitudes($plantilla, $workspace, $datos);
			$plantilla=$this->alerta($plantilla, "LA SOLICITUD NO FUE RESPONDIDA", "");
			$this->mostrarVista($plantilla);
		}

		public function agregarImagen($nombre, $desc){
			$opBD=new OperarioBD();
			$ok=$opBD->registrarDisenio($nombre,$desc);

			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/nuevoDis.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			
			if($ok){
				$plantilla=$this->alerta($plantilla, "DISEÑO AÑADIDO EXITOSAMENTE", "");
			}else{
				$plantilla=$this->alerta($plantilla, "FALLO AL AGREGAR EL DISEÑO", "");
			}
			$this->mostrarVista($plantilla);
		}

		public function cambiarPassword($actual, $nueva, $confirmacion){
			$nueva2=$this->encriptarPassword($nueva);
			$confirmacion2=$this->encriptarPassword($confirmacion);

			$barLat=$this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");
			$plantilla = $this -> init($barLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/settings.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);

			if($nueva2==$confirmacion2){
				$actual2=$this->encriptarPassword($actual);
				$op=new OperarioBD();
				$ok=$op->cambiarContrasenia($_SESSION["dni"],$actual2,$nueva2);
				
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


	/* AUXILIARES */

		public function cargarTabla($plantilla, $workspace, $datos){
			$filaP=$this->leerPlantilla("Aplicacion/Vista/filaTablaPedidos.html");
			$info="";

			for($i=0; $i<count($datos); $i++){
				$aux=$filaP;
				$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
				$aux=$this->reemplazar($aux, "{{estado}}", $datos[$i][10]);
				$aux=$this->reemplazar($aux, "{{cliente}}", $datos[$i][5]);
				$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][1]);
				$aux=$this->reemplazar($aux, "{{operario}}", $datos[$i][6]);
				$aux=$this->reemplazar($aux, "{{precio}}", $datos[$i][8]);
				$info.=$aux;
			}
			$workspace=$this->reemplazar($workspace, "{{filas}}", $info);
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function cargarTablaSolicitudes($plantilla, $workspace, $datos){
			$filaP=$this->leerPlantilla("Aplicacion/Vista/filaTablaSolicitudes.html");
			$info="";
			for($i=0; $i<count($datos); $i++){
				$aux=$filaP;
				$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
				$aux=$this->reemplazar($aux, "{{nombre}}", "Pepito");
				$aux=$this->reemplazar($aux, "{{tel}}", "5782585");
				$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][4]);
				$aux=$this->reemplazar($aux, "{{quien}}", "Operario");
				$aux=$this->reemplazar($aux, "{{haceAlgo}}", "RESPONDER");

				$info.=$aux;
			}
			$workspace=$this->reemplazar($workspace, "{{filas}}", $info);
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}


		
	}
?>