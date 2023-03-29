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
if(isset($_GET["slno"]))
{
$_SESSION['sl']=$_GET['slno'];
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
$vm=$_POST['vehiclemodel'];
$vn=$_POST['vehiclenumber'];
$sc=$_POST['seatingcapacity'];
$rpd=$_POST['rentperday'];
$fl=$_POST['flag'];
if($fl==1)
{
$sql="INSERT INTO `car_details` (`slno`, `vehiclemodel`, `vehiclenumber`, `seatingcapacity`, `rentperday`, `days`, `cname`) VALUES (NULL, '$vm', '$vn', '$sc', '$rpd', NULL, NULL)";
$result=mysqli_query($conn,$sql);
if($result)
$showAlert=true;
else $showError="Process Failed.";
}
else
{
$sql="SELECT slno FROM `car_details` WHERE `vehiclenumber` LIKE '$vn'";
$result=mysqli_query($conn,$sql);
$code =mysqli_fetch_all($result, MYSQLI_ASSOC);
$sl=$code[0]['slno'];
$sql1="UPDATE `car_details` SET `vehiclemodel` = '$vm', `vehiclenumber` = '$vn', `seatingcapacity` = '$sc', `rentperday` = '$rpd' WHERE `car_details`.`slno` = '$sl'";
$result1=mysqli_query($conn,$sql1);
if($result1)
$showAlert=true;
else $showError="Process Failed.";
}
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
    <link href="../resources/favicon.png" rel="icon" type="image/x-icon">
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
  <strong>Success !</strong> Data added successfully.
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
  <div class="container mx-auto">
  <?php
  $sql = "SELECT * FROM `car_details`";
  $result = mysqli_query($conn, $sql);
  if(!$result)
  {
      echo 'result error: '. mysqli_connect_error();
  }  
  $code =mysqli_fetch_all($result, MYSQLI_ASSOC);
  echo '
  <table class="table table-hover table-bordered" id="datatable">
    <thead>
      <tr class="text-center">
        <th scope="col">Vehicle Model</th>
        <th scope="col">Vehicle Number</th>
        <th scope="col">Seating Capacity</th>
        <th scope="col">Rent per Day</th>
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
     echo '<form action="addcar.php" method="get">';
     echo '<input type="hidden" id="slno" name="slno" value="'.$code['slno'].'">';
     echo '<td><button type="submit">Edit</button></td>';
     echo '</form>';
  echo '</tr>';
     endforeach;
     echo '</tbody>
     </table>';
  mysqli_free_result($result);
  ?>
</div>
<h3 align=center style="color:darkorchid;">Add Car data</h3><br>
<div class="container mx-auto">
<?php
echo '
<table class="table table-hover table-bordered">
  <thead>
    <tr class="text-center">
      <th scope="col">Vehicle Model</th>
      <th scope="col">Vehicle Number</th>
      <th scope="col">Seating Capacity</th>
      <th scope="col">Rent per Day</th>
    </tr>
  </thead>
  <tbody>';
echo '<tr class="text-center">';
echo '<form action="addcar.php" method="post">';
echo '<td><input type="text" id="vehiclemodel" name="vehiclemodel"></td>';
echo '<td><input type="text" id="vehiclenumber" name="vehiclenumber"></td>';
echo '<td><input type="text" id="seatingcapacity" name="seatingcapacity"></td>';
echo '<td><input type="text" id="rentperday" name="rentperday"></td>';
echo '<input type="hidden" id="flag" name="flag" value="1">';
echo '<td><button type="submit">Submit Entry</button></td>';
echo '</form>';
   echo '</tr>';
   echo '</tbody>
   </table><br>';
?>
</div>
<h3 align=center style="color:darkorchid;">Edit Car data</h3><br>
<div class="container mx-auto">
<?php
if(isset($_GET["slno"]))
{
  $sql = "SELECT * FROM `car_details` WHERE `slno` LIKE '$_SESSION[sl]'";
  $result = mysqli_query($conn, $sql);
  if(!$result)
  {
      echo 'result error: '. mysqli_connect_error();
  }  
  $code =mysqli_fetch_all($result, MYSQLI_ASSOC);
echo '
<table class="table table-hover table-bordered">
  <thead>
    <tr class="text-center">
      <th scope="col">Vehicle Model</th>
      <th scope="col">Vehicle Number</th>
      <th scope="col">Seating Capacity</th>
      <th scope="col">Rent per Day</th>
    </tr>
  </thead>
  <tbody>';
echo '<tr class="text-center">';
echo '<form action="addcar.php" method="post">';
echo '<td><input type="text" id="vehiclemodel" name="vehiclemodel" value="'.$code[0]['vehiclemodel'].'"></td>';
echo '<td><input type="text" id="vehiclenumber" name="vehiclenumber" value="'.$code[0]['vehiclenumber'].'"></td>';
echo '<td><input type="text" id="seatingcapacity" name="seatingcapacity" value="'.$code[0]['seatingcapacity'].'"></td>';
echo '<td><input type="text" id="rentperday" name="rentperday" value="'.$code[0]['rentperday'].'"></td>';
echo '<input type="hidden" id="flag" name="flag" value="2">';
echo '<td><button type="submit">Update Data</button></td>';
echo '</form>';
   echo '</tr>';
   echo '</tbody>
   </table>';
}
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
      </tr>
    </thead>
    <tbody>';
  echo '<tr class="text-center">';
  echo '<form action="addcar.php" method="post">';
  echo '<td><input type="text" id="vehiclemodel" name="vehiclemodel"></td>';
  echo '<td><input type="text" id="vehiclenumber" name="vehiclenumber"></td>';
  echo '<td><input type="text" id="seatingcapacity" name="seatingcapacity"></td>';
  echo '<td><input type="text" id="rentperday" name="rentperday"></td>';
  echo '<input type="hidden" id="flag" name="flag" value="2">';
  echo '<td><button type="submit">Update Data</button></td>';
  echo '</form>';
     echo '</tr>';
     echo '</tbody>
     </table>';
}
   echo '<br><br>';
   mysqli_free_result($result);
   mysqli_close($conn);
?>
</div>
<?php include('footer.php'); ?>
  </body>
</html>