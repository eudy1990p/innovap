
$(document).on('ready',function(){
	$('#contenedorFormulario').hide();
    $('#sector').val(0);

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
        $('#nombres,#apellidos,#descripcion,#ubicacion').val('');
        $('#sector').val(0);
        $('#divNombres,#divDescripcion,#divUbicacion,#divSector').removeClass('has-error');
    }; 

    $('#btnCancelar').on('click',function(){
        $('#spinner_registro_centros').html('');
        $('#btnAccion').html('Guardar');
        $('#btnAccion').addClass('btn-success');
        $('#btnAccion').removeClass('btn-warning');
        limpiar();
    });
    $('#form_registro_centros').on('submit',function(e){
        e.preventDefault();
        var texto=$('#btnAccion').html();
        var accion="";
        
        if($('#nombres').val()!="" &&
           $('#descripcion').val()!="" && 
           $('#ubicacion').val()!="" && 
           $('#sector').val()!="0" ){
            //VALIDACION DE nombres,descripcion,ubicacion y sector
            $('#divNombres,#divDescripcion,#divUbicacion,#divSector').removeClass('has-error');
            
            if(texto=="Guardar"){
                accion="guardar_centro";
            }else if(texto=="Guardar Cambios"){
                accion="editar_centro";
            }
            
            $.ajax({
                type:'POST',
                url:'../../../Php/procesos.php',
                data:
                {
                    accion:accion,
                    nombres:$('#nombres').val(),
                    descripcion:$('#descripcion').val(),
                    ubicacion:$('#ubicacion').val(),
                    sector:$('#sector').val(),
                    idcentro:$('#centro2').val()
                },
                beforeSend:function()
                {
                    $('#spinner_registro_centros').html('<i class="fa fa-spinner fa-spin fa-3x"></i>');
                }
            }).done(function(respuesta){
                $('#spinner_registro_centros').html('');
                if(respuesta=="SI"){
                    if(texto=="Guardar"){
                        alertify.log("Centro registrado");
                    }else if(texto="Guardar Cambios"){
                        alertify.log("Centro modificado");
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
                        alertify.error('Ocurrió un error en la creación del centro');
                    }else if(texto="Guardar Cambios"){
                        alertify.error('Ocurrió un error en la edición del centro');
                    }                    
                }else{
                    alertify.error('Error: '+respuesta);
                }
            });
            
            
        }else{
            var errores="";
            
            if($('#nombres').val()==""){
                $('#divNombres').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe introducir el Nombre";}
                else
                    {errores+="• Debe introducir el Nombre";}
            }else{
                $('#divNombres').removeClass('has-error');
            }
            if($('#descripcion').val()==""){
                $('#divDescripcion').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe introducir la Descipción";}
                else
                    {errores+="• Debe introducir la Descipción";}
            }else{
                $('#divDescripcion').removeClass('has-error');
            }

            if($('#ubicacion').val()==""){
                $('#divUbicacion').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe introducir la Ubicación";}
                else
                    {errores+="• Debe introducir la Ubicación";}
            }else{
                $('#divUbicacion').removeClass('has-error');
            }
            if($('#sector').val()=="0"){
                $('#divSector').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe seleccionar el Sector";}
                else
                    {errores+="• Debe seleccionar el Sector";}
            }else{
                $('#divSector').removeClass('has-error');
            }
                      
           
            if(errores!=""){
              alertify.error(errores);
            }
        }
    });
    modificar=function(idcentro,nombres,descripcion,ubicacion,sector){
        $('#divNombres,#divDescripcion,#divUbicacion,#divSector').removeClass('has-error');
        $('#centro2').val(idcentro);
        $('#nombres').val(nombres);
        $('#descripcion').val(descripcion);
        $('#ubicacion').val(ubicacion);
        $('#sector').val(sector);

        $('#btnAccion').html('Guardar Cambios');
        $('#btnAccion').removeClass('btn-success');
        $('#btnAccion').addClass('btn-warning');
        

        $('#contenedorFormulario').fadeIn();
        $('#abrirForm').html('Cerrar');
        $('#abrirForm').removeClass('btn-success');
        $('#abrirForm').addClass('btn-primary');
        n++;   
    };
    borrar=function(idcentro,nombres){
        swal({
            title: "Eliminar Centro",
            text: "Estás seguro de eliminar el centro "+nombres,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false 
        }, function(isConfirm){
            if (isConfirm) { 
                $.ajax({
                    type:'POST',
                    url:'../../../Php/procesos.php',
                    data:
                    {
                        'accion':'borrar_centro',
                        'idcentro':idcentro
                    }
                }).done(function(respuesta){
                    if(respuesta=="SI"){
                        alertify.log("Centro eliminado");
                        limpiar();
                                       
                    }else if(respuesta=="NO"){
                        var razones="• El centro está vinculado a uno o varios doctores";
                        sweetAlert("El centro no puede ser eliminado", razones, "error");
                    }else{
                        alertify.error("Error: "+respuesta);
                    }
                    mostrar();
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
    			'accion':'mostrar_centros'
    		}
    	}).done(function(respuesta){
            var DATA=[];
    		var json=JSON.parse(respuesta);
    		for(var i=0;i<json.length;i++){
    			fila={};
    			fila[0]=json[i]['idcentro'];
                fila[1]=json[i]['nombres'];
                fila[2]=json[i]['descripcion'];
    			fila[3]=json[i]['ubicacion'];
                fila[4]=json[i]['sector'];
                
                var editar="<a onclick='modificar("+json[i]['idcentro']+",`"+json[i]['nombres']+"`,`"+json[i]['descripcion']+"`,`"+json[i]['ubicacion']+"`,`"+json[i]['sector']+"`)' class='btn btn-warning'><i class='fa fa-pencil-square fa-lg'></i></a>";
                var eliminar="<a onclick='borrar("+json[i]['idcentro']+",`"+json[i]['nombres']+"`)' href='#' class='btn btn-danger'><i class='fa fa-trash-o fa-lg'></i></a>";                            
    			fila[5]=editar+eliminar;
    			DATA.push(fila);  			
    		}
            var oTable = $('#tblCentros').dataTable();
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