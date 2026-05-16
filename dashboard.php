<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
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
</head>
<body>

<nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
        <span class="navbar-brand">💰 PlayMoney</span>
        <a href="logout.php" class="btn btn-light">Sair</a>
    </div>
</nav>

<div class="container mt-5">
    <h2>Olá, <?php echo $_SESSION['nome']; ?> 👋</h2>
    <p class="text-muted">Seu painel financeiro</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card dashboard-card shadow">
                <div class="card-body">
                    <h5>Saldo Atual</h5>
                    <h3 class="text-success">R$ 2.500,00</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card shadow">
                <div class="card-body">
                    <h5>Receitas</h5>
                    <h3 class="text-primary">R$ 4.000,00</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card shadow">
                <div class="card-body">
                    <h5>Despesas</h5>
                    <h3 class="text-danger">R$ 1.500,00</h3>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>