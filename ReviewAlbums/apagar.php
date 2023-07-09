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

$query_albums="SELECT id FROM albums WHERE id = $id LIMIT 1";
$result_albums = $conn->prepare($query_albums);
$result_albums->execute();

if(($result_albums) AND ($result_albums->rowCount() != 0)) {
  $query_del_albums = "DELETE FROM albums WHERE id = $id";
  $apagar_album = $conn->prepare($query_del_albums);

  if ($apagar_album->execute()){
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