<?php

session_start();
include("includes/database.php");

if(!$connection){
  echo "connection error";
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
  
  
  
    $query = "SELECT item_id, name FROM item_cache where name like '".$_POST['searchbox']."%'";

    $sql = $connection->query($query);
    

  }



?>

<html>
  
  <?php
include("includes/head.php");
?>
  
  <body>
    
  <form method="post" action="search.php">
    <input id="searchbox" name="searchbox" placeholder="Search.." >
  </form>
    
    <br/>
    <br/>
    <br/>
    <?php
    while($items = mysqli_fetch_array($sql)){
      echo "<a href='//www.wowhead.com/item=".$items['item_id']."' class='q3' >".$items['name']."</a>";
    }
        
    ?>
  </body>
  
  
</html>

