<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);

function permisos() {  
  if (isset($_SERVER['HTTP_ORIGIN'])){
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Credentials: true');      
  }  
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))          
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
    exit(0);
  }
}
permisos();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$estatus = (isset($_POST['estatus'])) ? $_POST['estatus'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : '';
$fechanacimiento = (isset($_POST['fechanacimiento'])) ? $_POST['fechanacimiento'] : '';
$edad = (isset($_POST['edad'])) ? $_POST['edad'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
$puesto = (isset($_POST['puesto'])) ? $_POST['puesto'] : '';
$departamento = (isset($_POST['departamento'])) ? $_POST['departamento'] : '';
$turno = (isset($_POST['turno'])) ? $_POST['turno'] : '';
$rfc = (isset($_POST['rfc'])) ? $_POST['rfc'] : ''; 
$colonia = (isset($_POST['colonia'])) ? $_POST['colonia'] : ''; 
$calle = (isset($_POST['calle'])) ? $_POST['calle'] : ''; 
$cp = (isset($_POST['cp'])) ? $_POST['cp'] : '';


switch($opcion){
	case 1:
        $consulta = "SELECT id, estatus, nombre, sexo, fechanacimiento, edad, telefono, correo, puesto, departamento, turno, rfc, colonia, calle, cp FROM datosgenerales WHERE activo = 1 ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "INSERT INTO datosgenerales (estatus, nombre, sexo, fechanacimiento, edad, telefono, correo, puesto, departamento, turno, rfc, colonia, calle, cp, activo) VALUES('$estatus', '$nombre', '$sexo', '$fechanacimiento', '$edad', '$telefono', '$correo', '$puesto', '$departamento', '$turno', '$rfc', '$colonia', '$calle', '$cp', 1) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $getusuario = "SELECT id FROM datosgenerales ORDER BY id DESC LIMIT 1";
        $respuesta = $conexion->prepare($getusuario);
        $respuesta->execute();
        while($row = $respuesta->fetch(PDO::FETCH_ASSOC)){
            $idusuario = $row['id'];
        }
        $consulta2 = "INSERT INTO historial (puesto, departamento, turno, idusuariofk) VALUES('$puesto', '$departamento', '$turno', '$idusuario')";
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();
        break;
    case 3:
        $consulta = "UPDATE datosgenerales SET estatus='$estatus', nombre='$nombre', sexo='$sexo', fechanacimiento='$fechanacimiento', edad='$edad', telefono='$telefono', correo='$correo', puesto='$puesto', departamento='$departamento', turno='$turno', rfc='$rfc', colonia='$colonia', calle='$calle', cp='$cp', activo=1 WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $consulta2 = "INSERT INTO historial (puesto, departamento, turno, idusuariofk) VALUES('$puesto', '$departamento', '$turno', '$id')";
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 4:
        $consulta = "UPDATE datosgenerales SET activo = 0 WHERE id = '$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 5:
        $consulta = "SELECT * FROM historial WHERE idusuariofk='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;