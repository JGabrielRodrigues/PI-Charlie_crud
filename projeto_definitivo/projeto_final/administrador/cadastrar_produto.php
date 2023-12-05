<?php

session_start();


require_once('../config/conexao.php');


try {
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    echo "<div id='messagee'>Erro ao buscar categoria " . $erro->getMessage() . "</div>";
}



?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtoss</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    <script>
        function adicionarImagem() {
            const containerImagens = document.getElementById('containerImagens');
            const novoInput = document.createElement('input');
            novoInput.type = 'text';
            novoInput.name = 'imagem_url[]';
            containerImagens.appendChild(novoInput);
        }
    </script>
</head>

<body>
    <p>
        <button><a href="painel_admin.php">Voltar ao Painel do Administrador</a></button>

    <form action="" method="post" enctype="multipart/form-data">

        <div class="container">

            <h2> CADASTRAR PRODUTO</h2>

            <div class="cadastro">


                <input type="text" name="nome" id="nome" required>
                <label for="nome">Nome:</label>
            </div>

            <div class="cadastro">


                <input type="text" name="descricao" id="descricao" required>
                <label for="descricao">Descrição:</label>
            </div>

            <div class="cadastro">


                <input type="number" name="preco" id="preco" step="0.01" required>
                <label for="preco">Preço:</label>

            </div>

            <div class="cadastro">

                <input type="number" name="desconto" id="desconto" step="0.01" required>
                <label for="desconto">Desconto:</label>
            </div>


            <div class="cadastro">

                <input type="number" name="quantidade" id="quantidade" required>
                <label for="quantidade">estoque:</label>
            </div>

            <div class="cadastro">

                <select name="categoria_id" id="categoria_id" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['CATEGORIA_ID'] ?>">
                            <?= $categoria['CATEGORIA_NOME'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>


                <lbel for="ativo">Ativo:</label>
                    <input type="checkbox" name="ativo" id="ativo" value="1" checked>


            </div>

            <div class="cadastro">

                <input type="text" name="imagem_url[]" required>

                <button type="button" onclick="adicionarImagem()">Adicionar mais imagens</button>
                <label for="imagem">Imagem URL:</label>
            </div>

            <div class="cadastro">
                <input type="submit" value="cadastrar" class="botao">
            </div>

            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $nome = $_POST['nome'];
                $descricao = $_POST['descricao'];
                $preco = $_POST['preco'];
                $quantidade = $_POST['quantidade'];
                $desconto = $_POST['desconto'];
                $categoria_id = $_POST['categoria_id'];
                $status = $_POST['ativo'];
                $imagens = isset($_POST['imagem_url']) ? $_POST['imagem_url'] : [];

                try {
                    $sql_produto = "INSERT INTO PRODUTO( PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO,CATEGORIA_ID,PRODUTO_ATIVO
            ) VALUES (
                :nome,
                :descricao, 
                :preco, 
                :desconto, 
                :categoria_id,
                :ativo
            )";


                    $stmt_produto = $pdo->prepare($sql_produto);
                    $stmt_produto->bindParam(':nome', $nome, PDO::PARAM_STR);
                    $stmt_produto->bindParam(':descricao', $descricao, PDO::PARAM_STR);
                    $stmt_produto->bindParam(':preco', $preco, PDO::PARAM_INT);
                    $stmt_produto->bindParam(':desconto', $desconto, PDO::PARAM_STR);
                    $stmt_produto->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
                    $stmt_produto->bindParam(':ativo', $status, PDO::PARAM_INT);
                    $stmt_produto->execute();


                    $produto_id = $pdo->lastInsertId();




                    if (!empty($imagens)) {
                        foreach ($imagens as $ordem => $url_imagem) {
                        }
                    }


                    $sql_estoque = "INSERT INTO PRODUTO_ESTOQUE 
            (
                PRODUTO_ID,
                PRODUTO_QTD
            ) VALUES (
                :produto_id,
                :quantidade
            )";

                    $stmt_estoque = $pdo->prepare($sql_estoque);
                    $stmt_estoque->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                    $stmt_estoque->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
                    $stmt_estoque->execute();

                    echo "<p style='color:green;'>Produto cadastrado com sucesso!</p>";
                } catch (PDOException $e) {
                    echo "<p style='color:red;'>Erro ao cadastrar produto: " . $e->getMessage() . "</p>";
                }
            }






            ?>

        </div>

    </form>
</body>

</html>