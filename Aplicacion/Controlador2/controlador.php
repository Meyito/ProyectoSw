<?php

	/**
 	* .............................................
 	* UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
 	*    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
 	*      LAUNDRYSOFT - LAVA RAPID JEANS S.A.S
 	*             SAN JOSE DE CUCUTA-2015
	 * ............................................
 	*/


	include_once "Aplicacion/Modelo/AdministradorBD.php";
	include_once "Aplicacion/Modelo/clienteBD.php";
	include_once "Aplicacion/Modelo/operarioBD.php";
	include_once "Aplicacion/Modelo/usuarioBD.php";

	/**
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	* @author Edgar Yesid Garcia Ortiz 1150967
	* @author Fernando Antonio Peñaranda Torres 1150684
	*/
	

	class Controlador{

	/*GENERALES*/

		/**
		* Metodo que carga un archivo de la vista
		* @param $plantilla - Ruta del archivo a cargar
		* @return string con el valor html que debe ser mostrado
		*/
		public function leerPlantilla($plantilla){
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
		*	Método que se encarga de agregar una alerta al documento html
		*	@param   $plantilla - plantilla sobre la cua se debe mostrar la alerta
		*	@param   $titulo - titulo de la alerta
		*	@param   $alerta - mensaje de la alerta
		*	@return  un string del html de la plantilla que permite la ejecucion de la alerta
		*/
		public function alerta($plantilla, $titulo, $alerta)
		{
			return $plantilla."<script>alerta(\"".$titulo."\",\"".$alerta."\",3000);</script>";
		}

	/*VISTAS*/
		/**
		* Metodo que toma el archivo estatico de la pagina inicial y lo carga en pantalla
		*/
		public function inicio(){
			$inicio = $this->leerPlantilla("Aplicacion/Vista/index.html");
			$this->mostrarVista($inicio);
		}

	/*MÉTODOS AUXILIARES*/

		/**
		*	Metodo que inicia sesión y crea una clase del tipo de usuario correspondiente
		*	@param $cedula - Numero de cedula del usuario a verificar
		*	@param $contrasena - Contrasena del usuario a verificar
		*/
		public function login($cedula, $password){
			$passwordSSH=$this->encriptarPassword($password);

			$userBD=new UsuarioBD();
			$datos=$userBD->login($cedula, $passwordSSH);

			if($datos!=false){
				$this->cargarPerfil($datos);
				header('Location: index.php');
			}else{
				$inicio = $this->leerPlantilla("Aplicacion/Vista/index.html");
				$inicio = $this->alerta($inicio, "No se ha podido iniciar sesión", "Verifique sus datos e intentelo nuevamente");
				$this->mostrarVista($inicio);
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

		/**
		*	Método que se encarga de iniciar la variable de sesión con el username y la foto de perfil del usuario
		*	@param   $datos - Array con los datos del usuario
		*/
		public function cargarPerfil($datos){
			$_SESSION["username"]=$datos[0][0];
			$_SESSION["dni"]=$datos[0][1];
			$tipo="";
			if($datos[0][2]==1){
				$tipo="Administrador";
				$_SESSION["img"]="admin.png";
			}else if($datos[0][2]==2){
				$tipo="Operario";
			}else{
				$tipo="Cliente";
				$_SESSION["img"]="usuario.png";
			}
			$_SESSION["tipo"]=$tipo;
		}

		public function init($barraLat){
			$plantilla = $this->leerPlantilla("Aplicacion/Vista/principal.html");

			$barraSup=$this->leerPlantilla("Aplicacion/Vista/barraSup.html");
			$barraSup = $this->reemplazar($barraSup, "{{username}}", $_SESSION["username"]);
			$barraSup = $this->reemplazar($barraSup, "{{tipo}}", $_SESSION["tipo"]);
			$barraSup = $this->reemplazar($barraSup, "{{img}}", $_SESSION["img"]);
			$plantilla = $this->reemplazar($plantilla, "{{barraSuperior}}", $barraSup);
			$plantilla = $this->reemplazar($plantilla, "{{barraLateral}}", $barraLat);

			return $plantilla;
		}

		/**
		*	Método que se encarga de asignar el nombre con el que se guardará la imagen de perfil del usuario
		*	@param   $imagen - nombre de la nueva imagen de perfil del usuario
		*	@return  un string con el nombre con el que se almacenará la imagen
		*/
		public function procesarImagen($imagen)
		{
			$nombre = $_FILES['imagen']['name'];
			if($nombre!=""){
				if(!file_exists("Estatico/img/modelo/".$nombre)){
					move_uploaded_file($_FILES['imagen']['tmp_name'],"Estatico/img/modelo/".$nombre);
				}else{
					$cont=1;
					while(file_exists("Estatico/img/modelo/"."[".$cont."]".$nombre)){
						$cont++;
					}
					move_uploaded_file($_FILES['imagen']['tmp_name'],"Estatico/img/modelo/"."[".$cont."]".$nombre);
					$nombre =  "[".$cont."]".$_FILES['imagen']['name'];
				}
			}
			return $nombre;
		}

	}
?>