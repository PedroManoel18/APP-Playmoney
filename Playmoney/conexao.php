<?php
$host = "localhost";
$user = "root";
$password = "23452345";
$database = "playmoney";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>