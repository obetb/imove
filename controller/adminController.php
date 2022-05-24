<?php


    $option = (isset($_POST["option"])) ? $_POST["option"]: "";

    $id = (isset($_POST["id"])) ? $_POST["id"]: "";

    $name = (isset($_POST["name"])) ? $_POST["name"]: "";
    $email = (isset($_POST["email"])) ? $_POST["email"]: "";
    $password = (isset($_POST["password"])) ? $_POST["password"]: "";
    $role = (isset($_POST["role"])) ? intval($_POST["role"]): "";
    $status = (isset($_POST["status"])) ? intval($_POST["status"]): "";


    switch($option) {

        case "viewUsers":
            $users =  new crudAdministrator();
            $users = $users -> getAllUsers();
            $usersData = array();

            while ($result = $users -> fetch(PDO::FETCH_ASSOC)) {
    
                $usersRows = array();
                $usersRows["iduser"] = $result["iduser"];
                $usersRows["name"] = $result["name"];
                $usersRows["email"] = $result["email"];

                if($result["photo"] == "") {
                    $result["photo"] = "../assets/img/dog.jpeg";
                }

                $usersRows["photo"] = '<img src="'.$result["photo"].'" style="width:50px; height:50px;">';
                $usersRows["role"] = "Normal"; // $result["user_rol_fk"];

                if($result["user_status_fk"] == "1") {
                    $result["user_status_fk"] = "Activo";
                } 
                else if($result["user_status_fk"] == "2") {
                    $result["user_status_fk"] = "Inactivo";
                }
                $usersRows["status"] = $result["user_status_fk"];
                $usersRows["edit"] = '<button type="button" id="btnEdit" data-id="'.$result["iduser"].'" class="btn btn-warning btn-xs update">Actualizar</button>';
                $usersRows["delete"] = '<button type="button" id="btnDelete" data-id2="'.$result["iduser"].'" class="btn btn-danger btn-xs delete">Eliminar</button>';
                $usersData[] = $usersRows;
            }

            echo json_encode($usersData);
            exit();
            break;
        
        case "insertUser":

            $newUser = new crudAdministrator();

            if ($newUser -> checkIfUserExist($email)) {

                $message = "Este usuario existe";
                echo json_encode(array("status" => $message));
                exit();
            } 
            else {

                if ($newUser -> registerNewUser($name, $email, $password, $role, $status)) {
                    $message = "Usuario gregado correctamente";
                    echo json_encode(array("status" => $message));
                    exit();
                }
                else {
                    $message = "No se pudo agregar el usuario";
                    echo json_encode(array("status" => $message));
                    exit();
                }
                
            }
            
            break;

        case "getParticularUser":

            $getUser = new crudAdministrator();
            $getUser = $getUser -> getUser($id);

            if ($getUser) {
                echo json_encode($getUser -> fetch(PDO::FETCH_ASSOC));
                exit();
            }
            else {
                $message = "No se pudo encontrar informacion de este usuario";
                echo json_encode(array("status" => $message));
                exit();
            }

            break;

        case "updateUser":

            $updateUser = new crudAdministrator();
        
            if($updateUser -> updateUser($id, $name, $email, $role, $status)) {

                $message = "Usuario actualizado";
                echo json_encode(array("status" => $message));
                exit();

            } else {

                $message = "Usuario no actualizado";
                echo json_encode(array("status" => $message));
                exit();

            }

            break;

        case "deleteUser":
            
            $deleteUser = new crudAdministrator();

            if($deleteUser -> deleteUser($id)) {
                
                $message = "Se ha eliminado el usuario";
                echo json_encode(array("status" => $message));
                exit();

            } else {

                $message = "No se pudo eliminar";
                echo json_encode(array("status" => $message));
                exit();
                
            }

            break;
    }

?>