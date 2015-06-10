<?php

	/**
 	* .............................................
 	* UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
 	*    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
 	*      LAUNDRYSOFT - LAVA RAPID JEANS S.A.S
 	*             SAN JOSE DE CUCUTA-2015
	 * ............................................
 	*/

	/**
	* Clase encargada del manejo de consultas a la base de datos. 
	* Esta clase será extendida por las demas clases del modelo
	*/

	/**
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	* @author Edgar Yesid Garcia Ortiz 1150967
	* @author Fernando Antonio Peñaranda Torres 1150684
	*/
	
	class Modelo{

		private $conexion;

		/**
		*	Método que se encarga de realizar la conexión a la Base de Datos
		*	@param $host - Nombre del servidor de Base de Datos
		*	@param $usuario - Nombre del usuario root
		*	@param $contrasena - Contraseña del usuario root
		*	@param $base - Nombre de la base de datos
		*/
		public function conectar()
		{
			$this->conexion = mysqli_connect("localhost","root","","Lavanderia") or die(mysql_error($conexion));
		}

		/**
		*	Método que se encarga de cerrar la conexión con la Base de Datos.
		*/
		public function desconectar()
		{
			mysqli_close($this->conexion);
		}

		/**
		*	Método que se encarga de realizar una operación en alguna tabla de la Base de Datos(Inserción, Borrado, Eliminación, Actualización).
		*	@param $sql - Revise un String con la operación a Realizar
		*	@return un fetch_array o un boolean dependiendo de la consulta realizada
		*/
		public function consultar($sql)
		{
			return mysqli_query($this->conexion,$sql);
		}

	}
?>