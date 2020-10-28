<?php
    include_once __DIR__ . '/../connUtils/configConnection.php';
    /**
     * Connections Functions
     * @param $tableName
     * @param $class
     * @param bool $showLog
     * @param bool $logOnlyError
     * @return bool|mysqli_result
     */
    function insert($tableName, $class, $showLog = false, $logOnlyError = false) {
        $conn = getConn();
        $dataKey = "";
        $dataValues = "";
        $class_vars2 = get_object_vars($class);
        foreach ($class_vars2 as $key => $value) {
            if ($dataKey === "") {
                $dataKey = "`" . trim($key) . "`";
                $dataValues = toSqlInsetParameter($value);
            } else {
                $dataKey = "$dataKey, `" . trim($key) . "`";
                $dataValues = "$dataValues, " . toSqlInsetParameter($value) . "";
            }
        }
        $sql = "INSERT INTO " . $tableName . " (" . $dataKey . ") VALUES (" . $dataValues . ")";
        $result = $conn->query($sql);
        if ($showLog) {
            showConnResult($result, $conn, $sql, $logOnlyError);
        }
        return $result;
    }
