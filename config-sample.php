<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'dbname');

//twillo info
$sid = 'yourtwilloinfo';
$token = 'yourtwillotoken';
$from = '+yourtwillnonumber';
$crypt_key = "oru-9(£20fjasdiofewfqwfh;klncsahei223gfpaoeighew";
$message= "appointment available.";
$buy_link = "https://whereveryouwantosendthemto";
 
/* Attempt to connect to MySQL database */
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>