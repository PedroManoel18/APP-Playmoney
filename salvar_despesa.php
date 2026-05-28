<?php
session_start();

include("conexao.php");

$id_usuario = $_SESSION['id'];

$valor = $_POST['valor'];
$descricao = $_POST['descricao'];
$tipo = $_POST['tipo'];
$data = $_POST['data_vencimento'];

$sql = mysqli_prepare(
$conn,
"INSERT INTO despesas
(id_usuario, valor, descricao, tipo, data_vencimento)
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

    header("Location: listar_despesas.php");

}else{

    echo "Erro ao salvar despesa.";

}
?>