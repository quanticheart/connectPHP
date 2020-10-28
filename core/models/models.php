<?php
    include_once __DIR__ . '/../connection/config/connConfig.php';
    include_once __DIR__ . '/../utils/utils.php';
    include_once __DIR__ . '/modelsUtils.php';
    
    /**
     * this functions update all models from your database
     */
    function generateTableModels() {
        $config = getConnConfig();
        $conn = getConn();
        $sql = "SHOW TABLES FROM " . $config["dbName"];
        $result = $conn->query($sql);
        
        if (!$result) {
            echo "DB Error, could not list tables\n";
            echo 'MySQL Error: ' . mysqli_error($conn);
            exit;
        }
        
        while ($row = mysqli_fetch_row($result)) {
            $tableName = $row[0];
            createModelFromTable($tableName, true);
        }
        
        mysqli_free_result($result);
    }
    
    /**
     * this functions return columns names and types from your database
     * @param $tableName
     * @return array
     */
    function getColumnsFromTable($tableName) {
        $conn = getConn();
        $sql = "SHOW COLUMNS FROM " . $tableName;
        $result2 = $conn->query($sql);
        
        $return = Array();
        $columns = Array();
        $columnsTypes = Array();
        
        if (mysqli_num_rows($result2) > 0) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $columns[] = $row['Field'];
                $columnsTypes[] = $row['Type'];
            }
        }
        
        $return[0] = $columns;
        $return[1] = $columnsTypes;
        
        return $return;
    }
    
    /**
     * this function create one model from specific table
     * @param $tableName
     * @param bool $showLog
     */
    function createModelFromTable($tableName, $showLog = false) {
        
        /**
         * Verify table's columns list
         */
        $result = getColumnsFromTable($tableName);
        
        /**
         * Create File In Classes Folder
         */
        $filename = __DIR__ . "/classes/" . capTag($tableName) . "Model.php";
        $fp = fopen($filename, 'w') or die("Unable to open file! ");
        
        $columns = $result[0];
        $columnsTypes = $result[1];
        
        createConstants($tableName);
        
        /**
         * write file
         */
        fwrite($fp, '<?php ' . "\n\n");
        fwrite($fp, '    class ' . capTag($tableName) . 'Model {' . "\n");
        foreach ($columns as $key => $data) {
            fwrite($fp, '        public $' . $data . '; ' . "\n");
        }
        fwrite($fp, '' . "\n");
        foreach ($columns as $key => $data) {
            fwrite($fp, '        public function get' . capTag($data) . '() {' . "\n");
            fwrite($fp, '           return $this->' . $data . '; ' . "\n");
            fwrite($fp, '        }' . "\n\n");
            fwrite($fp, '        public function set' . capTag($data) . '($' . $data . ') {' . "\n");
            fwrite($fp, '           $this->' . $data . ' = $' . $data . ';' . "\n");
            fwrite($fp, '        }' . "\n\n");
        }
        fwrite($fp, '    }');
        fclose($fp);
        
        if ($showLog) {
            echo "End Create $tableName Model Class</br>";
        }
    }
    
    /**
     * @param $tableName
     */
    function createConstants($tableName) {
        if (!defined(capTag($tableName))) {
            $filename = __DIR__ . "/constants/tableConstants.php";
            if (!file_exists($filename)) {
                $fp = fopen($filename, 'a') or die("Unable to open file! ");
                fwrite($fp, '<?php ' . "\n\n");
                fwrite($fp, '    const ' . capTagVar("table_" . $tableName) . ' = "' . $tableName . '";' . "\n");
            } else {
                $fp = fopen($filename, 'a') or die("Unable to open file! ");
                fwrite($fp, '    const ' . capTagVar("table_" . $tableName) . ' = "' . $tableName . '";' . "\n");
            }
        }
    }
    
    /**
     * @param $key
     * @return string
     */
    function capTag($key) {
        $a = explode("_", $key);
        $keyCap = "";
        foreach ($a as $b) {
            $keyCap = $keyCap . "" . clearSpaceStrings(ucwords($b));
        }
        return $keyCap;
    }
    
    function capTagVar($key) {
        $a = explode("_", $key);
        $keyCap = "";
        foreach ($a as $b) {
            $keyCap = $keyCap . "" . clearSpaceStrings(ucwords($b));
        }
        return lcfirst($keyCap);
    }
    
    function mysqlTypeToPHP($type) {
        gettype($type);
    }
    
    /**
     * @param $tableName
     * @param $array
     * @param $class
     * @return array
     */
    function convertArrayToModel($tableName, $array, $class = null) {
        $arrayReturn = [];
        foreach ($array as $data) {
            $arrayReturn[] = convertObjectToModel($tableName, $data, $class);
        }
        return $arrayReturn;
    }
    
    function getTypeColumn($type) {
        switch ($type) {
            case "tinyint":
            case "bit":
                return 'bool';
                break;
            default:
                return $type;
        }
    }
    
    /**
     * @param $tableName
     * @param $object
     * @param $class
     * @return mixed
     */
    function convertObjectToModel($tableName, $object, $class = null) {
        $instance = null;
        
        if ($class === null) {
            $filename = __DIR__ . "/classes/" . capTag($tableName) . "Model.php";
            $class = "" . capTag($tableName) . "Model";
            if (file_exists($filename)) {
                $instance = new $class();
            } else {
                createModelFromTable($tableName);
                
                while (10) {
                    if (file_exists($filename)) {
                        reloadIncludeModels();
                        $instance = new $class();
                        break;
                    } else {
                        sleep(2);
                    }
                }
            }
            
        } else {
            $instance = new $class();
        }
        
        foreach ($object as $key => $value) {
            $instance->$key = is_bool($value) ? (bool)$value : $value;
        }
        return $instance;
    }
    