<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];
$nome = trim($_POST['nome_categoria'] ?? '');
$tipo = $_POST['tipo_categoria'] ?? '';

if ($nome === '' || !in_array($tipo, ['Receita', 'Despesa'], true)) {
    die("Dados inválidos para cadastro de categoria.");
}

$sql = mysqli_prepare($conn, "INSERT INTO categorias (id_usuario, nome_categoria, tipo_categoria) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($sql, "iss", $id_usuario, $nome, $tipo);

if (mysqli_stmt_execute($sql)) {
    redirecionar("listar_categorias.php");
}

die("Erro ao salvar categoria.");
?>
