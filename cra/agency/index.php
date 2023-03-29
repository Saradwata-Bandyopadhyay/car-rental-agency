<?php
session_start();
$showAlert=false;
$showError=false;
if(!isset($_SESSION['loggedin'])|| $_SESSION['loggedin']!=true)
{
header("location: login.php");
exit;
}
else
{
include('../connect.php');
$sql = "SELECT * FROM `car_details`";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    echo 'result error: '. mysqli_connect_error();
}  
$code =mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard for <?php echo $_SESSION['username']?></title>
    <meta content="CRA customer Dashboard" name="description">
    <link href="../resources/favicon.png" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body class="d-flex flex-column min-vh-100">
 <?php 
 require 'nav.php'
 ?>
  <h1 align=center style="color:darkorchid;">Dashboard for <?php echo $_SESSION['username']?></h1><br>
  <div class="container mx-auto" id="ddata">
  </div>
  <script>
$(document).ready(function()
  {
    setInterval(function()
    {
        $.ajax({
            url: 'rented.php',
            success: function(data) 
            {
                $('#ddata').html(data);
            }
        });
    }, 1000);
});
</script>
<br><br>
<?php include('footer.php'); ?>
  </body>
</html>