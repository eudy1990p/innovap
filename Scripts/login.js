$('.tooltip').hide();

$('.form-input').focus(function() {
   $('.tooltip').fadeOut(250);
   $("."+$(this).attr('tooltip-class')).fadeIn(500);
});

$('.form-input').blur(function() {
   $('.tooltip').fadeOut(250);
});

$('.login-button').click(function (event) {
  event.preventDefault();
  // or use return false;
});

$(".login-button").click(function() {
  if ( $('.login-form').css( "transform" ) == 'none' ){
    if($('#txtUsuario').val()!="" && $('#txtClave').val()!=""){
      
      $('.login-form').css("transform","rotateY(-180deg)");
      $('.loading').css("transform","rotateY(0deg)");
      var delay=600;
      setTimeout(function(){
        $('.loading-spinner-large').css("display","block");
        $('.loading-spinner-small').css("display","block");
      }, delay);

      $.ajax({
        type:'POST',
        url:'../../Php/procesos.php',
        data:
        {
          'accion':'login',
          'usuario':$('#txtUsuario').val(),
          'clave':$('#txtClave').val()
        }
      }).done(function(respuesta){
        var json=JSON.parse(respuesta);

        if($.isNumeric(json.idusuario) && json.idusuario!=0 && json.tipo_usuario!=""){
          setTimeout(function(){
            $('#usuarioLogeado').val(json.idusuario);
            $('#tipo_usuarioLogeado').val(json.tipo_usuario);
            $('#form_logeado').submit();
          }, 2500);          
        }else if(json.idusuario!="" || json.tipo_usuario!=""){          
          setTimeout(function(){
            $('.login-form').css("transform","rotateY(-360deg)");
            $('.loading').css("transform","rotateY(180deg)");
            $('.loading-spinner-large').css("display","none");
            $('.loading-spinner-small').css("display","none");
            alertify.error("Datos incorrectos");
          }, 1200);
          
        }else{          
          setTimeout(function(){
            $('.login-form').css("transform","rotateY(-360deg)");
            $('.loading').css("transform","rotateY(180deg)");
            $('.loading-spinner-large').css("display","none");
            $('.loading-spinner-small').css("display","none");
            alertify.error("Error: "+json.error);
          }, 1200);
        }
        
      });
      
    }else{
      var errores="";

      if($('#txtUsuario').val()==""){
        if(errores!=""){
          errores+="<br> • Debe introducir el Usuario";
        }else{
          errores+="• Debe introducir el Usuario";
        }
      }
      if($('#txtClave').val()==""){
        if(errores!=""){
          errores+="<br> • Debe introducir la Clave";
        }else{
          errores+="• Debe introducir la Clave";
        }
      }
      if(errores!=""){
        alertify.error(errores);
      }
    }
    
  } else {
      $('.login-form').css("transform","" );
  }
});