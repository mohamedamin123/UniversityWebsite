<?php
    class mySql {
        private const _serveur = "localhost";
        private const _dbb = "university";
        private const _login = "root";
        private const _mdp = "";
        private $_cnx;

        function __construct() {
            try {
                $this->_cnx = new PDO("mysql:host=".self::_serveur.";dbname=".self::_dbb, self::_login, self::_mdp);
                
            } catch (PDOException $e) {
                echo '<br/>Echec lors de la connexion: '.$e->getMessage();
                // return false;
            }

            // return true;
        }

        function __destruct() {
            $this->_cnx = null;
        }

        /** 
         * RETURN VALUES:
         * 
         * @param return false, checks if query worked and returns true.
         * @param return 0, checks if there are any elements and returns true/false.
         * @param return 1, return first element.
         * @param return 2, return all elements.
         * @param return 3, return last inserted id.
         * 
         * ALL PARAMETERS
         * */
        public function request($query, $array, $return = false) {
            
            // The prepare function sends a query to the database once and readies itself for user input. You only have to send the variables to it which reduces the brandwidth required.
            $prep = $this->_cnx->prepare($query);

            // Sends the variables to the prepared statement and returns TRUE if statement is logical (valid) - FALSE if not.
            $result = $prep->execute($array);

            if (!$result) {

                die("Statement Error (query: ".$query.", ".var_dump($array).") because ". print_r($this->_cnx->errorInfo(),true)); 
                return false; 
            }

            if ($return === false) { // DEFAULT: just checking if query worked
                return true;
            } else if ($return == 0) { // checks if there are any elements
                return $prep->rowCount() > 0;
            } else if ($return == 1) { // fetch first element (for SELECT)
                return $prep->rowCount() > 0? $prep->fetch() : array();
            } else if ($return == 2) { // fetch all elements (for SELECT)
                return $prep->rowCount() > 0? $prep->fetchAll() : array();
            } else if ($return == 3) { // get last inserted ID (FOR INSERT)
                return $this->_cnx->lastInsertId();
            }

            /* Query EXAMPLE:
                $this->request(
                    "INSERT INTO stars(art_id, acc_id, stars) VALUES (:art_id, :user_id, :stars)",
                    array(
                        ':art_id' => $art_id,
                        ':user_id' => $user_id,
                        ':stars' => $stars
                    ),
                    3 // returns newly inserted ID
                ); 
            */
        }

        // public abstract function insert($class);
        // public abstract function update($class);
    }

?>