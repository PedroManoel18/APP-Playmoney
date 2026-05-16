<?php
include("conexao.php");

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = trim($_POST['senha']);

$stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE email=?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "E-mail já cadastrado! <br><a href='cadastro.html'>Voltar</a>";
    exit();
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO usuarios(nome,email,senha) VALUES(?,?,?)"
);

mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senhaHash);

if (mysqli_stmt_execute($stmt)) {
    $id = mysqli_insert_id($conn);
    echo "
    <h2>Cadastro realizado com sucesso!</h2>
    Código do usuário: <strong>$id</strong><br><br>
    <a href='login.php'>Ir para login</a>
    ";
} else {
    echo "Erro ao cadastrar. <br><a href='cadastro.html'>Voltar</a>";
}
?>