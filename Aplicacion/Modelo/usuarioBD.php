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

	class UsuarioBD extends Modelo
	{

		public function login($DNI,$password)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT nombre, DNI, tipo FROM Usuario WHERE DNI = '".$DNI."' AND password = '".$password."' ");
			$this->desconectar();
			$cont = 0;
			$datos= array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos, $fila);
				$cont++;
			}
			
			if($cont==1)
			{
				return $datos;
			}
			else
			{
				return false;
			}
			
		}

	}
?>