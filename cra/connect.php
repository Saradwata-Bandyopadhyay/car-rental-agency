<?php
$conn = mysqli_connect('localhost','root','', "cra");
	if(!$conn)
	{
		echo 'Connection error: '. mysqli_connect_error();
	}
?>