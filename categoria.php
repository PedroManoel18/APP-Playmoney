<?php
require_once("funcoes.php");
exigir_login();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Categorias | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">💰 PlayMoney</a>
        <div>
            <a href="dashboard.php" class="btn btn-light me-2">Dashboard</a>
            <a href="listar_categorias.php" class="btn btn-warning">Listar Categorias</a>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4">Cadastrar Categoria</h3>
                    <form action="salvar_categoria.php" method="POST">
                        <input type="text" name="nome_categoria" placeholder="Nome da Categoria" class="form-control mb-3" required>
                        <select name="tipo_categoria" class="form-select mb-3" required>
                            <option value="Receita">Receita</option>
                            <option value="Despesa">Despesa</option>
                        </select>
                        <button type="submit" class="btn btn-success w-100">Salvar Categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
