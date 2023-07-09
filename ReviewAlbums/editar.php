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

$query_albums = "SELECT id, nome_artista, nome_album FROM albums WHERE id = $id LIMIT 1";
$result_albums = $conn->prepare($query_albums);
$result_albums->execute();

if (($result_albums) AND ($result_albums->rowCount() != 0)) {
    $row_albums = $result_albums->fetch(PDO::FETCH_ASSOC);
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
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificar se o usuário clicou no botão
        if (!empty($dados['EditSuges'])) {
            $empty_input = false;
            $dados = array_map('trim', $dados);
            if (in_array("", $dados)) {
                $empty_input = true;
                echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
            }
            if (!$empty_input) {
                $query_up_albums= "UPDATE albums SET nome_artista=:nome_artista, nome_album=:nome_album WHERE id=:id";
                $edit_albums = $conn->prepare($query_up_albums);
                $edit_albums->bindParam(':nome_artista', $dados['nome_artista'], PDO::PARAM_STR);
                $edit_albums->bindParam(':nome_album', $dados['nome_album'], PDO::PARAM_STR);
                $edit_albums->bindParam(':id', $id, PDO::PARAM_INT);
                if($edit_albums->execute()){
                    $_SESSION['msg'] = "<p style='color: green;'>Usuário editado com sucesso!</p>";
                    header("Location: index.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
                }
            }
        }
        ?>

        <form id="edit-albums" method="POST" action="">
            <label>Nome Artista: </label>
            <input type="text" name="nome_artista" id="nome_artista" value="<?php
            if (isset($dados['nome_artista'])) {
                echo $dados['nome_artista'];
            } elseif (isset($row_albums['nome_artista'])) {
                echo $row_albums['nome_artista'];
            }
            ?>" ><br><br>

            <label>Nome Álbum:  </label>
            <input type="text" name="nome_album" id="nome_album" value="<?php
                   if (isset($dados['nome_album'])) {
                       echo $dados['nome_album'];
                   } elseif (isset($row_albums['nome_album'])) {
                       echo $row_albums['nome_album'];
                   }
                   ?>" ><br><br>

            <input type="submit" value="Salvar" name="EditSuges">
        </form>
    </body>
</html>