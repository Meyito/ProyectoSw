<?php

	require_once "Aplicacion/Controlador/controlador.php";
	include_once "Aplicacion/Modelo/operarioBD.php";

	class Operario extends Controlador{

		public function inicioValidado(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/op-home.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function menuDisenos(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/op-gestionD.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaAnadirDisenos(){
			$plantilla = $this -> cargarAnadirDis();
			$this->mostrarVista($plantilla);
		}

		public function cargarAnadirDis(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/nuevoDis.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function vistaSolicitudes(){
			$plantilla = $this->cargarSolicitudes();
			$this->mostrarVista($plantilla);
		}

		public function cargarSolicitudes(){
			$opBD=new OperarioBD();

			$datos=$opBD->visualizarCotizaciones("pendiente");

			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/consultarSolicitudes.html");
			$workspace =$this->reemplazar($workspace, "{{algo}}", "SOLICITUDES DE");
			$workspace =$this->reemplazar($workspace, "{{algo2}}", "");
			$plantilla=$this->procesarConsulta($plantilla, $workspace, "Solicitudes", $datos);
			
			return $plantilla;
		}

		public function vistaPedidos(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/operario-pedidos.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaConfiguracion(){
			$plantilla = $this -> cargarConfiguracion();
			$this->mostrarVista($plantilla);
		}

		public function cargarConfiguracion(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/settings.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function init(){
			$plantilla = $this->leerPlantilla("Aplicacion/Vista/principal.html");

			$barraSup=$this->leerPlantilla("Aplicacion/Vista/barraSup.html");
			$barraSup = $this->reemplazar($barraSup, "{{username}}", $_SESSION["username"]);
			$barraSup = $this->reemplazar($barraSup, "{{tipo}}", $_SESSION["tipo"]);
			$barraSup = $this->reemplazar($barraSup, "{{img}}", "2.jpg");

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralOperario.html");

			$plantilla = $this->reemplazar($plantilla, "{{barraSuperior}}", $barraSup);
			$plantilla = $this->reemplazar($plantilla, "{{barraLateral}}", $barraLat);

			return $plantilla;
		}

		public function responderSolicitud($codigo){
			$plantilla = $this -> cargarResponderSolicitud($codigo);
			$this->mostrarVista($plantilla);
		}

		public function cargarResponderSolicitud($codigo){
			$opBD=new OperarioBD();
			$datos=$opBD->getCotizacion($codigo);
			$img=$opBD->getDisenio($datos[0][8]);

			$plantilla = $this -> init();
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
			return $plantilla;
		}

		public function editarSolicitud($codOp, $codCot, $precio, $desc){
			$opBD=new OperarioBD();

			$ok=$opBD->responderCotizacion($codOp,$codCot,$precio, $desc);

			$plantilla=$this->cargarSolicitudes();

			if($ok){
				$plantilla=$this->alerta($plantilla, "COTIZACION ENVIADA EXITOSAMENTE", "");
			}else{
				$plantilla=$this->alerta($plantilla, "COTIZACION NO ENVIADA", "Por favor intentelo nuevamente");
			}

			$this->mostrarVista($plantilla);
		}
		
		public function cambiarPassword($actual, $nueva, $confirmacion){
			$nueva2=$this->encriptarPassword($nueva);
			$confirmacion2=$this->encriptarPassword($confirmacion);

			if($nueva2==$confirmacion2){
				$actual2=$this->encriptarPassword($actual);
				$op=new OperarioBD();
				$ok=$op->cambiarContrasenia($_SESSION["dni"],$actual2,$nueva2);
				if($ok){
					$plantilla=$this->cargarConfiguracion();
					$plantilla=$this->alerta($plantilla, "Contraseña actual cambiada exitosamente", "");
					$this->mostrarVista($plantilla);
				}else{
					$plantilla=$this->cargarConfiguracion();
					$plantilla=$this->alerta($plantilla, "ERROR", "Contraseña incorrecta");
					$this->mostrarVista($plantilla);
				}
			}else{
				$plantilla=$this->cargarConfiguracion();
				$plantilla=$this->alerta($plantilla, "ERROR", "Las contraseñas no son iguales");
				$this->mostrarVista($plantilla);
			}
		}

		public function agregarImagen($nombre, $desc){
			$opBD=new OperarioBD();
			$ok=$opBD->registrarDisenio($nombre,$desc);
			$plantilla=$this->cargarAnadirDis();
			if($ok){
				$plantilla=$this->alerta($plantilla, "DISEÑO AÑADIDO EXITOSAMENTE", "");
			}else{
				$plantilla=$this->alerta($plantilla, "FALLO AL AGREGAR EL DISEÑO", "");
			}
			$this->mostrarVista($plantilla);
		}

		public function procesarConsulta($plantilla, $workspace, $tipo, $datos){

			$tam=count($datos);

			$opBD=new OperarioBD();


			if($tam<=8){
				$slides=$this->leerPlantilla("Aplicacion/Vista/slideConsultarSolicitudes.html");
				$slides=$this->reemplazar($slides, "{{tipo}}", "active-slide");
				$slides=$this->reemplazar($slides, "{{dequien}}", "CLIENTE");

				$filas="";
				for($i=0; $i<$tam; $i++){
					$aux=$this->leerPlantilla("Aplicacion/Vista/filaConsulta.html");

					$datosCliente=$opBD->visualizarCliente($datos[$i][1]);

					$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
					$aux=$this->reemplazar($aux, "{{nombre}}", $datosCliente[0][2]);
					$aux=$this->reemplazar($aux, "{{tel}}", $datosCliente[0][4]);
					$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][4]);
					$aux=$this->reemplazar($aux, "{{quien}}", "Operario");
					$aux=$this->reemplazar($aux, "{{haceAlgo}}", "RESPONDER");

					$filas=$filas.$aux;
				}

				$slides=$this->reemplazar($slides, "{{filas}}", $filas);
				$workspace=$this->reemplazar($workspace, "{{nav}}", "");
				$workspace=$this->reemplazar($workspace, "{{slides}}", $slides);

			}else{
				$totalSlides="";
				$nav=$this->leerPlantilla("Aplicacion/Vista/sliderNav.html");
				$puntos="";

				for($i=0; $i<$tam; $i++){
					$auxSlide=$this->leerPlantilla("Aplicacion/Vista/slideConsultarSolicitudes.html");
					
					if($i==0){
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "active-slide");
						$puntos="<li class='dot active-dot'>&bull;</li>";
					}else{
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "");
						$puntos=$puntos."<li class='dot'>&bull;</li>";
					}
					$slides=$this->reemplazar($slides, "{{dequien}}", "CLIENTE");

					$filas="";
					for($j=0; ($j<7 && $i<$tam); $j++, $i++){
						$aux=$this->leerPlantilla("Aplicacion/Vista/filaConsulta.html");

						$datosCliente=$opBD->visualizarCliente($datos[$i][1]);

						$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
						$aux=$this->reemplazar($aux, "{{nombre}}", $datosCliente[0][2]);
						$aux=$this->reemplazar($aux, "{{tel}}", $datosCliente[0][4]);
						$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][4]);
						$aux=$this->reemplazar($aux, "{{quien}}", "Operario");
						$aux=$this->reemplazar($aux, "{{haceALgo}}", "RESPONDER");

						$filas=$filas.$aux;
					}

					$auxSlide=$this->reemplazar($auxSlide, "{{filas}}", $filas);

					$totalSlides=$totalSlides.$auxSlide;
				}

				$nav=$this->reemplazar($nav, "{{puntos}}", $puntos);
				$workspace=$this->reemplazar($workspace, "{{nav}}", $nav);
				$workspace=$this->reemplazar($workspace, "{{slides}}", $totalSlides);
			}

			
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			
			return $plantilla;
		}
	}
?>