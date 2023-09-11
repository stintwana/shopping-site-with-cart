<?php 
session_start();
include('rating.php');
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
 
// Include the database config file 
require_once 'dbConfig.php'; 

if(isset($_GET['book_code'])){
    $view= sanitizeString($_GET['book_code']);
}
?>
<?php 
require_once "header.php";
$sql = "Select * FROM books";
$all_products = $db->query($sql);
if($all_products->num_rows){
    foreach($all_products as $book){
        echo ["name"];
        echo ["description"];
        echo ["price"];
    }
}
?>
