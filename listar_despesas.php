<?php
session_start();

include("conexao.php");

$id_usuario = $_SESSION['id'];

$query = mysqli_query(
$conn,
"SELECT * FROM despesas
 WHERE id_usuario='$id_usuario'"
);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Minhas Despesas | PlayMoney</title>

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="css/style.css">

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-dark bg-danger shadow">

<div class="container-fluid">

<span class="navbar-brand">
💸 PlayMoney
</span>

<div>

<a href="dashboard.php"
   class="btn btn-light">

Dashboard

</a>

<a href="despesas.html"
   class="btn btn-warning">

Nova Despesa

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

<h2>Minhas Despesas</h2>

<p class="text-muted">
Visualize e gerencie suas despesas cadastradas
</p>

<div class="card shadow p-4">

<table class="table table-bordered table-hover bg-white">

<tr class="table-danger">

<th>Valor</th>
<th>Descrição</th>
<th>Tipo</th>
<th>Vencimento</th>
<th>Ações</th>

</tr>

<?php while($despesa = mysqli_fetch_assoc($query)){ ?>

<tr>

<td>
R$ <?php echo number_format($despesa['valor'],2,",","."); ?>
</td>

<td>
<?php echo $despesa['descricao']; ?>
</td>

<td>
<?php echo $despesa['tipo']; ?>
</td>

<td>
<?php echo $despesa['data_vencimento']; ?>
</td>

<td>

<a href="editar_despesa.php?id=<?php echo $despesa['id_despesa']; ?>"
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

<a href="despesas.html"
   class="btn btn-danger">

Cadastrar Nova Despesa

</a>

<a href="dashboard.php"
   class="btn btn-primary">

Voltar ao Dashboard

</a>

</div>

</div>

</body>
</html>