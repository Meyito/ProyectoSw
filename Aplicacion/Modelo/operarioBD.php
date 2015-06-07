<?php

	include_once "Aplicacion/Modelo/modelo.php";

	class Operario extends Modelo
	{
		public function visualizarPedidosPendientes()
		{
			$this->conectar();
			$aux = $consultar("SELECT * FROM Pedido WHERE estado='pendiente'");
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{	
				array_push($datos,$fila);
			}
			return $datos;
		}
		public function visualizarCotizacion()
		{
			$this->conectar();
			$aux = $consultar("SELECT * FROM Cotizacion");
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos, $fila);
			}
			return $datos;
		}
		public function responderCotizacion($codigo,$descripcion,$estado,$precioTotal)
		{
			$this->conectar();
			if($descripcion == "")
			{
				$aux = $consultar("UPDATE Cotizacion SET estado = '".$estado."',precioTotal = '".$precioTotal."'
									WHERE codigo='".$codigo."'");
			}
			else
			{
				$aux = $consultar("UPDATE Cotizacion SET descripcion = '".$descripcion."',estado = '".$estado."',precioTotal = '".$precioTotal."'
									WHERE codigo='".$codigo."'");
			}
			$this->desconectar();
			return $aux;
		}
	}

?>