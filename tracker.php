<?php
session_start();
include("includes/database.php");

$query = "select tracked_items.item_id, tracked_items.max_value, tracked_items.min_value, auctionhouse.bid, auctionhouse.buyout, auctionhouse.quantity,                       auctionhouse.ownerRealm, auctionhouse.timeLeft, auctionhouse.owner, auctionhouse.timeLeft, item_cache.itemLevel, count(*) as count
          from tracked_items 
          inner join item_cache on tracked_items.item_id = item_cache.item_id
          inner join 
          auctionhouse on tracked_items.item_id = auctionhouse.item where tracked_items.user_id = ".$_SESSION['user_id']." and auctionhouse.buyout < tracked_items.max_value or tracked_items.max_value is null and tracked_items.user_id = ".$_SESSION['user_id']." group by tracked_items.item_id, auctionhouse.buyout, auctionhouse.owner, auctionhouse.bid, auctionhouse.quantity order by tracked_items.item_id desc, auctionhouse.buyout asc";

$sql = $connection->query($query);

$query2 = "select tracked_items.item_id, item_cache.name from tracked_items
inner join item_cache on tracked_items.item_id = item_cache.item_id where tracked_items.user_id = ".$_SESSION['user_id']." group by item_cache.name";

$sql2 = $connection->query($query2);

?>

<html>
  <?php
  include("includes/head.php");
  include("includes/navigation.php");
  ?>
  <body>
  <div class="container track-head d-none d-md-block">
    <div class="row">
      <div class="col-md-3 d-none d-md-block "><a class="">Item</a></div>
      <div class="col-md-1 text-center"><a>Ilvl</a></div>
      <div class="col-md-1 text-center"><a>Amount</a></div>
      <div class="col-md-1 text-center"><a><i class="far fa-clock" style="line-height:25px;"></i></a></div>
      <div class="col-md-2 text-center"><a>Seller</a></div>
      <div class="col-md-2 text-center"><a>Bid</a></div>
      <div class="col-md-2 text-center"><a>Buyout</a></div>
    </div>  
  </div>  
  <div class="container">
    
    <?php

    while($row = mysqli_fetch_array($sql2)){
      echo "<div class='row item-header'>";
      echo "<div class='col-md-6'><a id='itemname' name='itemname' href='//www.wowhead.com/item=".$row['item_id']."' class=' wow-item' >".$row['name']."</a></div>";
      echo "<div class='col-md-6 text-right'><button class='deletebutton hidebutton'><i style='line-height:25px;' class='".$row['item_id']." fas fa-arrow-alt-circle-down'></i></button></div>";
      echo "</div>";
      while($items = mysqli_fetch_array($sql)){
        if($items['item_id'] == $row['item_id']){
      $items['buyout'] = sprintf('%06d', $items['buyout']);
      $items['bid'] = sprintf('%06d', $items['bid']);
      echo "<div class='row hidethis ".$row['item_id']."button'>";
      echo "<div class='col-md-3'><a id='itemname' name='itemname' href='//www.wowhead.com/item=".$items['item_id']."' class=' wow-item' >".$items['item_id']."</a></div>";
      
      //layout for mobile
      echo "<div class='d-md-none col-3'><p>Ilvl</p></div>";
      echo "<div class='col-md-1 col-9 text-center'><a>".$items['itemLevel']."</a></div>";
      
      echo "<div class='d-md-none col-3'><p>Amount</p></div>";    
      echo "<div class='col-md-1 col-9 text-center'><a>".$items['quantity']." of ".$items['count']."</a></div>";

      echo "<div class='d-md-none col-4'><p>Time Left</p></div>";     
      echo "<div class='col-md-1 col-8 text-center'><a>".$items['timeLeft']."</a></div>";
          
      echo "<div class='d-md-none col-3'><p>Seller</p></div>";     
      echo "<div class='col-md-2 col-9 text-center'><a>".$items['owner']."</a></div>";
      
      echo "<div class='d-md-none col-3'><p>Bid</p></div>";       
      echo "<div class='col-md-2 col-9 text-center'><a>".substr($items['bid'], 0, -4)."</a><a class='gold'>g </a><a>".substr($items['bid'], -4, 2) ."</a><a class='silver'>s </a><a>".substr($items['bid'], -2) ."</a><a class='copper'>c</a></div>";
      
      echo "<div class='d-md-none col-3'><p>Buyout</p></div>";    
      echo "<div class='col-md-2 col-9 text-center'><a>".substr($items['buyout'], 0, -4)."</a><a class='gold'>g </a><a>".substr($items['buyout'], -4, 2) ."</a><a class='silver'>s </a><a>".substr($items['buyout'], -2) ."</a><a class='copper'>c</a></div>";
      
      
      echo "</div>";
        }
        
        
      }
      mysqli_data_seek($sql, 0);
    }
    
    
//    while($items = mysqli_fetch_array($sql)){
//      $items['buyout'] = sprintf('%06d', $items['buyout']);
//      $items['bid'] = sprintf('%06d', $items['bid']);
//      echo "<div class='row'>";
//      echo "<div class='col-md-3'><a id='itemname' name='itemname' href='//www.wowhead.com/item=".$items['item_id']."' class=' wow-item' >".$items['item_id']."</a></div>";
//      echo "<div class='col-md-1 text-center'><a>".$items['itemLevel']."</a></div>";
//      echo "<div class='col-md-1 text-center'><a>".$items['quantity']." of ".$items['count']."</a></div>";
//      echo "<div class='col-md-1 text-center'><a>".$items['timeLeft']."</a></div>";
//      echo "<div class='col-md-2 text-center'><a>".$items['owner']."</a></div>";
//      echo "<div class='col-md-2 text-center'><a>".substr($items['bid'], 0, -4)."</a><a class='gold'>g </a><a>".substr($items['bid'], -4, 2) ."</a><a class='silver'>s </a><a>".substr($items['bid'], -2) ."</a><a class='copper'>c</a></div>";
//      echo "<div class='col-md-2 text-center'><a>".substr($items['buyout'], 0, -4)."</a><a class='gold'>g </a><a>".substr($items['buyout'], -4, 2) ."</a><a class='silver'>s </a><a>".substr($items['buyout'], -2) ."</a><a class='copper'>c</a></div>";
//      
//      
//      echo "</div>";
//      
//}
    
    ?>
  
  </div>
  
  </body>
  
</html>