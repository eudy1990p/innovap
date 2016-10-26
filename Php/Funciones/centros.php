<?php 
	function mostrar_centros($conexion){
		try {
			$consulta="SELECT * FROM centros";
			$statement=$conexion->prepare($consulta);
			$statement->execute();
			$results=$statement->fetchAll(PDO::FETCH_ASSOC);
			$json=json_encode($results);
			return $json;
		} catch (Exception $e) {
			return $e->getMessage;
		}
	}
	function editar_centros($conexion,$idcentros,$nombres,$descripcion,$ubicacion,$sector){
		try {
			$consulta="UPDATE centros SET nombres=?,descripcion=?,ubicacion=?,sector=? WHERE idcentro=?";
			$statement=$conexion->prepare($consulta);
			$statement->bindValue(1,$nombres);
			$statement->bindValue(2,$descripcion);
			$statement->bindValue(3,$ubicacion);
			$statement->bindValue(4,$sector);
			$statement->bindValue(5,$idcentros);		

			if($statement->execute()){
				return "SI";
			}else{
				return "NO";
			}	
		} catch (Exception $e) {
			return $e->getMessage;
		}

	}

	function guardar_centro($conexion,$nombres,$descripcion,$ubicacion,$sector){
		try {
			$consulta="INSERT INTO centros (nombres,descripcion,ubicacion,sector) VALUES(?,?,?,?)";
			$statement=$conexion->prepare($consulta);
			$statement->bindValue(1,$nombres);
			$statement->bindValue(2,$descripcion);
			$statement->bindValue(3,$ubicacion);
			$statement->bindValue(4,$sector);
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
	function borrar_centro($conexion,$idcentro){
		try {
			$consulta="DELETE FROM centros WHERE idcentro=:idcentro";
			$statement=$conexion->prepare($consulta);
			$statement->execute(
				array(':idcentro'=>$idcentro)
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