<?php


//Filters The String and checks if the user exist in the database before logging in
require_once "header.php";
require_once "dbConfig.php";
echo "<br><br><br><br>";
echo "<div class=register-form>";
$error = $user = $pass = "";

if (isset($_POST['user'])){
    
    $user = strtolower(sanitizeString($_POST['user']));
    $pass = sanitizeString($_POST['pass']);
    $salt1 = "pl$@";
    $salt2 = "@*^g";
    $token = hash('ripemd128',"$salt1$pass$salt2");
    $user_token = hash('ripemd128',"$salt1$user$salt2");

    if($user == "" || $pass == ""){
        $error = "<span class='error'>Not all fields where entered<br</span>";
    }
    else{
        $result = queryMysql("SELECT user_token,pass FROM members Where user_token='$user_token' AND pass = '$token'");

        if($result->num_rows ==0){
            $error = "<span class='error'>Username/Pass is false</span><br/>";
        }
        else{

            $_SESSION['user_token']=$user_token;
            $_SESSION['user']=$user;
          die("logged in as $user <a href = 'index.php?view=$user'>click</a> here to Continue ");
        }
    }
}
//The Login Form
echo <<<_END
<form method = "post" action = "login.php">$error
<h1 align = 'center '>Login</h1>
<h2>Please enter login details</h2>
<input type = "text" name = 'user' value = '$user' placeholder='username'/><br/><br/>

<input type = "password" name = 'pass' value = '$pass'  placeholder='password'/><br>
_END;
?>
<div data-role='fieldcontain'>
<input  type = "submit" value = "Submit" class='btn-submit'><br/>

not yet a member?<a href="register.php">Click here to register</a>
</div>

</form></div>
</body>
</html>