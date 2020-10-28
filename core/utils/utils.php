<?php /** @noinspection PhpIncludeInspection */
    include_once 'logs.php';
    
    /**
     * @param $dir
     */
    function require_all_files($dir) {
        foreach (glob("$dir/*") as $path) {
            if (preg_match('/\.php$/', $path)) {
                require_once $path;  // it's a PHP file so just require it
            } elseif (is_dir($path)) {
                require_all_files($path);  // it's a subdir, so call the same function for this subdir
            }
        }
    }
    
    /**
     * @param $string
     * @return string
     */
    function clearSpace($string) {
        return trim(preg_replace("/\s+/", " ", $string));
    }
    
    /**
     * @param $string
     * @return false|mixed|string|string[]|null
     */
    function toUrl($string) {
        $string = preg_replace("/\s+/", " ", $string);
        $string = str_replace(" ", "-", trim($string));
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = strtolower($string);
        return $string;
    }
    
    /**
     * @param $string
     * @param $contains
     * @return bool
     */
    function contains($string, $contains) {
        return strpos($string, $contains) !== false;
    }
    
    /**
     * @param $array
     * @param $string
     * @return bool
     */
    function containsInArray($array, $string) {
        return in_array($string, $array, true);
    }
    
    /**
     * @param $nameFunction
     * @param $array
     */
    function createFunctionFromArray($nameFunction, $array) {
        echo '<br>function ' . $nameFunction . '($value){<br>';
        foreach ($array as $data) {
            echo 'if($value == "' . $data . '") { <br>return "mudarValor"; <br>}<br>';
        }
        echo 'return NULL;<br>';
        echo '}<br>';
    }
    
    /**
     * @param $value
     * @return mixed
     */
    function openJsonFile($value) {
        $str = file_get_contents($value);
        return json_decode($str, true); // decode the JSON into an associative array
    }
    
    /**
     * @param $local
     * @return DOMDocument
     */
    function openHtmlFile($local) {
        $document = new DOMDocument();
        $document->loadHTMLFile($local);
        return $document;
    }
    
    /**
     * @param $inPath
     * @param $outPath
     */
    function save_image($inPath, $outPath) { //Download images from remote server
        $in = fopen($inPath, "rb");
        $out = fopen($outPath, "wb");
        while ($chunk = fread($in, 8192)) {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }