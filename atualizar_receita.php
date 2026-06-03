<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];
$id = (int) ($_POST['id'] ?? 0);
$valor = (float) ($_POST['valor'] ?? 0);
$descricao = trim($_POST['descricao'] ?? '');
$tipo = $_POST['tipo'] ?? '';
$id_categoria = (int) ($_POST['id_categoria'] ?? 0);
$data_vencimento = $_POST['data_vencimento'] ?? '';

if ($id <= 0 || $valor <= 0 || $descricao === '' || !in_array($tipo, ['Fixa', 'Variavel'], true) || $id_categoria <= 0 || $data_vencimento === '') {
    die("Dados inválidos para atualização de despesa.");
}

$verifica = mysqli_prepare($conn, "SELECT id_categoria FROM categorias WHERE id_categoria = ? AND id_usuario = ? AND tipo_categoria = 'Despesa'");
mysqli_stmt_bind_param($verifica, "ii", $id_categoria, $id_usuario);
mysqli_stmt_execute($verifica);
if (mysqli_num_rows(mysqli_stmt_get_result($verifica)) === 0) {
    die("Categoria de despesa inválida.");
}

$sql = mysqli_prepare($conn, "UPDATE despesas SET valor = ?, descricao = ?, tipo = ?, id_categoria = ?, data_vencimento = ? WHERE id_despesa = ? AND id_usuario = ?");
mysqli_stmt_bind_param($sql, "dssisii", $valor, $descricao, $tipo, $id_categoria, $data_vencimento, $id, $id_usuario);
mysqli_stmt_execute($sql);
redirecionar("listar_despesas.php");
?>
