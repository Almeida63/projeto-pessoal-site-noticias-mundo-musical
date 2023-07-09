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

$query_noticias="SELECT id FROM noticias WHERE id = $id LIMIT 1";
$result_noticias = $conn->prepare($query_noticias);
$result_noticias->execute();

if(($result_noticias) AND ($result_noticias->rowCount() != 0)) {
  $query_del_noticias = "DELETE FROM noticias WHERE id = $id";
  $apagar_noticias = $conn->prepare($query_del_noticias);

  if ($apagar_noticias->execute()){
    $_SESSION['msg'] = "<p style='color: green;'>Apagado :) ! </p>";
    header("Location: index.php");
  }else{
    $_SESSION['msg'] = "<p style='color: #f00;'>Não apagado </p>";
    header("Location: index.php");
  }
}else{
  $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Sugestão de notícia não encontrada! </p>";
  header("Location: index.php");
}

?>