<?php

namespace App\Services\Interfaces;

use Exception;

interface LogManageInterface{
    
    /**
     * exceptionHandle() retirve the exception class message and store it on log file.
     */

    public function exceptionHandle($exception, $action = '');

    /**
     * logCreate() store the log data on log file.
     */
    
    public function logCreate($logData, $level = 'info');

    /**
     * enableGlobalQueryLog() show to query log with file line wise.
     */

    public function enableGlobalQueryLog($previous_log_delete);

    /**
     * getLogData() show the log data.
     */

    public function getLogData($params = []);

}