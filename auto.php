<!DOCTYPE html>
<html lang="en">
<head>
  <title>AUTOMOBILIŲ DUOMENYS</title>
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

    $results_per_page = 5;

    $statementSelect = $con->prepare("SELECT COUNT(*) FROM radars;");
    $statementSelect->execute();

    $count_of_records = $statementSelect->fetchAll()[0]['COUNT(*)'];

    $count_of_pages = ceil($count_of_records / $results_per_page);

    if(!isset($_GET['page']) || $_GET['page'] <= 0){
        $page = 1;
    }elseif($_GET['page'] > $count_of_pages){
        $page = $count_of_pages;
    }else{
        $page = $_GET['page'];
    }

    $this_page_first_result = ($page-1) * $results_per_page;

}
catch(PDOException $e) {
    die('klaida');
}

echo "<br>";
echo "<table border=\"1\" style=\"border-collapse: collapse; border-spacing: 0;\">\n";
echo "<thead style=\"text-align: center; background: lightgray; padding: 10px 10px 10px 10px;\">
<tr>
    <th style=\"padding: 10px 10px 10px 10px;\" >Numeris</th>
    <th style=\"padding: 10px 10px 10px 10px;\" >Kiekis</th>
    <th style=\"padding: 10px 10px 10px 10px;\" >Max greitis</th>
</tr>
</thead>\n";

$statementSelect = $con->prepare("SELECT number, 
                                    COUNT(*) AS kiekis, 
                                    round(MAX(distance/time),2) AS greitis 
                                FROM radars 
                                GROUP BY number
                                LIMIT " . $this_page_first_result . ", " . $results_per_page . ";");
$statementSelect->execute();

foreach ($statementSelect->fetchAll() as $row) {
echo '<tr>';
echo '<td>' . $row["number"] . '</td>';
echo '<td>' . $row["kiekis"] . '</td>';
echo '<td>' . $row["greitis"] . '</td>';
echo '<tr>';

}

echo '</table>';
echo "<br>";
echo "<button><a href=auto.php?page=" . ($page-1) . ">Previuos</a></button>";

$number = 1;
for($number; $number <= $count_of_pages; $number +=1){
    if($page==$number){
        echo "<b> " . " " . "[$number]" . " " . "</b>";
    }else{
        echo "<a href='?page=$number'>$number</a> ";
    }
}

echo "<button><a href=auto.php?page=" . ($page+1). ">Next</a></button>";

?>
<br>
<br>
<button><a class="btn" href="index.php">Grįžti atgal</a></button> 



