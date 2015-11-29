<?php

	/**
 	* .............................................
 	* UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
 	*    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
 	*      LAUNDRYSOFT - LAVA RAPID JEANS S.A.S
 	*             SAN JOSE DE CUCUTA-2015
	 * ............................................
 	*/

	require_once "Aplicacion/Controlador2/controlador.php";
	include_once "Aplicacion/Modelo/AdministradorBD.php";

	/**
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	* @author Edgar Yesid Garcia Ortiz 1150967
	* @author Fernando Antonio Peñaranda Torres 1150684
	*/

	class Administrador extends Controlador{


	/*VISTAS*/
		public function index(){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/admin-home.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function menuClientes(){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/admin-gestion-clientes.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function menuOperarios(){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/admin-gestion-operarios.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaPedidos(){
			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarPedidos("");

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaPedidos.html");

			$plantilla=$this->cargarTabla($plantilla, $workspace, $datos);

			$this->mostrarVista($plantilla);
		}

		public function vistaConsultarClientes(){
			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarClientes();

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaUsuarios.html");
			$workspace=$this->reemplazar($workspace, "{{cargo}}", "CLIENTES");
			$plantilla=$this->cargarTablaUsuarios($plantilla, $workspace, "Cliente", $datos);

			$this->mostrarVista($plantilla);
		}

		public function vistaConsultarOperarios(){
			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarOperarios();

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaUsuarios.html");
			$workspace=$this->reemplazar($workspace, "{{cargo}}", "OPERARIOS");
			$plantilla=$this->cargarTablaUsuarios($plantilla, $workspace, "Operario", $datos);

			$this->mostrarVista($plantilla);
		}

		public function vistaConfiguracion(){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/settings.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function mostrarRegistroC(){
			$plantilla=$this->vistaRegistroCliente();
			$this->mostrarVista($plantilla);
		}

		public function mostrarRegistroO(){
			$plantilla=$this->vistaRegistroOperario();
			$this->mostrarVista($plantilla);
		}

		public function vistaRegistroCliente(){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);
			
			$workspace = $this->formRegistro();
			$workspace = $this->reemplazar($workspace, "{{tipo}}", "registroCliente");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);

			return $plantilla;
		}
		
		public function vistaRegistroOperario(){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$workspace = $this->formRegistro();
			$workspace = $this->reemplazar($workspace, "{{tipo}}", "registroOperario");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function vistaEditarCliente($dni){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarCliente($dni);

			$workspace=$this->formEditar($datos);
			$workspace = $this->reemplazar($workspace, "{{tipo}}", "edicionCliente");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaEliminarCliente($dni){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarCliente($dni);
			
			$workspace=$this->leerPlantilla("Aplicacion/Vista/confirmarEliminar.html");
			$workspace=$this->reemplazar($workspace, "{{cargo}}", "Cliente");
			$workspace=$this->reemplazar($workspace, "{{dni}}", $dni);
			$workspace=$this->reemplazar($workspace, "{{nombre}}", $datos[0][2]);
			$plantilla=$this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaEditarOperario($dni){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarOperario($dni);

			$workspace=$this->formEditar($datos);
			$workspace = $this->reemplazar($workspace, "{{tipo}}", "edicionOperario");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}

		public function vistaEliminarOperario($dni){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarOperario($dni);

			$workspace=$this->leerPlantilla("Aplicacion/Vista/confirmarEliminar.html");
			$workspace=$this->reemplazar($workspace, "{{cargo}}", "Operario");
			$workspace=$this->reemplazar($workspace, "{{dni}}", $dni);
			$workspace=$this->reemplazar($workspace, "{{nombre}}", $datos[0][2]);
			$plantilla=$this->reemplazar($plantilla, "{{workspace}}", $workspace);
			$this->mostrarVista($plantilla);
		}


	/*PROCESAMIENTO*/
		public function registrarCliente($nombre, $cedula, $password, $email, $direccion, $tel){
			$admin=new AdministradorBD();
			$password2=$this->encriptarPassword($password);
			$ok=$admin->registrarCliente($cedula,$password2,$nombre,$tel,$email,$direccion);
			$plantilla = $this->vistaRegistroCliente();
			
			if($ok){
				$plantilla = $this->alerta($plantilla, "Registro Exitoso", "");	
			}else{
				$plantilla = $this->alerta($plantilla, "Registro No Exitoso", "Por favor verifique que los datos ingresados sean validos");
			}

			$this->mostrarVista($plantilla);
		}

		public function registrarOperario($nombre, $cedula, $password, $email, $direccion, $tel){
			$admin=new AdministradorBD();
			$password2=$this->encriptarPassword($password);
			$ok=$admin->registrarOperario($cedula,$password2,$nombre,$tel,$email,$direccion);
			$plantilla = $this->vistaRegistroOperario();

			if($ok){
				$plantilla = $this->alerta($plantilla, "Registro Exitoso", "");
			}else{
				$plantilla = $this->alerta($plantilla, "Registro No Exitoso", "Por favor verifique que los datos ingresados sean validos");
			}

			$this->mostrarVista($plantilla);
		}

		public function editarCliente($DNI, $mail, $dir){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$adminBD=new AdministradorBD();
			$ok=$adminBD->modificarUsuario($DNI,$mail,$dir);
			
			$datos=$adminBD->visualizarCliente($DNI);
			$workspace=$this->formEditar($datos);
			$workspace = $this->reemplazar($workspace, "{{tipo}}", "edicionCliente");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);

			if($ok){
				$plantilla=$this->alerta($plantilla, "EDICIÓN EXITOSA", "");
			}else{
				$plantilla=$this->alerta($plantilla, "NO SE PUDO REALIZAR LA EDICIÓN", "Por favor revisar los datos ingresados.");
			}

			$this->mostrarVista($plantilla);
		}

		public function eliminarCliente($dni){

			$adminBD=new AdministradorBD();
			$ok=$adminBD->eliminarUsuario($dni);
			$datos=$adminBD->visualizarClientes();

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaUsuarios.html");
			$workspace=$this->reemplazar($workspace, "{{cargo}}", "CLIENTES");
			$plantilla=$this->cargarTablaUsuarios($plantilla, $workspace, "Cliente", $datos);

			if($ok){
				$plantilla=$this->alerta($plantilla, "CLIENTE ELIMINADO EXITOSAMENTE", "");
			}else{
				$plantilla=$this->alerta($plantilla, "NO SE PUDO ELIMINAR EL CLIENTE", "");
			}

			$this->mostrarVista($plantilla);
		}

		public function editarOperario($DNI, $mail, $dir){
			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$adminBD=new AdministradorBD();
			$ok=$adminBD->modificarUsuario($DNI,$mail,$dir);
			

			$datos=$adminBD->visualizarOperario($DNI);
			$workspace=$this->formEditar($datos);
			$workspace = $this->reemplazar($workspace, "{{tipo}}", "edicionCliente");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			
			if($ok){
				$plantilla=$this->alerta($plantilla, "EDICIÓN EXITOSA", "");
			}else{
				$plantilla=$this->alerta($plantilla, "NO SE PUDO REALIZAR LA EDICIÓN", "Por favor revisar los datos ingresados.");
			}

			$this->mostrarVista($plantilla);
		}

		public function eliminarOperario($dni){
			$adminBD=new AdministradorBD();
			$ok=$adminBD->eliminarUsuario($dni);
			$datos=$adminBD->visualizarOperarios();

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);

			$workspace = $this->leerPlantilla("Aplicacion/Vista/tablaUsuarios.html");
			$workspace=$this->reemplazar($workspace, "{{cargo}}", "OPERARIOS");
			$plantilla=$this->cargarTablaUsuarios($plantilla, $workspace, "Operario", $datos);

			if($ok){
				$plantilla=$this->alerta($plantilla, "OPERARIO ELIMINADO EXITOSAMENTE", "");
			}else{
				$plantilla=$this->alerta($plantilla, "NO SE PUDO ELIMINAR EL OPERARIO", "");
			}

			$this->mostrarVista($plantilla);
		}

		public function cambiarPassword($actual, $nueva, $confirmacion){
			$nueva2=$this->encriptarPassword($nueva);
			$confirmacion2=$this->encriptarPassword($confirmacion);

			$barraLat = $this->leerPlantilla("Aplicacion/Vista/barraLateralAdmin.html");
			$plantilla = $this -> init($barraLat);
			$workspace = $this->leerPlantilla("Aplicacion/Vista/settings.html");
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);

			if($nueva2==$confirmacion2){
				$actual2=$this->encriptarPassword($actual);
				$admin=new AdministradorBD();
				$ok=$admin->cambiarContrasenia($_SESSION["dni"],$actual2,$nueva2);
				
				if($ok){
					$plantilla=$this->alerta($plantilla, "Contraseña actual cambiada exitosamente", "");
				}else{
					$plantilla=$this->alerta($plantilla, "ERROR", "Contraseña incorrecta");
				}

			}else{
				$plantilla=$this->alerta($plantilla, "ERROR", "Las contraseñas no son iguales");
			}

			$this->mostrarVista($plantilla);
		}


	//AUXILIARES

		public function cargarTabla($plantilla, $workspace, $datos){
			$filaP=$this->leerPlantilla("Aplicacion/Vista/filaTablaPedidos.html");
			$info="";
			for($i=0; $i<count($datos); $i++){
				$aux=$filaP;
				$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);
				$aux=$this->reemplazar($aux, "{{estado}}", $datos[$i][10]);
				$aux=$this->reemplazar($aux, "{{cliente}}", $datos[$i][5]);
				$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][1]);
				$aux=$this->reemplazar($aux, "{{operario}}", $datos[$i][6]);
				$aux=$this->reemplazar($aux, "{{precio}}", $datos[$i][8]);
				$info.=$aux;
			}
			$workspace=$this->reemplazar($workspace, "{{filas}}", $info);
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function cargarTablaUsuarios($plantilla, $workspace, $cargo, $datos){
			$filaP=$this->leerPlantilla("Aplicacion/Vista/filaTablaUsuarios.html");
			$info="";
			for($i=0; $i<count($datos); $i++){
				$aux=$filaP;
				$aux=$this->reemplazar($aux, "{{nombre}}", $datos[$i][2]);
				$aux=$this->reemplazar($aux, "{{cedula}}", $datos[$i][0]);
				$aux=$this->reemplazar($aux, "{{tel}}", $datos[$i][4]);
				$aux=$this->reemplazar($aux, "{{direccion}}", $datos[$i][6]);
				$aux=$this->reemplazar($aux, "{{correo}}", $datos[$i][5]);
				$aux=$this->reemplazar($aux, "{{cargo}}", $cargo);
				$info.=$aux;
			}
			$workspace=$this->reemplazar($workspace, "{{filas}}", $info);
			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}

		public function formRegistro(){
			$workspace = $this->leerPlantilla("Aplicacion/Vista/registro.html");

			$workspace = $this->reemplazar($workspace, "{{dir}}", "");
			$workspace = $this->reemplazar($workspace, "{{tel}}", "");
			$workspace = $this->reemplazar($workspace, "{{correo}}", "");
			$workspace = $this->reemplazar($workspace, "{{password}}", "");
			$workspace = $this->reemplazar($workspace, "{{cedula}}", "");
			$workspace = $this->reemplazar($workspace, "{{nombre}}", "");
			$workspace = $this->reemplazar($workspace, "{{editable}}", "required");
			$workspace = $this->reemplazar($workspace, "{{OPCION}}", "REGISTRAR");

			return $workspace;
		}

		public function formEditar($datos){
			$workspace = $this->leerPlantilla("Aplicacion/Vista/registro.html");

			$workspace = $this->reemplazar($workspace, "{{dir}}", $datos[0][6]);
			$workspace = $this->reemplazar($workspace, "{{tel}}", $datos[0][4]);
			$workspace = $this->reemplazar($workspace, "{{correo}}", $datos[0][5]);
			$workspace = $this->reemplazar($workspace, "{{password}}", "********");
			$workspace = $this->reemplazar($workspace, "{{cedula}}", $datos[0][0]);
			$workspace = $this->reemplazar($workspace, "{{nombre}}", $datos[0][2]);
			$workspace = $this->reemplazar($workspace, "{{editable}}", "readonly");
			$workspace = $this->reemplazar($workspace, "{{OPCION}}", "EDITAR");

			return $workspace;
		}

		
	
		



//-----------------------------------------------------------------------------//
		
		public function procesarPedidos($plantilla, $workspace, $cargo, $datos){
			$tam=count($datos);
			$admin=new AdministradorBD();

			if($tam<=8){
				$slides=$this->leerPlantilla("Aplicacion/Vista/sliderConsultarPedidos.html");
				$slides=$this->reemplazar($slides, "{{tipo}}", "active-slide");

				$filas="";
				for($i=0; $i<$tam; $i++){
					$aux=$this->leerPlantilla("Aplicacion/Vista/filaPedidos.html");

					$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);

					$dato2=$admin->getEstado($datos[$i][10]);
					$aux=$this->reemplazar($aux, "{{estado}}", $dato2[0][1]);

					$dato2=$admin->visualizarCliente($datos[$i][5]);
					$aux=$this->reemplazar($aux, "{{cliente}}", $dato2[0][2]);

					$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][1]);

					$dato2=$admin->visualizarOperario($datos[$i][6]);
					$aux=$this->reemplazar($aux, "{{operario}}", $dato2[0][2]);
					$aux=$this->reemplazar($aux, "{{precio}}", $datos[$i][8]);

					

					$filas=$filas.$aux;
				}

				$slides=$this->reemplazar($slides, "{{filas}}", $filas);
				$workspace=$this->reemplazar($workspace, "{{nav}}", "");
				$workspace=$this->reemplazar($workspace, "{{slides}}", $slides);
			}else{
				$totalSlides="";
				$nav=$this->leerPlantilla("Aplicacion/Vista/sliderNav.html");
				$puntos="";

				for($i=0; $i<$tam; $i++){
					$auxSlide=$this->leerPlantilla("Aplicacion/Vista/slideConsultarPedidos.html");
					
					if($i==0){
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "active-slide");
						$puntos="<li class='dot active-dot'>&bull;</li>";
					}else{
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "");
						$puntos=$puntos."<li class='dot'>&bull;</li>";
					}

					$filas="";
					for($j=0; ($j<7 && $i<$tam); $j++, $i++){
						$aux=$this->leerPlantilla("Aplicacion/Vista/filaPedidos.html");

						$aux=$this->reemplazar($aux, "{{codigo}}", $datos[$i][0]);

						$dato2=$admin->getEstado($datos[$i][10]);
						$aux=$this->reemplazar($aux, "{{estado}}", $dato2[0][1]);

						$dato2=$admin->visualizarCliente($datos[$i][5]);
						$aux=$this->reemplazar($aux, "{{cliente}}", $dato2[0][2]);

						$aux=$this->reemplazar($aux, "{{fecha}}", $datos[$i][1]);

						$dato2=$admin->visualizarOperario($datos[$i][6]);
						$aux=$this->reemplazar($aux, "{{operario}}", $dato2[0][2]);
						$aux=$this->reemplazar($aux, "{{precio}}", $datos[$i][8]);

						$filas=$filas.$aux;
					}

					$auxSlide=$this->reemplazar($auxSlide, "{{filas}}", $filas);

					$totalSlides=$totalSlides.$auxSlide;
				}

				$nav=$this->reemplazar($nav, "{{puntos}}", $puntos);
				$workspace=$this->reemplazar($workspace, "{{nav}}", $nav);
				$workspace=$this->reemplazar($workspace, "{{slides}}", $totalSlides);
			}

			

			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			return $plantilla;
		}
		public function cargarConsultarClientes(){
			$adminBD=new AdministradorBD();
			$datos=$adminBD->visualizarClientes();

			$plantilla = $this -> init();
			$workspace = $this->leerPlantilla("Aplicacion/Vista/consultarUsuarios.html");
			$plantilla=$this->procesarConsulta($plantilla, $workspace, "Cliente", $datos);

			return $plantilla;
		}

		public function procesarConsulta($plantilla, $workspace, $cargo, $datos){
			$plantilla= $this->reemplazar($plantilla, "{{cargo}}", $cargo);

			$tam=count($datos);

			if($tam<=8){
				$slides=$this->leerPlantilla("Aplicacion/Vista/slideConsultarUsuario.html");
				$slides=$this->reemplazar($slides, "{{tipo}}", "active-slide");

				$filas="";
				for($i=0; $i<$tam; $i++){
					$aux=$this->leerPlantilla("Aplicacion/Vista/filaUsuario.html");
					$aux=$this->reemplazar($aux, "{{n}}", $i."");

					$aux=$this->reemplazar($aux, "{{cargo}}", $cargo);
					$aux=$this->reemplazar($aux, "{{nombre}}", $datos[$i][2]);
					$aux=$this->reemplazar($aux, "{{cedula}}", $datos[$i][0]);
					$aux=$this->reemplazar($aux, "{{tel}}", $datos[$i][4]);
					$aux=$this->reemplazar($aux, "{{direccion}}", $datos[$i][6]);
					$aux=$this->reemplazar($aux, "{{correo}}", $datos[$i][5]);

					$filas=$filas.$aux;
				}

				$slides=$this->reemplazar($slides, "{{filas}}", $filas);
				$workspace=$this->reemplazar($workspace, "{{nav}}", "");
				$workspace=$this->reemplazar($workspace, "{{slides}}", $slides);
			}else{
				$totalSlides="";
				$nav=$this->leerPlantilla("Aplicacion/Vista/sliderNav.html");
				$puntos="";

				for($i=0; $i<$tam; $i++){
					$auxSlide=$this->leerPlantilla("Aplicacion/Vista/slideConsultarUsuario.html");
					
					if($i==0){
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "active-slide");
						$puntos="<li class='dot active-dot'>&bull;</li>";
					}else{
						$auxSlide=$this->reemplazar($auxSlide, "{{tipo}}", "");
						$puntos=$puntos."<li class='dot'>&bull;</li>";
					}

					$filas="";
					for($j=0; ($j<7 && $i<$tam); $j++, $i++){
						$aux=$this->leerPlantilla("Aplicacion/Vista/filaUsuario.html");

						$aux=$this->reemplazar($aux, "{{n}}", $j."");
						$aux=$this->reemplazar($aux, "{{cargo}}", $cargo);
						$aux=$this->reemplazar($aux, "{{nombre}}", $datos[$i][2]);
						$aux=$this->reemplazar($aux, "{{cedula}}", $datos[$i][0]);
						$aux=$this->reemplazar($aux, "{{tel}}", $datos[$i][4]);
						$aux=$this->reemplazar($aux, "{{direccion}}", $datos[$i][6]);
						$aux=$this->reemplazar($aux, "{{correo}}", $datos[$i][5]);

						$filas=$filas.$aux;
					}
					$auxSlide=$this->reemplazar($auxSlide, "{{filas}}", $filas);

					$totalSlides=$totalSlides.$auxSlide;
				}

				$nav=$this->reemplazar($nav, "{{puntos}}", $puntos);
				$workspace=$this->reemplazar($workspace, "{{nav}}", $nav);
				$workspace=$this->reemplazar($workspace, "{{slides}}", $totalSlides);
			}

			

			$plantilla = $this->reemplazar($plantilla, "{{workspace}}", $workspace);
			if($tam==0){
				$plantilla=$this->alerta($plantilla, "".$cargo." no encontrado", "No existe ningun ".$cargo." registrado con esa cédula.");
			}

			return $plantilla;
		}


		
	}		
?>