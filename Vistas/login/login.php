<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8">
    <title>Login</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>   
    <script type="text/javascript" src="../../Lib/alertify/alertify.min.js"></script>
    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Nunito:400,300,700'>
    <link rel="stylesheet" href="../../Lib/css/estilo-login.css">
    <link rel="stylesheet" href="../../Lib/alertify/alertify.core.css">
    <link rel="stylesheet" href="../../Lib/alertify/alertify.default.css">
  
  </head>
  <body>
    <div class="container">
      <div class="form-container flip">
        <form class="login-form">
          <h3 class="title">Login</h3>
            <div class="form-group" id="username">
              <input class="form-input" tooltip-class="username-tooltip" placeholder="Usuario" id="txtUsuario" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required="true"></input>
              <span id="username-tool" class="tooltip username-tooltip">Cuál es tu usuario?</span>
            </div>            
            <div class="form-group" id="password">
              <input type="password" class="form-input" tooltip-class="password-tooltip" id="txtClave" placeholder="Clave"></input>
              <span class="tooltip password-tooltip">Cuál es tu clave?</span>
            </div>
            <div class="form-group">
              <button class="login-button">Login</button>
              <input class="remember-checkbox" type="checkbox"></input>
              <p class="remember-p">Recordarme</p>
            </div>
        </form>
        <form id="form_logeado" action="../principal/inicio.php" method="POST">
          <input type="text" class="hidden" id="usuarioLogeado" name="usuarioLogeado"> 
          <input type="text" class="hidden" id="tipo_usuarioLogeado" name="tipo_usuarioLogeado"> 
        </form>

        <div class="loading">
          <div class="loading-spinner-large" style="display: none;"></div>
          <div class="loading-spinner-small" style="display: none;"></div>
        </div>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script>
    <script src='https://code.jquery.com/jquery-2.1.4.min.js'></script>
    <script src="../../Scripts/login.js"></script>
  </body>
</html>
