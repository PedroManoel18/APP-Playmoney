<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id = (int) ($_GET['id'] ?? 0);
$id_usuario = (int) $_SESSION['id'];

$sql = mysqli_prepare($conn, "SELECT * FROM receitas WHERE id_receita = ? AND id_usuario = ?");
mysqli_stmt_bind_param($sql, "ii", $id, $id_usuario);
mysqli_stmt_execute($sql);
$receita = mysqli_fetch_assoc(mysqli_stmt_get_result($sql));

if (!$receita) {
    die("Receita não encontrada.");
}

$catSql = mysqli_prepare($conn, "SELECT id_categoria, nome_categoria FROM categorias WHERE id_usuario = ? AND tipo_categoria = 'Receita' ORDER BY nome_categoria");
mysqli_stmt_bind_param($catSql, "i", $id_usuario);
mysqli_stmt_execute($catSql);
$categorias = mysqli_stmt_get_result($catSql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Receita | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <a href="listar_receitas.php" class="btn btn-secondary mb-3">Voltar</a>
    <div class="card shadow p-4">
        <h3>Editar Receita</h3>
        <form action="atualizar_receita.php" method="POST">
            <input type="hidden" name="id" value="<?php echo (int) $receita['id_receita']; ?>">
            <div class="mb-3">
                <label>Valor</label>
                <input type="number" step="0.01" min="0.01" name="valor" value="<?php echo proteger_saida($receita['valor']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descrição</label>
                <input type="text" name="descricao" value="<?php echo proteger_saida($receita['descricao']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tipo</label>
                <select name="tipo" class="form-select" required>
                    <option value="Fixa" <?php echo $receita['tipo'] === 'Fixa' ? 'selected' : ''; ?>>Fixa</option>
                    <option value="Variavel" <?php echo $receita['tipo'] === 'Variavel' ? 'selected' : ''; ?>>Variável</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Categoria</label>
                <select name="id_categoria" class="form-select" required>
                    <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                        <option value="<?php echo (int) $cat['id_categoria']; ?>" <?php echo (int) $cat['id_categoria'] === (int) $receita['id_categoria'] ? 'selected' : ''; ?>>
                            <?php echo proteger_saida($cat['nome_categoria']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Data de Lançamento</label>
                <input type="date" name="data_lancamento" value="<?php echo proteger_saida($receita['data_lancamento']); ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Atualizar Receita</button>
        </form>
    </div>
</div>
</body>
</html>
