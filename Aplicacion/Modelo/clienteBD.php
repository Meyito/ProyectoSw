<?php

include_once "Aplicacion/Modelo/modelo.php";

class ClienteBD extends Modelo
{

	public function login($DNI,$password,$tipo)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT nombre FROM Usuario WHERE DNI = '".$DNI."' 
									AND password = '".$password."' AND tipo = ".$tipo." ");
			$this->desconectar();
			$cont = 0;
			$nombre = "";
			while($fila = mysqli_fetch_array($aux))
			{
				$nombre = $fila[0];
				$cont++;
			}
			
			if($cont==1)
			{
				return $nombre;
			}
			else
			{
				return false;
			}
			
		}

	public function cambiarContrasenia($DNI,$password,$newPassword)
	{
		$this->conectar();
		$aux = $this->consultar("SELECT DNI FROM Usuario WHERE DNI = '".$DNI."' 
								AND password = '".$password."'");
		if($aux!=false)
		{
			$aux = $this->consultar("UPDATE Usuario SET password = '".$newPassword."'
									WHERE DNI = '".$DNI."' AND password = '".$password."'");
			
			if($aux)
			{
				$this->desconectar();
				return true;
			}
		}
		$this->desconectar();
		return false;
	}
	public function visualizarPedidosVigentes()
	{
		$this->conectar();
		$aux = $this->consultar("SELECT * FROM Pedido WHERE estado = 'vigente'");
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos, $fila);
		}
		return $datos;
	}
	public function visualizarPedidosHistoricos()
	{
		$this->conectar();
		$aux = $this->consultar("SELECT * FROM Pedido WHERE estado = 'finalizado'");
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos, $fila);
		}
		return $datos;
	}
	public function generarCotizacion($codigo)
	{
		$this->coenctar();
		//FALTA GENERAR LA FECHA DE CREACION
		$aux = $this->consultar("INSERT INTO Cotizacion(codigo,estado,fecha) VALUES('".$codigo."','pendiente',)");
		$this->desconectar();
		return $aux;
	}
	public function visualizarCotizaciones($codigoCliente)
	{
		$this->conectar();
		$aux = $this->consultar("");
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos,$fila);
		}
		return $datos;
	}
}

?>