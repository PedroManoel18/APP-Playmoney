<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id = (int) ($_GET['id'] ?? 0);
$id_usuario = (int) $_SESSION['id'];

if ($id <= 0) {
    redirecionar("listar_categorias.php");
}

$receitas = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM receitas WHERE id_categoria = ? AND id_usuario = ?");
mysqli_stmt_bind_param($receitas, "ii", $id, $id_usuario);
mysqli_stmt_execute($receitas);
$totalReceitas = mysqli_fetch_assoc(mysqli_stmt_get_result($receitas))['total'];

$despesas = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM despesas WHERE id_categoria = ? AND id_usuario = ?");
mysqli_stmt_bind_param($despesas, "ii", $id, $id_usuario);
mysqli_stmt_execute($despesas);
$totalDespesas = mysqli_fetch_assoc(mysqli_stmt_get_result($despesas))['total'];

if ($totalReceitas > 0 || $totalDespesas > 0) {
    echo "<script>alert('Não é possível excluir uma categoria vinculada a receitas ou despesas.'); window.location='listar_categorias.php';</script>";
    exit();
}

$delete = mysqli_prepare($conn, "DELETE FROM categorias WHERE id_categoria = ? AND id_usuario = ?");
mysqli_stmt_bind_param($delete, "ii", $id, $id_usuario);
mysqli_stmt_execute($delete);
redirecionar("listar_categorias.php");
?>
