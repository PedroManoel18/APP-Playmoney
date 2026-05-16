<?php
session_start();
include("conexao.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

$stmt = mysqli_prepare($conn, "SELECT id,nome,senha FROM usuarios WHERE email=?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($usuario = mysqli_fetch_assoc($result)) {

    if (password_verify($senha, $usuario['senha'])) {

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];

        header("Location: dashboard.php");
        exit();
    }
}

echo "Login inválido! <br><a href='login.php'>Voltar</a>";
?>