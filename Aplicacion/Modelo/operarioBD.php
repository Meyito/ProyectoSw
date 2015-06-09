<?php

	include_once "Aplicacion/Modelo/modelo.php";

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
		public function visualizarCotizacionesPendientes()
		{
			$this->conectar();
			$aux = $consultar("SELECT * FROM Cotizacion WHERE estado = 'pendiente'");
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos, $fila);
			}
			return $datos;
		}
		public function visualizarCotizacionCliente($DNI_Cliente)
		{
			$this->conectar();
			$aux = $consultar("SELECT * FROM Cotizacion WHERE DNI_Cliente = '".$DNI_Cliente."'");
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos, $fila);
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
		public function eliminarDisenio($codigo)
		{
			$this->conectar();
			$aux = $this->consultar("DELETE FROM Disenio WHERE codigo = '".$codigo."'");
			$this->desconectar();
			return $aux;
		}
		public function registrarBodega($nombre,$descripcion)
		{
			$aux = false;
			$this->conectar();
			if($descripcion == "")
			{
				$aux = $this->consultar("INSERT INTO Bodega(nombre) VALUES ('".$nombre."')");
			}
			else
			{
				$aux = $this->consultar("INSERT INTO Bodega(nombre,descripcion) VALUES ('".$nombre."','".$descripcion."')");
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
		public function responderCotizacion($codigoOperario,$codigo,$descripcion,$precioTotal)
		{
			$aux = false;
			$this->conectar();
			if($descripcion == "")
			{
				$aux = $consultar("UPDATE Cotizacion SET DNI_Operario = '".$codigoOperario."',estado = 'respuesta',precioTotal = ".$precioTotal."
									WHERE codigo='".$codigo."'");
			}
			else
			{
				$aux = $consultar("UPDATE Cotizacion SET DNI_Operario = '".$codigoOperario."',descripcion = '".$descripcion."',estado = 'respuesta',precioTotal = '".$precioTotal."'
									WHERE codigo='".$codigo."'");
			}
			$this->desconectar();
			return $aux;
		}


	}

?>