<?php
session_start();
include("includes/database.php");


if($_SERVER["REQUEST_METHOD"]=="POST"){
  
$query = 'INSERT INTO tracked_items (item_id,user_id,min_value,max_value)
          VALUES
          (?,?,?,?)';
  

  $statement = $connection->prepare($query);
  
  if(strlen($_POST[minG]) == 0){
    $_POST[minG] = 00;
  }
  if(strlen($_POST[minS]) == 0){
    $_POST[minS] = 00;
  }
  if(strlen($_POST[minC]) == 0){
    $_POST[minC] = 00;
  }
  if(strlen($_POST[maxG]) == 0){
    $_POST[maxG] = 00;
  }
  if(strlen($_POST[maxS]) == 0){
    $_POST[maxS] = 00;
  }
  if(strlen($_POST[maxC]) == 0){
    $_POST[maxC] = 00;
  }
  
  if(strlen($_POST[minG]) == 1){
    $_POST[minG] = 0 . $_POST[minG];
  }
  if(strlen($_POST[minS]) == 1){
    $_POST[minS] = 0 . $_POST[minS];
  }
  if(strlen($_POST[minC]) == 1){
    $_POST[minC] = 0 . $_POST[minC];
  }
  
  if(strlen($_POST[maxG]) == 1){
    $_POST[maxG] = 0 . $_POST[maxG];
  }
  if(strlen($_POST[maxS]) == 1){
    $_POST[maxS] = 0 . $_POST[maxS];
  }
  if(strlen($_POST[maxC]) == 1){
    $_POST[maxC] = 0 . $_POST[maxC];
  }
  
  $max_value = $_POST[maxG] . $_POST[maxS] . $_POST[maxC];
  $min_value = $_POST[minG] . $_POST[minS] . $_POST[minC];
  echo $min_value;
  
 if($max_value == NULL || $max_value == '000'){
  $max = null;
  echo 'null';
} else{
 $max = $max_value;
   echo '$max';
 }
  
   if($min_value == NULL || $min_value == '000'){
  $min = null;
     echo 'null';
} else{
 $min = $min_value;
     echo '$max';
 }

  $statement->bind_param("iiii",$_POST['item_id'],$_POST['user_id'],$min,$max);

  print_r($query);
  
  $statement->execute();
  printf("Error: %s.\n", $stmt->error);

  
echo $_POST['item_id'];
echo $_POST['itemname'];
if($_POST['max'] == NULL){
  echo 'null';
}

print_r($_POST);
    
  
header("location:/ahtrack/search.php");  
  }
?>