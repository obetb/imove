<?php

    class Connection {

        private $server;
        private $user;
        private $password;
        private $database;


        public function __construct($server = "localhost", $user = "root", $password = "", $database = "imove") {
            $this -> server = $server;
            $this -> user = $user;
            $this -> password = $password;
            $this -> database = $database;
        }


        public function connect() {
            try {
                $conn = new PDO("mysql:host=$this->server;dbname=$this->database;", $this->user, $this->password);

                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // echo "Conexión exitosa";
                return $conn;

            } catch(PDOException $e) {
                echo "Falla en la conexión: ".$e -> getMessage();
            }
        }
    }

    /*
    
    // Instanciamos la clase conexión para llemar a su método que muestre un mensaje para saber si 
    // se conectó a la base de datos o no.

    $c = new Connection();

    $c -> connect(); 
    */
?>