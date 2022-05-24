<?php

    require_once "controller/templateController.php";

    $template = new templateController();

    /*
        Instancia del método plantilla, se llama a la plantilla principal.
    */
    $template -> mainTemplate();
?>