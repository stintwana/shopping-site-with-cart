<?php
require_once 'header.php';
//AJAX call to That checks if the user exits in the database, If Exists Or Not The the User IS notified
echo "<br><br><br><br>";
echo <<<_END
<script>
function checkUser(user){
if(user.value==''){
    $('#used').html('&nbsp;')
    return
}
$.post
(
'checkUser.php',
{user : user.value },
function(data)
{
    $('#used').html(data)
}
)
}

function validateUserName(user){

}
</script>
_END;

//Logout Function To Logout Users

//Called To Send Queries To Any Table
Function queryMysql($query){
    global $db;
    $result = $db -> query($query);
    if(!$result) die($db->connect_error);
    return $result;
}

Function sanitizeString($var){
    global $db;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $db->real_escape_string($var);
    }
$error = $user = $full_names = $email_address = $pass = "";
if(isset($_SESSION['user'])) destroySession();

if (isset($_POST['user'])){
    $user = strtolower(sanitizeString($_POST['user']));
    $email_address = sanitizeString($_POST['e_mail']);
    $pass = sanitizeString($_POST['pass']);
    $salt1 = "pl$@";
    $salt2 = "@*^g";
    $token = hash('ripemd128',"$salt1$pass$salt2");
    $user_token = hash('ripemd128',"$salt1$user$salt2");

    if($user == "" || $email_address =="" || $pass == "" ){
        $error = "<span class ='alert alert-danger'>Not all fields where entered</span>";
    }
    else{
        $result = queryMysql("SELECT * FROM members WHERE user='$user'");

        if($result->num_rows ){
            $error = "<span class = 'alert alert-danger'>This user already exists</span><br><br>";
        }
        else{
            queryMysql("INSERT INTO members (  `user`,`user_token`, `pass`, `e_mail`, `created`)
            VALUES('$user','$user_token', '$token', '$email_address', CURRENT_DATE())");// Redirect to the specific page
echo("<script>location.href='login.php'</script>");
        }
    }
}
?>
<?php
echo <<<_END
<div class='main'>
<div class = 'register-form'>
<h2>Please Provide Information</h2>
<form method = "post" action = "register.php"> $error


<div class="col-md-6 mb-3">							
<label>Username</label>
<input type = "text" maxlegth='16' name = 'user' value = '$user' placeholder='choose username' onBlur ='checkUser(this)'>
<label><div id='used'>&nbsp;</div></label>
</div>

<div class="col-md-6 mb-3">	
<label>E-mail</label>
<input type = "email" name = 'e_mail' value = '$email_address' placeholder='Email Address'>
</div>

<div class="col-md-6 mb-3">	
<label>password</label>
<input type = 'password' name = 'pass' value = '$pass'  placeholder='choose password'><br>
</div>

<div class="col-md-6 mb-3">	
<label>register</label>
<input data-transition='slide' type = "submit" value = "submit">
</div>
</form></div>
</div>
</body>
</html>
_END;
?>
