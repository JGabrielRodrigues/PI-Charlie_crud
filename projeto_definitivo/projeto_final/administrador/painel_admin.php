<?php
session_start(); // Iniciar a sessão

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Painel ADM</title>
    <link rel="stylesheet" href="../css/painel_adm.css">
</head>

<body>

    <img src="../img/charlie-logo.png" alt="logo">

    <div class="container">

        <h2 class="text">Bem-vindo ADM</h2>

        <div class="produto">

            <a href="cadastrar_produto.php">cadastrar Produtos</a>
            <a href="listar_produtos.php">Listar Produtos</a>

        </div>

        <div class="adm">

            <a href="cadastrar_admin.php">Cadastrar ADM</a>

            <a href="listar_adm.php">Listar ADM</a>

        </div>

        <div class="categorias">

            <a href="cadastrar_categoria.php">Cadastrar categoria</a>

            <a href="listar_categoria.php">Listar categorias</a>

        </div>



    </div>
</body>

</html>