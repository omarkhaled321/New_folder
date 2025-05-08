<?php

if (!defined("db_SERVER")) define("db_SERVER", "localhost");
if (!defined("db_USER")) define("db_USER", "root");
if (!defined("db_PASSWORD")) define("db_PASSWORD", "");
if (!defined("db_DBNAME")) define("db_DBNAME", "crazy_sale");

$conn = mysqli_connect(db_SERVER, db_USER, db_PASSWORD, db_DBNAME);
if (!$conn) {
    die('Could not connect: ');  
}
?>
