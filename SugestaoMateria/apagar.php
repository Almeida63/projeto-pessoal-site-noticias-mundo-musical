<?php

session_start();
ob_start();
include_once './conexao.php';

$id = filter_input(INPUT_GET, "id_artista", FILTER_SANITIZE_NUMBER_INT);
var_dump($id);

if(empty($id)){
  $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Sugestão não encontrada! </p>";
  header("Location: index.php");
  exit();
}

$query_materias="SELECT id FROM materias WHERE id = $id LIMIT 1";
$result_materias = $conn->prepare($query_materias);
$result_materias->execute();

if(($result_materias) AND ($result_materias->rowCount() != 0)) {
  $query_del_materias = "DELETE FROM materias WHERE id = $id";
  $apagar_materia = $conn->prepare($query_del_materias);

  if ($apagar_materia->execute()){
    $_SESSION['msg'] = "<p style='color: green;'>Apagado :) ! </p>";
    header("Location: index.php");
  }else{
    $_SESSION['msg'] = "<p style='color: #f00;'>Não apagado </p>";
    header("Location: index.php");
  }
}else{
  $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Sugestão não encontrada! </p>";
  header("Location: index.php");
}

?>