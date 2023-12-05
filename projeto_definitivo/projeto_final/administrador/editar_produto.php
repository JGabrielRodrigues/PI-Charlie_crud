<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$produto_id = $_GET['id'];


$stmt_produto = $pdo->prepare("SELECT * FROM PRODUTO p INNER JOIN PRODUTO_ESTOQUE e ON p.PRODUTO_ID = e.PRODUTO_ID WHERE p.PRODUTO_ID = :produto_id");
$stmt_produto->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
$stmt_produto->execute();
$produto = $stmt_produto->fetch(PDO::FETCH_ASSOC);


$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
$stmt_categoria->execute();
$categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);

$stmt_img = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id ORDER BY IMAGEM_ORDEM");
$stmt_img->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
$stmt_img->execute();
$imagens_existentes = $stmt_img->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/cadastro2.css">
</head>

<body>


    <form action="" method="post" enctype="multipart/form-data">


        <div class="container">

            <h2> EDITAR PRODUTO</h2>

            <div class="cadastro">


                <input class="item" type="text" name="nome" id="nome" value="<?= $produto['PRODUTO_NOME'] ?> " required>
                <label class="item" for="nome">Nome:</label>
            </div>

            <div class="cadastro">


                <input class="item" type="text" name="descricao" id="descricao" value=" <?= $produto['PRODUTO_DESC'] ?>" required>
                <label class="item" for="descricao">Descrição:</label>
            </div>

            <div class="cadastro">


                <input class="item" type="number" name="preco" id="preco" step="0.01" value="<?= $produto['PRODUTO_PRECO'] ?>" required>
                <label class="item" for="preco">Preço:</label>

            </div>

            <div class="cadastro">

                <input class="item" type="number" name="desconto" id="desconto" step="0.01" value="<?= $produto['PRODUTO_DESCONTO'] ?>" required>
                <label class="item" for="desconto">Desconto:</label>
            </div>


            <div class="cadastro">
                <input class="item" type="number" name="estoque" id="estoque" value="<?= $produto['PRODUTO_QTD'] ?>" required>
                <label class="item" for="estoque">estoque:</label>
            </div>

            <div class="cadastro">

                <select name="categoria_id" id="categoria_id" required>
                    <?php foreach ($categorias as $categoria) : ?>
                        <?php $selected = $produto['CATEGORIA_ID'] == $categoria['CATEGORIA_ID'] ? 'selected' : ''; ?>
                        <option value="<?= $categoria['CATEGORIA_ID'] ?>" <?= $selected ?>>
                            <?= $categoria['CATEGORIA_NOME'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>


                <lbel for="ativo">Ativo:</label>
                    <input type="checkbox" name="ativo" id="ativo" value="1" <?= $produto['PRODUTO_ATIVO'] ? 'checked' : '' ?> checked>


            </div>


            <div class="cadastro">

                <input type="text" name="nova_imagem_url" id="nova_imagem_url">
                <label for="nova_imagem_url">Nova URL de Imagem:</label>

            </div>

            <div class="cadastro">

                <?php foreach ($imagens_existentes as $imagem) : ?>

                    <input type="text" name="editar_imagem_url[<?= $imagem['IMAGEM_ID'] ?>]" value="<?= $imagem['IMAGEM_URL'] ?>">
                    <label>URL das Imagem:</label>

                <?php endforeach; ?>

            </div>

            <div class="cadastro">

                <input type="submit" value="atualizar" class="botao">
                <span> <input class="botao" type="submit" value="lista de produtos" formaction="listar_produtos.php"></span>

            </div>



            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Atualizando as URLs das imagens existentes.
                if (isset($_POST['editar_imagem_url'])) {
                    foreach ($_POST['editar_imagem_url'] as $imagem_id => $url_editada) {
                        $stmt_update = $pdo->prepare("UPDATE PRODUTO_IMAGEM SET IMAGEM_URL = :url WHERE IMAGEM_ID = :imagem_id");
                        $stmt_update->bindParam(':url', $url_editada, PDO::PARAM_STR);
                        $stmt_update->bindParam(':imagem_id', $imagem_id, PDO::PARAM_INT);
                        $stmt_update->execute();
                    }
                }

                // Adicionando nova imagem 
                if (isset($_POST['nova_imagem_url']) && !empty($_POST['nova_imagem_url'])) {
                    $nova_imagem_url = $_POST['nova_imagem_url'];
                    $imagem_ordem = 0;
                    $stmt_inserir_imagem = $pdo->prepare("INSERT INTO PRODUTO_IMAGEM (PRODUTO_ID, IMAGEM_URL, IMAGEM_ORDEM) VALUES (:produto_id, :imagem_url, :imagem_ordem)");
                    $stmt_inserir_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                    $stmt_inserir_imagem->bindParam(':imagem_url', $nova_imagem_url, PDO::PARAM_STR);
                    $stmt_inserir_imagem->bindParam(':imagem_ordem', $imagem_ordem, PDO::PARAM_INT);
                    $stmt_inserir_imagem->execute();
                }

                // Atualizando as informações do produto.
                $nome = $_POST['nome'];
                $descricao = $_POST['descricao'];
                $estoque = $_POST['estoque'];
                $preco = $_POST['preco'];
                $categoria_id = $_POST['categoria_id'];
                $ativo = isset($_POST['ativo']) ? "\x01" : "\x00";
                $desconto = $_POST['desconto'];

                try {
                    $stmt_update_produto = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, CATEGORIA_ID = :categoria_id, PRODUTO_ATIVO = :ativo, PRODUTO_DESCONTO = :desconto WHERE PRODUTO_ID = :produto_id");
                    $stmt_update_produto->bindParam(':nome', $nome);
                    $stmt_update_produto->bindParam(':descricao', $descricao);
                    $stmt_update_produto->bindParam(':preco', $preco);
                    $stmt_update_produto->bindParam(':categoria_id', $categoria_id);
                    $stmt_update_produto->bindParam(':ativo', $ativo);
                    $stmt_update_produto->bindParam(':desconto', $desconto);
                    $stmt_update_produto->bindParam(':produto_id', $produto_id);
                    $stmt_update_produto->execute();

                    $stmt_update_estoqueproduto = $pdo->prepare("UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :estoque WHERE PRODUTO_ID = :produto_id");
                    $stmt_update_estoqueproduto->bindParam(':estoque', $estoque, PDO::PARAM_INT);
                    $stmt_update_estoqueproduto->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                    $stmt_update_estoqueproduto->execute();

                    echo "<p style='color:green;'>Produto atualizado com sucesso!</p>";
                } catch (PDOException $e) {
                    echo "<p style='color:red;'>Erro ao atualizar produto: " . $e->getMessage() . "</p>";
                }
            }
            ?>

        </div>

    </form>

</body>

</html>