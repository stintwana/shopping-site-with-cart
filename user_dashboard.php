<?php
session_start();
require_once  "header.php";
$sql = $db->query("SELECT * FROM members WHERE user_token = '$user_token'");
if($sql->num_rows){
    while($row = $sql->fetch_assoc()){ ?>

<div class="dashboard" style = "margin-top: 7%;">
<h1 align = "center">Profile Information</h1>
<div class="dashboard-row">
<div class="profile-information">
<h3>Customer information</h3>
<p><b>username: </b><?php echo $row['user'] ?></p>
<p><b>E-mail: </b> <?php echo $row['e_mail'] ?></p>
</div>

<div class="ongoing-order">
<h3>Ongoing order</h3>

There is currently no ongoing orders <a href="index.php">Lets go shopping</a>
</div>

<div class="order-history">
    <h3>Order History</h3>
    oiwhrehgiraewihw y 54y4y5y4y54y
    3yhg35h 35h35y5h53 y5y5yty345y54y4
    54y54ty54t54tyey5y54y5y54y4yy5y 5y5y53y 
    54yw5y5y 5y5y5y 
</div>

</div>
</div>
<?php
    }
}
?>
