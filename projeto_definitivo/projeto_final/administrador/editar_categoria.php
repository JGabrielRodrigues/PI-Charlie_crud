<?php
session_start();

require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}


$categoria_id = $_GET['CATEGORIA_ID'];


$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA WHERE  CATEGORIA_ID = :categoria_id");
$stmt_categoria->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
$stmt_categoria->execute();
$categoria = $stmt_categoria->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>

<body>

    <a href="painel_admin.php"> <img src="../img/charlie-logo.png" alt="logo"></a>

    <form method="post" action="">



        <div class="container">

            <h2> Cadastrar Categoria</h2>

            <div class="cadastro">

                <input type="text" name="nome" id="nome" value="<?= $categoria['CATEGORIA_NOME'] ?>" required>
                <label for="CATEGORIA_NOME">Nome da categoria </label>
            </div>

            <div class="cadastro">

                <input type="text" name="descricao" id="descricao" value="<?= $categoria['CATEGORIA_DESC'] ?>" required>
                <label for="CATEGORIA_DESC">Descrição da categoria</label>
            </div>

            <div class="cadastro">


                <select name="CATEGORIA_ATIVO" id="CATEGORIA_ATIVO">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>



            </div>

            <input type="submit" value="Cadastrar" class="botao" >

            <span> <input class="botao" type="submit" value="lista CATEGORIAS" formaction="listar_categoria.php"></span>

            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $nome = $_POST['nome'];
                $descricao = $_POST['descricao'];
                $ativo = isset($_POST['ativo']) ? "\x01" : "\x00";

                try {
                    $stmt_update_categoria = $pdo->prepare("UPDATE CATEGORIA SET CATEGORIA_NOME = :nome, CATEGORIA_DESC = :descricao, CATEGORIA_ATIVO = :ativo WHERE CATEGORIA_ID = :categoria_id");
                    $stmt_update_categoria->bindParam(':nome', $nome);
                    $stmt_update_categoria->bindParam(':descricao', $descricao);
                    $stmt_update_categoria->bindParam(':ativo', $ativo);
                    $stmt_update_categoria->bindParam(':categoria_id', $categoria_id);
                    $stmt_update_categoria->execute();

                    echo "<p style='color:green;'>Categoria atualizado com sucesso!</p>";
                } catch (PDOException $e) {
                    echo "<p style='color:red;'>Erro ao atualizar administrador: " . $e->getMessage() . "</p>";
                }
            }


            ?>

</body>

</html>