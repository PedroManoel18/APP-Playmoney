<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];
$sql = mysqli_prepare($conn, "SELECT r.id_receita, r.valor, r.descricao, r.tipo, r.data_lancamento, c.nome_categoria FROM receitas r LEFT JOIN categorias c ON c.id_categoria = r.id_categoria AND c.id_usuario = r.id_usuario WHERE r.id_usuario = ? ORDER BY r.data_lancamento DESC");
mysqli_stmt_bind_param($sql, "i", $id_usuario);
mysqli_stmt_execute($sql);
$query = mysqli_stmt_get_result($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listar Receitas | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">💰 PlayMoney</a>
        <div>
            <a href="dashboard.php" class="btn btn-light">Dashboard</a>
            <a href="receitas.php" class="btn btn-warning">Nova Receita</a>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="mb-4">Receitas Cadastradas</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th><th>Categoria</th><th>Descrição</th><th>Tipo</th><th>Valor</th><th>Data</th><th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($receita = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo (int) $receita['id_receita']; ?></td>
                                <td><?php echo proteger_saida($receita['nome_categoria'] ?: 'Sem Categoria'); ?></td>
                                <td><?php echo proteger_saida($receita['descricao']); ?></td>
                                <td><?php echo proteger_saida($receita['tipo']); ?></td>
                                <td>R$ <?php echo number_format((float) $receita['valor'], 2, ',', '.'); ?></td>
                                <td>
                                    <?php echo !empty($receita['data_lancamento']) ? date('d/m/Y', strtotime($receita['data_lancamento'])) : '-'; ?>
                                </td>
                                <td>
                                    <a href="editar_receita.php?id=<?php echo (int) $receita['id_receita']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_receita.php?id=<?php echo (int) $receita['id_receita']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente excluir esta receita?');">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
