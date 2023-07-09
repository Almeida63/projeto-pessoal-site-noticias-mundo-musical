<?php

session_start();
ob_start();
include_once './conexao.php';

$id = filter_input(INPUT_GET, "id_artista", FILTER_SANITIZE_NUMBER_INT);
var_dump($id);

if(empty($id)){
  $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Sugestão de notícia não encontrada! </p>";
  header("Location: index.php");
  exit();
}

$query_site="SELECT id FROM site WHERE id = $id LIMIT 1";
$result_site = $conn->prepare($query_site);
$result_site->execute();

if(($result_site) AND ($result_site->rowCount() != 0)) {
  $query_del_site = "DELETE FROM site WHERE id = $id";
  $apagar_site = $conn->prepare($query_del_site);

  if ($apagar_site->execute()){
    $_SESSION['msg'] = "<p style='color: green;'>Apagado :) ! </p>";
    header("Location: index.php");
  }else{
    $_SESSION['msg'] = "<p style='color: #f00;'>Não apagado </p>";
    header("Location: index.php");
  }
}else{
  $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Sugestão pro site não encontrada! </p>";
  header("Location: index.php");
}

?>