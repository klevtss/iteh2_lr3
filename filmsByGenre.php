<?php

$genreId = $_GET["ID_Genre"];

try{
  require "connection.php";
  $stmt = $dbh->prepare("SELECT name, date, country FROM film JOIN film_genre ON ID_FILM = FID_FILM WHERE FID_GENRE = :genreId");
  $stmt->bindParam(":genreId", $genreId);
  $stmt->execute();
  $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC);
  header('Content-Type: text/plain');
  foreach ($cursor as $item) {
    echo "<li>" . $item["name"] . " " . $item["date"] . " " . $item["country"] . "</li>";
    echo "<hr>";
  }
} catch (PDOException $ex) {
  echo $ex->getMessage(); 
}

?>