<?php
  include("includes/database.php");
  include('includes/head.php');

  if (isset($_GET['email']) && isset($_GET['token'])){
    echo 'hey';
    
    
    $email = $_GET['email'];
    $token = $_GET['token'];
    echo $email;
    echo $token;
    
    $query = "select user_id from user where email='$email' and token='$token' and email_validated=0";
    
    $sql = $connection->query($query);
    print_r($sql);
    while ($row = $sql->fetch_assoc()){
      print_r($row['user_id']);
      $userid = $row['user_id'];
      $query = "update user set email_validated=1, token='' where user_id = $userid";
      print_r($query);
      $sql = $connection->query($query);
    }
    
    
    
  } else {
    
  }
    
    
    
    
  

?>