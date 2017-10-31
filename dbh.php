<?php

$conn = mysqli_connect("localhost", "root", "Rottman", "loginsystem");

if (!$conn){
	die("Connection Failed: ".mysqli_connect_error());
}

?>