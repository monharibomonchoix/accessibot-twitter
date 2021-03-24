<?php

define("MESSAGE_LOG_INFO", 0);
define("MESSAGE_LOG_WARNING", 1);
define("MESSAGE_LOG_ERROR", 2);

class LogMessage
{
  public static function log(string $message, int $type = MESSAGE_LOG_INFO)
  {
    echo "[" . date('Y-m-d H:i:s') . "] ";

    switch($type)
    {
      case MESSAGE_LOG_WARNING:
        echo "\033[1;33m[WARNING]: \033[0m";
        break;
      case MESSAGE_LOG_INFO:
        echo "\033[1;37m[INFO]: \033[0m";
        break;
      case MESSAGE_LOG_ERROR:
        echo "\033[1;31m[ERROR]: \033[0m";
        break;
      default:
        die("No log level " . $type);
    }
    echo $message . "\n";
  }
}