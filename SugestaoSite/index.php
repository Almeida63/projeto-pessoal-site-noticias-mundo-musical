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
    
    $query_site= "SELECT id, nome, email, sugestao FROM site LIMIT $inicio, $limite_resultado";
    $result_site = $conn->prepare($query_site);
    $result_site->execute();

    if(($result_site) AND ($result_site->rowCount() != 0)){
       while($row_site= $result_site->fetch(PDO::FETCH_ASSOC)){
         extract($row_site);
         echo "<br>";
         echo "<br>";
         echo "<b>SUGESTÕES PRO SITE: </b> <br>";
         echo "<br>";
         echo "ID: " . $row_site['id'] . "<br>";
         echo "Nome " .$row_site['nome'] . "<br>";
         echo "E-Mail: " .$row_site['email'] . "<br><br>";
         echo "Sugestão: " .$row_site['sugestao'] . "<br><br>";
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
