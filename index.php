<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ЛР3</title>
</head>
<script>
  const ajax = new XMLHttpRequest();
  

  function getText() {
    const genreId = document.getElementById("ID_Genre").value;
    ajax.onreadystatechange = function() {
    if (ajax.readyState === 4 && ajax.status === 200) {
      document.getElementById("resultText").innerHTML = ajax.responseText;
    }
  };
  ajax.open('GET', 'filmsByGenre.php?ID_Genre=' + genreId);
  ajax.send();
  }

  function getXML() {
    let output = "";
    const actorId = document.getElementById("ID_Actor").value;
    ajax.onreadystatechange = function() {
    if (ajax.readyState === 4 && ajax.status === 200) {
      let node = ajax.responseXML.getElementsByTagName("film");
      for (i = 0; i < node.length; i += 3) {
        output += "<li>" + node[i].childNodes[0].nodeValue + " " +  node[i + 1].childNodes[0].nodeValue + " " + node[i + 2].childNodes[0].nodeValue + " " + "</li>" + "<hr>";
      }
      document.getElementById("resultXML").innerHTML = output;
    }
  };
  ajax.open('GET', 'filmsByActor.php?ID_Actor=' + actorId);
  ajax.send();
  }

  function getJSON() {
    let output = "";
    const firstDate = document.getElementById("first_date").value;
    const secondDate = document.getElementById("second_date").value;
    ajax.onreadystatechange = function() {
    if (ajax.readyState === 4 && ajax.status === 200) {
      const responseJSON = JSON.parse(ajax.responseText);
      for (let i = 0; i < responseJSON.length; i++) {
        output += "<li>" + responseJSON[i].name + " " + responseJSON[i].date + " " +  responseJSON[i].director + "</li>" + "<hr>";
      }
      document.getElementById("resultJSON").innerHTML = output;
    }
  };
  ajax.open('GET', 'filmsByDate.php?first_date=' + firstDate + "&second_date=" + secondDate);
  ajax.send();
  }
</script>
<body>
  <?php
    require_once "connection.php"; 
  ?>
  
  Список фільмів обраного жанру
  <select id="ID_Genre">
    <?php
      $stmt = $dbh->prepare("SELECT * from genre ORDER BY ID_Genre ASC");
      $stmt->execute(); 
      $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC); 
      foreach ($cursor as $item) {
        echo "<option value=" . $item["ID_Genre"] . ">" . $item["title"] . "</option>";
      }
    ?>
  </select>
  <input type="submit" value="Обрати" onclick="getText()">
  <div id="resultText"></div>

  Список фільмів з обраним актором
  <select id="ID_Actor">
    <?php
      $stmt = $dbh->prepare("SELECT * from actor ORDER BY ID_Actor ASC");
      $stmt->execute(); 
      $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC); 
      foreach ($cursor as $item) {
        echo "<option value=" . $item["ID_Actor"] . ">" . $item["name"] . "</option>";
      }
    ?>
  </select>
  <input type="submit" value="Обрати" onclick="getXML()">
  <div id="resultXML"></div>

  Список фільмів за вказаний часовий інтервал
  <input type="date" id="first_date" name="first_date" value="2009-09-09">
  <label for="second_date">Друга дата</label>
  <input type="date" id="second_date" name="second_date" value="2014-09-01">
  <input type="submit" value="Обрати" onclick="getJSON()">
  <div id="resultJSON"></div>
</body>
</html>