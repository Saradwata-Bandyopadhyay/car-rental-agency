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
include('connect.php');
if($_SERVER["REQUEST_METHOD"]=="POST")
{
$vn=$_POST['vehiclenumber'];
$days=$_POST['days'];
$sql="UPDATE `car_details` SET `days` = '$days', `cname` = '$_SESSION[username]' WHERE `car_details`.`vehiclenumber` LIKE '$vn'";
$result=mysqli_query($conn,$sql);
if($result)
$showAlert=true;
else $showError="Process Failed.";
}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard of <?php echo $_SESSION['username']?></title>
    <meta content="CRA customer Dashboard" name="description">
    <link href="resources/favicon.png" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body class="d-flex flex-column min-vh-100">
 <?php 
 require 'nav.php'
 ?>
 <?php
 if($showAlert)
    {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success !</strong> Car rented successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    if($showError)
    {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error !</strong> '.$showError.'
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
  <h1 align=center style="color:darkorchid;">Dashboard of <?php echo $_SESSION['username']?></h1><br>
  <h3 align=center style="color:darkorchid;">Available cars to rent</h3><br>
  <div class="container mx-auto">
<?php
$sql = "SELECT * FROM `car_details` WHERE `cname` IS NULL";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    echo 'result error: '. mysqli_connect_error();
}  
$code =mysqli_fetch_all($result, MYSQLI_ASSOC);
if($code == NULL)
echo '<h3 align=center style="color:black;">No Car avaiable to Rent</h3><br>';
else
{
echo '
<table class="table table-hover table-bordered">
  <thead>
    <tr class="text-center">
      <th scope="col">Vehicle Model</th>
      <th scope="col">Vehicle Number</th>
      <th scope="col">Seating Capacity</th>
      <th scope="col">Rent per Day</th>
      <th scope="col">Enter Days</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>';
  foreach($code as $code) :
echo '<tr class="text-center">';
   echo '<td>'.$code['vehiclemodel'].'</td>';
   echo '<td>'.$code['vehiclenumber'].'</td>';
   echo '<td>'.$code['seatingcapacity'].'</td>';
   echo '<td>'.$code['rentperday'].'</td>';
   echo '<form action="index.php" method="post">';
   echo '<td><input type="number" id="days" name="days" min="1" max="30"></td>';
   echo '<input type="hidden" id="vehiclenumber" name="vehiclenumber" value="'.$code['vehiclenumber'].'">';
   echo '<td><button type="submit">Rent Now</button></td>';
   echo '</form>';
echo '</tr>';
   endforeach;
   echo '</tbody>
   </table>';
mysqli_free_result($result);
}
?>
</div>
<h3 align=center style="color:darkorchid;">Rented Cars</h3><br>
<div class="container mx-auto">
<?php
$sql = "SELECT * FROM `car_details` WHERE `cname` LIKE '$_SESSION[username]'";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    echo 'result error: '. mysqli_connect_error();
}  
$code =mysqli_fetch_all($result, MYSQLI_ASSOC);
if($code == NULL)
echo '<h3 align=center style="color:black;">No Car Rented</h3><br>';
else
{
echo '
<table class="table table-hover table-bordered">
  <thead>
    <tr class="text-center">
      <th scope="col">Vehicle Model</th>
      <th scope="col">Vehicle Number</th>
      <th scope="col">Seating Capacity</th>
      <th scope="col">Rent per Day</th>
      <th scope="col">Rented Days</th>
      <th scope="col">Total Cost</th>
    </tr>
  </thead>
  <tbody>';
  foreach($code as $code) :
echo '<tr class="text-center">';
   echo '<td>'.$code['vehiclemodel'].'</td>';
   echo '<td>'.$code['vehiclenumber'].'</td>';
   echo '<td>'.$code['seatingcapacity'].'</td>';
   echo '<td>'.$code['rentperday'].'</td>';
   echo '<td>'.$code['days'].'</td>';
   echo '<td>'.$code['rentperday']*$code['days'].'</td>';
echo '</tr>';
   endforeach;
   echo '</tbody>
   </table><br><br>';
mysqli_free_result($result);
mysqli_close($conn); 
}
?>
</div> 
<?php include('footer.php'); ?>
  </body>
</html>