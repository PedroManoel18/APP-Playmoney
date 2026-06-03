<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id = (int) ($_GET['id'] ?? 0);
$id_usuario = (int) $_SESSION['id'];

$sql = mysqli_prepare($conn, "SELECT id_categoria, nome_categoria, tipo_categoria FROM categorias WHERE id_categoria = ? AND id_usuario = ?");
mysqli_stmt_bind_param($sql, "ii", $id, $id_usuario);
mysqli_stmt_execute($sql);
$query = mysqli_stmt_get_result($sql);
$categoria = mysqli_fetch_assoc($query);

if (!$categoria) {
    die("Categoria não encontrada.");
}

if (isset($_POST['atualizar'])) {
    $nome = trim($_POST['nome_categoria'] ?? '');
    $tipo = $_POST['tipo_categoria'] ?? '';

    if ($nome === '' || !in_array($tipo, ['Receita', 'Despesa'], true)) {
        die("Dados inválidos.");
    }

    $update = mysqli_prepare($conn, "UPDATE categorias SET nome_categoria = ?, tipo_categoria = ? WHERE id_categoria = ? AND id_usuario = ?");
    mysqli_stmt_bind_param($update, "ssii", $nome, $tipo, $id, $id_usuario);
    mysqli_stmt_execute($update);
    redirecionar("listar_categorias.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Categoria | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <a href="listar_categorias.php" class="btn btn-secondary mb-3">Voltar</a>
    <div class="card shadow">
        <div class="card-body">
            <h3>Editar Categoria</h3>
            <form method="POST">
                <input type="text" name="nome_categoria" value="<?php echo proteger_saida($categoria['nome_categoria']); ?>" class="form-control mb-3" required>
                <select name="tipo_categoria" class="form-select mb-3" required>
                    <option value="Receita" <?php echo $categoria['tipo_categoria'] === 'Receita' ? 'selected' : ''; ?>>Receita</option>
                    <option value="Despesa" <?php echo $categoria['tipo_categoria'] === 'Despesa' ? 'selected' : ''; ?>>Despesa</option>
                </select>
                <button type="submit" name="atualizar" class="btn btn-success">Atualizar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
