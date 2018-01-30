<?php

$user = "user";
$password = "password";
$host = "localhost";
$database = "item_db";

$connection = mysqli_connect($host,$user,$password,$database);

if(!$connection){
  echo "connection error";
}
else{

}
?>