<?php

$first_date = $_GET["first_date"];
$second_date = $_GET["second_date"];

try{
  require "connection.php";
  $stmt = $dbh->prepare("SELECT name, date, director FROM film WHERE date between :first_date AND :second_date");
  $stmt->bindParam(":first_date", $first_date);
  $stmt->bindParam(":second_date", $second_date);
  $stmt->execute();
  $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC);
  header('Content-Type: application/json');
  echo json_encode($cursor);
} catch (PDOException $ex) {
  echo $ex->getMessage(); 
}

?>