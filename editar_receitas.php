<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
header("Location: editar_receita.php?id=" . $id);
exit();
?>
