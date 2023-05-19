<?php

namespace Core;

class ErrorHandler
{
    public static function logError($errno, $errstr, $errfile, $errline)
    {
        $logMessage = "Erreur [$errno] : $errstr dans le fichier $errfile à la ligne $errline";

        self::displayError($logMessage);
    }

    public static function displayError($errorMsg) {
      echo $errorMsg;
    }
}