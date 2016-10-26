<?php 
	
	function login($conexion,$usuario,$clave){
		try {
			$consulta="SELECT idusuario,tipo_usuario FROM usuarios WHERE
			usuario=? AND clave=? LIMIT 1";
			$statement=$conexion->prepare($consulta);
			$statement->bindValue(1,$usuario);
			$statement->bindValue(2,md5($clave));
			$statement->execute();
			$respuesta=array(
		   		'idusuario'=>"",
		   		'tipo_usuario'=>""
		   	);

			if($statement->rowCount()==1){
				while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
				   $respuesta=array(
				   		'idusuario'=>$row['idusuario'],
				   		'tipo_usuario'=>$row['tipo_usuario']
				   	);
				}
			}else{
				$respuesta=array(
			   		'idusuario'=>"",
			   		'tipo_usuario'=>""
			   	);
			}
			return $respuesta;
		} catch (Exception $e) {
			$error=array('error'=>$e->getMessage);
			return $error;
		}
	}

	function datos_usuario($conexion,$idusuario){
		try {
			$consulta="SELECT usuario FROM usuarios WHERE
			idusuario=? LIMIT 1";
			$statement=$conexion->prepare($consulta);
			$statement->bindValue(1,$idusuario);
			$statement->execute();
			return $statement;
		} catch (Exception $e) {
			return $e->getMessage;
		}
	}
	function mostrar_usuarios($conexion){
		try {
			$consulta="SELECT * FROM usuarios";
			$statement=$conexion->prepare($consulta);
			$statement->execute();
			$results=$statement->fetchAll(PDO::FETCH_ASSOC);
			$json=json_encode($results);
			return $json;
		} catch (Exception $e) {
			return $e->getMessage;
		}
	}
	function editar_usuario($conexion,$usuario,$idusuario,$nombre,$apellido,$tipo_usuario){
		try {
			$consulta="UPDATE usuarios SET nombres=?,apellidos=?,usuario=?,tipo_usuario=? WHERE idusuario=?";
			$statement=$conexion->prepare($consulta);
			$statement->bindValue(1,$nombre);
			$statement->bindValue(2,$apellido);
			$statement->bindValue(3,$usuario);
			$statement->bindValue(4,$tipo_usuario);
			$statement->bindValue(5,$idusuario);

			if($statement->execute()){
				return "SI";
			}else{
				return "NO";
			}	
		} catch (Exception $e) {
			return $e->getMessage;
		}

	}

	function guardar_usuario($conexion,$usuario,$clave,$nombre,$apellido,$tipo_usuario){
		try {
			$consulta="INSERT INTO usuarios(nombres,apellidos,usuario,clave,tipo_usuario) VALUES(:nombres,:apellidos,:usuario,:clave,:tipo_usuario)";
			$statement=$conexion->prepare($consulta);
			$statement->execute(
				array(':nombres'=>$nombre,':apellidos'=>$apellido,':usuario'=>$usuario,':clave'=>md5($clave),':tipo_usuario'=>$tipo_usuario)
			);
			if($statement->rowCount()>0){
				return "SI";
			}else{
				return "NO";
			}			
		} catch (Exception $e) {
			return $e->getMessage;
		}
	}
	function borrar_usuario($conexion,$idusuario){
		try {
			$consulta="DELETE FROM usuarios WHERE idusuario=:idusuario";
			$statement=$conexion->prepare($consulta);
			$statement->execute(
				array(':idusuario'=>$idusuario)
			);
			if($statement->rowCount()>0){
				return "SI";
			}else{
				return "NO";
			}		
		} catch (Exception $e) {
			return $e->getMessage;
		}
	}
?>