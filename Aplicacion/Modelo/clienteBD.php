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
	public function visualizarOperario($DNI_Cliente)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Usuario WHERE DNI = '".$DNI_Cliente."'
									AND tipo = 2");
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;
		}
	public function visualizarPedidosCliente($DNI_Cliente,$estado)
		{
			$this->conectar();
			if($estado == "")
			{
				$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion,
										c.DNI_Cliente,c.DNI_Operario,c.descripcion,c.precioTotal,c.cantidad,p.codigoEstado,c.codigoDisenio,p.codigoBodega
										FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo
										AND c.DNI_Cliente = ".$DNI_Cliente."");
			}
			else
			{
				$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion,
										c.DNI_Cliente,c.DNI_Operario,c.descripcion,c.precioTotal,c.cantidad,p.codigoEstado,c.codigoDisenio,p.codigoBodega
										FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo
										AND c.DNI_Cliente = ".$DNI_Cliente."
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
		$aux = false;
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
	public function obtenerCodigoDisenio($url)
	{
		$this->conectar();
		$aux = $this->consultar("SELECT codigo FROM Disenio WHERE url = '".$url."'");
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos,$fila);
		}
		return $datos;
	}
	public function eliminarDisenio($codigo)
	{
		$this->conectar();
		$aux = $this->consultar("DELETE FROM Disenio WHERE codigo = '".$codigo."'");
		$this->desconectar();
		return $aux;
	}
	/*
	public function registrarPrenda($cantidad,$descripcion,$codigoEstado,$codigoCotizacion,$codigoDisenio,$codigoBodega)
	{
		$aux = false;
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
	*/
	public function responderCotizacion($codigoCotizacion,$estado)
	{
		$this->conectar();
		$aux = $this->consultar("UPDATE Cotizacion SET estado = '".$estado."' WHERE codigo = ".$codigoCotizacion."");
		if($aux)
		{
			if($estado == 'aceptada')
			{
				$aux = $this->consultar("INSERT INTO Pedido(estado,codigoCotizacion,codigoEstado,fecha_Creacion,codigoBodega) VALUES('vigente',".$codigoCotizacion.",1,CURDATE(),1)");
			}
		}
		$this->desconectar();
		return $aux;
	}
	public function modificarCotizacion($codigoCotizacion,$cantidad,$codigoDisenio,$descripcion)
	{
		$this->conectar();

		$aux = $this->consultar(" UPDATE Cotizacion SET cantidad = ".$cantidad.",codigoDisenio = ".$codigoDisenio.",descripcion = '".$descripcion."',estado = 'pendiente' WHERE codigo = ".$codigoCotizacion."");
		$this->desconectar();
		return $aux;
	}
	public function generarCotizacion($DNI_Cliente,$descripcion,$cantidad,$codigoDisenio)
	{
		$aux = false;
		$this->conectar();
		if($descripcion == "")
		{
			$aux = $this->consultar("INSERT INTO Cotizacion(DNI_Cliente,estado,fecha,cantidad,codigoDisenio) VALUES('".$DNI_Cliente."','pendiente',CURDATE(),".$cantidad.",".$codigoDisenio.")");
		}
		else
		{
			$aux = $this->consultar("INSERT INTO Cotizacion(DNI_Cliente,estado,fecha,descripcion,cantidad,codigoDisenio) VALUES('".$DNI_Cliente."','pendiente',CURDATE(),'".$descripcion."',".$cantidad.",".$codigoDisenio.")");
		}
		
		$this->desconectar();
		return $aux;
	}
	public function visualizarCotizaciones($DNI_Cliente,$estado)
	{
		$aux = false;
		$this->conectar();
		if($estado == "")
		{
			$aux = $this->consultar("SELECT c.codigo, u.nombre, u.telefono, c.fecha
										FROM Cotizacion c, Usuario u
										WHERE u.DNI=c.DNI_Operario AND DNI_Cliente = '".$DNI_Cliente."'");
		}
		else
		{
			$aux = $this->consultar("SELECT c.codigo, u.nombre, u.telefono, c.fecha
										FROM Cotizacion c, Usuario u
										WHERE u.DNI=c.DNI_Operario AND estado = '".$estado."' AND DNI_Cliente = '".$DNI_Cliente."'");
		}
		$this->desconectar();
		$datos = array();
		while($fila = mysqli_fetch_array($aux))
		{
			array_push($datos,$fila);
		}
		return $datos;
	}
	public function getCotizacion($codigo)
		{
			$aux = false;
			$this->conectar();

			$aux = $this->consultar("SELECT * FROM Cotizacion WHERE codigo='".$codigo."'");
			
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;
		}

	public function getDisenio($codigo)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Disenio WHERE codigo = '".$codigo."'");
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;
		}

		public function visualizarPedidos($estado)
		{
			$this->conectar();
			if($estado == "")
			{
				$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion,
										c.DNI_Cliente,c.DNI_Operario,c.descripcion,c.precioTotal,c.cantidad,p.codigoEstado,c.codigoDisenio,p.codigoBodega
										FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo");
			}
			else
			{
				$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion,
										c.DNI_Cliente,c.DNI_Operario,c.descripcion,c.precioTotal,c.cantidad,p.codigoEstado,c.codigoDisenio,p.codigoBodega
										FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo
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
		public function getEstado($cod){
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Estado WHERE codigo= '".$cod."'");
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;

		}
		public function visualizarCliente($DNI)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Usuario WHERE DNI = '".$DNI."' AND tipo = 3");
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;
		}
}

?>