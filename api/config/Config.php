<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set("Asia/Calcutta");

/*
 * off magic_quotes_gpc
 */
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

/**
 * Configuration for: Base URL
 */
define('URL', '//127.0.0.1/biotech/');  /*Change this */
define('DOC_PATH', 'D:/wamp/www/biotech/');/*Change this */
