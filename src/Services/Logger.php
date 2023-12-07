<?php
namespace App\Services;

use Exception;

class Logger {

    public static function error(Exception $exceptionObject){
        $message = $exceptionObject->getMessage();
        $trace = json_encode($exceptionObject->getTrace());
        self::registerLog("[".date("r")."] Message : $message | TraceException: $trace \r\n");
    }

    private static function registerLog($errorLog){
        $file_errors = is_writable('../logs/errors.log') ? fopen(__DIR__  . '../logs/errors.log', 'a') : false;
        if ($file_errors !== false) {
            fwrite($file_errors, $errorLog);
            fclose($file_errors);
        }
    }
    
}