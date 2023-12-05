<?php

session_start();

require_once('../config/conexao.php');


if (!isset($_SESSION['admin_logado'])) {

    header("Location:login.php");
    exit();
}

try {

    $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME, PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD FROM PRODUTO JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID");
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    echo "<p style='color:red;'>Erro ao listar produtos: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Listar Produtos</title>

    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- css da pagina -->
    <link rel="stylesheet" href="../css/listar_produto.css">

</head>

<body>
    <h2>Produtos Cadastrados</h2>
    <table class="table table-hover table-bordered border-dark">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Imagem</th>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Preço</th>
                <th scope="col">Categoria</th>
                <th scope="col">Ativo</th>
                <th scope="col">Desconto</th>
                <th scope="col">Estoque</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <?php foreach ($produtos as $produto) : ?>
            <tr>
                <td>
                    <?php echo $produto['PRODUTO_ID']; ?>
                </td>
                <td>
                    <img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" width="50">
                </td>
                </td>
                <td>
                    <?php echo $produto['PRODUTO_NOME']; ?>
                </td>
                <td>
                    <?php echo $produto['PRODUTO_DESC']; ?>
                </td>
                <td>
                    <?php echo $produto['PRODUTO_PRECO']; ?>
                </td>
                <td>
                    <?php echo $produto['CATEGORIA_NOME']; ?>
                </td>
                <td>
                    <?php echo ($produto['PRODUTO_ATIVO'] == 1 ? 'Sim' : 'Não'); ?>
                </td>
                <td>
                    <?php echo $produto['PRODUTO_DESCONTO']; ?>
                </td>
                <td>
                    <?php echo $produto['PRODUTO_QTD']; ?>
                </td>
                <td>
                    <button><a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn">Editar</a></button>
                    <button onclick="excluir(<?php echo $produto['PRODUTO_ID']; ?>)" class="action-btn delete-btn">excluir
                        </buttton>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form>
        <input class="botao" type="submit" value="PAINEL ADM" formaction="painel_admin.php">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function excluir() {
            alert("Função desabilitada!");
            var btn = document.getElementById('excluir');
        }
    </script>

</body>

</html>