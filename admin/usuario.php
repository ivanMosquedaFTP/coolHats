<?php
require_once ('usuario.class.php');
include ('rol.class.php');

$app = new usuario();
$appRole = new rol();
// $app -> checkRole('administrador');

// acciones = crear y nuevo = agregar un nuevo usuario
// acciones = definir = definir nuevos permisos
// acciones = asignar = asignar permisos a roles
// acciones = enrolar = enrolar usuario a cierto role
$accion = (isset($_GET['accion']))?$_GET['accion'] : NULL;
$id=(isset($_GET['id']))?$_GET['id']:null;
switch ($accion) {
    case 'crear': {
        $roles = $appRole -> readAll();
        $misRoles = $app -> readAllRoles($id);

        include (__DIR__. '/views/usuario/crear.php');
        break;
    }

    case 'nuevo': {
        // $data=$_POST['data'];
        $data = $_POST;
        // echo'<pre />';
        // print_r($data);
        // die();
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "Usuario dado de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "El usuario no ha sido dado de alta";
            $tipo = "danger";
        }

        $usuarios = $app->readAll();
        include(__DIR__.'/views/usuario/index.php');
        break;
    }

    case 'nuevoDesdeSnippet': {
        // $data=$_POST['data'];
        $data = $_POST;
        // echo'<pre />';
        // print_r($data);
        // die();
        $resultado = $app->createDesdeSnippet($data);
        if ($resultado) {
            $mensaje = "Usuario dado de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "El usuario no ha sido dado de alta";
            $tipo = "danger";
        }
        include(__DIR__ . "/../index.php");

        break;
    }

    case 'nuevoDesdeLogin': {
        // $data=$_POST['data'];
        $data = $_POST;
        // echo'<pre />';
        // print_r($data);
        // die();
        $resultado = $app->createDesdeLogin($data);
        if ($resultado) {
            $mensaje = "Usuario dado de alta correctamente";
            $tipo = "success";
        } else {
            $mensaje = "El usuario no ha sido dado de alta";
            $tipo = "danger";
        }
        include(__DIR__ . "/../index.php");

        break;
    }

    case 'actualizar': {
        $app -> checkRole('administrador');
        $usuarios = $app -> readOne($id); 
        $roles = $appRole -> readAll();
        $misRoles = $app -> readAllRoles($id);

        include(__DIR__.'/views/usuario/crear.php');
        break;
    }
    
    case 'modificar': {
        $app -> checkRole('administrador');
        $data= $_POST;
        $result=$app->update($id,$data);
        if($result){
            $mensaje="El usuario se ha actualizado";
            $tipo="success";
        }else{
            $mensaje="No se ha actualizado";
            $tipo="danger";
        }
        $usuarios = $app->readAll();
        include(__DIR__.'/views/usuario/index.php');
        break;
    }

    case 'eliminar': {
        $app -> checkRole('administrador');
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app -> delete($id);
                if ($resultado) {
                    $mensaje = "El usuario se eliminó correctamente";
                    $tipo = "success";
                } else {
                    $mensaje = "El usuario no se eliminó correctamente";
                    $tipo = "danger";
                }
            }
        }
        $usuarios = $app->readAll();
        include(__DIR__.'/views/usuario/index.php');
        break;
    }

    default: {
        $usuarios = $app->readAll();
        include 'views/usuario/index.php';
        include(__DIR__.'/views/usuario/index.php');
        break;
    }
}
?>