<?php 
date_default_timezone_set('America/Santo_Domingo');
function conectar(){
	try{
		$conexion=new PDO("mysql:dbname=bdinnovapp;host=127.0.0.1","root","edward");
		return $conexion;
	}catch(PDOException $e){
		echo "Error: ".$e->getMessage();
		die();
	}
}
//Carga funciones del modulo de usuarios
require_once('Funciones/usuarios.php');
//Carga funciones del modulo de doctores
require_once('Funciones/doctores.php');
//Carga funciones del modulo de centros
require_once('Funciones/centros.php');
?>