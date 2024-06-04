<?php
require_once "dbconfig.php";

error_reporting(E_ALL ^ E_DEPRECATED);

session_start();


function isSession(){
    if(isset($_SESSION["user_id"])){
        return $_SESSION["user_id"];
    } else return NULL;
}

?>


