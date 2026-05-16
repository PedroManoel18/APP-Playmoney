<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | PlayMoney</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card card-playmoney shadow-lg p-4">

        <div class="text-center mb-4">
            <h1 class="logo">💰 PlayMoney</h1>
            <p class="text-muted">Entre na sua conta</p>
        </div>

        <form action="autenticar.php" method="POST">
            <input type="email" name="email" class="form-control mb-3" placeholder="E-mail" required>
            <input type="password" name="senha" class="form-control mb-3" placeholder="Senha" required>

            <button class="btn btn-success w-100">Entrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="cadastro.html">Criar conta</a>
        </div>

    </div>
</div>

</body>
</html>