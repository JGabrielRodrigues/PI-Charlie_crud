<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT ADMINISTRADOR.*, ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO, ADM_IMAGEM 
                           FROM ADMINISTRADOR ");
    $stmt->execute();
    $administrador = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar Adminstrador: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Listar Administradores</title>

    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- css da pagina -->
    <link rel="stylesheet" href="../css/listar_produtos.css">
</head>

<body>
    <h2 class=".">Listar Administradores</h2>
    <table class="table table-hover table-bordered border-dark">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>avatar</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Ativo</th>
                
                <th>Ações</th>
            </tr>
        </thead>
        <?php foreach ($administrador as $adm) : ?>
            <tr>
                <td>
                    <?php echo $adm['ADM_ID']; ?>
                </td>

                <td><img src="<?php echo $adm['ADM_IMAGEM']; ?>" alt="<?php echo "A imagem do Administrador " . $adm['ADM_NOME'] . " não pode ser carregada"; ?>" width="50"></td>
                
                <td>
                    <?php echo $adm['ADM_NOME']; ?>
                </td>
                <td>
                    <?php echo $adm['ADM_EMAIL']; ?>
                </td>
                <td>
                    <?php echo $adm['ADM_SENHA']; ?>
                </td>
                <td>
                    <?php echo ($adm['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?>
                </td>
                <td>
                <button><a href="editar_adm.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn">Editar</a></button>
                <button id="excluir" onclick="excluir(<?php echo $adm['ADM_ID']; ?>)" class="action-btn delete-btn">excluir</buttton>
                    </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p></p>
    <button class="action-btn"><a href="painel_admin.php" class="action-btn">Voltar ao Painel do
            Administrador</a></button>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function excluir() {
            alert("Função desabilitada!");
            var btn = document.getElementById('excluir');
        }
    </script>
</body>


</html>