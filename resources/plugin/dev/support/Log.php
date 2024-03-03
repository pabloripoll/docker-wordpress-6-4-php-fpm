<?php

namespace Plugin\Support;

class Log
{
    public static function debug($value = null)
    {
        $value != null ? : $value = '¯v(%)v¯';
        $content = print_r($value, true);
        $file = dirname(__DIR__, 1) . '/log/debug.txt';
        file_put_contents($file, "\n[".date("Y.m.d H:i:s")."]↴\n".$content, FILE_APPEND | LOCK_EX);
    }
}