<?php
    /**
     * include core.php for create connections file for your website
     */
    include_once 'core/core.php';
    /**
     * after include core, create your functions for your website
     */
    
    /**
     * Selects examples
     */
    
    /**
     * Select with * from
     * @return array
     */
    function getArrayFromMyTable() {
        /**
         * select table from return one object's array
         */
        return select('test_data');
    }
    
    /**
     * Select with * from and where clause
     * @param $id
     * @return array
     */
    function getArrayFromMyTableWithWhere($id) {
        /**
         * select table from return one object's array
         */
        return selectWhere('test_data', /* Where clause for example */ "id > " . $id);
    }
    
    /**
     * Select with * from and where clause
     * @param $id
     * @return array
     */
    function getArrayFromMyTableWithCase() {
        /**
         * select table from return one object's array
         */
        return selectCase('test_data', /* Case clause for example */ "WHEN > ");
    }
    
    /**
     * select with where
     * @param $id
     * @return array
     */
    function getObjectFromMyTable($id) {
        /**
         * select table from return one object by where clause
         */
        return selectRow('test_data', /* Where clause for example */ "id = " . $id);
    }
    
    /**
     * Insert example
     */
    
    /**
     * insert table
     * @param $model
     * @return bool|mysqli_result
     */
    function insertInMyTable($model) {
        /**
         * return true for success or false for error in insert
         */
        return insert('test_data', /* $model class for example */ $model);
    }
    
    /**
     * delete example
     */
    
    /**
     * delete with where clause
     * @param $id
     * @return bool|mysqli_result
     */
    function deleteFromMyTable($id) {
        /**
         * return true for success or false for error in delete
         */
        return delete('test_data', /* Where clause for example */ "id = " . $id);
    }
    
    /**
     * update examples
     */
    
    /**
     * update with where clause
     * @param $model
     * @param $id
     * @return bool|mysqli_result
     */
    function updateInMyTable($model, $id) {
        /**
         * return true for success or false for error in update
         */
        return update('test_data',/* $model class for example */ $model,/* Where clause for example */ "id = " . $id);
    }
    
    /**
     * update with where clause
     *
     * this functions accept update fields with NULL values
     *
     * @param $model
     * @param $id
     * @return bool|mysqli_result
     */
    function updateWithNullInMyTable($model, $id) {
        /**
         * return true for success or false for error in update
         */
        return updateWithNull('test_data',/* $model class for example */ $model,/* Where clause for example */ "id = " . $id);
    }
    
    