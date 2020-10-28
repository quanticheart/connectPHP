<?php
    /**
     * @param $str
     */
    function logW($str) {
        logPhp('yellow', 'LogW', $str);
    }
    
    /**
     * @param $str
     */
    function logJson($str) {
        echo json_encode($str,true);
    }
    
    /**
     * @param $array_data
     */
    function logArray($array_data) {
        print("<pre>" . print_r($array_data, true) . "</pre>");
    }
    
    /**
     * @param $tag
     * @param $str
     */
    function logTagW($tag, $str) {
        logPhp('red', $tag, $str);
    }
    
    /**
     * @param $color
     * @param $tag
     * @param $msg
     */
    function logPhp($color, $tag, $msg) {
        echo "<p><b>" . $tag . " </b>: " . $msg . "</p><br>";
    }
    
    /**
     * @param $class
     */
    function logClass($class) {
        $class_vars2 = get_object_vars($class);
        $data = "";
        foreach ($class_vars2 as $key => $value) {
            if ($value !== NULL) {
                if ($data === "") {
                    $data = "$key => " . toSqlInsetParameter($value) . "";
                } else {
                    $data = "$data , $key => " . toSqlInsetParameter($value) . "";
                }
            }
        }
        logW($data);
    }