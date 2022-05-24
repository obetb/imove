<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])) {
            
            $message = "Algunos campos estan vacios";
            echo json_encode(array("status" => $message));
            exit();

        } else {

            // $message = "Los campos estan llenos";

            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $role = 2; // "Rol número 2: Usuario normal"
            $status = 1; // "Estado número 1: Usuario activo"
            
            $user = new Signup();

            if ($user -> checkIfUserExist($email)) {
                $message = "Existe en nuestra base de datos";
                echo json_encode(array("status" => $message));
                exit();

            } else {
                // $message = "No existe en nuestra base de datos";

                $user -> registerNewUser($name, $email, $password, $role, $status);

                $message = "Registro exitoso";
                echo json_encode(array("status" => $message));
                exit();
            }
        }
    }

?>