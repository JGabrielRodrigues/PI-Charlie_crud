<?php
session_start();
require_once('../config/conexao.php');


if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar categoria</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>

<body>

    <a href="painel_admin.php"> <img src="../img/charlie-logo.png" alt="logo"></a>

    <form method="post" action="">



        <div class="container">

            <h2> Cadastrar Categoria</h2>

            <div class="cadastro">

                <input type="text" name="CATEGORIA_NOME" id="CATEGORIA_NOME" required>
                <label for="CATEGORIA_NOME">Nome da categoria </label>
            </div>

            <div class="cadastro">

                <input type="text" name="CATEGORIA_DESC" id="CATEGORIA_DESC" required>
                <label for="CATEGORIA_DESC">Descrição da categoria</label>
            </div>

            <div class="cadastro">


                <select name="CATEGORIA_ATIVO" id="CATEGORIA_ATIVO">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>

            </div>

            <input class="botao" type="submit" value="Cadastrar">

           

            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $CATEGORIA_NOME = $_POST['CATEGORIA_NOME'];
            $CATEGORIA_DESC = $_POST['CATEGORIA_DESC'];
            $CATEGORIA_ATIVO = $_POST['CATEGORIA_ATIVO'];

            try {
            $sql = "INSERT INTO CATEGORIA (CATEGORIA_NOME, CATEGORIA_DESC, CATEGORIA_ATIVO) VALUES (:CATEGORIA_NOME, :CATEGORIA_DESC, :CATEGORIA_ATIVO)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':CATEGORIA_NOME', $CATEGORIA_NOME, PDO::PARAM_STR);
            $stmt->bindParam(':CATEGORIA_DESC', $CATEGORIA_DESC, PDO::PARAM_STR);
            $stmt->bindParam(':CATEGORIA_ATIVO', $CATEGORIA_ATIVO, PDO::PARAM_INT);
            $stmt->execute();

            echo "<p style='color:green;'>categoria cadastrada com sucesso!</p>";
            } catch (PDOException $erro) {
            echo "<div id='messagee'>Erro ao realizar o cadastro</div>" . $erro->getMessage() . "</p>";
            }
            }
            ?>


        </div>

    </form>


</body>

</html>