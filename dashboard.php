<?php
session_start();

include("conexao.php");

if (!isset($_SESSION['id'])) {

    header("Location: login.php");
    exit();

}

$id_usuario = $_SESSION['id'];

$nome = $_SESSION['nome'];


// TOTAL RECEITAS

$queryReceitas = mysqli_query(
$conn,
"SELECT SUM(valor) AS total_receitas
 FROM receitas
 WHERE id_usuario='$id_usuario'"
);

$receitas = mysqli_fetch_assoc($queryReceitas);

$totalReceitas = $receitas['total_receitas'];

if($totalReceitas == null){
    $totalReceitas = 0;
}


// TOTAL DESPESAS

$queryDespesas = mysqli_query(
$conn,
"SELECT SUM(valor) AS total_despesas
 FROM despesas
 WHERE id_usuario='$id_usuario'"
);

$despesas = mysqli_fetch_assoc($queryDespesas);

$totalDespesas = $despesas['total_despesas'];

if($totalDespesas == null){
    $totalDespesas = 0;
}


// SALDO

$saldo = $totalReceitas - $totalDespesas;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Dashboard | PlayMoney</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="css/style.css">

</head>

<body>

<nav class="navbar navbar-dark bg-success shadow">

<div class="container-fluid">

<span class="navbar-brand">
💰 PlayMoney
</span>

<div>

<a href="receitas.html"
   class="btn btn-light">

Receitas

</a>

<a href="despesas.html"
   class="btn btn-danger">

Despesas

</a>

<a href="logout.php"
   class="btn btn-dark">

Sair

</a>

</div>

</div>

</nav>


<div class="container mt-5">

<h2>
Olá, <?php echo $nome; ?> 👋
</h2>

<p class="text-muted">
Bem-vindo ao seu painel financeiro
</p>


<div class="row mt-4">

<!-- SALDO -->

<div class="col-md-4">

<div class="card dashboard-card shadow">

<div class="card-body">

<h5>Saldo Atual</h5>

<h3 class="text-success">

R$
<?php echo number_format($saldo,2,",","."); ?>

</h3>

</div>

</div>

</div>


<!-- RECEITAS -->

<div class="col-md-4">

<div class="card dashboard-card shadow">

<div class="card-body">

<h5>Total Receitas</h5>

<h3 class="text-primary">

R$
<?php echo number_format($totalReceitas,2,",","."); ?>

</h3>

</div>

</div>

</div>


<!-- DESPESAS -->

<div class="col-md-4">

<div class="card dashboard-card shadow">

<div class="card-body">

<h5>Total Despesas</h5>

<h3 class="text-danger">

R$
<?php echo number_format($totalDespesas,2,",","."); ?>

</h3>

</div>

</div>

</div>

</div>


<!-- RESUMO FINANCEIRO -->

<div class="card shadow mt-5 p-4">

<h4>Resumo Financeiro</h4>

<p>

O sistema PlayMoney está monitorando suas entradas e saídas financeiras.

</p>

<ul>

<li>
Receitas cadastradas:
<strong>
R$ <?php echo number_format($totalReceitas,2,",","."); ?>
</strong>
</li>

<li>
Despesas cadastradas:
<strong>
R$ <?php echo number_format($totalDespesas,2,",","."); ?>
</strong>
</li>

<li>
Saldo disponível:
<strong>
R$ <?php echo number_format($saldo,2,",","."); ?>
</strong>
</li>

</ul>

</div>

</div>

</body>
</html>