<?php
    include_once __DIR__ . "/../../config.php";
    /**
     * Conn
     */
    /**
     * @return array
     */
    
    /**
     * @return mysqli
     */
    function getConn() {
        $connData = getConnConfig();
        $conn = new mysqli($connData["host"], $connData["user"], $connData["pass"], $connData["dbName"]);
        $conn->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
        if ($conn->connect_error) {
            die("Error " . mysqli_error($conn));
        } else {
            return $conn;
        }
    }