<?php
session_start();
ob_start();
include_once 'conexao.php';

$id = filter_input(INPUT_GET, "id_artista", FILTER_SANITIZE_NUMBER_INT);

if(empty($id)) {
  $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Sugestão não encontrada! </p>";
  header("Location: index.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar</title>
</head>
<body>
    <center>
    
    <a href="index.php">Listar</a><br>
    <a href="enviar-sugestao.php">Cadastrar</a><br>
    <h1>Visualizar</h1>
     
    <?php
      $query_materias = "SELECT id, nome, email, materia FROM materias WHERE id = $id LIMIT 1 ";
      $result_materias = $conn->prepare($query_materias);
      $result_materias->execute();

      if(($result_materias) AND ($result_materias->rowCount() != 0 )){
       $row_materias = $result_materias->fetch(PDO:: FETCH_ASSOC);
        
       echo "<b>SUGESTÃO: </b> <br>";
       echo "<br>";
       extract($row_materias);
       echo "ID:  $id <br>";
       echo "Nome: $nome <br>";
       echo "E-mail: $email  <br>";
       echo "Sugestão de matéria: $materia  <br>";

      } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Sugestão não encontrada! </p>";
        header("Location: index.php");
      }


    ?>
</body>
</html>