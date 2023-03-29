<?php 
$showAlert=false;
$showError=false;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
include 'connect.php';
$username=$_POST["username"];
$password=$_POST["password"];
$cpassword=$_POST["cpassword"];
$existSql="SELECT * FROM `users` WHERE `username` LIKE '$username'";
$result=mysqli_query($conn,$existSql);
$numExistRows=mysqli_num_rows($result);
if($numExistRows)
{$showError="Username is in use , Please use something else.";}
else {
if($password==$cpassword)
{
$hash=password_hash($password,PASSWORD_DEFAULT);
$sql="INSERT INTO `users` (`slno`, `username`, `password`, `accountdate`) VALUES (NULL, '$username', '$hash', current_timestamp())";
$result=mysqli_query($conn,$sql);
if($result)
{$showAlert=true;}
}
else {$showError="Passwords do not match.";}
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup to CRA</title>
    <link href="resources/favicon.png" rel="icon" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body class="d-flex flex-column min-vh-100">
    <?php require 'nav.php' ?>
    <?php 
    if($showAlert)
    {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success !</strong> Your account is now created and you can login.
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
    <h1 class="text-center mt-4">Signup to CRA</h1>
    <div class="container d-flex justify-content-center my-auto">
    <form action="signup.php" method="post">
  <div class="form-group col-md-12 mb-4">
    <label for="username" class="form-label">User name</label>
    <input type="text" maxlength="10" class="form-control form-control-lg" id="username" name="username" aria-describedby="emailHelp">
  </div>
  <div class="form-group col-md-12 mb-4">
    <label for="password" class="form-label">Password</label>
    <input type="password" maxlength="10" class="form-control form-control-lg" id="password" name="password">
  </div>
  <div class="form-group col-md-12 mb-4">
    <label for="cpassword" class="form-label">Confirm Password</label>
    <input type="password" maxlength="10" class="form-control form-control-lg" id="cpassword" name="cpassword">
    <div id="emailHelp" class="form-text">Make sure to type the same password.</div>
  </div>
  <button type="submit" class="btn btn-primary col-md-6">Signup</button>
</form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>