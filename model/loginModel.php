<?php

    require_once "connection.php";

    class Login extends Connection {

        public function getUser($email, $password) {
            $sql = "SELECT * FROM user WHERE email = :email";

            $stament = $this -> connect() -> prepare($sql);
            $stament -> bindParam(":email", $email);
            $stament -> execute();

            $user = $stament -> fetch(PDO::FETCH_ASSOC);
            $results = $stament -> rowCount();

            if ($results > 0 && password_verify($password, $user["password"])) {
                return array(
                    "name" => $user["name"],
                    "email" => $user["email"],
                    "photo" => $user["photo"],
                    "role" => $user["user_rol_fk"],
                    "status" => $user["user_status_fk"]
                );
            }

            return null;
        }
    }

?>