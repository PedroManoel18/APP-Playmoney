<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];

function buscar_total(mysqli $conn, string $sql, int $id_usuario): float
{
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return (float) mysqli_fetch_assoc($resultado)['total'];
}

$receitas = buscar_total($conn, "SELECT COALESCE(SUM(valor), 0) AS total FROM receitas WHERE id_usuario = ?", $id_usuario);
$despesas = buscar_total($conn, "SELECT COALESCE(SUM(valor), 0) AS total FROM despesas WHERE id_usuario = ?", $id_usuario);
$categorias = (int) buscar_total($conn, "SELECT COUNT(*) AS total FROM categorias WHERE id_usuario = ?", $id_usuario);
$saldo = $receitas - $despesas;

$labelsReceitas = [];
$dadosReceitas = [];
$sqlReceitasCategoria = mysqli_prepare($conn, "SELECT c.nome_categoria, COALESCE(SUM(r.valor), 0) AS total FROM receitas r INNER JOIN categorias c ON c.id_categoria = r.id_categoria AND c.id_usuario = r.id_usuario WHERE r.id_usuario = ? GROUP BY c.nome_categoria ORDER BY c.nome_categoria");
mysqli_stmt_bind_param($sqlReceitasCategoria, "i", $id_usuario);
mysqli_stmt_execute($sqlReceitasCategoria);
$resultReceitas = mysqli_stmt_get_result($sqlReceitasCategoria);
while ($linha = mysqli_fetch_assoc($resultReceitas)) {
    $labelsReceitas[] = $linha['nome_categoria'];
    $dadosReceitas[] = (float) $linha['total'];
}

$labelsDespesas = [];
$dadosDespesas = [];
$sqlDespesasCategoria = mysqli_prepare($conn, "SELECT c.nome_categoria, COALESCE(SUM(d.valor), 0) AS total FROM despesas d INNER JOIN categorias c ON c.id_categoria = d.id_categoria AND c.id_usuario = d.id_usuario WHERE d.id_usuario = ? GROUP BY c.nome_categoria ORDER BY c.nome_categoria");
mysqli_stmt_bind_param($sqlDespesasCategoria, "i", $id_usuario);
mysqli_stmt_execute($sqlDespesasCategoria);
$resultDespesas = mysqli_stmt_get_result($sqlDespesasCategoria);
while ($linha = mysqli_fetch_assoc($resultDespesas)) {
    $labelsDespesas[] = $linha['nome_categoria'];
    $dadosDespesas[] = (float) $linha['total'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">💰 PlayMoney</a>
        <div>
            <a href="receitas.php" class="btn btn-success me-2">Receitas</a>
            <a href="despesas.php" class="btn btn-danger me-2">Despesas</a>
            <a href="categoria.php" class="btn btn-info me-2">Categorias</a>
            <a href="relatorio.php" class="btn btn-warning me-2">Relatórios</a>
            <a href="logout.php" class="btn btn-dark">Sair</a>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h2 class="mb-4">Bem-vindo, <?php echo proteger_saida($_SESSION['nome']); ?></h2>
    <div class="row g-3">
        <div class="col-md-3"><div class="card dashboard-card text-center"><div class="card-body"><h5>Total Receitas</h5><h3 class="text-success">R$ <?php echo number_format($receitas, 2, ',', '.'); ?></h3></div></div></div>
        <div class="col-md-3"><div class="card dashboard-card text-center"><div class="card-body"><h5>Total Despesas</h5><h3 class="text-danger">R$ <?php echo number_format($despesas, 2, ',', '.'); ?></h3></div></div></div>
        <div class="col-md-3"><div class="card dashboard-card text-center"><div class="card-body"><h5>Saldo Atual</h5><h3 class="text-primary">R$ <?php echo number_format($saldo, 2, ',', '.'); ?></h3></div></div></div>
        <div class="col-md-3"><div class="card dashboard-card text-center"><div class="card-body"><h5>Categorias</h5><h3 class="text-info"><?php echo $categorias; ?></h3></div></div></div>
    </div>
    <div class="row mt-5 g-3">
        <div class="col-md-6"><div class="card shadow"><div class="card-body"><h4 class="text-center">Receitas por Categoria</h4><canvas id="graficoReceitas"></canvas></div></div></div>
        <div class="col-md-6"><div class="card shadow"><div class="card-body"><h4 class="text-center">Despesas por Categoria</h4><canvas id="graficoDespesas"></canvas></div></div></div>
    </div>
</div>
<script>
const categoriasReceitas = <?php echo json_encode($labelsReceitas, JSON_UNESCAPED_UNICODE); ?>;
const valoresReceitas = <?php echo json_encode($dadosReceitas); ?>;
new Chart(document.getElementById('graficoReceitas'), { type: 'pie', data: { labels: categoriasReceitas, datasets: [{ data: valoresReceitas }] } });

const categoriasDespesas = <?php echo json_encode($labelsDespesas, JSON_UNESCAPED_UNICODE); ?>;
const valoresDespesas = <?php echo json_encode($dadosDespesas); ?>;
new Chart(document.getElementById('graficoDespesas'), { type: 'doughnut', data: { labels: categoriasDespesas, datasets: [{ data: valoresDespesas }] } });
</script>
</body>
</html>
