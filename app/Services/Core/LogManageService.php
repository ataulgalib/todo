<?php

namespace App\Services\Core;

use App\Services\Interfaces\LogManageInterface;
use Exception;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\LazyCollection;

class LogManageService implements LogManageInterface
{
    public function exceptionHandle($exception, $action = ''){


        $logData = $this->generateLogDetails($exception, $action);
        $this->logCreate($logData, LOG_ERROR_KEY);

    }

    protected function generateLogDetails($exception,$action = 'NOTHING_FOR_LOG_DATA'){

        $logData = [
            LOG_ACTION_KEY => $action,
            'ip_address' => request()->ip(),
            'current_route_name' => \Route::currentRouteName(),
            'route_action' => request()->route()->getActionName(),
            'current_url' => request()->fullUrl(),
            'exception' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'class' => get_class($exception),
            //'trace' => $exception->getTrace(),
            'previousException' => $exception->getPrevious(),
            'exceptionTrace' => $exception->getTraceAsString(),
        ];

        return $logData;
    }

    public function logCreate($logData, $level = LOG_INFO_KEY){

        if(empty($level)){
            $level = LOG_INFO_KEY;
        }

        try {

            if(!isset($logData['auth_user'])){
                $logData['auth_user'] = auth()->check() ? ['user_id' => auth()->user()->id, 'user_name' => auth()->user()->name ] : ['user_id' => null, 'user_name' => 'GUEST'];

            }

            if(!isset($logData['ip_address'])){
                $logData['ip_address'] = request()->ip();
            }

            if(!isset($logData['current_url'])){
                $logData['current_url'] = request()->fullUrl();
            }

            $json_data = safe_json_encode($logData);

            $level = (string) $level;

            Log::{$level}($json_data);

        } catch (Exception $e) {

            Log::{LOG_CRITICAL_KEY}(safe_json_encode($this->generateLogDetails($e, CATCH_EXCEPTION_LOG_NAME)));

            $status = false;
        }

        return $status ?? false;
    }

    public function enableGlobalQueryLog($previous_log_delete = true)
    {
        $query_log_file_path = storage_path('/logs/query.log');
        $itaration = 0;
        $fils = [];

        if($previous_log_delete){
            File::delete($query_log_file_path);
        }

        DB::listen(function ($query) use ($query_log_file_path, &$itaration) {
            $actual_query = vsprintf(
                str_replace('?', '%s', $query->sql),
                array_map(
                    function ($binding) {
                        if($binding instanceof \DateTime) {
                            $binding = $binding->format('Y-m-d H:i:s');
                        }
                        $binding = addslashes($binding);
                        return is_numeric($binding) ? $binding : "'{$binding}'";
                    },
                    $query->bindings
                )
            );

            File::append(
                $query_log_file_path,
                PHP_EOL. ++$itaration.
                '. MAIN_QUERY => '.$actual_query .
                PHP_EOL . 'EXCUTION_TIME =>'.  $query->time .
                PHP_EOL
            );

            $fils[$itaration] = [
                'MAIN_QUERY' => $actual_query,
            ];

            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

            $file_name = [];
            foreach ($backtrace as $trace) {
                if(array_key_exists('file',$trace) && array_key_exists('line',$trace)){

                    if( strpos($trace['file'],'vendor')==false && strpos($trace['file'],'Middleware')==false && strpos($trace['file'],'public')==false && strpos($trace['file'],'server')==false && strpos($trace['file'],'storage')==false && strpos($trace['file'],'index')==false){

                        $file_name = array_merge($file_name, [substr($trace['file'],strrpos($trace['file'],"\\")+1,strlen($trace['file'])-strrpos($trace['file'],"\\")) =>  $trace['line']]);
                        File::append(
                            $query_log_file_path,
                            substr($trace['file'],strrpos($trace['file'],"\\")+1,strlen($trace['file'])-strrpos($trace['file'],"\\")) .
                            ' '.$trace['file'] .', Line No => '.$trace['line']
                            .PHP_EOL
                        );

                    }
                }
            }
        });


    }

    public function getLogData($params = []){

        $log_file_information = $this->getLogFileInformation();
        $search = $this->genarateSerchaParameter($params);
        $log_date = $this->setDates($search);;

        $logs_datas = LazyCollection::make(function () use($log_file_information, $search) {
            if(!empty($log_file_information) && !empty($search)){
                foreach ($log_file_information as $log) {
                    $logs_data = $this->readLogData($log, $search['search_key']);
                    yield $logs_data;
                }
            }

        })->chunk(100)
        ->flatten(2)
            ->reverse()
        ->toArray();

        $logs_datas = arrayPagination($logs_datas, $params['page_limit']);

        return [
            LOG_ACTION_KEY => 'VISITED_LOG_DATA',
            STATUS_CODE_KEY => config('configuration.software_exception_code.success'),
            'data' => $logs_datas,
            'search' => $search,
        ];
    }

    private function getLogFileInformation(){
        $log_data = [];
        $log_files = File::allFiles(storage_path('/logs'));

        // REMOVE LAST LARAVEL.LOG FILE AND QUERY LOG -3
        // REMOVE ONLY QUERY.LOG FILE -2


        $itaration = 0;
        if(count($log_files) > 3){
            $itaration = count($log_files) - 3;
        }

        foreach ($log_files as $key => $log_file) {
            if($key <= $itaration){
                $log_data[] = [
                    'file_name' => $log_file->getFilename(),
                    'file_path' => $log_file->getPathname(),
                    'file_size' => $log_file->getSize(),
                    'file_last_modified' => $log_file->getMTime(),
                ];
            }
        }

        $log_data  = array_reverse($log_data);

        return $log_data;
    }

    private function genarateSerchaParameter($params = []){

        return [
            'date_from' => $params['date_from'] ?? '',
            'date_to' => $params['date_to'] ?? '',
            'search_key' => $params['search_key'] ?? '',
            'page_limit' => $params['page_limit'] ?? '',
            'daterange' => $params['daterange'] ?? '',
        ];
    }

    private function setDates($search){
        $dates = [$search['date_from']];

        while (end($dates) < $search['date_to']) {
            $dates[] = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
        }

        return $dates;
    }

    private function readLogData($log_file, $search_phrase)
    {
        $matches = [];
        $logs = [];

        $file_data = file_get_contents($log_file['file_path']);

        $pattern = '[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:",\.\?\\\]';
        preg_match_all(
            "/(\[\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}\].*[\s\S]*?)(?=\[\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}\])/",
            $file_data,
            $matches
        );

        foreach ($matches[0] as $log_data) {

            $log_data = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
            }, $log_data);

            if (!empty($search_phrase)) {
                if (preg_match("/" . preg_quote($search_phrase, "/") . "/", $log_data)) {
                    $log_date = substr($log_data,0 , 21);
                    $logs[] =[
                        'log_data' => $log_data,
                        'log_file_name' => $log_file['file_name'],
                        'log_date' =>  $log_date,
                    ];
                }
            } else {
                $log_date = substr($log_data,0 , 21);
                $logs[] =[
                    'log_data' => $log_data,
                    'log_file_name' => $log_file['file_name'],
                    'log_date' =>  $log_date,
                ];
            }

        }

        return $logs;
    }
}
