<?php 
require_once('init.php');

if(isset($_POST['accion']) && $_POST['accion']!=""){
	$conexion=conectar();
	$accion=$_POST['accion'];
	#LOGIN
	if($accion=="login"){
		if(isset($_POST['usuario']) && $_POST['usuario']!="" &&
			isset($_POST['clave']) && $_POST['clave']!=""){
			print_r(json_encode(login($conexion,$_POST['usuario'],$_POST['clave'])));
		}
	#FIN LOGIN

	#CRUD DE USUARIOS
	}elseif($accion=="mostrar_usuarios"){
		echo mostrar_usuarios($conexion);
	}elseif($accion=="editar_usuario"){
		if(isset($_POST['nombre']) && $_POST['nombre']!="" &&
			isset($_POST['apellido']) && $_POST['apellido']!="" &&
			isset($_POST['usuario']) && $_POST['usuario']!="" &&
			isset($_POST['idusuario']) && $_POST['idusuario']!="" &&
			isset($_POST['tipo_usuario']) && $_POST['tipo_usuario']!=""){
			echo editar_usuario($conexion,$_POST['usuario'],$_POST['idusuario'],$_POST['nombre'],$_POST['apellido'],$_POST['tipo_usuario']);
		}
	}elseif($accion=="guardar_usuario"){
		if(isset($_POST['nombre']) && $_POST['nombre']!="" &&
			isset($_POST['apellido']) && $_POST['apellido']!="" &&
			isset($_POST['usuario']) && $_POST['usuario']!="" &&
			isset($_POST['clave']) && $_POST['clave']!="" &&
			isset($_POST['tipo_usuario']) && $_POST['tipo_usuario']!=""){
			echo guardar_usuario($conexion,$_POST['usuario'],$_POST['clave'],$_POST['nombre'],$_POST['apellido'],$_POST['tipo_usuario']);
		}
	}elseif($accion=="borrar_usuario"){
		if(isset($_POST['idusuario']) && $_POST['idusuario']!=""){
			echo borrar_usuario($conexion,$_POST['idusuario']);
		}
	}
	#FIN CRUD DE USUARIOS

	#CRUD DE DOCTORES
	elseif($accion=="mostrar_doctores"){
		echo mostrar_doctores($conexion);
	}elseif($accion=="editar_doctor"){
		if(isset($_POST['nombres']) && $_POST['nombres']!="" &&
			isset($_POST['apellidos']) && $_POST['apellidos']!="" &&
			isset($_POST['cedula']) && $_POST['cedula']!="" &&
			isset($_POST['telefono']) && $_POST['telefono']!="" &&
			isset($_POST['centro']) && $_POST['centro']!="" &&
			isset($_POST['iddoctor']) && $_POST['iddoctor']!=""){

			$celular="";
			$especialidad="";

			if(isset($_POST['celular']) && $_POST['celular']!=""){
				$celular=$_POST['celular'];
			}
			if(isset($_POST['especialidad']) && $_POST['especialidad']!=""){
				$especialidad=$_POST['especialidad'];
			}

			echo editar_doctor($conexion,$_POST['iddoctor'],$_POST['nombres'],$_POST['apellidos'],$_POST['cedula'],$_POST['telefono'],$celular,$especialidad,$_POST['centro']);
		}
	}elseif($accion=="guardar_doctor"){
		if(isset($_POST['nombres']) && $_POST['nombres']!="" &&
			isset($_POST['apellidos']) && $_POST['apellidos']!="" &&
			isset($_POST['cedula']) && $_POST['cedula']!="" &&
			isset($_POST['telefono']) && $_POST['telefono']!="" &&
			isset($_POST['centro']) && $_POST['centro']!=""){

			$celular="";
			$especialidad="";

			if(isset($_POST['celular']) && $_POST['celular']!=""){
				$celular=$_POST['celular'];
			}
			if(isset($_POST['especialidad']) && $_POST['especialidad']!=""){
				$especialidad=$_POST['especialidad'];
			}
			echo guardar_doctor($conexion,$_POST['nombres'],$_POST['apellidos'],$_POST['cedula'],$_POST['telefono'],$celular,$especialidad,$_POST['centro']);
		}
	}elseif($accion=="borrar_doctor"){
		if(isset($_POST['iddoctor']) && $_POST['iddoctor']!=""){
			echo borrar_doctor($conexion,$_POST['iddoctor']);
		}
	}elseif($accion=="cargar_centros"){
		echo cargar_centros($conexion);
	}
	#FIN CRUD DE DOCTORES

	#CRUD DE CENTROS
	elseif($accion=="mostrar_centros"){
		echo mostrar_centros($conexion);
	}elseif($accion=="editar_centro"){
		if(isset($_POST['nombres']) && $_POST['nombres']!="" &&
			isset($_POST['descripcion']) && $_POST['descripcion']!="" &&
			isset($_POST['ubicacion']) && $_POST['ubicacion']!="" &&
			isset($_POST['sector']) && $_POST['sector']!="" &&
			isset($_POST['idcentro']) && $_POST['idcentro']!=""){

			echo editar_centros($conexion,$_POST['idcentro'],$_POST['nombres'],$_POST['descripcion'],$_POST['ubicacion'],$_POST['sector']);
		}
	}elseif($accion=="guardar_centro"){
		if(isset($_POST['nombres']) && $_POST['nombres']!="" &&
			isset($_POST['descripcion']) && $_POST['descripcion']!="" &&
			isset($_POST['ubicacion']) && $_POST['ubicacion']!="" &&
			isset($_POST['sector']) && $_POST['sector']!="" ){

			echo guardar_centro($conexion,$_POST['nombres'],$_POST['descripcion'],$_POST['ubicacion'],$_POST['sector']);
		}
	}elseif($accion=="borrar_centro"){
		if(isset($_POST['idcentro']) && $_POST['idcentro']!=""){
			echo borrar_centro($conexion,$_POST['idcentro']);
		}
	}
	#FIN CRUD DE CENTROS
}else{
	echo "No hay acción";	
	$conexion=conectar();
	echo editar_doctor($conexion,3,"new name","new lastname","cedula","phone","celphone","dentist",1);
}
?>