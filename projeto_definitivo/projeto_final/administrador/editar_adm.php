<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$adm_id = $_GET['id'];

// Busca as informações do produto.
$stmt_adm = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :adm_id");
$stmt_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_adm->execute();
$produto = $stmt_adm->fetch(PDO::FETCH_ASSOC);

// Busca as imagens do produto.
$stmt_img = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :adm_id ");
$stmt_img->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_img->execute();
$imagens_existentes = $stmt_img->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>

<body>
   
    <form action="" method="post" enctype="multipart/form-data">

 

        <div class="container">

        <h2>Editar Administrador</h2>

            <div class="cadastro">

                <input type="text" name="nome" id="nome" value="<?= $produto['ADM_NOME'] ?>" required>
                <label for="nome">Nome:</label>
            </div>

            <div class="cadastro">

                <input type="email" name="email" id="email" value="<?= $produto['ADM_EMAIL'] ?>" required>
                <label for="descricao">Email:</label>
            </div>

            <div class="cadastro">

                <input type="text" name="senha" id="senha" value="<?= $produto['ADM_SENHA'] ?>" required>
                <label for="preco">Senha:</label>

            </div>

            <div class="cadastro">

                <input type="checkbox" name="ativo" id="ativo" value="1" <?= $produto['ADM_ATIVO'] ? 'checked' : '' ?>>
                <label for="ativo">Ativo</label>
            </div>




            <div class="cadastro">


                <?php
                foreach ($imagens_existentes as $imagem) {


                    echo '<input type="text" name="editar_imagem_url[' . $imagem['ADM_ID'] . ']" value="' . $imagem['ADM_IMAGEM'] . '">';
                    echo '<label>URL da Imagem:</label>';

                }
                ?>

            </div>

            <input type="submit" value="atualizar" class="botao">

            
        <input class="botao" type="submit" value="PAINEL ADM" formaction="painel_admin.php">
   

            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Atualizando as URLs das imagens.
                if (isset($_POST['editar_imagem_url'])) {
                    foreach ($_POST['editar_imagem_url'] as $imagem_id => $url_editada) {
                        $stmt_update = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_IMAGEM = :url WHERE ADM_ID = :imagem_id");
                        $stmt_update->bindParam(':url', $url_editada, PDO::PARAM_STR);
                        $stmt_update->bindParam(':imagem_id', $imagem_id, PDO::PARAM_STR);
                        $stmt_update->execute();
                    }
                }

                // Atualizando as informações do produto.
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $ativo = isset($_POST['ativo']) ? 1 : 0;


                try {
                    $stmt_update_produto = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ID = :adm_id, ADM_ATIVO = :ativo WHERE ADM_ID = :adm_id");
                    $stmt_update_produto->bindParam(':nome', $nome);
                    $stmt_update_produto->bindParam(':email', $email);
                    $stmt_update_produto->bindParam(':senha', $senha);
                    $stmt_update_produto->bindParam(':ativo', $ativo);
                    $stmt_update_produto->bindParam(':adm_id', $adm_id);
                    $stmt_update_produto->execute();

                    

                    echo "<p style='color:green;'>ADM atualizado com sucesso!</p>";
                } catch (PDOException $e) {
                    echo "<p style='color:red;'>Erro ao atualizar ADM: " . $e->getMessage() . "</p>";
                }
            }



            ?>

    </form>

</body>

</html>