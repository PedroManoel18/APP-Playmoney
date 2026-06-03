<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];

function soma_relatorio(mysqli $conn, string $tabela, int $id_usuario): float
{
    $sql = mysqli_prepare($conn, "SELECT COALESCE(SUM(valor), 0) AS total FROM {$tabela} WHERE id_usuario = ?");
    mysqli_stmt_bind_param($sql, "i", $id_usuario);
    mysqli_stmt_execute($sql);
    return (float) mysqli_fetch_assoc(mysqli_stmt_get_result($sql))['total'];
}

$totalReceitas = soma_relatorio($conn, 'receitas', $id_usuario);
$totalDespesas = soma_relatorio($conn, 'despesas', $id_usuario);
$saldo = $totalReceitas - $totalDespesas;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relatório Financeiro | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">📊 Relatório Financeiro</span>
        <div><a href="dashboard.php" class="btn btn-light">Dashboard</a></div>
    </div>
</nav>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="mb-4">Resumo Financeiro</h3>
            <div class="row g-3">
                <div class="col-md-4"><div class="card text-center border-success"><div class="card-body"><h5>Total Receitas</h5><h3 class="text-success">R$ <?php echo number_format($totalReceitas, 2, ',', '.'); ?></h3></div></div></div>
                <div class="col-md-4"><div class="card text-center border-danger"><div class="card-body"><h5>Total Despesas</h5><h3 class="text-danger">R$ <?php echo number_format($totalDespesas, 2, ',', '.'); ?></h3></div></div></div>
                <div class="col-md-4"><div class="card text-center border-primary"><div class="card-body"><h5>Saldo Atual</h5><h3 class="text-primary">R$ <?php echo number_format($saldo, 2, ',', '.'); ?></h3></div></div></div>
            </div>
            <div class="mt-4">
                <button onclick="window.print()" class="btn btn-primary">Imprimir Relatório</button>
                <a href="dashboard.php" class="btn btn-success">Voltar ao Dashboard</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
