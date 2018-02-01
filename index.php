<?php
session_start();
include("includes/databse.php");


?>

<html>
  <?php
  include("includes/head.php");
  ?>
  <body>
  
  


  
  <form method="post" action="search.php">
    <input id="searchbox" name="searchbox" placeholder="Search.." >
  </form>
  
<?php
include("search.php");
?>
  
      <p>hey</p>
    <br/>
<!--
    <br/>

    <br/>
    <br/>
  <?php
  
//    
    
  ?>
-->
    
    
    </body>
  
</html>