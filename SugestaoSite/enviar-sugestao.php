<?php
session_start();
ob_start();
include_once 'conexao.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Sugestão</title>
</head>
<body>
    <center>
    
    <a href="index.php">Listar</a><br>
    <a href="enviar-sugestao.php">Cadastrar</a><br>
    <h1>Envie sua sugestão Para o site.</h1>
    <?php
      $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
         
        if (!empty($dados['EnvSuges'])) {
      
        $empty_input = false;
      
        array_map('trim', $dados);
       if(in_array("", $dados)){
        $empty_input = true;
        echo "Erro! necessário preencher todos os campos";

       }
        

        if(!$empty_input){

           $query_site = "INSERT INTO site (nome, email, sugestao) VALUES ('".$dados['nome'] ."', '" .$dados['email']. "', '" .$dados['sugestao']. "') ";
           $env_suges = $conn ->prepare($query_site);
           $env_suges->execute();
           if($env_suges-> rowCount()){
             unset($dados);
             $_SESSION['msg'] = "<p style='color: green;'>Sugestão pro site enviada com sucesso! </p>"; 
             header("Location: index.php");
            }else{
            echo "<p style='color: red;'> Erro, sugestão pro site não enviada </p>";

          }

        }

      }
    ?>
    <form name="env-suges" method="POST" action="">
        <label>Nome: </label>
        <input type="text" name="nome" id="nome" required><br><br>

        <label>E-mail</label>
        <input type="email" name="email" id="email" required><br><br>

        <label>Sugestão</label>
        <input type="text" name="sugestao" id="sugestao" required><br><br>

        <input type="submit" value="Enviar Sugestão" name = "EnvSuges">
       


    </form>
    </center>
</body>
</html>