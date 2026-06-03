<?php
function proteger_saida($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function exigir_login(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit();
    }
}

function redirecionar(string $pagina): void
{
    header("Location: " . $pagina);
    exit();
}
?>
