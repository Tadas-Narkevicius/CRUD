<!DOCTYPE html>
<html lang="en">
<head>
  <title>ATSPAUZDINTI DUOMENYS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<div>

<br>
<p><a href="add.php" class="btn btn-success">Create</a></p>               

<?php

try {
    $con = new PDO('mysql:host=localhost;dbname=Auto1', 'root', 'mysql');     
}
catch(PDOException $e) {
    die('klaida');
}

$results_per_page = 10;

$statementSelect = $con->prepare("SELECT count(*) FROM radars;");

$statementSelect->execute();

$count_of_records = $statementSelect->fetch()['count(*)'];

$count_of_pages = ceil($count_of_records / $results_per_page);

if(!isset($_GET['page']) || $_GET['page'] <= 0){
    $page = 1;
}elseif($_GET['page'] > $count_of_pages){
    $page = $count_of_pages;
}else{
    $page = $_GET['page'];
}

$this_page_first_result = ($page-1) * $results_per_page;

echo "<table border=\"1\" style=\"border-collapse: collapse; border-spacing: 0;\">\n";
echo "<thead style=\"text-align: center; background: lightgray; padding: 10px 10px 10px 10px;\">
    <tr>
        <th style=\"padding: 10px 10px 10px 10px;\" >Nr.</th>
        <th style=\"padding: 10px 10px 10px 10px;\" >Data ir laikas</th>
        <th style=\"padding: 10px 10px 10px 10px;\" >Automobilio numeris</th>
        <th style=\"padding: 10px 10px 10px 10px;\">Nuvažiuotas atstumas metrais</th>
        <th style=\"padding: 10px 10px 10px 10px;\">Sugaištas laikas sekundėmis</th>
        <th style=\"padding: 10px 10px 10px 10px;\">Vairuotojas</th>
        <th>Nuorodos</th>
    </tr>
    </thead>\n";

$statementSelect = $con->prepare("SELECT radars.id, radars.date, radars.number, radars.distance, radars.time, drivers.name 
                            FROM radars
                            LEFT JOIN drivers ON radars.driver_Id = drivers.driver_Id
                            LIMIT " . $this_page_first_result . "," . $results_per_page . ";");

$statementSelect->execute();

foreach ($statementSelect->fetchAll() as $row) {
    echo '<tr>';
    echo '<td style="text-align: center;" >' . $row["id"] . '</td>';
    echo '<td style="text-align: center;" >' . $row["date"] . '</td>';
    echo '<td style="text-align: center;">' . $row["number"] . '</td>';
    echo '<td style="text-align: center;">' . $row["distance"] . '</td>';
    echo '<td style="text-align: center;">' . $row["time"] . '</td>';
    echo '<td style="text-align: center;">' . $row["name"] . '</td>';
    echo '<td style="text-align: center; width=250; padding: 10px 10px 10px 10px;" >';
    echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
    echo ' ';
    echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
    echo ' ';
    echo '<a class="btn btn-primary" href="assign_driver.php?id='.$row['id'].'">Priskirti vairuotoją</a>';
    echo '</td>'; 
}
echo '</table>';
?>

<?php
echo "<br>";
echo "<button><a href=index.php?page=" . ($page - 1) . ">Previuos</a></button>";

$number = 1;
for($number; $number <= $count_of_pages; $number +=1){
    if($page== $number){
        echo "<b> " . " " . "[$number]" . " " . "</b>";
    }else{
        echo "<a href='?page=$number'>$number</a> ";
    }
}

echo "<button><a href=index.php?page=" . ($page + 1) . ">Next</a></button>";
?>

<br>
<br>
<style>
    #outer
    {
        width:50%;
        text-align: center;
    }
    .btn 
    {
        display: inline-block;      
    } 
</style>

<div id="outer">   
    <button type="button" class="btn"><a href="auto.php">Automobiliai</a></button>
    
    <button type="button" class="btn"><a href="month.php">Menuo</a></button>
    
    <button type="button" class="btn"><a href="years.php">Metai</a></button>
</div> 
<?php

