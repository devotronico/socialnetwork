<?php
session_start();
define('DB_SERVER', '89.46.111.58');
define('DB_USERNAME', 'Sql1176037');
define('DB_PASSWORD', '88w2410cp6');
define('DB_NAME', 'Sql1176037_1');
 
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($mysqli === false) {die("ERROR: Could not connect. " . $mysqli->connect_error);}

define('PASSWORD_LENGTH', 8);
define('MAXLOADTWEET', 8);

// COSTANTI PER CARICARE LE IMMAGINI DAL FORM
const MAX_FILE_SIZE = 5000000;
const MAX_FILE_WIDTH = 100;
const MAX_FILE_HEIGHT = 100;
const IMAGE_DIR = "img/avatar/";
?>





