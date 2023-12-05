<?php

session_start();


require_once('../config/conexao.php');


if (!isset($_SESSION['admin_logado'])) {

    header("Location:login.php");
    exit();
}


if (isset($_GET['update']) && $_GET['update'] === 'success') {
    echo "<div id='messagee'>Categoria atualizada com sucesso!</div>";
}

try {

    $stmt = $pdo->prepare("SELECT 
        CATEGORIA_ID,
        CATEGORIA_NOME,
        CATEGORIA_DESC,
        CATEGORIA_ATIVO 
        FROM CATEGORIA
    ");
    $stmt->execute();

    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {

    echo "Erro " . $erro->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar categoria</title>
    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- css da pagina -->
    <link rel="stylesheet" href="estilo_listarcategoria.css">
</head>

<body>


    <h2>lista categorias</h2>

    <table class="table table-hover table-bordered border-dark">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <?php foreach ($categorias as $categoria) : ?>
            <tr>
                <td>
                    <?php echo $categoria['CATEGORIA_ID']; ?>
                </td>
                <td>
                    <?php echo $categoria['CATEGORIA_NOME']; ?>
                </td>
                <td>
                    <?php echo $categoria['CATEGORIA_DESC']; ?>
                </td>
                <td>
                    <?php
                    echo ($categoria['CATEGORIA_ATIVO'] == 0) ? 'Inativo' : 'Ativo';
                    ?>
                </td>

                <td>
                    <button>
                        <a href="editar_categoria.php?CATEGORIA_ID=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn" data-toggle="tooltip" data-original-title="Edit user">
                            Editar
                        </a>
                    </button>
                    <br>
                    <button id="excluir" onclick="excluir(<?php echo $categoria['CATEGORIA_ID']; ?>)" class="action-btn delete-btn">excluir</buttton>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function excluir() {
            alert("Função desabilitada!");
            var btn = document.getElementById('excluir');
        }
    </script>

    <button>
        <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    </button>




</body>

</html>