<?php  

    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial</title>
</head>
<body>
   
    <?php
        if(!isset($_SESSION["session"])):
    ?>

    <h1>Aquí va todo el diseño principal</h1> 
    <div class="container">
        <a href="view/modules/login.php">Inicia sesión</a>
        <br>
        <a href="view/modules/signup.php">Registrate</a>
    </div>
    <?php
        else:
    ?>
    <h3>¿Quieres salir?</h3>
    <a href="controller/logoutController.php">Cerrar mi sesión</a>
    <?php
        endif;
    ?>
</body>
</html>