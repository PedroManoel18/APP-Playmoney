<?php
include("conexao.php");

$id = $_GET['id'];

$query = mysqli_query(
$conn,
"SELECT * FROM receitas WHERE id_receita='$id'"
);

$receita = mysqli_fetch_assoc($query);

if(isset($_POST['atualizar'])){

    $valor = $_POST['valor'];
    $descricao = $_POST['descricao'];

    mysqli_query(
    $conn,
    "UPDATE receitas
     SET valor='$valor',
         descricao='$descricao'
     WHERE id_receita='$id'"
    );

    header("Location: listar_receitas.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container mt-5">

<h2>Editar Receita</h2>

<form method="POST"
      class="card p-4 shadow">

<input type="number"
       step="0.01"
       name="valor"
       value="<?php echo $receita['valor']; ?>"
       class="form-control mb-3">

<input type="text"
       name="descricao"
       value="<?php echo $receita['descricao']; ?>"
       class="form-control mb-3">

<button name="atualizar"
        class="btn btn-success">

Atualizar

</button>

</form>

</div>

</body>
</html>