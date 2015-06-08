<?php

	require_once "Aplicacion/Controlador/controlador.php";
	include_once "Aplicacion/Modelo/AdministradorBD.php";

	class Administrador extends Controlador{

		public function inicioValidado(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/admin-home.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function menuClientes(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/admin-gestion-clientes.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function menuOperarios(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/admin-gestion-operarios.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaPedidos(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/admin-pedidos.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaConsultarClientes(){
			$plantilla=$this->procesarConsulta();
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

		public function vistaRegistroCliente(){
			$plantilla=$this->cargarRegistroCliente();
			$this->mostrarVista($plantilla);
		}

		public function cargarRegistroCliente(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/registro.html");
			$workspace = $this->reemplazar($workspace, "{{tipo}}", "registroCliente");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function vistaRegistroOperario(){
			$plantilla = $this->cargarRegistroOperario();
			$this->mostrarVista($plantilla);
		}

		public function cargarRegistroOperario(){
			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/registro.html");
			$workspace = $this->reemplazar($workspace, "{{tipo}}", "registroOperario");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function init(){
			$plantilla = $this->leerPlantilla("Aplicacion/Vista/principal.html");

			$barraSup=$this->leerPlantilla("Aplicacion/Vista/barraSup.html");
			$barraSup = $this->reemplazar($barraSup, "{{username}}", $_SESSION["username"]);
			$barraSup = $this->reemplazar($barraSup, "{{tipo}}", $_SESSION["tipo"]);
			$barraSup = $this->reemplazar($barraSup, "{{img}}", "2.jpg");

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");

			$plantilla = $this->reemplazar($plantilla, "{{barraSuperior}}", $barraSup);
			$plantilla = $this->reemplazar($plantilla, "{{barraLateral}}", $barraLat);

			return $plantilla;
		}

		public function registrarCliente($nombre, $cedula, $password, $email, $direccion, $tel){
			$admin=new AdministradorBD();
			$password2=$this->encriptarPassword($password);
			$ok=$admin->registrarCliente($cedula,$password2,$nombre,$tel,$email,$direccion);
			if($ok){
				$plantilla = $this->cargarRegistroCliente();
				$plantilla = $this->alerta($plantilla, "Registro Exitoso", "");
				$this->mostrarVista($plantilla);
			}else{
				$plantilla = $this->cargarRegistroCliente();
				$plantilla = $this->alerta($plantilla, "Registro No Exitoso", "Por favor verifique que los datos ingresados sean validos");
				$this->mostrarVista($plantilla);
			}
		}

		public function registrarOperario($nombre, $cedula, $password, $email, $direccion, $tel){
			$admin=new AdministradorBD();
			$password2=$this->encriptarPassword($password);
			$ok=$admin->registrarOperario($cedula,$password2,$nombre,$tel,$email,$direccion);
			if($ok){
				$plantilla = $this->cargarRegistroOperario();
				$plantilla = $this->alerta($plantilla, "Registro Exitoso", "");
				$this->mostrarVista($plantilla);
			}else{
				$plantilla = $this->cargarRegistroOperario();
				$plantilla = $this->alerta($plantilla, "Registro No Exitoso", "Por favor verifique que los datos ingresados sean validos");
				$this->mostrarVista($plantilla);
			}
		}

		public function cambiarPassword($actual, $nueva, $confirmacion){
			$nueva2=$this->encriptarPassword($nueva);
			$confirmacion2=$this->encriptarPassword($confirmacion);

			if($nueva2==$confirmacion2){
				$actual2=$this->encriptarPassword($actual);
				$admin=new AdministradorBD();
				$ok=$admin->cambiarContrasenia($_SESSION["dni"],$actual2,$nueva2);
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

		public function procesarConsulta(){
			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarClientes();

			$tam=count($datos);

			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/consultarClientes.html");

			if($tam<=8){
				$slides=$this->leerPlantilla("Aplicacion/Vista/slideConsultarCliente.html");
				$slides=$this->reemplazar($slides, "{{tipo}}", "active-slide");

				$filas="";
				for($i=0; $i<$tam; $i++){
					$aux=$this->leerPlantilla("Aplicacion/Vista/filaCliente.html");
					$aux=$this->reemplazar($aux, "{{nombre}}", $datos[$i][2]);
					$aux=$this->reemplazar($aux, "{{cedula}}", $datos[$i][0]);
					$aux=$this->reemplazar($aux, "{{tel}}", $datos[$i][4]);
					$aux=$this->reemplazar($aux, "{{direccion}}", $datos[$i][6]);
					$aux=$this->reemplazar($aux, "{{correo}}", $datos[$i][5]);

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
					$auxSlide=$this->leerPlantilla("Aplicacion/Vista/slideConsultarCliente.html");
					
					if($i==0){
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "active-slide");
						$puntos="<li class='dot active-dot'>&bull;</li>";
					}else{
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "");
						$puntos=$puntos."<li class='dot'>&bull;</li>";
					}

					$filas="";
					for($j=0; ($j<7 && $i<$tam); $j++, $i++){
						$aux=$this->leerPlantilla("Aplicacion/Vista/filaCliente.html");
						$aux=$this->reemplazar($aux, "{{nombre}}", $datos[$i][2]);
						$aux=$this->reemplazar($aux, "{{cedula}}", $datos[$i][0]);
						$aux=$this->reemplazar($aux, "{{tel}}", $datos[$i][4]);
						$aux=$this->reemplazar($aux, "{{direccion}}", $datos[$i][6]);
						$aux=$this->reemplazar($aux, "{{correo}}", $datos[$i][5]);

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