<?php

    require_once "connection.php";

    class Signup extends Connection {

        public function checkIfUserExist($email) {
            $sql = "SELECT email FROM user WHERE email = :email";
            $stament = $this -> connect() -> prepare($sql);
            $stament -> bindParam(":email", $email, PDO::PARAM_STR);
            $stament -> execute();
            $results = $stament -> rowCount();
            
            if($results > 0) {
                return true;
            }
            return false;
        }

        public function registerNewUser($name, $email, $password, $role, $status) {
            $sql = "INSERT INTO user (name, email, password, user_rol_fk, user_status_fk) VALUES (:name, :email, :password, :role, :status)";
            
            $stament = $this -> connect() -> prepare($sql);

            $stament -> bindParam(":name", $name);
            $stament -> bindParam(":email", $email);
            $password = password_hash($password, PASSWORD_BCRYPT);
            $stament -> bindParam(":password", $password);
            $stament -> bindParam(":role", $role);
            $stament -> bindParam(":status", $status);

            $stament -> execute();
            $result = $stament -> rowCount();

            if($result > 0) {
                return true;
            }
            
            return false;
        }
    }
    
?>