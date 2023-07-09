<?php
session_start();
ob_start();
include_once './conexao.php';

$id = filter_input(INPUT_GET, "id_artista", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
    header("Location: index.php");
    exit();
}

$query_site = "SELECT id, nome, email, sugestao FROM site WHERE id = $id LIMIT 1";
$result_site = $conn->prepare($query_site);
$result_site->execute();

if (($result_site) AND ($result_site->rowCount() != 0)) {
    $row_site = $result_site->fetch(PDO::FETCH_ASSOC);
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Editar</title>
    </head>
    <body>
        <a href="index.php">Listar</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>

        <h1>Editar</h1>

        <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($dados['EditSuges'])) {
            $empty_input = false;
            $dados = array_map('trim', $dados);
            if (in_array("", $dados)) {
                $empty_input = true;
                echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
            }
            if (!$empty_input) {
                $query_up_site= "UPDATE site SET nome=:nome, email=:email, sugestao=:sugestao WHERE id=:id";
                $edit_site = $conn->prepare($query_up_site);
                $edit_site->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $edit_site->bindParam(':email', $dados['email'], PDO::PARAM_STR);
                $edit_site->bindParam(':sugestao', $dados['sugestao'], PDO::PARAM_STR);
                $edit_site->bindParam(':id', $id, PDO::PARAM_INT);
                if($edit_site->execute()){
                    $_SESSION['msg'] = "<p style='color: green;'>Sugestão editada com sucesso!</p>";
                    header("Location: index.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Sugestão não editada com sucesso!</p>";
                }
            }
        }
        ?>

        <form id="edit-albums" method="POST" action="">
            <label>Nome: </label>
            <input type="text" name="nome" id="nome" value="<?php
            if (isset($dados['nome'])) {
                echo $dados['nome'];
            } elseif (isset($row_site['nome'])) {
                echo $row_site['nome'];
            }
            ?>" ><br><br>

            <label>E-mail:  </label>
            <input type="email" name="email" id="email" value="<?php
                   if (isset($dados['email'])) {
                       echo $dados['email'];
                   } elseif (isset($row_site['email'])) {
                       echo $row_site['email'];
                   }
                   ?>" ><br><br>

            <label>Sugestão:  </label>
            <input type="sugestao" name="sugestao" id="sugestao" value="<?php
                   if (isset($dados['sugestao'])) {
                       echo $dados['sugestao'];
                   } elseif (isset($row_sugestao['sugestao'])) {
                       echo $row_sugestao['sugestao'];
                   }
                   ?>" ><br><br>       

            <input type="submit" value="Salvar" name="EditSuges">
        </form>
    </body>
</html>