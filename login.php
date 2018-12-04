<?php
session_start();

if ($_SESSION['username'] !== NULL){
header("location:/ahtrack/index.php"); //to redirect back to "index.php" after logging out
exit();
}
include("includes/database.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
$username = $_POST["username"];
$password = $_POST["password"];

  
 $query = "SELECT `user_id`, `user_rank`, `password` FROM `user` WHERE username = '$username'";
  
 $sql = $connection->query($query);
  
  
  while ($row = $sql->fetch_assoc()){
    if (password_verify($password, $row['password'])){
      //echo 'Login Succesful';
      print_r($row);
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['user_rank'] = $row['user_rank'];
      header('Location: index.php');
    } else{
      
    }
  }
  
}


?>


<html>
<?php
include("includes/head.php");
include("includes/navigation.php");
?>
  <body>

    <div class="container">
      
      <form id="login" method="post" action="login.php"> 
        <div class="text-center">
          <label> Username:</label>
          <input id="username" name="username">
          
          <label> Password:</label>
          <input type="password" id="password" name="password">
          
          <button class="btn btn-primary">Login</button>
        </div>
      </form>

    </div>

</body>

  
</html>


