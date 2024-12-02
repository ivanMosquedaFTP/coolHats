<?php
  require_once('../sistema.class.php');

  $app = new sistema;
  $accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;

  switch ($accion) {
    case 'register': {
      include(__DIR__.'/views/register/index.php');
      break;
    }

    case 'preLogin': {
      include(__DIR__.'/views/login/index.php');
      break;
    }

    case 'preCreate': {
      include(__DIR__.'/views/register/index.php');
      break;
    }

    case 'login': {
      $email = $_POST['data']['email'];
      $contrasena = $_POST['data']['contrasena'];
      if($app -> login($email, $contrasena)) {
        $mensaje = "Bienvenido al sistema";
        $tipo = "success";
        $app -> checkRole('administrador');
        require_once(__DIR__.'/views/header/headerAdministrador.php');
        $app -> alerta($tipo, $mensaje);
        //TODO:plantillas personalizadas de Bienvenida
      } else {
        $mensaje = "email o contrasena equivocados, <a href='login.php'>[presione aqui para volver a intentar]</a>";
        $tipo = "danger";
        require_once(__DIR__.'/views/header.php');
        $app -> alerta($tipo, $mensaje);
        require_once(__DIR__.'/views/footer.php');
      }

      break;
    }

    case 'logout': {$app -> logout(); break;}
    
    default: {
      include(__DIR__.'/views/login/index.php');
      break;
    }
  }

  require_once(__DIR__.'/views/footer.php');
?>