<?php
require_once("funcoes.php");
require_once("conexao.php");
exigir_login();

$id_usuario = (int) $_SESSION['id'];
$sql = mysqli_prepare($conn, "SELECT id_categoria, nome_categoria, tipo_categoria FROM categorias WHERE id_usuario = ? ORDER BY nome_categoria");
mysqli_stmt_bind_param($sql, "i", $id_usuario);
mysqli_stmt_execute($sql);
$query = mysqli_stmt_get_result($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listar Categorias | PlayMoney</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Categorias</h2>
    <a href="dashboard.php" class="btn btn-primary mb-3">Dashboard</a>
    <a href="categoria.php" class="btn btn-success mb-3">Nova Categoria</a>
    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cat = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo (int) $cat['id_categoria']; ?></td>
                            <td><?php echo proteger_saida($cat['nome_categoria']); ?></td>
                            <td><?php echo proteger_saida($cat['tipo_categoria']); ?></td>
                            <td>
                                <a href="editar_categoria.php?id=<?php echo (int) $cat['id_categoria']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="excluir_categoria.php?id=<?php echo (int) $cat['id_categoria']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente excluir esta categoria?');">Excluir</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
