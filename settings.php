<?php
session_start();
include("includes/database.php");

$username = $_SESSION['username'];
$password = $_POST["password"];

  
 $query = "SELECT `user_id`, `user_rank`, `password`, `server` FROM `user` WHERE username = '$username'";
$sql = $connection->query($query);
  
  $query2 = "SELECT * from serverlist";
  $sql2 = $connection->query($query2);
  
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $query = "UPDATE `user` SET `server`= '".$_POST['server']."' WHERE `username` = '$username'";
  $sql = $connection->query($query);
  $_SESSION['server'] = $_POST['server'];
}

?>

<html>
  <?php
  include("includes/head.php");
  include("includes/navigation.php");
  ?>
  <body>
    <form action="" method="post">
    <select name="server">
    <?php
    while ($row = $sql2->fetch_assoc()){
  echo "<option value=".$row['server'].">".$row['server']."</option>"; 
  }    
    ?>
      </select>
      <input type="submit">
  </form>  
    
    </body>
  
</html>