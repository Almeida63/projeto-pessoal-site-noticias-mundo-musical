<?php
session_start();
include_once './conexao.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar</title>
</head>
<body>
    <a href="index.php">Listar</a><br>
    <a href="enviar-sugestao.php">Cadastrar</a><br>
    <h1>Listar</h1>

    <?php
     if(isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
     }
     
    $pagina =  filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual: 1;
    

    $limite_resultado= 40;

    $inicio = ($limite_resultado * $pagina) - $limite_resultado;
    
    $query_materias = "SELECT id, nome, email, materia FROM materias LIMIT $inicio, $limite_resultado";
    $result_materias = $conn->prepare($query_materias);
    $result_materias->execute();

    if(($result_materias) AND ($result_materias->rowCount() != 0)){
       while($row_materias= $result_materias->fetch(PDO::FETCH_ASSOC)){
         extract($row_materias);
         echo "<br>";
         echo "<br>";
         echo "<b>SUGESTÕES DE MATÉRIAS: </b> <br>";
         echo "<br>";
         echo "ID: " . $row_materias['id'] . "<br>";
         echo "Nome:" .$row_materias['nome'] . "<br>";
         echo "E-mail:  " .$row_materias['email'] . "<br><br>";
         echo "Sugestão de matéria: " .$row_materias['materia'] . "<br><br>";
         echo "<a href='visualizar.php?id_artista=$id'>Visualizar</a><br>";
         echo "<a href='editar.php?id_artista=$id'>Editar</a><br>";
         echo "<a href='apagar.php?id_artista=$id'>Apagar</a><br>";
         echo "<hr>";
        }  
      }

      echo "<br>"

   ?>
  </body>
</html>
