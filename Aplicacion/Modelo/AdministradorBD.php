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

	class AdministradorBD extends Modelo
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

		//INSERTS
		public function registrarCliente($DNI,$password,$nombre,$telefono,$correo_electronico,$direccion)
		{
			$this->conectar();
			
			$aux = $this->consultar("INSERT INTO Usuario VALUES('".$DNI."','".$password."','".$nombre."',3,'".$telefono."','".$correo_electronico."','".$direccion."')");
			$this->desconectar();

			if($aux)
			{
				return true;
			}
			
			return false;
			
		}
		public function registrarOperario($DNI,$password,$nombre,$telefono,$correo_electronico,$direccion)
		{
			$this->conectar();
			
			$aux = $this->consultar("INSERT INTO Usuario VALUES('".$DNI."','".$password."','".$nombre."',2,'".$telefono."','".$correo_electronico."','".$direccion."')");
			$this->desconectar();

			if($aux)
			{
				return true;
			}
			
			return false;
		}

		//UPDATES
		public function modificarUsuario($DNI,$correo_electronico,$direccion)
		{
			$this->conectar();
			$aux = $this->consultar(" UPDATE Usuario SET correo_electronico = '".$correo_electronico."',direccion = '".$direccion."' WHERE DNI = '".$DNI."'");
			$this->desconectar();
			return $aux;
		}
		
		//DELETES
		
		public function eliminarUsuario($DNI)
		{
			$this->conectar();
			$aux = $this->consultar("DELETE FROM Usuario WHERE DNI = '".$DNI."'");
			$this->desconectar();
			return $aux;
		}

		//SELECTS
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
		*/
		public function visualizarPedidosCliente($DNI_Cliente,$estado)
		{
			$this->conectar();
			if($estado == "")
			{
				$aux = $this->consultar("SELECT p.codigo, e.nombre, u.nombre, p.fecha_Creacion, x.nombre, c.precioTotal 
										FROM Cotizacion c,Pedido p, Estado e, Usuario u, Usuario x 
										WHERE x.DNI=c.DNI_Operario AND u.DNI=c.DNI_Cliente AND e.codigo=p.codigoEstado 
										AND p.codigoCotizacion = c.codigo AND c.DNI_Cliente = ".$DNI_Cliente."");
			}
			else
			{
				$aux = $this->consultar("SELECT p.codigo, e.nombre, u.nombre, p.fecha_Creacion, x.nombre, c.precioTotal 
										FROM Cotizacion c,Pedido p, Estado e, Usuario u, Usuario x 
										WHERE x.DNI=c.DNI_Operario AND u.DNI=c.DNI_Cliente AND e.codigo=p.codigoEstado 
										AND p.codigoCotizacion = c.codigo AND p.estado='".$estado."' 
										AND c.DNI_Cliente = ".$DNI_Cliente."'");
										
			}
			$this->desconectar();
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos, $fila);
			}
			return $datos;
		}

	
		public function visualizarPedidos($estado)
		{
			$this->conectar();
			if($estado == "")
			{
				$aux = $this->consultar("SELECT p.codigo, e.nombre, u.nombre, p.fecha_Creacion, x.nombre, c.precioTotal 
										FROM Cotizacion c,Pedido p, Estado e, Usuario u, Usuario x 
										WHERE x.DNI=c.DNI_Operario AND u.DNI=c.DNI_Cliente AND e.codigo=p.codigoEstado 
										AND p.codigoCotizacion = c.codigo");
			}
			else
			{
				/*$aux = $this->consultar("SELECT p.codigo,p.fecha_Creacion,p.fecha_Recoleccion,p.fecha_Entrega,p.direccion,
										c.DNI_Cliente,c.DNI_Operario,c.descripcion,c.precioTotal,c.cantidad,p.codigoEstado,c.codigoDisenio,p.codigoBodega
										FROM Cotizacion c,Pedido p WHERE p.codigoCotizacion = c.codigo
										AND p.estado='".$estado."'");*/
				$aux = $this->consultar("SELECT p.codigo, e.nombre, u.nombre, p.fecha_Creacion, x.nombre, c.precioTotal 
										FROM Cotizacion c,Pedido p, Estado e, Usuario u, Usuario x 
										WHERE x.DNI=c.DNI_Operario AND u.DNI=c.DNI_Cliente AND e.codigo=p.codigoEstado 
										AND p.codigoCotizacion = c.codigo AND p.estado='".$estado."'");
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
		*/
		public function visualizarClientes()
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Usuario WHERE tipo = 3");
			$this->desconectar();
			$datos = array();
			while($fila=mysqli_fetch_array($aux))
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
		public function visualizarOperarios()
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Usuario WHERE tipo = 2");
			$this->desconectar();
			$datos = array();
			while($fila=mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
			}
			return $datos;
		}
		public function visualizarOperario($DNI)
		{
			$this->conectar();
			$aux = $this->consultar("SELECT * FROM Usuario WHERE DNI = '".$DNI."' AND tipo = 2");
			$datos = array();
			while($fila = mysqli_fetch_array($aux))
			{
				array_push($datos,$fila);
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

	}
?>