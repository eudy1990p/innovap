
$(document).on('ready',function(){
	$('#contenedorFormulario').hide();
    $('#tipo_usuario').val(0);
	var n=0;
    $('#abrirForm').on('click',function(){
        if(n%2==0){
        	$('#contenedorFormulario').fadeIn();
            $(this).html('Cerrar');
            $(this).removeClass('btn-success');
            $(this).addClass('btn-primary');
            $('#btnCancelar').click();
        }else{
        	$('#contenedorFormulario').fadeOut();
            $(this).html('Agregar Nuevo');
            $(this).removeClass('btn-primary');
            $(this).addClass('btn-success');
            $('#btnCancelar').click();
        }
        n++;
    });

    limpiar = function(){
        $('#nombres,#apellidos,#usuario,#clave,#clave2').val('');
        $('#tipo_usuario').val(0);
        $('#divNombres,#divApellidos,#divUsuario,#divClave,#divClave2,#divTipousuario').removeClass('has-error');
    }; 

    $('#btnCancelar').on('click',function(){
        $('#spinner_registro_usuarios').html('');
        $('#btnAccion').html('Guardar');
        $('#btnAccion').addClass('btn-success');
        $('#btnAccion').removeClass('btn-warning');
        $('#clave,#clave2').prop('disabled', false);
        limpiar();
    });
    $('#form_registro_usuarios').on('submit',function(e){
        e.preventDefault();
        var texto=$('#btnAccion').html();
        var accion="";
        
        if($('#nombres').val()!="" &&
           $('#apellidos').val()!="" && 
           $('#usuario').val()!="" &&
           $('#tipo_usuario').val()!=0){
            //VALIDACION DE nombres,apellidos y usuario
            $('#divNombres,#divApellidos,#divUsuario,#divTipousuario').removeClass('has-error');
            var execute=false;

            //Si estoy guardando, valido la clave

            if(texto=="Guardar"){
                accion="guardar_usuario";
                if($('#clave').val()!="" && $('#clave2').val()!="" && ($('#clave').val()==$('#clave2').val())){
                    execute=true;
                }else{
                    execute=false;
                }
            //Si estoy modificando no valido la clave
            }else if(texto="Guardar Cambios"){
                accion="editar_usuario";
                execute=true;
            }
            
            if(execute){
                $.ajax({
                    type:'POST',
                    url:'../../../Php/procesos.php',
                    data:
                    {
                        accion:accion,
                        nombre:$('#nombres').val(),
                        apellido:$('#apellidos').val(),
                        usuario:$('#usuario').val(),
                        tipo_usuario:$('#tipo_usuario').val(),
                        clave:$('#clave').val(),
                        idusuario:$('#usuario2').val()
                    },
                    beforeSend:function()
                    {
                        $('#spinner_registro_usuarios').html('<i class="fa fa-spinner fa-spin fa-3x"></i>');
                    }
                }).done(function(respuesta){
                    $('#spinner_registro_usuarios').html('');
                    if(respuesta=="SI"){
                        if(texto=="Guardar"){
                            alertify.log("Usuario registrado");
                        }else if(texto="Guardar Cambios"){
                            alertify.log("Usuario modificado");
                        }
                        limpiar();
                        mostrar();
                        $('#contenedorFormulario').fadeOut();
                        $('#abrirForm').html('Agregar Nuevo');
                        $('#abrirForm').removeClass('btn-primary');
                        $('#abrirForm').addClass('btn-success');
                        n++;
                    }else if(respuesta=="NO"){
                        if(texto=="Guardar"){
                            alertify.error('Ocurrió un error en la creación del usuario');
                        }else if(texto="Guardar Cambios"){
                            alertify.error('Ocurrió un error en la edición del usuario');
                        }                    
                    }else{
                        alertify.error('Error: '+respuesta);
                    }
                });
            }else{
                var errores="";
                //Valido la clave
                if($('#clave').val()==""){
                    $('#divClave').addClass('has-error');
                    if(errores!=""){errores+="<br> • Debe introducir la Clave";}
                    else
                        {errores+="• Debe introducir la Clave";}
                }else{
                     $('#divClave').removeClass('has-error');
                }
                //Valido la repiticion de la clave
                if($('#clave2').val()==""){
                    $('#divClave2').addClass('has-error');
                    if(errores!=""){errores+="<br> • Debe repetir la Clave";}
                    else
                        {errores+="• Debe repetir la Clave";}
                }else{
                     $('#divClave2').removeClass('has-error');
                }
                var c1=$('#clave').val(), c2=$('#clave2').val();
                //Si alguna clave esta escrita, compruebo su parentesco
                if(c1!="" && c2!=""){
                    if(c1!=c2){
                        $('#divClave,#divClave2').addClass('has-error');
                        if(errores!=""){errores+="<br> • Las contraseñas no coinciden";}
                        else
                            {errores+="• Las contraseñas no coinciden";}                    
                    }else{
                        $('#divClave,#divClave2').removeClass('has-error');
                    }
                }
                if(errores!=""){
                  alertify.error(errores);
                }
            }
            
        }else{
            var errores="";
            if($('#tipo_usuario').val()=="0"){
                $('#divTipousuario').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe seleccionar el tipo de usuario";}
                else
                    {errores+="• Debe seleccionar el tipo de usuario";}
            }else{
                $('#divTipousuario').removeClass('has-error');
            }

            if($('#nombres').val()==""){
                $('#divNombres').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe introducir el Nombre";}
                else
                    {errores+="• Debe introducir el Nombre";}
            }else{
                $('#divNombres').removeClass('has-error');
            }
            if($('#apellidos').val()==""){
                $('#divApellidos').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe introducir el Apellidos";}
                else
                    {errores+="• Debe introducir el Apellidos";}
            }else{
                $('#divApellidos').removeClass('has-error');
            }
            if($('#usuario').val()==""){
                $('#divUsuario').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe introducir el Usuario";}
                else
                    {errores+="• Debe introducir el Usuario";}
            }else{
                $('#divUsuario').removeClass('has-error');
            }           
           
            if(errores!=""){
              alertify.error(errores);
            }
        }
    });
    modificar=function(idusuario,nombres,apellidos,usuario,tipo_usuario){
        $('#divNombres,#divApellidos,#divUsuario,#divClave,#divClave2').removeClass('has-error');
        $('#usuario2').val(idusuario);
        $('#nombres').val(nombres);
        $('#apellidos').val(apellidos);
        $('#usuario').val(usuario);
        $('#tipo_usuario').val(tipo_usuario);

        $('#btnAccion').html('Guardar Cambios');
        $('#btnAccion').removeClass('btn-success');
        $('#btnAccion').addClass('btn-warning');
        //la contraseña no puede ser cambiada por esta via
        $('#clave,#clave2').prop('disabled', true);

        $('#contenedorFormulario').fadeIn();
        $('#abrirForm').html('Cerrar');
        $('#abrirForm').removeClass('btn-success');
        $('#abrirForm').addClass('btn-primary');
        n++;   
    };
    borrar=function(idusuario,nombres,apellidos){
        swal({
            title: "Eliminar Usuario",
            text: "Estás seguro de eliminar a "+nombres+" "+apellidos,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true 
        }, function(isConfirm){
            if (isConfirm) { 
                $.ajax({
                    type:'POST',
                    url:'../../../Php/procesos.php',
                    data:
                    {
                        'accion':'borrar_usuario',
                        'idusuario':idusuario
                    }
                }).done(function(respuesta){
                    if(respuesta=="SI"){
                        alertify.log("Usuario eliminado");
                        limpiar();
                        mostrar();                        
                    }else if(respuesta=="NO"){
                        alertify.error("Ocurrió un error al eliminar el usuario");
                    }else{
                        alertify.error("Error: "+respuesta);
                    }
                });
            }
        });
    };
    mostrar=function(){
    	$.ajax({
    		type:'POST',
    		url:'../../../Php/procesos.php',
    		data:
    		{
    			'accion':'mostrar_usuarios'
    		}
    	}).done(function(respuesta){
    		var DATA=[];
    		var json=JSON.parse(respuesta);
    		for(var i=0;i<json.length;i++){
    			fila={};
    			fila[0]=json[i]['idusuario'];
                fila[1]=json[i]['nombres'];
                fila[2]=json[i]['apellidos'];
    			fila[3]=json[i]['usuario'];

                var tipo_usuario="";
                if(json[i]['tipo_usuario']=="Administrador"){
                    tipo_usuario="<label class='label label-danger'>"+json[i]['tipo_usuario']+"</label>";
                }else if(json[i]['tipo_usuario']=="Doctor"){
                    tipo_usuario="<label class='label label-primary'>"+json[i]['tipo_usuario']+"</label>";
                }else if(json[i]['tipo_usuario']=="Paciente"){
                    tipo_usuario="<label class='label label-success'>"+json[i]['tipo_usuario']+"</label>";
                }
                fila[4]=tipo_usuario;
                var editar="<a onclick='modificar("+json[i]['idusuario']+",`"+json[i]['nombres']+"`,`"+json[i]['apellidos']+"`,`"+json[i]['usuario']+"`,`"+json[i]['tipo_usuario']+"`)' class='btn btn-warning'><i class='fa fa-pencil-square fa-lg'></i></a>";
                var eliminar="<a onclick='borrar("+json[i]['idusuario']+",`"+json[i]['nombres']+"`,`"+json[i]['apellidos']+"`)' href='#' class='btn btn-danger'><i class='fa fa-trash-o fa-lg'></i></a>";                            
    			fila[5]=editar+eliminar;
    			DATA.push(fila);  			
    		}
            var oTable = $('#tblUsuarios').dataTable();
            oTable.fnClearTable();
    		if(DATA.length>0){  			
                oTable.fnAddData(DATA);
                oTable.fnDraw();   
    		}else{
                oTable.fnDraw();
            }
    	});
    }
    mostrar();
});