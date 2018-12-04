<?php

$link4 = login;


if( $_SESSION['username'] !== NULL){
  $title4 = $_SESSION['username'];
  $link4 = logout;
} else {
  $link4 = login;
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">

  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="" id="navbarTogglerDemo01">
        <ul class="navbar-nav ">
          <li class="nav-item">
            <a class="nav-link"> <?php echo $title4?> <span class="sr-only">(current)</span></a>
          </li>
        </ul>  
  </div>
  
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tracker.php">Tracked</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="search.php">Search</a>
      </li>
    </ul>
    
  </div>
  
    <div class="collapse navbar-collapse " id="navbarTogglerDemo01">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $link4; ?>.php"> <?php echo $link4?> <span class="sr-only">(current)</span></a>
          </li>
        </ul>  
  </div>
  
</nav>