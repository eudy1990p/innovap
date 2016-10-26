<?php 
	session_start();
	require_once('../../../Php/init.php');
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

		    	<!--BOOTSTRAP-->		    	
				<link rel="stylesheet" href="../../../Lib/css/bootstrap.min.css">
				<!--FINBOOTSTRAP-->
				
				<!--PLANTILLA-->
		      	<link rel="stylesheet" href="../../../Lib/css/font-awesome.css">
		      	<link rel="stylesheet" href="../../../Lib/css/AdminLTE.min.css">
		      	<link rel="stylesheet" href="../../../Lib/css/_all-skins.min.css">
		      	<link rel="apple-touch-icon" href="../../../Lib/img/apple-touch-icon.png">
		      	<link rel="shortcut icon" href="../../../Lib/img/favicon.ico">
		      	<!--FIN PLANTILLA-->

		      	<!--ALERTIFY-->
		      	<link rel="stylesheet" type="text/css" href="../../../Lib/css/alertify.core.css">
		      	<link rel="stylesheet" type="text/css" href="../../../Lib/css/alertify.default.css">
		      	<script type="text/javascript" src="../../../Lib/js/alertify.min.js"></script>
		      	<!--FIN ALERTIFY-->

		      	<!-- SWEETALERT>-->
		      	<link rel="stylesheet" type="text/css" href="../../../Lib/sweetalert/sweetalert.css">
		      	<script src="../../../Lib/sweetalert/sweetalert.min.js"></script> 
		      	<!-- FIN SWEETALERT>-->
				
		    	<!-- DATATABLES NUEVO -->
					<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
					<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.1.2/css/rowReorder.dataTables.min.css">
					<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
					<script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.js"></script>
					<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
					<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.1.2/js/dataTables.rowReorder.min.js"></script>
					<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
				<!-- DATATABLES NUEVO -->

				<!-- MASK-->
				<script src="../../../Lib/js/maskedinput.min.js" type="text/javascript"></script>
				<!-- FIN MASK -->

				<!-- SCRIPT PERSONAL-->
				<script type="text/javascript" src="../../../Scripts/doctores.js"></script>
				<!-- FIN SCRIPT PERSONAL-->

				<script type="text/javascript">
					$(document).ready(function() {
					    var table = $('#tblDoctores').DataTable( {
					        rowReorder: {
					            selector: 'td:nth-child(2)'
					        },
					        responsive: true,
					        "language": {
				              "search": "Buscar:",
				              "searchPlaceholder": "Buscar por columnas",
				              "lengthMenu": "Mostrar _MENU_ doctores por página",
				              "zeroRecords": "Nada encontrado",
				              "info": "Mostrando página _PAGE_ de _PAGES_",
				              "infoEmpty": "No hay doctores disponibles",
				              "infoFiltered": "(filtrado desde _MAX_ doctores totales)",
				              "paginate": {
				                "previous": "Anterior",
				                "next":"Siguiente"
				              }
				            },"aoColumnDefs": [
				            	{ "sClass": "text-center", "aTargets": [0,1,2,3,4,5,6] }
				            ]
					    });
					});

					
				</script>
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
			                        <a href="../../../Php/Funciones/cerrar_sesion.php" class="btn btn-default btn-flat">Cerrar Sesión</a>
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
					                  <li><a href="../../Centros/centros"><i class="fa fa-circle-o"></i> Centros</a></li>
					                  <li><a href="#"><i class="fa fa-circle-o"></i> Doctores</a></li>
					                  <li><a href="../../Pacientes/pacientes"><i class="fa fa-circle-o"></i> Pacientes</a></li>
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
				                  		<li><a href="../../acceso/usuarios"><i class="fa fa-circle-o"></i> Usuarios</a></li>
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
		                  							<div class="container">
														<h1 class="text-center">Doctores</h1>
														<center>
													        <button id="abrirForm" class="btn btn-success">Agregar Nuevo</button>
													    </center>     
														<div id="contenedorFormulario">
													        <form id="form_registro_doctores">
													            <div class="row row-flex row-flex-wrap">
													                <input type="hidden" id="doctor2">
													                <div id="divNombres" class="form-group text-center col-md-6 col-xs-12">
													                    <label class="control-label" for="nombres">Nombres</label>
													                    <input type="text" class="form-control" id="nombres" placeholder="Nombres">
													                </div>
													                <div id="divApellidos" class="form-group text-center col-md-6 col-xs-12">
													                    <label class="control-label" for="apellidos">Apellidos</label>
													                    <input type="text" class="form-control" id="apellidos" placeholder="Apellidos">
													                </div>
													                <div id="divCedula" class="form-group text-center col-md-6 col-xs-12">
													                    <label class="control-label" for="cedula">Cédula</label>
													                    <input type="text" class="form-control" id="cedula" placeholder="Cédula">
													                </div>
													                <div id="divTelefono" class="form-group text-center col-md-6 col-xs-12">
													                    <label class="control-label" for="telefono">Teléfono</label>
													                    <input type="text" class="form-control" id="telefono" placeholder="Teléfono">
													                </div>
													                <div id="divCelular" class="form-group text-center col-md-6 col-xs-12">
													                    <label class="control-label" for="celular">Celular</label>
													                    <input type="text" class="form-control" id="celular" placeholder="Celular">
													                </div>
													                <div id="divEspecialidad" class="form-group text-center col-md-6 col-xs-12">
													                    <label class="control-label" for="especialidad">Especialidad</label>
													                    <input type="text" class="form-control" id="especialidad" placeholder="Especialidad">
													                </div>
													                <div id="divCentro" class="form-group text-center col-md-6 col-xs-12 col-md-offset-3">
													                    <label class="control-label" for="centro">Centro</label>
													                    <select id="centro" class="form-control">
													                    	
													                    </select>
													                </div>
													                  
													            </div>
													            <div class="form-group">
													                <div class="row">
													                    <center><button id="btnAccion" type="submit" class="btn btn-success">Guardar</button>
													                    <button id="btnCancelar" type="button" class="btn btn-danger">Cancelar</button></center>
													                </div>
													            </div>
													        </form>
													    </div>
													    <div class="form-group">
													        <div class="row">
													            <center>
													                <div id="spinner_registro_doctores" class="text-center"></div>
													            </center>
													        </div>
													    </div>
													    
													    	<table id="tblDoctores">
													    		<thead>
													    			<tr>
													    				<th>Id</th>
													    				<th>Nombres</th>
													    				<th>Apellidos</th>
														    			<th>Cédula</th>
														    			<th>Teléfono</th>
														    			<th>Celular</th>
														    			<th>Especialidad</th>
														    			<th>Centro</th>
														    			<th>Opciones</th>
													    			</tr>													    			
													    		</thead>
													    		<tbody></tbody>
													    	</table>													    
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
			</body>

			<script src="../../../Lib/js/bootstrap.min.js"></script>
			<script src="../../../Lib/js/app.min.js"></script>  
		</html>		
		<?php
	}else{
	  header("location:../../login/login.php");  
	}
	
?>