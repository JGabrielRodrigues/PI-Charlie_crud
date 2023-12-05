<?php
session_start();

if(isset($_SESSION['mensagem'])){
    echo '<div class="mensagem">' . $_SESSION['mensagem'] . '</div>';
    unset($_SESSION['mensagem']);
}
$_SESSION['mensagem'] = 'Esta é uma mensagem de exemplo.';
?>
/*
if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}




require_once('../administrador/conexao.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM ADMINISTRADOR WHERE ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Administradir excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir o administrador. Tente novamente.";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
    echo "não é possivel excluir administrador no momento!";
}
?>
*/
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Excluir Administrador</title>
    <link rel="stylesheet" href="./estilo_excluir.css">
</head>
<body>
<h2 class="text">Excluir Produto</h2>
<p class="text"><?php echo $mensagem; ?></p>
<button>
    <a href="listar_adm.php">Voltar à Lista de administadores</a>
</button>

</body>
</html>
/*