<?php
session_start();

include("conexao.php");

$id_usuario = $_SESSION['id'];

$query = mysqli_query(
$conn,
"SELECT * FROM receitas
 WHERE id_usuario='$id_usuario'"
);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Minhas Receitas | PlayMoney</title>

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="css/style.css">

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-dark bg-success shadow">

<div class="container-fluid">

<span class="navbar-brand">
💰 PlayMoney
</span>

<div>

<a href="dashboard.php"
   class="btn btn-light">

Dashboard

</a>

<a href="receitas.html"
   class="btn btn-warning">

Nova Receita

</a>

<a href="logout.php"
   class="btn btn-dark">

Sair

</a>

</div>

</div>

</nav>


<!-- CONTEÚDO -->

<div class="container mt-5">

<h2>Minhas Receitas</h2>

<p class="text-muted">
Visualize e gerencie suas receitas cadastradas
</p>

<div class="card shadow p-4">

<table class="table table-bordered table-hover bg-white">

<tr class="table-success">

<th>Valor</th>
<th>Descrição</th>
<th>Tipo</th>
<th>Data</th>
<th>Ações</th>

</tr>

<?php while($receita = mysqli_fetch_assoc($query)){ ?>

<tr>

<td>
R$ <?php echo number_format($receita['valor'],2,",","."); ?>
</td>

<td>
<?php echo $receita['descricao']; ?>
</td>

<td>
<?php echo $receita['tipo']; ?>
</td>

<td>
<?php echo $receita['data_lancamento']; ?>
</td>

<td>

<a href="editar_receitas.php?id=<?php echo $receita['id_receita']; ?>"
   class="btn btn-primary btn-sm">

Editar

</a>

</td>

</tr>

<?php } ?>

</table>

</div>


<!-- BOTÕES -->

<div class="d-flex gap-2 mt-4">

<a href="receitas.html"
   class="btn btn-success">

Cadastrar Nova Receita

</a>

<a href="dashboard.php"
   class="btn btn-primary">

Voltar ao Dashboard

</a>

</div>

</div>

</body>
</html>