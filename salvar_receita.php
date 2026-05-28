<?php
session_start();

include("conexao.php");

$id_usuario = $_SESSION['id'];

$valor = $_POST['valor'];
$descricao = $_POST['descricao'];
$tipo = $_POST['tipo'];
$data = $_POST['data_lancamento'];

$sql = mysqli_prepare(
$conn,
"INSERT INTO receitas
(id_usuario, valor, descricao, tipo, data_lancamento)
VALUES (?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
$sql,
"idsss",
$id_usuario,
$valor,
$descricao,
$tipo,
$data
);

if(mysqli_stmt_execute($sql)){

    header("Location: listar_receitas.php");

}else{

    echo "Erro ao salvar receita.";

}
?>