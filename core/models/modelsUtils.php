<?php
    require_all_files(__DIR__ . "/classes/");
    require_all_files(__DIR__ . "/constants/");
    
    /**
     * for reload models in run time
     */
    function reloadIncludeModels() {
        require_all_files(__DIR__ . "/classes/");
        require_all_files(__DIR__ . "/constants/");
    }
