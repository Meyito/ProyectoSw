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
			$cont = 0;
			while($fila = mysqli_fetch_array($aux))
			{
				$cont++;
			}
			if($cont == 0 || $cont > 1)
			{
				return false;
			}
			$aux = $this->consultar("UPDATE Usuario SET password = '".$newPassword."'
									WHERE DNI = '".$DNI."'");
			
			if($aux)
			{
				$this->desconectar();
				return true;
			}
		}
		$this->desconectar();
		return false;
	}
	public function visualizarPedidosCliente($codigoCliente,$estado)
	{
		$this->conectar();
		if($estado == "")
		{
			$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion 
									FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo
									AND c.DNI_Cliente = ".$codigoCliente."");
		}
		else
		{
			$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion 
									FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo
									AND c.DNI_Cliente = ".$codigoCliente." 
									AND p.estado='".$estado."'");
		}
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos, $fila);
		}
		return $datos;
	}
	public function registrarDisenios($url,$descripcion)
	{
		$this->conectar();
		if($descripcion == "")
		{
			$aux = $this->consultar("INSERT INTO Disenio(url) VALUES ('".$url."')");
		}
		else
		{
			$aux = $this->consultar("INSERT INTO Disenio(url,descripcion) VALUES ('".$url."','".$descripcion."')");
		}
		$this->desconectar();
		return $aux;
	}
	public function visualizarDisenios()
	{
		$this->conectar();
		$aux = $this->consultar("SELECT * FROM Disenio");
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos,$fila);
		}
		return $datos;
	}
	public function registrarPrenda($cantidad,$descripcion,$codigoEstado,$codigoCotizacion,$codigoDisenio,$codigoBodega)
	{
		$this->conectar();
		if($descripcion == "")
		{
			$aux = $this->consultar("INSERT INTO Prenda(cantidad,codigoEstado,codigoCotizacion,codigoDisenio,codigoBodega) 
							VALUES(".$cantidad.",".$codigoEstado.",".$codigoCotizacion.",".$codigoDisenio.",".$codigoBodega.")");
		}
		else
		{
			$aux = $this->consultar("INSERT INTO Prenda(cantidad,descripcion,codigoEstado,codigoCotizacion,codigoDisenio,codigoBodega) 
							VALUES(".$cantidad.",'".$descripcion."',".$codigoEstado.",".$codigoCotizacion.",".$codigoDisenio.",".$codigoBodega.")");
		}
		
		$this->desconectar();
		return $aux;
	}
	public function visualizarPrendaPedido($DNI_Cliente,$codigoPedido)
	{
		$this->conectar();
		$aux = $this->consultar("SELECT h.codigo,h.cantidad,h.descripcion,e.nombre,b.nombre
								FROM Prenda h,Bodega b,Pedido p,Cotizacion c,Estado e,Diseño d
								WHERE p.codigo = ".$codigoPedido."
								AND p.codigoCotizacion = c.codigo
								AND c.DNI_Cliente = '".$DNI_Cliente."'
								AND c.codigo = h.codigoCotizacion
								AND h.codigoEstado = e.codigo
								AND h.codigoBodega = b.codigo
								AND h.codigoDiseño = d.codigo");
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos, $fila);
		}
		return $datos;
	}
	public function visualizarPrendaCotizacion($DNI_Cliente,$codigoCotizacion)
	{
		$this->conectar();
		$aux = $this->consultar("SELECT * FROM Prenda WHERE codigoCotizacion = ".$codigoCotizacion." 
								AND DNI_Cliente = '".$DNI_Cliente."'");
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos,$fila);
		}
		return $datos;
	}
	public function responderCotizacion($DNI,$estado)
	{

	}
	public function modificarCotizacion($DNI,$descripcion)
	{
		$this->conectar();
		$aux = $this->consultar(" UPDATE Cotizacion SET descripcion = '".$descripcion."',estado = 'pendiente' WHERE DNI = '".$DNI."'");
		$this->desconectar();
		return $aux;
	}
	public function generarCotizacion($DNI_Cliente,$descripcion)
	{
		$this->conectar();
		if($descripcion == "")
		{
			$aux = $this->consultar("INSERT INTO Cotizacion(DNI_Cliente,estado,fecha) VALUES('".$DNI_Cliente."','pendiente',CURDATE())");
		}
		else
		{
			$aux = $this->consultar("INSERT INTO Cotizacion(DNI_Cliente,estado,fecha,descripcion) VALUES('".$DNI_Cliente."','pendiente',CURDATE(),'".$descripcion."')");
		}
		
		$this->desconectar();
		return $aux;
	}
	public function visualizarCotizaciones($codigoCliente)
	{
		$this->conectar();
		$aux = $this->consultar("SELECT * FROM Cotizacion WHERE DNI_Cliente = '".$codigoCliente."'");
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