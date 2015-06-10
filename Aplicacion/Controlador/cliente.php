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

		public function inicioValidado(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/cliente-home.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaPedidos(){
			$clBD=new ClienteBD();
			$datos=$clBD->visualizarPedidos("");

			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/consultarPedido.html");
			
			$plantilla=$this->procesarPedidos($plantilla, $workspace, "Operario", $datos);

			$this->mostrarVista($plantilla);
		}

		public function editarSolicitud($codigoCotizacion, $cantidad, $urlImagen, $descripcion){
			$clBD=new ClienteBD();
			$codigoDisenio=$clBD->obtenerCodigoDisenio($urlImagen);
			$ok=$clBD->modificarCotizacion($codigoCotizacion,$cantidad,$codigoDisenio[0][0],$descripcion);
			return $ok;
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

		public function vistaCotizaciones(){
			$plantilla = $this -> cargarCotizaciones();
			$this->mostrarVista($plantilla);
		}

		public function cargarCotizaciones(){
			$clBD=new ClienteBD();

			$datos=$clBD->visualizarCotizaciones($_SESSION["dni"],"respuesta");

			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/consultarSolicitudes.html");
			$workspace =$this->reemplazar($workspace, "{{algo}}", "");
			$workspace =$this->reemplazar($workspace, "{{algo2}}", "ES");
			$plantilla=$this->procesarConsulta($plantilla, $workspace, "Solicitudes", $datos);
			
			return $plantilla;
		}

		public function crearPedido(){
			$plantilla = $this -> cargarCrearPedido();
			$this->mostrarVista($plantilla);
		}

		public function cargarCrearPedido(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/crearPedido.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
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
			$barraSup = $this->reemplazar($barraSup, "{{img}}", "usuario.png");

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");

			$plantilla = $this->reemplazar($plantilla, "{{barraSuperior}}", $barraSup);
			$plantilla = $this->reemplazar($plantilla, "{{barraLateral}}", $barraLat);

			return $plantilla;
		}

		public function abrirCotizacion($codCot){
			$clBD=new ClienteBD();
			$datos=$clBD->getCotizacion($codCot);
			$img=$clBD->getDisenio($datos[0][8]);

			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/responderSolicitudOperario.html");


			$workspace=$this->reemplazar($workspace, "{{boton}}", "<form action='index.php' method='POST'>
			<input type='text' class='ocultar' name='codCot' value='{{codigoCot}}'>
			<input type='text' class='ocultar' name='tipo' value='aceptarCotizacion'>
			<input class='botonEnviar botonROJO boton3' type='submit' value='ACEPTAR'>
			</form>");

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

		public function cambiarPassword($actual, $nueva, $confirmacion){
			$nueva2=$this->encriptarPassword($nueva);
			$confirmacion2=$this->encriptarPassword($confirmacion);

			if($nueva2==$confirmacion2){
				$actual2=$this->encriptarPassword($actual);
				$cliente=new ClienteBD();
				$ok=$cliente->cambiarContrasenia($_SESSION["dni"],$actual2,$nueva2);
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

		public function consultarCodDis($nombre){
			//AQUI LLAMO AL METODO PENDIENTE DE DANIEL
			$cBD=new ClienteBD();
			$cod=$cBD->obtenerCodigoDisenio($nombre);

			return $cod[0][0];
		}

		public function solicitarCotizacion($dni, $nombre, $cant, $desc){
			$plantilla=$this->cargarCrearPedido();

			if($cant>=70){

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
				$plantilla=$this->alerta($plantilla, "SOLICITUD NO ENVIADA", "Solo se pueden realizar solicitudes para <br> lotes de 70 o más Jeans");
			}

			

			$this->mostrarVista($plantilla);
		}

		public function registrarDisenios($nombre,$desc){
			$cBD=new ClienteBD();

			$cBD->registrarDisenios($nombre,$desc);

			return;
		}

		public function procesarConsulta($plantilla, $workspace, $tipo, $datos){

			$tam=count($datos);

			$clBD=new ClienteBD();


			if($tam<=8){
				$slides=$this->leerPlantilla("Aplicacion/Vista/slideConsultarSolicitudes.html");
				$slides=$this->reemplazar($slides, "{{tipo}}", "active-slide");
				$slides=$this->reemplazar($slides, "{{dequien}}", "OPERARIO");

				$filas="";
				for($i=0; $i<$tam; $i++){
					$aux=$this->leerPlantilla("Aplicacion/Vista/filaConsulta.html");

					$datosOp=$clBD->visualizarOperario($datos[$i][2]);

					$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
					$aux=$this->reemplazar($aux, "{{nombre}}", $datosOp[0][2]);
					$aux=$this->reemplazar($aux, "{{tel}}", "5782585");
					$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][4]);
					$aux=$this->reemplazar($aux, "{{quien}}", "Cliente");
					$aux=$this->reemplazar($aux, "{{haceAlgo}}", "ABRIR");

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
					$slides=$this->reemplazar($slides, "{{dequien}}", "OPERARIO");

					$filas="";
					for($j=0; ($j<7 && $i<$tam); $j++, $i++){
						$aux=$this->leerPlantilla("Aplicacion/Vista/filaConsulta.html");

						$datosOp=$clBD->visualizarOperario($datos[$i][2]);

						$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
						$aux=$this->reemplazar($aux, "{{nombre}}", $datosOp[0][2]);
						$aux=$this->reemplazar($aux, "{{tel}}", "5782585");
						$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][4]);
						$aux=$this->reemplazar($aux, "{{quien}}", "Cliente");
						$aux=$this->reemplazar($aux, "{{haceAlgo}}", "ABRIR");
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

		public function procesarPedidos($plantilla, $workspace, $cargo, $datos){
			$tam=count($datos);
			$cliente=new ClienteBD();

			if($tam<=8){
				$slides=$this->leerPlantilla("Aplicacion/Vista/sliderConsultarPedidos.html");
				$slides=$this->reemplazar($slides, "{{tipo}}", "active-slide");

				$filas="";
				for($i=0; $i<$tam; $i++){
					$aux=$this->leerPlantilla("Aplicacion/Vista/filaPedidos.html");

					$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);

					$dato2=$cliente->getEstado($datos[$i][10]);
					$aux=$this->reemplazar($aux, "{{estado}}", $dato2[0][1]);

					$dato2=$cliente->visualizarCliente($datos[$i][5]);
					$aux=$this->reemplazar($aux, "{{cliente}}", $dato2[0][2]);

					$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][1]);

					$dato2=$cliente->visualizarOperario($datos[$i][6]);
					$aux=$this->reemplazar($aux, "{{operario}}", $dato2[0][2]);
					$aux=$this->reemplazar($aux, "{{precio}}", $datos[$i][8]);

					

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
					$auxSlide=$this->leerPlantilla("Aplicacion/Vista/slideConsultarPedidos.html");
					
					if($i==0){
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "active-slide");
						$puntos="<li class='dot active-dot'>&bull;</li>";
					}else{
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "");
						$puntos=$puntos."<li class='dot'>&bull;</li>";
					}

					$filas="";
					for($j=0; ($j<7 && $i<$tam); $j++, $i++){
						$aux=$this->leerPlantilla("Aplicacion/Vista/filaPedidos.html");

						$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);

						$dato2=$cliente->getEstado($datos[$i][10]);
						$aux=$this->reemplazar($aux, "{{estado}}", $dato2[0][1]);

						$dato2=$cliente->visualizarCliente($datos[$i][5]);
						$aux=$this->reemplazar($aux, "{{cliente}}", $dato2[0][2]);

						$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][1]);

						$dato2=$cliente->visualizarOperario($datos[$i][6]);
						$aux=$this->reemplazar($aux, "{{operario}}", $dato2[0][2]);
						$aux=$this->reemplazar($aux, "{{precio}}", $datos[$i][8]);

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