<?php 

$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'livro';

$connection= mysqli_connect($hostname,$username,$password,$dbname);
mysqli_set_charset($connection,"utf8");
if(!$connection){
         die("database connection failed:".mysqli_connect_error()); 
}
