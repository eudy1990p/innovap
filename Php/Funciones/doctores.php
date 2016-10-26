<?php 
	function mostrar_doctores($conexion){
		try {
			$consulta="SELECT d.iddoctor,d.nombres,d.apellidos,d.cedula,d.telefono,d.celular,d.especialidad,c.nombres as 'c_nombres',c.idcentro as 'id_centro' FROM doctores d INNER JOIN centros c ON d.idcentro=c.idcentro";
			$statement=$conexion->prepare($consulta);
			$statement->execute();
			$results=$statement->fetchAll(PDO::FETCH_ASSOC);
			$json=json_encode($results);
			return $json;
		} catch (Exception $e) {
			return $e->getMessage;
		}
	}
	function cargar_centros($conexion){
		try {
			$consulta="SELECT idcentro,nombres FROM centros";
			$statement=$conexion->prepare($consulta);
			$statement->execute();
			$results=$statement->fetchAll(PDO::FETCH_ASSOC);
			$json=json_encode($results);
			return $json;
		} catch (Exception $e) {
			return $e->getMessage;
		}
	}
	function editar_doctor($conexion,$iddoctor,$nombres,$apellidos,$cedula,$telefono,$celular,$especialidad,$centro){
		try {
			$consulta="UPDATE doctores SET nombres=?,apellidos=?,cedula=?,telefono=?,celular=?,especialidad=?,idcentro=? WHERE iddoctor=?";
			$statement=$conexion->prepare($consulta);
			$statement->bindValue(1,$nombres);
			$statement->bindValue(2,$apellidos);
			$statement->bindValue(3,$cedula);
			$statement->bindValue(4,$telefono);
			$statement->bindValue(5,$celular);
			$statement->bindValue(6,$especialidad);
			$statement->bindValue(7,$centro);	
			$statement->bindValue(8,$iddoctor);		

			if($statement->execute()){
				return "SI";
			}else{
				return "NO";
			}	
		} catch (Exception $e) {
			return $e->getMessage;
		}

	}

	function guardar_doctor($conexion,$nombres,$apellidos,$cedula,$telefono,$celular,$especialidad,$centro){
		try {
			$consulta="INSERT INTO doctores (nombres,apellidos,cedula,telefono,celular,especialidad,idcentro) VALUES(?,?,?,?,?,?,?)";
			$statement=$conexion->prepare($consulta);
			$statement->bindValue(1,$nombres);
			$statement->bindValue(2,$apellidos);
			$statement->bindValue(3,$cedula);
			$statement->bindValue(4,$telefono);
			$statement->bindValue(5,$celular);
			$statement->bindValue(6,$especialidad);
			$statement->bindValue(7,$centro);
			$statement->execute();
			if($statement->rowCount()>0){
				return "SI";
			}else{
				return "NO";
			}			
		} catch (Exception $e) {
			return $e->getMessage;
		}
	}
	function borrar_doctor($conexion,$iddoctor){
		try {
			$consulta="DELETE FROM doctores WHERE iddoctor=:iddoctor";
			$statement=$conexion->prepare($consulta);
			$statement->execute(
				array(':iddoctor'=>$iddoctor)
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