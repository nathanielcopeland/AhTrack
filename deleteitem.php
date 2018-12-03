<?php
session_start();
include("includes/database.php");


if($_SERVER["REQUEST_METHOD"]=="POST"){
  
$query = "DELETE FROM tracked_items where id = ". $_POST['idNumber'];
          
  
  echo $query;
$statement = $connection->query($query);
  print_r($statement);
  echo $statement;

header("location:/ahtrack/search.php");
  
  }
else{
  echo "nothing here";
}
?>