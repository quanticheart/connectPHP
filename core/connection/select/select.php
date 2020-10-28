<?php
    include_once __DIR__ . '/../connUtils/configConnection.php';
    
    /**
     * @param $tableName
     * @param $columnName
     * @param null $class
     * @return array
     */
    function selectRowDuplicates($tableName, $columnName, $class = null) {
        $conn = getConn();
        $sql = "SELECT * FROM
        " . $tableName . "
        GROUP BY  " . $columnName . "
        HAVING COUNT( " . $columnName . ") > 1";
        $result = $conn->query($sql);
        $json = mysqli_fetch_array($result);
        return convertArrayToModel($tableName, $json, $class);
    }
    
    /**
     * @param $tableName
     * @param null $class
     * @return array
     */
    function select($tableName, $class = null) {
        $conn = getConn();
        $sql = "SELECT * FROM " . $tableName;
        $json = $conn->query($sql);
        return convertArrayToModel($tableName, $json, $class);
    }
    
    /**
     * @param $tableName
     * @param null $case
     * @param null $class
     * @return array
     */
    function selectCase($tableName, $case = null, $class = null) {
        $caseWrite = $case !== null ? $case : "";
        $conn = getConn();
        $sql = "SELECT * " . $caseWrite . " FROM " . $tableName;
        $json = $conn->query($sql);
        return convertArrayToModel($tableName, $json, $class);
    }
    
    /**
     * @param $tableName
     * @param $where
     * @param null $class
     * @return array
     */
    function selectWhere($tableName, $where, $class = null) {
        $conn = getConn();
        $sql = "SELECT * FROM " . $tableName . " WHERE " . $where;
        $json = $conn->query($sql);
        return convertArrayToModel($tableName, $json, $class);
    }
    
    /**
     * @param $tableName
     * @param $where
     * @param null $class
     * @return mixed|null
     */
    function selectRow($tableName, $where, $class = null) {
        $conn = getConn();
        $sql = "SELECT * FROM " . $tableName . " WHERE " . $where;
        $result = $conn->query($sql);
        $array = mysqli_fetch_assoc($result);
        if ($array) {
            return convertObjectToModel($tableName, $array, $class);
        } else {
            return null;
        }
    }
