<?php

    session_start();

    /* 
        Si la sesión existe: session_started y el role es 2, es decir: Usuario Normal .
        Entonces podrá visualizar toda esta página. 
    */
    if(isset($_SESSION["session"]) && $_SESSION["role"] === "2") {

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página personal</title>


</head>
<body>
    <h1>Hola usuario normal <?php echo $_SESSION["name"]; ?></h1>
</body>
</html>


<?php

    } else {
        header("Location: /imove/");
    }
?>
