<?php
    /**
     * Functions
     * @param $array
     * @return mixed
     */
    function utf8_converter($array) {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });
        return $array;
    }
    
    /**
     * @param $value
     * @return string
     */
    function toSqlInsetParameter($value) {
        return $value === NULL ? 'NULL' : "'" . addslashes(trim($value)) . "'";
    }
    
    /**
     * @param $string
     * @return string
     */
    function clearSpaceStrings($string) {
        return trim(preg_replace("/\s+/", " ", $string));
    }
    
    /**
     * @param $result
     * @param $conn
     * @param $sql
     * @param bool $onlyError
     */
    function showConnResult($result, $conn, $sql, $onlyError = false) {
        if ($onlyError) {
            if (!$result) {
                echo "<b>ERROR!!!</b> " . mysqli_error($conn) . "<br>";
            }
        } else {
            if (!$result) {
                echo "<b>ERROR!!!</b> " . mysqli_error($conn) . "<br>" . $sql . "<br>";
            } else {
                echo "Ok ->" . $sql . "<br>";
            }
        }
    }