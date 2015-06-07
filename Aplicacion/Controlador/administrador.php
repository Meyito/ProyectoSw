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
	}
?>