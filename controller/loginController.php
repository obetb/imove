<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["email"]) || empty($_POST["password"])) {

            $message = "Algunos campos estan vacios";
            echo json_encode(array("status" => $message));
            exit();

        } else {
            
            // $messages = "Los campos estan llenos";

            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = new Login();
            $results = $user -> getUser($email, $password);

            if (!$results) {

                $message = "No esta registrado";
                echo json_encode(array("status" => $message));
                exit();
                
            } else {

                $_SESSION["session"] = "session_started";
                $_SESSION["name"] = $results["name"];
                $_SESSION["email"] = $results["email"];
                $_SESSION["photo"] = $results["photo"];
                $_SESSION["role"] = $results["role"];
                $_SESSION["status"] = $results["status"];

                /* Se verifica que el usuario sin importar que sea administrador o normal tenga un
                   estadoa activo. */
                
                   if ($results["status"] === "1") {
                       // $message = "Usuario activo";

                       /* Si el usuario es un administrador */

                       if ($results["role"] == 1) {

                           $message = "Usuario administrador";
                           echo json_encode(array("status" => $message));
                           exit();

                        } 
                       
                       /* Si el usuario es normal */
                       
                       else if ($results["role"] == 2) {
                           
                           $message = "Usuario normal";
                           echo json_encode(array("status" => $message));
                           exit();

                        }
                       
                   } else if ($results["status"] === "2") {

                       $message = "Usuario inactivo";
                       echo json_encode(array("status" => $message));
                       exit();

                    }

                /*echo json_encode(
                    array(
                        "status" => "Usuario encontrado",
                        "name" => $results["name"],
                        "email" => $results["email"]
                        )
                    );
                exit();*/
            }
        }
    }

?>