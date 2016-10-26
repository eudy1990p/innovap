
$(document).on('ready',function(){
    $("#cedula").mask("999-9999999-9");
    $("#celular,#telefono").mask("(999) 999-9999");
    

	$('#contenedorFormulario').hide();
    
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
        $('#nombres,#apellidos,#cedula,#telefono,#celular,#especialidad').val('');
        $('#centro').val(0);
        $('#divNombres,#divApellidos,#divCedula,#divTelefono,#divCelular,#divEspecialidad').removeClass('has-error');
    }; 

    $('#btnCancelar').on('click',function(){
        $('#spinner_registro_doctores').html('');
        $('#btnAccion').html('Guardar');
        $('#btnAccion').addClass('btn-success');
        $('#btnAccion').removeClass('btn-warning');
        limpiar();
    });
    cargar_centros=function(){   
        $('#centro').html("<option value='0'>-- Seleccione el Centro --</option>");     
        $.ajax({
            type:'POST',
            url:'../../../Php/procesos.php',
            data:
            {
                'accion':'cargar_centros'
            }
        }).done(function(respuesta){
            var tabla="";
            var DATA=[];
            var json=JSON.parse(respuesta);
            for(var i=0;i<json.length;i++){
                tabla="<option value='"+json[i]['idcentro']+"'>"+json[i]['nombres']+"</option>";
                $('#centro').append(tabla);
            }
        });
    };

    mostrar=function(){
        $.ajax({
            type:'POST',
            url:'../../../Php/procesos.php',
            data:
            {
                'accion':'mostrar_doctores'
            }
        }).done(function(respuesta){
            var DATA=[];
            var json=JSON.parse(respuesta);
            for(var i=0;i<json.length;i++){
                fila={};
                fila[0]=json[i]['iddoctor'];
                fila[1]=json[i]['nombres'];
                fila[2]=json[i]['apellidos'];
                fila[3]=json[i]['cedula'];
                fila[4]=json[i]['telefono'];
                fila[5]=json[i]['celular'];
                fila[6]=json[i]['especialidad'];
                fila[7]=json[i]['c_nombres'];
                var editar="<a onclick='modificar("+json[i]['iddoctor']+",`"+json[i]['nombres']+"`,`"+json[i]['apellidos']+"`,`"+json[i]['cedula']+"`,`"+json[i]['telefono']+"`,`"+json[i]['celular']+"`,`"+json[i]['especialidad']+"`,`"+json[i]['id_centro']+"`)' class='btn btn-warning'><i class='fa fa-pencil-square fa-lg'></i></a>";
                var eliminar="<a onclick='borrar("+json[i]['iddoctor']+",`"+json[i]['nombres']+"`,`"+json[i]['apellidos']+"`)' href='#' class='btn btn-danger'><i class='fa fa-trash-o fa-lg'></i></a>";                            
                fila[8]=editar+eliminar;
                DATA.push(fila);            
            }
            var oTable = $('#tblDoctores').dataTable();
            oTable.fnClearTable();
            if(DATA.length>0){              
                oTable.fnAddData(DATA);
                oTable.fnDraw();   
            }else{
                oTable.fnDraw();
            }
            
            
        });
    }
    $('#form_registro_doctores').on('submit',function(e){
        e.preventDefault();
        var texto=$('#btnAccion').html();
        var accion="";
        
        if($('#nombres').val()!="" &&
           $('#apellidos').val()!="" && 
           $('#cedula').val()!="" && 
           $('#telefono').val()!="" &&
           $('#centro').val()!="0"){
            //VALIDACION DE nombres,apellidos,cedula y telefono
            $('#divNombres,#divApellidos,#divCedula,#divTelefono,#divCentro').removeClass('has-error');
            
            if(texto=="Guardar"){
                accion="guardar_doctor";
            }else if(texto=="Guardar Cambios"){
                accion="editar_doctor";
            }
            
            $.ajax({
                type:'POST',
                url:'../../../Php/procesos.php',
                data:
                {
                    accion:accion,
                    nombres:$('#nombres').val(),
                    apellidos:$('#apellidos').val(),
                    cedula:$('#cedula').val(),
                    telefono:$('#telefono').val(),
                    celular:$('#celular').val(),
                    especialidad:$('#especialidad').val(),
                    centro:$('#centro').val(),
                    iddoctor:$('#doctor2').val()
                },
                beforeSend:function()
                {
                    $('#spinner_registro_doctores').html('<i class="fa fa-spinner fa-spin fa-3x"></i>');
                }
            }).done(function(respuesta){
                $('#spinner_registro_doctores').html('');
                if(respuesta=="SI"){
                    if(texto=="Guardar"){
                        alertify.log("Doctor registrado");
                    }else if(texto="Guardar Cambios"){
                        alertify.log("Doctor modificado");
                    }
                    limpiar();
                    mostrar();
                    cargar_centros();
                    $('#contenedorFormulario').fadeOut();
                    $('#abrirForm').html('Agregar Nuevo');
                    $('#abrirForm').removeClass('btn-primary');
                    $('#abrirForm').addClass('btn-success');
                    n++;
                }else if(respuesta=="NO"){
                    if(texto=="Guardar"){
                        alertify.error('Ocurrió un error en la creación del doctor');
                    }else if(texto="Guardar Cambios"){
                        alertify.error('Ocurrió un error en la edición del doctor');
                    }                    
                }else{
                    alertify.error('Error: '+respuesta);
                }
            });
            
            
        }else{
            var errores="";
            if($('#centro').val()=="0"){
                $('#divCentro').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe seleccionar el centro";}
                else
                    {errores+="• Debe seleccionar el centro";}
            }else{
                $('#divCentro').removeClass('has-error');
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

            if($('#cedula').val()==""){
                $('#divCedula').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe introducir la Cédula";}
                else
                    {errores+="• Debe introducir la Cédula";}
            }else{
                $('#divCedula').removeClass('has-error');
            }
            if($('#telefono').val()==""){
                $('#divTelefono').addClass('has-error');
                if(errores!=""){errores+="<br> • Debe introducir el Teléfono";}
                else
                    {errores+="• Debe introducir el Teléfono";}
            }else{
                $('#divTelefono').removeClass('has-error');
            }
                      
           
            if(errores!=""){
              alertify.error(errores);
            }
        }
    });
    modificar=function(iddoctor,nombres,apellidos,cedula,telefono,celular,especialidad,id_centro){
        $('#divNombres,#divApellidos,#divCedula,#divTelefono').removeClass('has-error');
        $('#doctor2').val(iddoctor);
        $('#nombres').val(nombres);
        $('#apellidos').val(apellidos);
        $('#cedula').val(cedula);
        $('#telefono').val(telefono);
        $('#celular').val(celular);
        $('#especialidad').val(especialidad);
        $('#centro').val(id_centro);

        $('#btnAccion').html('Guardar Cambios');
        $('#btnAccion').removeClass('btn-success');
        $('#btnAccion').addClass('btn-warning');
        

        $('#contenedorFormulario').fadeIn();
        $('#abrirForm').html('Cerrar');
        $('#abrirForm').removeClass('btn-success');
        $('#abrirForm').addClass('btn-primary');
        n++;   
    };
    
    
    borrar=function(iddoctor,nombres,apellidos){
        swal({
            title: "Eliminar Doctor",
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
                        'accion':'borrar_doctor',
                        'iddoctor':iddoctor
                    }
                }).done(function(respuesta){
                    if(respuesta=="SI"){
                        alertify.log("Doctor eliminado");
                        limpiar();
                        mostrar();  
                        cargar_centros();                      
                    }else if(respuesta=="NO"){
                        alertify.error("Ocurrió un error al eliminar el doctor");
                    }else{
                        alertify.error("Error: "+respuesta);
                    }
                });
            }
        });
    };
    mostrar();
    cargar_centros();
});