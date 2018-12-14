<?php
session_start();
include("includes/database.php");

include("PHPMailer/src");
use PHPMailer\PHPMailer\PHPmailer;
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");

$query2 = "select * from serverlist";
$sql2 = $connection->query($query2);

if($_SERVER["REQUEST_METHOD"]=="POST"){

  
$errors = array();
$username = strtolower($_POST['username']);
  
if(strlen($username) > 16){
  $errors["username"] = "username too long";
}
if(strlen($username) < 3){
  $errors["username"] = "username should be atleast 3 characters";
}
if($errors["username"]){
  $errors["username"] = trim($errors["username"]);
}
$email = $_POST['email'];

$email_check = filter_var($email,FILTER_VALIDATE_EMAIL);  
  if($email_check == false){
    $errors["email"] = "email address is not valid";
  }
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

if($password1 !== $password2){
    $errors["password"] = "passwords do not match";
} elseif(strlen($password1) < 6){
    $errors["password"] = "password should be atleast 6 characters";
}

if(count($errors) == 0){
    //hash the password
    $password = password_hash($password1,PASSWORD_DEFAULT);  
    $token = 'qwertyuiopasdfghjklzxcvbnmQEWRTYUIOPASDFGHJKLZXCVBNM1234567890!$/()*';
    $token = str_shuffle($token);
    $token = substr($token, 0, 10);
  
$server = $_POST['server'];

$query = 'INSERT INTO user (username,email,password,user_rank,server,email_validated,token)
          VALUES
          (?,?,?,1,?,0,?)';
  

  $statement = $connection->prepare($query);
  

  $statement->bind_param("sssss",$username,$email,$password,$server,$token);

  
  $statement->execute();
} else{
  //print_r($errors);
}

  if($statement->affected_rows > 0){
    $message = "Account successfully created";
    $errormessage = "Account creation failed";
    $query = "SELECT max(id) from accounts";
    $statement = $connection->query($query);
    $result = mysqli_fetch_assoc($statement);
    $value = $result['max(id)'];
    $query = "insert into settings (user_id) VALUES ($value)";

    $result = $connection->query($query);
    
    $mail = new PHPMailer();
    $mail->isSMTP(); 
    $mail->Host        = "smtp.gmail.com"; // Sets SMTP server
    $mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = 'nathanielcopeland93@gmail.com';
    $mail->Password = 'kwerty321';
    $mail->From        = 'nathanielcopeland93@gmail.com';
    $Mail->FromName    = 'AHTrack';
    $mail->Priority    = 1;
    $Mail->CharSet     = 'UTF-8';
    $Mail->Encoding    = '8bit';
    $mail->addAddress($email);
    $mail->Subject = "Please Verify email";
    $mail->isHTML(true);
    $mail->Body = "Click on the link below to verify email address <br><br>
    <a href='localhost/ahtrack/confirm.php?email=$email&token=$token'>Click here to verify</a>
      ";
    
    $mail->Send();
      
//    if(!$mail->send()) {
//    echo 'Message could not be sent.';
//    echo 'Mailer Error: ' . $mail->ErrorInfo;
//} else {
//    echo 'Message has been sent';
//}
    
    //header('Location: login.php');
} else {
    
        $message = $connection->error;
        if(strstr($message,"username")){
            $errors["username"] = "username already taken";
          //echo $errors["username"];
          //print_r($errors);
        }
        if(strstr($message,"email")){
            $errors["email"] = "email already used";
            //echo $errors["email"];
          //print_r($errors);
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
  
  <form id="registration" method="post" action="register.php">
    <div class="text-center">
    <h1>Register</h1>
  <label> Username:</label><br/>
  <input id="username" name="username" placeholder="John Doe"> <?php echo "<div style='color:red;'>".$errors['username']."</div>";?><br/>
    
  <label> Email:</label><br/>
  <input id="email" name="email" placeholder="JohnDoe@email.com"><?php echo "<div style='color:red;'>".$errors['email']."</div>";?><br/>
    
  <label> Password:</label><br/>
  <input type="password" id="password1" name="password1" placeholder="password"><br/>
  
    
  <label> Retype Password:</label><br/>
  <input type="password" id="password2" name="password2" placeholder="password"><?php echo "<div style='color:red;'>".$errors['password']."</div>";?><br/>
  
  <label> Server:</label><br/>
  <select name="server" >
      <?php
  while ($row = $sql2->fetch_assoc()){
  echo "<option value=".$row['server'].">".$row['server']."</option>"; 
  }  ?>  
      </select><br/><br/>    
  <button class="btn btn-primary">Register</button>
    </div> 
</form>  
  
</div>  

</body>  
  

</html>