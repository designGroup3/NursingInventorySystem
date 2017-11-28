<?php

$conn = mysqli_connect("localhost", "root", "Rottman3", "loginsystem");

if (!$conn){
	die("Connection Failed: ".mysqli_connect_error());
}

?>