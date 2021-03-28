<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
$app = new \Slim\App;

// GET Todos los clientes 
$app->get('/api/alumnos', function(Request $request, Response $response){
  $sql = "SELECT * FROM alumonos";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $alumnos = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($alumnos);
    }else {
      echo json_encode("No existen alumnos en la BBDD.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// GET Recueperar cliente por ID 
$app->get('/api/alumnos/{id}', function(Request $request, Response $response){
  $id_alumnos = $request->getAttribute('id');
  $sql = "SELECT * FROM alumonos WHERE id = $id_alumnos";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $alumnos = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($alumnos);
    }else {
      echo json_encode("No existen alumno en la BBDD con este ID.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// POST Crear nuevo cliente 
$app->post('/api/alumnos/nuevo', function(Request $request, Response $response){
   $entrada = $request->getParam('entrada');
   $salida = $request->getParam('salida'); 
  
  $sql = "INSERT INTO alumonos (entrada, salida) VALUES 
          (:entrada,  :salida)";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':entrada', $entrada);
    $resultado->bindParam(':salida', $salida);

    $resultado->execute();
    echo json_encode("Nuevo alumno guardado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 



// PUT Modificar cliente 
$app->put('/api/alumnos/modificar/{id}', function(Request $request, Response $response){
   $id_alumnos = $request->getAttribute('id');
   $entrada = $request->getParam('entrada');
   $salida = $request->getParam('salida'); 
  
  $sql = "UPDATE alumonos SET
          entrada = :entrada,
          salida = :salida
        WHERE id = $id_alumnos";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':entrada', $entrada);
    $resultado->bindParam(':salida', $salida);

    $resultado->execute();
    echo json_encode("alumno modificado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// DELETE borar cliente 
$app->delete('/api/alumnos/delete/{id}', function(Request $request, Response $response){
   $id_alumnos = $request->getAttribute('id');
   $sql = "DELETE FROM alumonos WHERE id = $id_alumnos";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);
     $resultado->execute();

    if ($resultado->rowCount() > 0) {
      echo json_encode("alumno eliminado.");  
    }else {
      echo json_encode("No existe alumno con este ID.");
    }

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 
