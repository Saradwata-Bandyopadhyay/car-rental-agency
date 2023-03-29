<?php 
$login=false;
$showError=false;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
include 'connect.php';
$username=$_POST["username"];
$password=$_POST["password"];
$sql="SELECT * FROM `users` WHERE `username` LIKE '$username'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
if($num == 1)
{
while($row=mysqli_fetch_assoc($result))
{
if(password_verify($password,$row['password']))
{
$login=true;
session_start();
$_SESSION['loggedin']=true;
$_SESSION['username']=$username;
header("location: index.php");
}
else {$showError="Invalid Credentials";}
}
}
else {$showError="Record not found";}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login to CRA</title>
    <link href="resources/favicon.png" rel="icon" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body class="d-flex flex-column min-vh-100">
    <?php require 'nav.php' ?>
    <?php 
    if($login)
    {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success !</strong> You are logged in.
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
    <h1 class="text-center mt-4">Login to CRA Dashboard</h1>
    <div class="container d-flex justify-content-center my-auto">
    <form action="login.php" method="post">
  <div class="form-group col-md-12 mb-4">
    <label for="username" class="form-label">User name</label>
    <input type="text" class="form-control form-control-lg" id="username" name="username" aria-describedby="emailHelp">
  </div>
  <div class="form-group col-md-12 mb-4">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control form-control-lg" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary col-md-6">Login</button>
</form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>