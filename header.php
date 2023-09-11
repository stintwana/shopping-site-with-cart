<?php

$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "tcm_books";
// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


$userstr = '(Guest)';

if(isset($_SESSION['user_token'])){
        $user_token = $_SESSION['user_token'];
        $user = $_SESSION['user'];
        $loggedIn = TRUE;
        $userstr = "Logged In: $user";
    }
    else {
        $loggedIn = FALSE;
    }

//Logout Function To Logout Users
Function destroySession(){
    $_SESSION = array();
    if (session_id() !="" || isset($_COOKIE[session_name()]))
    setcookie(session_name(),'',time()-2592000, '/');
}

include_once 'Cart.class.php'; 
$cart = new Cart; 
 
if(isset($_GET['view'])){
    $view= sanitizeString($_GET['view']);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <script src="js/jquery-3.6.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/rating.js"></script>
    <script src="js/nav.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css'>
    <title>TCM Books</title>
</head>
<body>

<?php 
if($loggedIn){
    echo  '<div class="topnav">';
    echo       '<div class="menu">';
    echo       '<div class="cart-view" style = "left:0px;">';
    echo      '<a href="login.php" title="'.$user.'"><i class="fa fa-user" aria-hidden="true" style="font-size:30px;"></i>&nbsp;&#x2714;</a>';?>
           <a href="viewCart.php" title="View Cart"><i class="fa fa-shopping-cart" aria-hidden="true" style="margin-left:2px;"></i><span class="badge badge-secondary badge-pill"> <?php echo ($cart->total_items() > 0)?$cart->total_items().'':'0'; ?></span></a>
           <?php
    echo   '</div>';

    echo           '<a href="index.php"><i style="font-size: 30px;" class ="fa fa-home" aria-hidden="true"></i> Home </a>';
    echo           '<a href="logout.php">Logout </a>';
    echo          '<a href="catalouge.php">Book Catalouge</a>';
    echo       '</div>';
    echo   '</div>';

}
else{
  
    echo  '<div class="topnav">';
    echo       '<div class="cart-view" style = "left:0px;">';
    echo      '<a href="login.php" title="login"><i class="fa fa-user" aria-hidden="true" style="font-size:30px;color:#f1f1ff;"></i></a>';?>
           <a href="viewCart.php" title="View Cart"><i class="fa fa-shopping-cart" aria-hidden="true" style="margin-left:2px;"></i><span class="badge badge-secondary badge-pill"> <?php echo ($cart->total_items() > 0)?$cart->total_items().'':'0'; ?></span></a>
           <?php
    echo   '</div>';
    echo       '<div class="menu">';
    echo           '<a href="index.php"><i style="font-size: 30px;" class ="fa fa-home" aria-hidden="true"></i> Home </a>';

    echo           '<a href="login.php">Login </a>';
    echo          '<a href="catalouge.php">Book Catalouge</a>';
    echo       '</div>';
    echo   '</div>';

}
?>
