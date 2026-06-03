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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow mt-5">
                <div class="card-body">
                    <h2 class="text-center">💰 PlayMoney</h2>
                    <form action="autenticar.php" method="POST">
                        <div class="mb-3">
                            <label>E-mail</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>
                        <button class="btn btn-primary w-100">Entrar</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="cadastro.php">Criar conta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
