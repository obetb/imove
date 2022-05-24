<?php

    require_once "connection.php";

    class crudAdministrator extends Connection {


        public function getAllUsers() {
            
            $usuarios = array(); //Devolverá todo
            try {
                $sql = "SELECT * FROM user WHERE user_rol_fk = 2";
                $stament = $this -> connect() -> prepare($sql);
                $stament -> execute();
                return $stament;
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }

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
            $sql = "INSERT INTO user (name, email, password, user_rol_fk, user_status_fk) VALUES (:name, :email, :password, :role, :status);";

            $stament = $this -> connect() -> prepare($sql);

            $stament -> bindParam(":name", $name);
            $stament -> bindParam(":email", $email);
            $password = password_hash($password, PASSWORD_BCRYPT);
            $stament -> bindParam(":password", $password);
            $stament -> bindParam(":role", $role);
            $stament -> bindParam(":status", $status);
            
            $stament -> execute();
            $results = $stament -> rowCount();
                
            if($results > 0) {
                return true;
            }
            return false;
        }

        public function getUser($id) {
            $sql = "SELECT user.name as 'user_name', user.email as 'user_email', user.photo as 'user_photo', user.user_rol_fk as 'role', user.user_status_fk as 'status', user_rol.name as 'user_rol', user_status.name as 'user_status' FROM user INNER JOIN user_rol ON user.user_rol_fk = user_rol.idrol INNER JOIN user_status ON user.user_status_fk = user_status.idstatus WHERE user.iduser = :id";
            $stament = $this -> connect() -> prepare($sql);
            $stament -> bindParam(":id", $id);
            $stament -> execute();
            return $stament;
        }

        public function updateUser($id, $name, $email, $role, $status) { 
            $sql = "UPDATE user SET user.name = :name, user.email = :email, user.user_rol_fk = :role, user_status_fk = :status WHERE user.iduser = :id";
            $stament = $this -> connect() -> prepare($sql);

            $stament -> bindParam(":id", $id);
            $stament -> bindParam(":name", $name);
            $stament -> bindParam(":email", $email);
            $stament -> bindParam(":role", $role);
            $stament -> bindParam(":status", $status);
            
            $stament -> execute();
            $results = $stament -> rowCount();
                
            if($results > 0) {
                return true;
            } 
            return false;
        }

        public function deleteUser($id) {
            $sql = "DELETE FROM user WHERE user.iduser = :id";
            $stament = $this -> connect() -> prepare($sql);
            $stament -> bindParam(":id", $id);
            $stament -> execute();
            $results = $stament -> rowCount();

            if($results > 0) {
                return true;
            } else {
                return false;
            }
        }

    }
    
    

?>