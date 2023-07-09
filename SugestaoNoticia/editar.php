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

$query_noticias = "SELECT id, nome, email, noticia FROM noticias WHERE id = $id LIMIT 1";
$result_noticias = $conn->prepare($query_noticias);
$result_noticias->execute();

if (($result_noticias) AND ($result_noticias->rowCount() != 0)) {
    $row_noticias = $result_noticias->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_usuario);
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
                $query_up_noticias= "UPDATE noticias SET nome=:nome, email=:email, noticia=:noticia WHERE id=:id";
                $edit_noticias = $conn->prepare($query_up_noticias);
                $edit_noticias->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $edit_noticias->bindParam(':email', $dados['email'], PDO::PARAM_STR);
                $edit_noticias->bindParam(':noticia', $dados['noticia'], PDO::PARAM_STR);
                $edit_noticias->bindParam(':id', $id, PDO::PARAM_INT);
                if($edit_noticias->execute()){
                    $_SESSION['msg'] = "<p style='color: green;'>Usuário editado com sucesso!</p>";
                    header("Location: index.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
                }
            }
        }
        ?>

        <form id="edit-albums" method="POST" action="">
            <label>Nome: </label>
            <input type="text" name="nome" id="nome" value="<?php
            if (isset($dados['nome'])) {
                echo $dados['nome'];
            } elseif (isset($row_noticias['nome'])) {
                echo $row_noticias['nome'];
            }
            ?>" ><br><br>

            <label>E-mail:  </label>
            <input type="email" name="email" id="email" value="<?php
                   if (isset($dados['email'])) {
                       echo $dados['email'];
                   } elseif (isset($row_noticias['email'])) {
                       echo $row_noticias['email'];
                   }
                   ?>" ><br><br>

            <label>Noticia:  </label>
            <input type="noticia" name="noticia" id="noticia" value="<?php
                   if (isset($dados['noticia'])) {
                       echo $dados['noticia'];
                   } elseif (isset($row_noticias['noticia'])) {
                       echo $row_noticias['noticia'];
                   }
                   ?>" ><br><br>       

            <input type="submit" value="Salvar" name="EditSuges">
        </form>
    </body>
</html>