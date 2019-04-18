<!DOCTYPE html>
<html lang="en">
<head>
  <title>MENESIŲ DUOMENYS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<?php

try 
{
    $con = new PDO('mysql:host=localhost;dbname=Auto1', 'root', 'mysql');     
        
    $Select1 = $con->prepare('SELECT YEAR(date) AS Periodas_metai,
                                    COUNT(*) AS Irasu_kiekis,
                                    ROUND(MAX(distance/time)) AS MAX_greitis,
                                    ROUND(MIN(distance/time)) AS MIN_greitis,
                                    ROUND(AVG(distance/time)) AS AVG_greitis
                                FROM radars 
                                GROUP BY YEAR(date);');
    $Select1->execute();
  
}
catch(PDOException $e) {
    die('klaida');
}

echo "<br>";
echo "<table border=\"1\" style=\"border-collapse: collapse; border-spacing: 0;\">\n";
echo "<thead style=\"text-align: center; background: lightgray; padding: 10px 10px 10px 10px;\">
<tr>
    <th style=\"padding: 10px 10px 10px 10px;\" >Metu Periodas</th>
    <th style=\"padding: 10px 10px 10px 10px;\" >Irasu kiekis</th>
    <th style=\"padding: 10px 10px 10px 10px;\" >Max greitis</th>
    <th style=\"padding: 10px 10px 10px 10px;\" >Min greitis</th>
    <th style=\"padding: 10px 10px 10px 10px;\" >Vidutinis greitis</th>
</tr>
</thead>\n";

foreach ($Select1->fetchAll() as $row) {
    echo '<tr>';
    echo '<td>' . $row["Periodas_metai"] . '</td>';
    echo '<td>' . $row["Irasu_kiekis"] . '</td>';
    echo '<td>' . $row["MAX_greitis"] . '</td>';
    echo '<td>' . $row["MIN_greitis"] . '</td>';
    echo '<td>' . $row["AVG_greitis"] . '</td>';
    echo '<tr>';
}

echo '</table>';
?>

<br>
<button><a class="btn" href="index.php">Gryžti atgal</a></button> 