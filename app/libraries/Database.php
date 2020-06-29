<?php
    /*
    * PDO Database Class
    * Connect to Database
    * Create Prepared Statement
    * Bind Values 
    * Return rows and results
    */

    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh;
        private $stmt;
        private $error;

        public function __construct(){
            // Set DSN
            $dsn = 'mysql:host='. $this->host . ';dbname=' . $this->dbname;
            $options= array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            // Create PDO Instance
            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            }catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        // Prepare statement with Query
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        public function bind($params, $value, $type = null){
            if(is_null($type)){
                switch(true){
                case  is_int($value):
                    $type = PDO:: PARAM_INT;
                    break;

                case  is_bool($value):
                    $type = PDO:: PARAM_BOOL;
                    break;

                case  is_null($value):
                    $type = PDO:: PARAM_NULL;
                    break;
                default:
                    $type = PDO:: PARAM_STR;
                }
            }

            $this->stmt->bindValue($params, $value, $type);
        }
        // Execute the prepare Statement
        public function execute(){
           return $this->stmt->execute();
        }

        // Get Result Set as arrays of Object
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        // Get Single Record as Object
        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Get Row Count
        public function rowCount(){
            return $this->stmt->rowCount();
        }

    }
?>