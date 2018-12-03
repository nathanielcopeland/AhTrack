<?php

session_start();
include("includes/database.php");

if (isset($_GET['term'])){
$searchTerm = $_GET['term'];

   $query = $connection->query("SELECT * FROM item_cache WHERE name LIKE '%".$searchTerm."%' ORDER BY name ASC");

    while ($row = $query->fetch_assoc()) 
    {
        $data[] = $row['name'];
    }

    if(count($data) <= 20 ){
      echo json_encode($data);
    } else {
      $toomany[] = "Too many results";
      echo json_encode($toomany);
    }
    //return json data
    
}
?>