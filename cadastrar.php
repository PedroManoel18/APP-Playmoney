<?php
include("conexao.php");

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senhaDigitada = $_POST['senha'] ?? '';

if ($nome === '' || $email === '' || $senhaDigitada === '') {
    die("Preencha todos os campos.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("E-mail inválido.");
}

$senha = password_hash($senhaDigitada, PASSWORD_DEFAULT);

$sqlVerifica = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE email = ?");
mysqli_stmt_bind_param($sqlVerifica, "s", $email);
mysqli_stmt_execute($sqlVerifica);
$resultado = mysqli_stmt_get_result($sqlVerifica);

if (mysqli_num_rows($resultado) > 0) {
    echo "<script>alert('E-mail já cadastrado'); window.location='cadastro.php';</script>";
    exit();
}

$sql = mysqli_prepare($conn, "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($sql, "sss", $nome, $email, $senha);

if (mysqli_stmt_execute($sql)) {
    echo "<script>alert('Cadastro realizado com sucesso!'); window.location='login.php';</script>";
    exit();
}

die("Erro ao cadastrar usuário.");
?>
