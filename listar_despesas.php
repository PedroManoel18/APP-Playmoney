<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];
$sql = mysqli_prepare($conn, "SELECT d.id_despesa, d.valor, d.descricao, d.tipo, d.data_vencimento, c.nome_categoria FROM despesas d LEFT JOIN categorias c ON c.id_categoria = d.id_categoria AND c.id_usuario = d.id_usuario WHERE d.id_usuario = ? ORDER BY d.data_vencimento DESC");
mysqli_stmt_bind_param($sql, "i", $id_usuario);
mysqli_stmt_execute($sql);
$query = mysqli_stmt_get_result($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listar Despesas | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">💰 PlayMoney</a>
        <div>
            <a href="dashboard.php" class="btn btn-light">Dashboard</a>
            <a href="despesas.php" class="btn btn-warning">Nova Despesa</a>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="mb-4">Despesas Cadastradas</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th><th>Categoria</th><th>Descrição</th><th>Tipo</th><th>Valor</th><th>Vencimento</th><th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($despesa = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo (int) $despesa['id_despesa']; ?></td>
                                <td><?php echo proteger_saida($despesa['nome_categoria'] ?: 'Sem Categoria'); ?></td>
                                <td><?php echo proteger_saida($despesa['descricao']); ?></td>
                                <td><?php echo proteger_saida($despesa['tipo']); ?></td>
                                <td>R$ <?php echo number_format((float) $despesa['valor'], 2, ',', '.'); ?></td>
                                <td><?php echo !empty($despesa['data_vencimento']) ? date('d/m/Y', strtotime($despesa['data_vencimento'])) : '-'; ?></td>
                                <td>
                                    <a href="editar_despesa.php?id=<?php echo (int) $despesa['id_despesa']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_despesa.php?id=<?php echo (int) $despesa['id_despesa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente excluir esta despesa?');">Excluir</a>
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
