<?php
session_start();
ob_start();
include_once './conexao.php';

$id = filter_input(INPUT_GET, "id_artista", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Sugestão não encontrada!</p>";
    header("Location: index.php");
    exit();
}

$query_materias = "SELECT id, nome, email, materia FROM materias WHERE id = $id LIMIT 1";
$result_materias = $conn->prepare($query_materias);
$result_materias->execute();

if (($result_materias) AND ($result_materias->rowCount() != 0)) {
    $row_materias = $result_materias->fetch(PDO::FETCH_ASSOC);
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Sugestão não encontrada!</p>";
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
                $query_up_materias= "UPDATE materias SET nome=:nome, email=:email, materia=:materia WHERE id=:id";
                $edit_materias = $conn->prepare($query_up_materias);
                $edit_materias->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $edit_materias->bindParam(':email', $dados['email'], PDO::PARAM_STR);
                $edit_materias->bindParam(':materia', $dados['materia'], PDO::PARAM_STR);
                $edit_materias->bindParam(':id', $id, PDO::PARAM_INT);
                if($edit_materias->execute()){
                    $_SESSION['msg'] = "<p style='color: green;'>Sugestão editada com sucesso!</p>";
                    header("Location: index.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Sugestão não editada com sucesso!</p>";
                }
            }
        }
        ?>

        <form id="edit-materias" method="POST" action="">
            <label>Nome: </label>
            <input type="text" name="nome" id="nome" value="<?php
            if (isset($dados['nome'])) {
                echo $dados['nome'];
            } elseif (isset($row_materias['nome'])) {
                echo $row_materias['nome'];
            }
            ?>" ><br><br>

            <label>E-mail  </label>
            <input type="email" name="email" id="email" value="<?php
                   if (isset($dados['email'])) {
                       echo $dados['email'];
                   } elseif (isset($row_materias['email'])) {
                       echo $row_materias['email'];
                   }      
                   ?>" ><br><br>

            <label>Matéria  </label>
            <input type="text" name="materia" id="materia" value="<?php
                   if (isset($dados['materia'])) {
                       echo $dados['materia'];
                   } elseif (isset($row_materias['materia'])) {
                       echo $row_materias['materia'];
                   }      
                   ?>" ><br><br>       

            <input type="submit" value="Salvar" name="EditSuges">
        </form>
    </body>
</html>