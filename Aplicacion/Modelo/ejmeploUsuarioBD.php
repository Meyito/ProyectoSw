<?php

	/**
 	* .............................................
 	* UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
 	*    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
 	*      LAUNDRYSOFT - LAVA RAPID JEANS S.A.S
 	*             SAN JOSE DE CUCUTA-2015
	 * ............................................
 	*/

	include_once "Aplicacion/Modelo/modelo.php";

	/**
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	* @author Edgar Yesid Garcia Ortiz 1150967
	* @author Fernando Antonio Peñaranda Torres 1150684
	*/

	/**
	* Clase encargada del manejo de los usuarios no docentes en la base de datos. Recibe llamados desde el controlador.php
	* Esta clase extiende de la clase modelo
	*/
	class UsuarioBD extends Modelo{

		//Diviertete, att Meli ^^

		/**
		*	Método que se encarga de crear la consulta para guardar un nuevo usuario en la Base de Datos.
		*	@param $username - Username del usuario a registrar
		*	@param $nombre - Nombre del usuario a registrar
		*	@param $codigo - Codigo del usuario a registrar
		*	@param $email - Email del usuario a registrar
		*	@param $contraseña - Contraseña del usuario a registrar
		*	@param $curso - Curso al que pertenece el usuario a registrar
		*/
		public function registrar($username, $nombre, $codigo, $email, $contrasena, $curso)
		{
			$this->conectar();
			if($curso==""){
				$this->consultar("INSERT INTO usuario VALUES('".$nombre."','".$username."','".$email."','".$contrasena."','".$codigo."',NULL,'','0','1','0','perfil.jpg', '1')");		
			}else{
				$this->consultar("INSERT INTO usuario VALUES('".$nombre."','".$username."','".$email."','".$contrasena."','".$codigo."','".$curso."','','0','1','0','perfil.jpg', '1')");	
			}
			$this->desconectar();
		}


		/**
		*	Método que se encarga de crear la consulta para loguear un usuario en la Aplicación
		*	@param $username - Username del usuario a loguear
		*	@param $contrasena -Contraseña encriptada del usuario a loguear
		*	@return El nombre del usuario si este se conecto de manera correcta, de lo contrario retorna false
		*/
		public function login($username, $contrasena)
		{
			$this->conectar();
			$aux=$this->consultar("SELECT username FROM usuario WHERE username='".$username."' AND contrasenaSH1='".$contrasena."'");
			$this->desconectar();
			$cont=0;
			$nombre="";

			while($fila=mysqli_fetch_array($aux)){
				$nombre=$fila[0];
				$cont++;
			}

			if($cont==1){
				return $nombre;
			}else{
				return false;
			}
		}


		/**
		*	Método que se encarga de consultar los datos de un usuario
		*	@param $username - Username del usuario 
		*	@return Un array con todos los datos del usuario si la consulta se realizo de manera correcta, de lo contrario un boolean
		*/
		public function obtenerDatos($username)
		{
			$this->conectar();
			$aux=$this->consultar("SELECT * FROM usuario WHERE username='".$username."'");
			$this->desconectar();
			$cont=0;
			$datos=array();

			while($fila=mysqli_fetch_array($aux)){
				$datos = $fila;
				$cont++;
			}

			if($cont==1){
				return $datos;
			}else{
				return false;
			}
		}


		/**
		*	Método que se encarga de actualizar el nivel de un usuario
		*	@param $username - Username del usuario 
		*	@param $nivel - Nuevo nivel
		*/
		public function actualizarNivel($username,$nivel)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET nivel='".$nivel."' WHERE username='".$username."'");
			$this->desconectar();
		}


		/**
		*	Método que se encarga de actualizar el subnivel de un usuario
		*	@param $username - Username del usuario 
		*	@param $subnivel - Nuevo subnivel
		*/
		public function actualizarSubnivel($username,$subnivel)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET subnivel='".$subnivel."' WHERE username='".$username."'");
			$this->desconectar();
		}


		/**
		*	Método que se encarga de actualizar el puntaje de un usuario
		*	@param $username - Username del usuario 
		*	@param $puntos - Cantidad de puntos nuevos que recibe el usuario
		*/
		public function actualizarPuntaje($username, $puntos)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET puntaje=".$puntos." WHERE username='".$username."'");
			$this->desconectar();
		}


		/**
		*	Método que se encarga de obtener el nivel de un usuario
		*	@param $username - Username del usuario 
		*	@return Un string con el nivel del usuario si la consulta se realizo de manera correcta
		*/
		public function getNivel($username)
		{
			$this->conectar();
			$aux=$this->consultar("SELECT nivel FROM usuario WHERE username='".$username."'");
			$this->desconectar();
			$nivel="";

			while($fila=mysqli_fetch_array($aux)){
				$nivel=$fila[0];
			}
			return $nivel;
		}


		/**
		*	Método que se encarga de obtener el subnivel de un usuario
		*	@param $username - Username del usuario 
		*	@return Un string con el subnivel del usuario si la consulta se realizo de manera correcta
		*/
		public function getSubnivel($username)
		{
			$this->conectar();
			$aux=$this->consultar("SELECT subnivel FROM usuario WHERE username='".$username."'");
			$this->desconectar();
			$subnivel="";

			while($fila=mysqli_fetch_array($aux)){
				$subnivel=$fila[0];
			}
			return $subnivel;
		}


		/**
		*	Método que se encarga de actualizar el nombre de un usuario
		*	@param $username - Username del usuario 
		*	@param $nombre - Nuevo nombre de usuario
		*/
		public function actualizarNombre($username,$nombre)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET nombre='".$nombre."' WHERE username='".$username."'");
			$this->desconectar();
			return $aux;
		}


		/**
		*	Método que se encarga de actualizar la descripcion de un usuario
		*	@param $username - Username del usuario 
		*	@param $descripción - Nueva descripción del usuario 
		*/
		public function actualizarDescripcion($username,$descripcion)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET descripcion='".$descripcion."' WHERE username='".$username."'");
			$this->desconectar();
			return $aux;
		}


		/**
		*	Método que se encarga de actualizar la imagen de perfil de un usuario
		*	@param $username - Username del usuario 
		*	@param $rutaImagen - Nueva imagen de perfil
		*/
		public function actualizarImagen($username,$rutaImagen)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET fotoPerfil='".$rutaImagen."' WHERE username='".$username."'");
			$this->desconectar();
			return $aux;
		}


		/**
		*	Método que se encarga de actualizar la imagen de portada de un usuario
		*	@param $username - Username del usuario 
		*	@param $portada - Nuevo idntificador de portada
		*/
		public function actualizarPortada($username,$portada)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET fotoPortada='".$portada."' WHERE username='".$username."'");
			$this->desconectar();
			return $aux;
		}
		

		/**
		*	Método que se encarga de actualizar los datos de un usuario
		*	@param $username - Username del usuario 
		*	@param $nombre - Nuevo nombre de usuario
		*	@param $contraseña - Nueva contraseña del usuario
		*	@param $curso - Nuevo curso al que pertenece el usuario
		*	@param $descripción - Nueva descripción del usuario 
		*	@param $rutaImagen - Nueva imagen de perfil
		*	@param $portada - Nuevo idntificador de portada
		*/
		public function actualizarDatos($username, $nombre, $descripcion, $rutaImagen, $portada)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET nombre='".$nombre."',  descripcion='".$descripcion."', fotoPerfil='".$rutaimagen."', fotoPortada='".$portada."' WHERE username='".$username."'");
			$this->desconectar();
		}


		/**
		*	Método que se encarga de registrar las medallas que halla ganado un usuario
		*	@param $username - Username del usuario 
		*	@param $logro - Logro de la nueva medalla que gano el usuario
		*/
		public function registrarMedalla($username, $logro)
		{
			$this->conectar();
			$this->consultar("INSERT INTO usuario-medalla VALUES('".$username."','".$logro."')");
			$this->desconectar();
		}


		/**
		*	Método que lista todas las medallas que puede ganar un usuario
		*	@return Una matriz donde cada fila es una medalla(logro, tipo)
		*/
		public function listarMedallas()
		{
			$this->conectar();
			$aux=$this->consultar("SELECT * FROM medalla");
			$this->desconectar();
			$datos=array();

			while($fila=mysqli_fetch_array($aux)){
				array_push($datos, $fila);
			}

			return $datos;
		}


		/**
		*	Método que se encarga de consultar los datos de un usuario
		*	@param $username - Username del usuario 
		*	@return Un array con todos los datos del usuario 
		*/
		public function getUsuario($username){
			$this->conectar();
			$aux=$this->consultar("SELECT * FROM usuario WHERE username='".$username."'");
			$this->desconectar();
			$datos=array();

			while($fila=mysqli_fetch_array($aux)){
				array_push($datos, $fila);
			}

			return $datos;
		}


		/**
		*	Método que lista todas las medallas que tiene un usuario
		*	@param $username - Nombre del usuario
		*	@return Un array donde cada posición es una medalla obtenida por el usuario, en caso de no haber medallas retorna false
		*/
		public function listarMedallasUsuario($username)
		{
			$this->conectar();
			$aux=$this->consultar("SELECT medalla.logro, medalla.tipo FROM medalla, usuarioMedalla WHERE usuarioMedalla.username='".$username."' AND medalla.logro = usuarioMedalla.logro");
			$this->desconectar();
			$datos=array();

			while($fila=mysqli_fetch_array($aux)){
				array_push($datos, $fila);
			}

			return $datos;
		}


		/**
		*	Método que se encarga de cambiar el password de un usuario
		*	@param $username - Username del usuario 
		*	@param $actual - Contraseña actual del usuario
		*	@param $nueva - Nueva contraseña del usuario
		*/
		public function cambiarPassword($usuario, $actual, $nueva)
		{
			$this->conectar();
			$aux=$this->consultar("UPDATE usuario SET contrasenaSH1='".$nueva."' WHERE username='".$usuario."' AND contrasenaSH1='".$actual."'");
			$this->desconectar();
			return $aux;
		}


		/**
		*	Método que se encarga de consultar nombre de un usuario a traves de su correo
		*	@param $correo - Correo del usuario
		*	@return nombre del usuario
		*/
		public function buscarCorreo($correo)
		{
			$this->conectar();
			$aux=$this->consultar("SELECT nombre FROM usuario WHERE correo='".$correo."'");
			$this->desconectar();
			return mysqli_fetch_array($aux)[0];
		}


		/**
		*	Método que se encarga de consultar username de un usuario a traves de su correo
		*	@param $correo - Correo del usuario
		*	@return nombre del usuario
		*/
		public function buscarUsername($correo)
		{
			$this->conectar();
			$aux=$this->consultar("SELECT username FROM usuario WHERE correo='".$correo."'");
			$this->desconectar();
			return mysqli_fetch_array($aux)[0];
		}


		/**
		*	Método que se encarga de consultar la contraseña de un usuario a traves de su correo
		*	@param $correo - Correo del usuario
		*	@return contraseña encriptada del usuario
		*/
		public function buscarps($correo)
		{
			$this->conectar();
			$aux=$this->consultar("SELECT contrasenaSH1 FROM usuario WHERE correo='".$correo."'");
			$this->desconectar();
			return mysqli_fetch_array($aux)[0];
		}	
	}
	
?>