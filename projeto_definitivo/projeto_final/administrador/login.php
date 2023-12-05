<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login ADM</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>

            <img src="../img/charlie-logo.png" alt="logo">

      
    
    <form action="processa_login.php" method="post" class="formu">


        <div class="container">
          <h2 class="text">Login ADM</h2> 

           

            <div class="caixa-login">

                <input type="text" name="nome" id="nome" required>
                <label for="nome">usuario</label>

            </div>

            <div  class="caixa-login">

                <input type="password" name="senha" id="senha" required>
                <label for="senha">Senha</label>
                
            </div>

            <input type="submit" value="Entrar" class="botao">
         <?php
         if (isset($_GET['erro'])) {
            echo '<p style="color:red;">Nome de usuario ou senha incorretos!</p>';
         }
         ?>

        </div>

    </form>

</body>

</html>