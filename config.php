<?php
session_start();
$host = "localhost"; 
$user = "root";
$password = "root";
$dbname = "sales1_db";

$con = mysqli_connect($host, $user, $password, $dbname);

if(!$con) {
	die("connection failed: " . mysqli_connect_error());
}