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
$data_lancamento = $_POST['data_lancamento'] ?? '';

if ($id <= 0 || $valor <= 0 || $descricao === '' || !in_array($tipo, ['Fixa', 'Variavel'], true) || $id_categoria <= 0 || $data_lancamento === '') {
    die("Dados inválidos para atualização de receita.");
}

$verifica = mysqli_prepare($conn, "SELECT id_categoria FROM categorias WHERE id_categoria = ? AND id_usuario = ? AND tipo_categoria = 'Receita'");
mysqli_stmt_bind_param($verifica, "ii", $id_categoria, $id_usuario);
mysqli_stmt_execute($verifica);
if (mysqli_num_rows(mysqli_stmt_get_result($verifica)) === 0) {
    die("Categoria de receita inválida.");
}

$sql = mysqli_prepare($conn, "UPDATE receitas SET valor = ?, descricao = ?, tipo = ?, id_categoria = ?, data_lancamento = ? WHERE id_receita = ? AND id_usuario = ?");
mysqli_stmt_bind_param($sql, "dssisii", $valor, $descricao, $tipo, $id_categoria, $data_lancamento, $id, $id_usuario);
mysqli_stmt_execute($sql);
redirecionar("listar_receitas.php");
?>
