<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];
$id_categoria = (int) ($_POST['id_categoria'] ?? 0);
$valor = (float) ($_POST['valor'] ?? 0);
$descricao = trim($_POST['descricao'] ?? '');
$tipo = $_POST['tipo'] ?? '';
$data = $_POST['data_vencimento'] ?? '';

if ($id_categoria <= 0 || $valor <= 0 || $descricao === '' || !in_array($tipo, ['Fixa', 'Variavel'], true) || $data === '') {
    die("Dados inválidos para cadastro de despesa.");
}

$verifica = mysqli_prepare($conn, "SELECT id_categoria FROM categorias WHERE id_categoria = ? AND id_usuario = ? AND tipo_categoria = 'Despesa'");
mysqli_stmt_bind_param($verifica, "ii", $id_categoria, $id_usuario);
mysqli_stmt_execute($verifica);
$resultado = mysqli_stmt_get_result($verifica);

if (mysqli_num_rows($resultado) === 0) {
    die("Categoria de despesa inválida.");
}

$sql = mysqli_prepare($conn, "INSERT INTO despesas (id_usuario, id_categoria, valor, descricao, tipo, data_vencimento) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($sql, "iidsss", $id_usuario, $id_categoria, $valor, $descricao, $tipo, $data);

if (mysqli_stmt_execute($sql)) {
    redirecionar("listar_despesas.php");
}

die("Erro ao salvar despesa.");
?>
