<?php
class DBCONNECT{
private $connection;

function connect() {
        include_once dirname(__FILE__) . '/CONFIG.php';

        // Connecting to mysql database
        $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD,DB_NAME);

        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            //since this is script so we need to exit it...
            exit;
        }else{
        //echo "Successfull";
        }

        // returing connection resource
        return $this->connection;
    }

}


?>
