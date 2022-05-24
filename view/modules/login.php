<?php

    session_start();
    require_once "../../model/connection.php";
    require_once "../../model/loginModel.php";
    require_once "../../controller/loginController.php";

    if(isset($_SESSION["session"])) {
        header("Location: /imove/");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia sesión</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

    <header>
        <nav class="nav">
            <div class="nav-container">
                <h1 class="nav-logo">Imove</h1>

                <label for="menu" class="nav-label">
                    <img src="../assets/img/menu.svg" class="nav-img" alt="Icono menú de navegación">
                </label>
                <input class="nav-input" type="checkbox" id="menu">

                <div class="nav-menu">
                    <a href="../../index.php" class="nav-item">Inicio</a>
                    <a href="signup.php" class="nav-item">Registrate</a>
                    <a href="#" class="nav-item">Sobre nosotros</a>
                </div>

            </div>
        </nav>
    </header>
    <div class="main">
        <div class="container">
            <div class="img-container">
                <img src="../assets/img/dog.jpeg" alt="Foto con perrito sonriente">
            </div>
            <div class="form-container">
                <h1>Inicia sesión</h1>
                <form action="login.php" method="POST" id="login-form">
                    <label for="email">Ingrese su correo electrónico</label>
                    <input type="email" name="email" id="email" placeholder="Ingrese su correo">

                    <label for="password">Ingrese su contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Ingrese su contraseña">

                    <input type="submit" name="login-btn" id="login-btn" value="Inicia sesión">
                </form>
            </div>
        </div>
    </div>

    <!-- Js - JQuery -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- My CUSTOM JS -->
    <script src="../assets/js/main.js"></script>
</body>
</html>