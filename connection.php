<?php 
try{
  $host = 'localhost';
  $dbname = 'lb_pdo_films';
  $username = 'root';
  $password = '';

  $dbh = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
} catch (PDOException $ex) {
  echo $ex->getMessage(); 
}
?>