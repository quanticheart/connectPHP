<?php
    include_once __DIR__ . '/../connUtils/configConnection.php';
    /**
     * @param $tableName
     * @param $class
     * @param $where
     * @param bool $showLog
     * @return bool|mysqli_result
     */
    function update($tableName, $class, $where, $showLog = false) {
        $conn = getConn();
        $data = "";
        $class_vars2 = get_object_vars($class);
        foreach ($class_vars2 as $key => $value) {
            if ($value !== NULL) {
                if ($data === "") {
                    $data = "$key = " . toSqlInsetParameter($value) . "";
                } else {
                    $data = "$data,$key = " . toSqlInsetParameter($value) . "";
                }
            }
        }
        $sql = "UPDATE " . $tableName . " SET " . $data . " WHERE " . $where . "";
        $result = $conn->query($sql);
        if ($showLog) {
            showConnResult($result, $conn, $sql);
        }
        return $result;
    }

    /**
     * @param $tableName
     * @param $class
     * @param $where
     * @param bool $showLog
     * @return bool|mysqli_result
     */
    function updateWithNull($tableName, $class, $where, $showLog = false) {
        $conn = getConn();
        $data = "";
        $class_vars2 = get_object_vars($class);
        foreach ($class_vars2 as $key => $value) {
            if ($data === "") {
                $data = "$key = " . toSqlInsetParameter($value) . "";
            } else {
                $data = "$data,$key = " . toSqlInsetParameter($value) . "";
            }
        }
        $sql = "UPDATE " . $tableName . " SET " . $data . " WHERE " . $where . "";
        $result = $conn->query($sql);
        if ($showLog) {
            showConnResult($result, $conn, $sql);
            echo $sql . "<br>";
        }
        return $result;
    }

