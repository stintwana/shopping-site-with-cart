<?php
//Destroys Current User Session And Logs Them Out
require_once 'header.php';

if(isset($_SESSION['user_token'])){
    destroySession();
    echo("<script>location.href='index.php'</script>");
}
     else echo "
<div class='register-form'>
You cannot logout when you havent logged in
     </div>";
?>
<br><br/>
</div>
</body>
</html>