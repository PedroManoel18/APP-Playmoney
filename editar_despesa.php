<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id = (int) ($_GET['id'] ?? 0);
$id_usuario = (int) $_SESSION['id'];

$sql = mysqli_prepare($conn, "SELECT * FROM despesas WHERE id_despesa = ? AND id_usuario = ?");
mysqli_stmt_bind_param($sql, "ii", $id, $id_usuario);
mysqli_stmt_execute($sql);
$despesa = mysqli_fetch_assoc(mysqli_stmt_get_result($sql));

if (!$despesa) {
    die("Despesa não encontrada.");
}

$catSql = mysqli_prepare($conn, "SELECT id_categoria, nome_categoria FROM categorias WHERE id_usuario = ? AND tipo_categoria = 'Despesa' ORDER BY nome_categoria");
mysqli_stmt_bind_param($catSql, "i", $id_usuario);
mysqli_stmt_execute($catSql);
$categorias = mysqli_stmt_get_result($catSql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Despesa | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <a href="listar_despesas.php" class="btn btn-secondary mb-3">Voltar</a>
    <div class="card shadow p-4">
        <h3>Editar Despesa</h3>
        <form action="atualizar_despesa.php" method="POST">
            <input type="hidden" name="id" value="<?php echo (int) $despesa['id_despesa']; ?>">
            <div class="mb-3">
                <label>Valor</label>
                <input type="number" step="0.01" min="0.01" name="valor" value="<?php echo proteger_saida($despesa['valor']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descrição</label>
                <input type="text" name="descricao" value="<?php echo proteger_saida($despesa['descricao']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tipo</label>
                <select name="tipo" class="form-select" required>
                    <option value="Fixa" <?php echo $despesa['tipo'] === 'Fixa' ? 'selected' : ''; ?>>Fixa</option>
                    <option value="Variavel" <?php echo $despesa['tipo'] === 'Variavel' ? 'selected' : ''; ?>>Variável</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Categoria</label>
                <select name="id_categoria" class="form-select" required>
                    <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                        <option value="<?php echo (int) $cat['id_categoria']; ?>" <?php echo (int) $cat['id_categoria'] === (int) $despesa['id_categoria'] ? 'selected' : ''; ?>>
                            <?php echo proteger_saida($cat['nome_categoria']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Data de Vencimento</label>
                <input type="date" name="data_vencimento" value="<?php echo proteger_saida($despesa['data_vencimento']); ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Atualizar Despesa</button>
        </form>
    </div>
</div>
</body>
</html>
