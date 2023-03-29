<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Available Cars to Rent</title>
    <meta content="Available Cars to Rent" name="description">
    <link href="resources/favicon.png" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
<body>
 <?php require 'nav.php' ?>
  <h1 align=center style="color:darkorchid;">Available Cars to Rent</h1><br>
  <div class="container mx-auto" id="ddata">
  </div>
  <script>
$(document).ready(function()
  {
    setInterval(function()
    {
        $.ajax({
            url: 'availabledata.php',
            success: function(data) 
            {
                $('#ddata').html(data);
            }
        });
    }, 1000);
});
</script>
<div class="text-center"><button class="btn btn-success" onclick="window.location.href='index.php'">Rent Now</button></div>
<?php include('footer.php'); ?>
  </body>
</html>