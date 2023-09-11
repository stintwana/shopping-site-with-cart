<!doctype html>
<html lang = en>
<head>
<meta charset="utf-8" />
   <meta http-equiv="refresh" content="8; url='index.php'" />
  <meta name="viewport" content ="width=device-width, initial-scale=1.0" >
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>
Thank You
</title>
</head>
<body style ="background-color:#9f1d35;color:white; font-family:montserrat;">
<h2 align = "center" >Thank you for contacting us, you will hear from us soon</h2> 

<p align= "center"> You Will Be Redirected Within <span id="countdowntimer" style = "font-size:20pt;">8 </span> Seconds</p>
 <div class="loader" style = "text-align :center;"></div> 
<script type="text/javascript">
    var timeleft = 8;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0)
        clearInterval(downloadTimer);
    },800);
</script>
<p align = "center" > If you are not redirected <a href= "index.php">Click here</a> </p> <p align = "center" >to go back to the home page.</p>
<footer class = "container-fluid">
    <p align = "center" >Certified by diStaxs </p>
</footer>
</body>
</html>
</html>