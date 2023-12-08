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
        $logsDirectory = __DIR__."/../../logs";
        if (!file_exists($logsDirectory)) {
            mkdir($logsDirectory, 0777, true); // Crea la carpeta con permisos de escritura
        }

        $file_errors =  fopen($logsDirectory .'/errors.log', 'w');

        if ($file_errors !== false) {
            fwrite($file_errors, $errorLog);
            fclose($file_errors);
        }
    }
    
}