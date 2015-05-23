<?php
session_start();
require_once'config.php';
require_once'system/sql.php';

function __autoload($class_name)
{
        require_once('modules/'.$class_name.'.php');
}
