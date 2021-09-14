<?php
ob_start();
(!defined('DS')) ? define('DS', DIRECTORY_SEPARATOR) : null;

require_once '..'.DS.'app'.DS.'init.php';

$connect = new lib\database\db_connection;
$handleurl = new lib\vendor\front_controller;
ob_end_flush();