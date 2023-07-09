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
    
    $query_albums = "SELECT id, nome_artista, nome_album FROM albums LIMIT $inicio, $limite_resultado";
    $result_albums = $conn->prepare($query_albums);
    $result_albums->execute();

    if(($result_albums) AND ($result_albums->rowCount() != 0)){
       while($row_albums= $result_albums->fetch(PDO::FETCH_ASSOC)){
         extract($row_albums);
         echo "<br>";
         echo "<br>";
         echo "<b>SUGESTÕES DE REVIEW: </b> <br>";
         echo "<br>";
         echo "ID: " . $row_albums['id'] . "<br>";
         echo "Nome " .$row_albums['nome_artista'] . "<br>";
         echo "Sugestao: " .$row_albums['nome_album'] . "<br><br>";
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
