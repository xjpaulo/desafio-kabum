<?php
$host_db="localhost:3306/";
$user="admin";
$pwd="kabum123"; 
$db="desafio";
//$con = mysqli_connect($host_db,$user,$pwd) or die (mysql_error());
$conn = new mysqli($host_db,$user,$pwd,$db);
//mysqli_select_db($db);
mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, 'SET character_set_connection=utf8');
mysqli_query($conn, 'SET character_set_client=utf8');
mysqli_query($conn, 'SET character_set_results=utf8');
?>

