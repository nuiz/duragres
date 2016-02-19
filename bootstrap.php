<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

session_start();
require("vendor/autoload.php");
