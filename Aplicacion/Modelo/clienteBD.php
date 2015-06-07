<?php

include_once "Aplicacion/Modelo/modelo.php";

class ClienteBD extends Modelo
{
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