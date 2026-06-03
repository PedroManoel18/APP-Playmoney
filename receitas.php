<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];

$sql = mysqli_prepare($conn, "SELECT id_categoria, nome_categoria FROM categorias WHERE id_usuario = ? AND tipo_categoria = 'Receita' ORDER BY nome_categoria");
mysqli_stmt_bind_param($sql, "i", $id_usuario);
mysqli_stmt_execute($sql);
$categorias = mysqli_stmt_get_result($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receitas | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-success">
    <div class="container">
        <span class="navbar-brand">💰 Receitas</span>
        <div>
            <a href="dashboard.php" class="btn btn-light">Dashboard</a>
            <a href="listar_receitas.php" class="btn btn-warning">Visualizar Receitas</a>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h3>Cadastrar Receita</h3>
            <form action="salvar_receita.php" method="POST">
                <input type="number" step="0.01" min="0.01" name="valor" placeholder="Valor" class="form-control mb-3" required>
                <input type="text" name="descricao" placeholder="Descrição" class="form-control mb-3" required>
                <select name="tipo" class="form-control mb-3" required>
                    <option value="Fixa">Fixa</option>
                    <option value="Variavel">Variável</option>
                </select>
                <select name="id_categoria" class="form-control mb-3" required>
                    <option value="">Selecione a Categoria</option>
                    <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                        <option value="<?php echo (int) $cat['id_categoria']; ?>">
                            <?php echo proteger_saida($cat['nome_categoria']); ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="date" name="data_lancamento" class="form-control mb-3" required>
                <button class="btn btn-success">Salvar Receita</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
