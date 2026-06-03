<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id = (int) ($_GET['id'] ?? 0);
$id_usuario = (int) $_SESSION['id'];

if ($id <= 0) {
    redirecionar("listar_despesas.php");
}

$sql = mysqli_prepare($conn, "DELETE FROM despesas WHERE id_despesa = ? AND id_usuario = ?");
mysqli_stmt_bind_param($sql, "ii", $id, $id_usuario);
mysqli_stmt_execute($sql);
redirecionar("listar_despesas.php");
?>
