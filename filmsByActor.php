<?php
$actorId = $_GET["ID_Actor"];
try {
    require "connection.php";
    $stmt = $dbh->prepare("SELECT name, date, country FROM film JOIN film_actor ON ID_FILM = FID_FILM WHERE FID_ACTOR = :actorId");
    $stmt->bindParam(":actorId", $actorId);
    $stmt->execute();
    $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo "<films>";
    foreach ($cursor as $item) {
        echo "<film>" . htmlspecialchars($item['name']) . "</film>";
        echo "<film>" . $item['date'] . "</film>";
        echo "<film>" . $item['country'] . "</film>";
    }
    echo "</films>";
} catch (PDOException $ex) {
    echo $ex->getMessage(); 
}
?>