<?php
    include_once __DIR__ . '/../connUtils/configConnection.php';
    /**
     * @param $tableName
     * @param $where
     * @param bool $showLog
     * @param bool $logOnlyError
     * @return bool|mysqli_result
     */
    function delete($tableName, $where, $showLog = false, $logOnlyError = false) {
        $conn = getConn();
        $sql = "DELETE FROM " . $tableName . " WHERE " . $where;
        
        $result = $conn->query($sql);
        if ($showLog) {
            showConnResult($result, $conn, $sql, $logOnlyError);
        }
        
        return $result;
    }
