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

	class OperarioBD extends Modelo
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
		public function modificarPedidos($codigoPedido,$codigoEstado,$fechaRecoleccion,$fechaEntrega,$direccion,$codigoBodega)
		{
			$aux = false;
			$this->conectar();
			$aux = $this->consultar("UPDATE Pedido SET codigoEstado = ".$codigoEstado.",fecha_Recoleccion = '".$fechaRecoleccion."',fecha_Entrega = '".$fechaEntrega."',direccion = '".$direccion."',codigoBodega = ".$codigoBodega." ");
			$this->desconectar();
			return $aux;
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
		public function visualizarPedidosCliente($codigoCliente,$estado)
		{
			$aux = false;
			$this->conectar();
			if($estado == "")
			{
				$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion 
										FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo
										AND c.DNI_Cliente = '".$codigoCliente."'");
			}
			else
			{
				$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion 
										FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo
										AND c.DNI_Cliente = '".$codigoCliente."'
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
		/*
		public function visualizarPrendas($codigoPedido)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT h.codigo,h.cantidad,h.descripcion,e.nombre,b.nombre
									FROM Prenda h,Bodega b,Pedido p,Cotizacion c,Estado e,Diseño d
									WHERE p.codigo = ".$codigoPedido." 
									AND p.codigoCotizacion = c.codigo
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
		public function modificarPedido($codigoPedido,$estado)
		{
			$this->conectar();
			$aux = $this->consultar("UPDATE Pedido SET estado = '".$estado."' WHERE codigo = ".$codigoPedido." ");
			$this->desconectar();
			return $aux;

		}
		public function modificarPrenda($codigo,$cantidad,$descripcion,$codigoEstado,$codigoCotizacion,$codigoDisenio,$codigoBodega)
		{
			$this->conectar();
			$aux = $this->consultar("UPDATE Prenda SET cantidad = ".$cantidad.",descripcion = '".$descripcion."',
									codigoEstado = ".$codigoEstado.",codigoCotizacion = ".$codigoCotizacion.",
									codigoDisenio = ".$codigoDisenio.",codigoBodega = ".$codigoBodega." 
									WHERE codigo = ".$codigo." ");
			$this->desconectar();
			return $aux;
		}
		*/
		public function visualizarCliente($DNI_Cliente)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Usuario WHERE DNI = '".$DNI_Cliente."'
									AND tipo = 3");
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;
		}
		public function responderCotizacion($codigoOperario,$codigo,$precioTotal, $descripcion)
		{
			$aux = false;
			$this->conectar();
			if($descripcion == "")
			{
				$aux = $this->consultar("UPDATE Cotizacion SET DNI_Operario = '".$codigoOperario."',estado = 'respuesta',precioTotal = '".$precioTotal."'
									WHERE codigo='".$codigo."'");
			}
			else
			{	
				$aux = $this->consultar("UPDATE Cotizacion SET DNI_Operario = '".$codigoOperario."',descripcion = '".$descripcion."',estado = 'respuesta',precioTotal = '".$precioTotal."'
									WHERE codigo='".$codigo."'");
			}
			$this->desconectar();
			return $aux;
		}
		public function visualizarCotizacionesCliente($DNI_Cliente,$estado)
		{
			$aux = false;
			$this->conectar();
			if($estado = "")
			{
				$aux = $this->consultar("SELECT * FROM Cotizacion WHERE DNI_Cliente = '".$DNI_Cliente."'");
			}
			else
			{
				$aux = $this->consultar("SELECT * FROM Cotizacion WHERE DNI_Cliente = '".$DNI_Cliente."' AND estado = '".$estado."'");
			}
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;
		}
		public function visualizarCotizaciones($estado)
		{
			$aux = false;
			$this->conectar();
			if($estado == "")
			{
				$aux = $this->consultar("SELECT * FROM Cotizacion");
			}
			else
			{
				$aux = $this->consultar("SELECT * FROM Cotizacion WHERE estado = '".$estado."'");
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

		public function registrarDisenio($url,$descripcion)
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
			if($aux)
				{
					return $aux;
				}
			return false;

		}
		public function visualizarDisenio()
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
		public function eliminarDisenio($codigo)
		{
			$this->conectar();
			$aux = $this->consultar("DELETE FROM Disenio WHERE codigo = '".$codigo."'");
			$this->desconectar();
			return $aux;
		}
		public function registrarBodega($nombre,$direccion)
		{
			$aux = false;
			$this->conectar();
			if($descripcion == "")
			{
				$aux = $this->consultar("INSERT INTO Bodega(nombre) VALUES ('".$nombre."')");
			}
			else
			{
				$aux = $this->consultar("INSERT INTO Bodega(nombre,direccion) VALUES ('".$nombre."','".$direccion."')");
			}
			$this->desconectar();
			if($aux)
				{
					return $aux;
				}
			return false;
		}
		public function visualizarBodega()
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Bodega");
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;
		}
		public function eliminarBodega($codigo)
		{
			$this->conectar();
			$aux = $this->consultar("DELETE FROM Bodega WHERE codigo = '".$codigo."'");
			$this->desconectar();
			return $aux;
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
		


	}

?>