<?php

session_start();
include("includes/database.php");

if(!$connection){
  echo "connection error";
}

$currentquery= "SELECT tracked_items.id, tracked_items.item_id, tracked_items.min_value, tracked_items.max_value, item_cache.name, item_cache.itemLevel from tracked_items inner join item_cache on tracked_items.item_id = item_cache.item_id where user_id =". $_SESSION['user_id'];
$currentsql = $connection->query($currentquery);


if($_SERVER["REQUEST_METHOD"]=="POST"){
  
  
    
    $string = $_POST['searchbox'] . '%';
    echo $string;
    $query = "SELECT item_id, name FROM item_cache where name like ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("s",$string);
    $statement->execute(); 
    
    $statement->bind_result($item_id, $name);
   

  }



?>

<html>
  
  <?php
include("includes/head.php");
include("includes/navigation.php");
?>
  
  <body>
    
    <div class="container track-head">
      <form method="post" action="search.php">
      <div class="row">
      <div class="col-md-4 d-none d-md-block"><a class="">Name</a></div>
      <div class="col-md-2 d-none d-md-block text-right"><a>Min Value</a></div>
      <div class="col-md-2 d-none d-md-block "><a>Max Value</a></div>
      <div class="col-md-2  col-8 ui-widget"><input value='' autocomplete="on"  class='searchbox' id="searchbox" name="searchbox" placeholder="Search.."></div>
      <div class="col-md-1 col-4"><button class="deletebutton"><i class="fas fa-search" style="line-height:25px;"></i></button></div>  
    </div>
      </form>
  </div>
    
    
    <div class="container">
      <br/>
      <?php
      
      if($_SERVER["REQUEST_METHOD"]!=="POST"){
      echo "<div class='row''>";  
      echo "<div class='col-md-12 text-center'><h1> Search for some items </h1></div>";
      echo "</div>"; 
      }
      
      ?>
      
    <?php
      if($_SERVER["REQUEST_METHOD"]=="POST"){
    while ($statement->fetch()) {
      echo "<form method='post' action='trackitem.php'>";
      echo "<div class='row'>";
      
      echo "<div class='col-md-4'><a id='itemname' name='itemname' href='//www.wowhead.com/item=".$item_id."' class=' wow-item' >".$name."</a></div>";
      echo "<input type='hidden' name='item_id' id='item_id' value=".$item_id.">";
      echo "<input type='hidden' name='user_id' id='user_id' value=".$_SESSION['user_id'].">";
      
      echo "<div class='col-md-3'>
            <div class='row'>
            <div class='col-md-4 whitebackground'><input style='width:75%;' class='hide-input text-right' maxlength='7' id='minG' name='minG'><a class='gold'> g</a>
            </div>
            
            <div class='col-md-2 whitebackground'><input style='width:70%;' class='hide-input text-right' maxlength='2' id='minS' name='minS'><a class='silver'> s</a></div><div class='col-md-2 whitebackground'><input style='width:70%;' class='hide-input text-right' maxlength='2' id='minC' name='minC'><a class='copper'> c</a></div></div> </div>";
      
      echo "<div class='col-md-3'><div class='row'>
            <div class='col-md-4 whitebackground'><input style='width:75%;' class='hide-input text-right' maxlength='7' id='maxG' name='maxG'><a class='gold'> g</a>
            </div>
            
            <div class='col-md-2 whitebackground'><input style='width:70%;' class='hide-input text-right' maxlength='2' id='maxS' name='maxS'><a class='silver'> s</a></div><div class='col-md-2 whitebackground'><input style='width:70%;' class='hide-input text-right' maxlength='2' id='maxC' name='maxC'><a class='copper'> c</a></div></div></div>";
      echo "<div class='col-md-1'><button class='deletebutton'><i class='fas fa-check' style='line-height:25px;'></i></button></div> ";
      echo "</form>";
      echo "</div>";
      
     }}
        
    ?>
      </div>
      <div class="container track-head">
    <div class="row">
      <div class="col-md-4 d-none d-md-block "><a class="">Item</a></div>
      <div class="col-md-2 d-none d-md-block text-center"><a>Ilvl</a></div>
      <div class="col-md-2 d-none d-md-block text-center"><a>Min Value</a></div>
      <div class="col-md-2 d-none d-md-block text-center"><a>Max Value</a></div>
      <div class="col-md-2 d-none d-md-block text-center"><a>Delete</a></div>
    </div>  
  </div>
    <div class="container">
      <?php
        while($currentitems = mysqli_fetch_array($currentsql)){
          
          if($currentitems['max_value'] == null || $currentitems['max_value'] == '0'){
            $currentitems['max_value'] = '000000';
          }
          
          if($currentitems['min_value'] == null || $currentitems['min_value'] == '0'){
            $currentitems['min_value'] = '000000';
          }
          
//          $minLength = strlen($currentitems['min_value']);
          $padLength = 6;
          $padChar = 0;
          $strType = 'd';
          $format = "%{$padChar}{$padLength}{$strType}";         
          $currentitems['min_value'] = sprintf($format, $currentitems['min_value']);
          $currentitems['max_value'] = sprintf($format, $currentitems['max_value']);
                   
      echo "<form method='post' action='deleteitem.php'>";
      echo "<div class='row'>";
      echo "<div class='col-md-4'><a id='item_id' name='item_id' href='//www.wowhead.com/item=".$currentitems['item_id']."' class=' wow-item' >".$currentitems['name']."</a></div>";
      echo "<input type='hidden' name='item_id' id='item_id' value=".$currentitems['item_id'].">";
      echo "<input type='hidden' name='idNumber' id='idNumber' value=".$currentitems['id'].">";
      echo "<div class='d-md-none col-3'><p>Ilvl</p></div>";    
      echo "<div class='col-md-2 col-9 text-center'><a>".$currentitems['itemLevel']."</a></div>";   
      
      echo "<div class='d-md-none col-3'><p>Bid</p></div>";
      //Min Value pricing turning 6+ number into gold/silver/copper    
      echo "<div class='col-md-2 col-9 text-center'><a>".substr($currentitems['min_value'], 0, -4)."</a><a class='gold'>g </a><a>".substr($currentitems['min_value'], -4, 2) ."</a><a class='silver'>s </a><a>".substr($currentitems['min_value'], -2) ."</a><a class='copper'>c</a></div>"; 
      
      echo "<div class='d-md-none col-3'><p>Buyout</p></div>";    
      //Max Value pricing turning 6+ number into gold/silver/copper     
      echo "<div class='col-md-2 col-9 text-center'><a>".substr($currentitems['max_value'], 0, -4)."</a><a class='gold'>g </a><a>".substr($currentitems['max_value'], -4, 2) ."</a><a class='silver'>s </a><a>".substr($currentitems['max_value'], -2) ."</a><a class='copper'>c</a></div>"; 
      
          
      echo "<div class='col-md-2 d-none d-md-block text-center'><a><button class='deletebutton'><i class='fas fa-times ' style='line-height:25px;'></i></button></a></div>";
      echo "<div class='d-md-none col-12 text-center'><a><button class='deletebutton'><p>Delete</p></i></button></a></div>";    
      echo "</form>";
      echo "</div>";
          
        }
      ?>
    </div>
  </body>
  
  
</html>

