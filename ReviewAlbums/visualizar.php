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
      $query_albums = "SELECT id, nome_artista, nome_album FROM albums WHERE id = $id LIMIT 1 ";
      $result_albums = $conn->prepare($query_albums);
      $result_albums->execute();

      if(($result_albums) AND ($result_albums->rowCount() != 0 )){
       $row_albums = $result_albums->fetch(PDO:: FETCH_ASSOC);
        
       //var_dump($row_review);
       echo "<b>SUGESTÃO: </b> <br>";
       echo "<br>";
       extract($row_albums);
       echo "ID:  $id <br>";
       echo "Artista: $nome_artista <br>";
       echo "Álbum/EP: $nome_album  <br>";

      } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Sugestão não encontrada! </p>";
        header("Location: index.php");
      }


    ?>
</body>
</html>