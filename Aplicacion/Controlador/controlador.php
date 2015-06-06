<?php

	class Controlador{

		/**
		* Metodo que toma el archivo estatico de la pagina inicial y lo carga en pantalla
		*/
		public function inicio(){
			$inicio = $this->leerPlantilla("Aplicacion/Vista/index.html");
			$this->mostrarVista($inicio);
		}

		/**
		* Metodo que carga un archivo de la vista
		* @param $plantilla - Ruta del archivo a cargar
		* @return string con el valor html que debe ser mostrado
		*/
		public function leerPlantilla($plantilla)
		{
			return file_get_contents($plantilla);
		}

		/**
		*	Toma una vista y la muestra en pantalla en el cliente
		* 	@param $vista - vista preconstruida para mostrar en el navegador
		*/
		public function mostrarVista($vista)
		{
			echo $vista;
		}

		/**
		*	Reemplaza un valor por otro en una cadena de texto. Utilizado para formatear las vistas
		* 	@param $ubicacion - String donde se reemplazará el valor
		* 	@param $cadenaReemplazar - Cadena que será buscada en la $ubicación
		*	@param $reemplazo - Cadena con la que se reemplazará $cadenaReemplazar
		*	@return cadena sobreescrita
		*/
		public function reemplazar($ubicacion, $cadenaReemplazar, $reemplazo)
		{
			return str_replace($cadenaReemplazar, $reemplazo, $ubicacion);
		}

		/**
		*	Método que se encarga de iniciar la variable de sesión con el username y la foto de perfil del usuario
		*	@param   $nombre - nombre del usuario
		*/
		public function cargarPerfil($cedula)
		{
			/*
			$usuario = new usuarioBD();
			$datos = $usuario->obtenerDatos($cedula);
			$_SESSION["username"] = $datos[1];
			*/

			$_SESSION["username"]="Angie Melissa D.";
		}

		/**
		*	Metodo que inicia sesión y crea una clase del tipo de usuario correspondiente
		*	@param $cedula - Numero de cedula del usuario a verificar
		*	@param $contrasena - Contrasena del usuario a verificar
		*/
		public function login($cedula, $password){
			$passwordSSH=$this->encriptarPassword($password);

			//Conexion al Modelo de Usuarios
			//$usuarioBD = new usuarioBD();

			//se validan los datos correspondientes
			//$datos = $usuarioBD->login($cedula, $passwordSSH);
			
			/*Si los datos son  correctos
			if($datos!=false){
				$_SESSION["nombre"] = $datos;

				Aqui se debe validar tambien que el usuario pertenezca tambien al tipo de 
				cargo que dijo(admin/cliente/operario), si esta bien se asigna la variable
				de sesion correspondiente. Si no lance una alerta
				$_SESSION["tipoUsuario"] = "usuario";

				se carga el perfil con los datos necesarios
				$this->cargarPerfil($datos);
				header('Location: index.php');
			}*/

			/*else{
				se lanza mensaje de error
				$this->inicioErrorLog();
			}*/

			//esto es de prueba
			$datos=$_POST["cedula"];
			if($_POST["tipo"]=="Administrador"){
				$_SESSION["tipo"]="Administrador";
				$this->cargarPerfil($datos);
				header('Location: index.php');
			}else if($_POST["tipo"]=="Cliente"){
				$_SESSION["tipo"]="Cliente";
				$this->cargarPerfil($datos);
				header('Location: index.php');
			}else if($_POST["tipo"]=="Operario"){
				$_SESSION["tipo"]="Operario";
				$this->cargarPerfil($datos);
				header('Location: index.php');
			}
		}

		/**
		*	Metodo de seguridad. Encripta la contraseña mediante el algoritmo SHA1. 
		*	Todas las validaciones y almacenamientos se hacen en este sistema.
		*	Las bases de datos no guardaran contraseñas tal cual las incluye el usuario.
		*	@param $password - Contraseña a encriptar
		*	@return contraseña encriptada en SHA1
		*/
		public function encriptarPassword($password){
			return sha1($password);
		}
	}
?>