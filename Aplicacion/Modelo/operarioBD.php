<?php

	include_once "Aplicacion/Modelo/modelo.php";

	class Operario extends Modelo
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
		public function visualizarPedidosFinalizados()
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Pedido WHERE estado = 'finalizado'");
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos, $fila);
			}
		}
		public function visualizarPedidosCliente($codigoCliente,$estado)
		{
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
		public function visualizarPedidos()
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Pedido");
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos, $fila);
			}
			return $datos;
		}
		public function visualizarPrendas($codigoPedido)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT h.codigo,h.cantidad,h.descripcion,e.nombre,b.nombre
									FROM Prenda h,Bodega b,Pedido p,Cotizacion c,Estado e,Diseño d,Foto f
									WHERE p.codigo = '".$codigoPedido."' 
									AND p.codigoCotizacion = c.codigo
									AND c.codigo = h.codigoCotizacion
									AND h.codigoEstado = e.codigo
									AND h.codigoBodega = b.codigo
									AND h.codigoDiseño = d.codigo
									AND d.codigoFoto = f.codigo");
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos, $fila);
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