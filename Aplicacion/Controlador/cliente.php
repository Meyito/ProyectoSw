<?php

	require_once "Aplicacion/Controlador/controlador.php";
	include_once "Aplicacion/Modelo/clienteBD.php";


	class Cliente extends Controlador{

		public function inicioValidado(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/cliente-home.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaPedidos(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/cliente-pedidos.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaCotizaciones(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/cliente-cotizaciones.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
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
			$barraSup = $this->reemplazar($barraSup, "{{img}}", "2.jpg");

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralCliente.html");

			$plantilla = $this->reemplazar($plantilla, "{{barraSuperior}}", $barraSup);
			$plantilla = $this->reemplazar($plantilla, "{{barraLateral}}", $barraLat);

			return $plantilla;
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
			//AQUI LLAMO AL METODO REGISTRAR DE DANIEL :3
			/*echo $dni."<br>";
			echo $codImagen."<br>";
			echo $cant."<br>";
			echo $desc."<br>";*/
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
	}
?>