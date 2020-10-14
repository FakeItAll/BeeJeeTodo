<?php


class Config
{
    public static function init($filename)
    {
        if (file_exists($filename)) {
            foreach (parse_ini_file($filename) as $k => $v) {
                putenv("$k=$v");
            }
        }
    }

    public static function get($key, $default = null)
    {
        return getenv($key, true) ?: $default;
    }
}