<?php 
	session_start();
	require_once('../../Php/init.php');
	$conexion=conectar();
	$usuario="";
	$idusuario="";
	$tipo_usuario="";
	$entrar=false;
	if(isset($_SESSION['idusuario']) && $_SESSION['idusuario']!="" &&
		isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario']!=""){
		$idusuario=$_SESSION['idusuario'];
		$usuario=$_SESSION['usuario'];
		$tipo_usuario=$_SESSION['tipo_usuario'];
		$entrar=true;
	}elseif(isset($_POST['usuarioLogeado']) && $_POST['usuarioLogeado']!="" &&
			isset($_POST['tipo_usuarioLogeado']) && $_POST['tipo_usuarioLogeado']!=""){
		$idusuario=$_POST['usuarioLogeado'];
		$tipo_usuario=$_POST['tipo_usuarioLogeado'];
		$datos=datos_usuario($conexion,$idusuario);
		foreach($datos as $dato){
			$usuario=$dato['usuario'];
		}
		$_SESSION['idusuario']=$idusuario;
		$_SESSION['usuario']=$usuario;
		$_SESSION['tipo_usuario']=$tipo_usuario;
		$entrar=true;
	}
	if($entrar){
		?>
		<!DOCTYPE html>
		<html>
		    <head>
		      	<meta charset="utf-8">
		      	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		      	<title>Sistema </title>
		      	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

				<!--JQUERY-->
				<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		    	<!--FIN JQUERY-->

		      	<link rel="stylesheet" href="../../Lib/css/bootstrap.min.css">
		      	<link rel="stylesheet" href="../../Lib/css/font-awesome.css">
		      	<link rel="stylesheet" href="../../Lib/css/AdminLTE.min.css">
		      	<link rel="stylesheet" href="../../Lib/css/_all-skins.min.css">
		      	<link rel="apple-touch-icon" href="../../Lib/img/apple-touch-icon.png">
		      	<link rel="shortcut icon" href="../../Lib/img/favicon.ico">
		      	<link rel="stylesheet" type="text/css" href="../../Lib/css/alertify.core.css">
		      	<link rel="stylesheet" type="text/css" href="../../Lib/css/alertify.default.css">
		    	<script type="text/javascript" src="../../Lib/js/alertify.min.js"></script>
		    </head>
		    <body class="hold-transition skin-blue sidebar-mini">
		    	<div class="wrapper">
			        <header class="main-header">
			          <a href="#" class="logo">
			            <span class="logo-mini"><b>MW</b>S</span>
			            <span class="logo-lg"><b>Medic Warrior</b></span>
			          </a>
			          <nav class="navbar navbar-static-top" role="navigation">
			          	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			              <span class="sr-only">Navegación</span>
			            </a>
			            <div class="navbar-custom-menu">
			              <ul class="nav navbar-nav">
			                <li class="dropdown user user-menu">
			                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			                  	<?php 
			                  	if($tipo_usuario=="Administrador"){
			                  		?>
			                  		<small class="" style='background-color:#E14D4D;'><?php echo $tipo_usuario; ?></small>	
			                  		<?php
			                  	}elseif($tipo_usuario=="Doctor"){
			                  		?>
			                  		<small class="" style='background-color:#4B979F;'><?php echo $tipo_usuario; ?></small>	
			                  		<?php
			                  	}elseif($tipo_usuario=="Paciente"){
			                  		?>
			                  		<small class="" style='background-color:#4B9F58;'><?php echo $tipo_usuario; ?></small>	
			                  		<?php
			                  	}
			                  	?>
			                    		                   
			                    <span class="hidden-xs"><?php echo $usuario;?></span>
			                  </a>
			                  <ul class="dropdown-menu">
			                    <li class="user-header">
			                      <img src="https://upload.wikimedia.org/wikipedia/commons/d/d3/User_Circle.png">
			                      <p>
			                        Medic Warrior - Historial médico y mas
			                        <small>Designed By Reisp Solutions</small>
			                      </p>
			                    </li>
			                    <li class="user-footer">                    
			                      <div class="pull-right">
			                        <a href="../../Php/Funciones/cerrar_sesion.php" class="btn btn-default btn-flat">Cerrar Sesión</a>
			                      </div>
			                    </li>
			                  </ul>
			                </li>              
			              </ul>
			            </div>
			          </nav>
			        </header>
					<!-- Menu IZQUIERDA-->
			        <aside class="main-sidebar">
			        	<section class="sidebar">
				            <ul class="sidebar-menu">
				            	<li class="header"></li>    
				            	<li class="treeview">
				            		<a href="#">
				                  		<i class="fa fa-laptop"></i>
				                  		<span>Registro</span>
				                  		<i class="fa fa-angle-left pull-right"></i>
				                	</a>
					                <ul class="treeview-menu">
					                  <li><a href="../Centros/centros"><i class="fa fa-circle-o"></i> Centros</a></li>
					                  <li><a href="../Doctores/doctores"><i class="fa fa-circle-o"></i> Doctores</a></li>
					                  <li><a href="../Pacientes/pacientes"><i class="fa fa-circle-o"></i> Pacientes</a></li>
					                </ul>
				              	</li>		              
				                <li class="treeview">
				                  <a href="#">
				                    <i class="fa fa-th"></i>
				                    <span>Diagnosticos</span>
				                     <i class="fa fa-angle-left pull-right"></i>
				                  </a>
				                  <ul class="treeview-menu">
				                    <li><a href="#"><i class="fa fa-circle-o"></i> Ingresos</a></li>
				                    <li><a href="#"><i class="fa fa-circle-o"></i> Reporte</a></li>                
				                  </ul>
				                </li>	

				                <li class="treeview">
				                	<a href="#">
					               		<i class="fa fa-shopping-cart"></i>
					                  	<span>Empleados</span>
					                   	<i class="fa fa-angle-left pull-right"></i>
					                </a>
					                <ul class="treeview-menu">
					                  <li><a href="#"><i class="fa fa-circle-o"></i> Nómina</a></li>  
					                  <li><a href="#"><i class="fa fa-circle-o"></i> Salientes</a></li>               
					                </ul>
					            </li>
				              
				                <li class="treeview">
				                	<a href="#">
				                		<i class="fa fa-folder"></i> <span>Acceso</span>
			                    		<i class="fa fa-angle-left pull-right"></i>
				                  	</a>
				                  	<ul class="treeview-menu">
				                  		<li><a href="../acceso/usuarios"><i class="fa fa-circle-o"></i> Usuarios</a></li>
				                    </ul>
				                </li>
				                
				                <li>
					            	<a href="#">
					                	<i class="fa fa-plus-square"></i> <span>Ayuda</span>
					                  	<small class="label pull-right bg-red">PDF</small>
					                </a>
					            </li>
				              	<li>
				              		<a href="#">
				                  		<i class="fa fa-info-circle"></i> <span>Acerca De...</span>
				                  		<small class="label pull-right bg-yellow">IT</small>
				                	</a>
				              	</li>                        
				            </ul>
			        	</section>		          
			        </aside>
					<!-- FINAL DE Menu IZQUIERDA-->

			        <div class="content-wrapper">
			        	<section class="content">
			        		<div class="row">
			        			<div class="col-md-12">
			                		<div class="box">
			                  			<div class="box-header with-border">
			                    			<h3 class="box-title">Sistema de Historial Médico</h3>
						                    <div class="box-tools pull-right">
						                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                    
						                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						                    </div>
			                  			</div>
		                  				<div class="box-body">
		                  					<div class="row">
		                  						<div class="col-md-12">
		                  							<!--Contenido-->
		                  							<div class="jumbotron">
		                  								<img src="../../Lib/img/fondo.jpg" class="img-responsive" alt="Cinque Terre">			
		                  							</div>
			                        				<!--Fin Contenido-->
			                      				</div>
			                    			</div>                        
			                  			</div>
			                		</div><!-- /.row -->
			              		</div><!-- /.box-body -->
			            	</div><!-- /.box -->
			          	</section><!-- /.content -->
			        </div><!-- /.col -->
		    	</div><!-- /.row -->
		      
			    <footer class="main-footer">
			    	<div class="pull-right hidden-xs">
			        	<b>Versión</b> 1.0.0
			        </div>
			        <strong>Copyright &copy; 2015-2020 <a href="#">Reisp Solutions</a>.</strong> All rights reserved.
			    </footer>
		        
			    <script src="../../Lib/js/jQuery-2.1.4.min.js"></script>
			    <script src="../../Lib/js/bootstrap.min.js"></script>
			    <script src="../../Lib/js/app.min.js"></script>    
		    </body>
		</html>								
		<?php
	}else{
	  header("location:../login/login.php");  
	}
	
?>