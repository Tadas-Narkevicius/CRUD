<!DOCTYPE html>
<html lang="en">
<head>
  <title>PRIDETI DUOMENIS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<br>
PRIDETI DUOMENIS: <br>
<br>
<form action="add.php", method="post">
   Greicio fiksavimo data ir laikas:<br>
   <input type="datetime-local" name="date" required><br> <br>
   Automobilio numeris:<br>
   <input type="text" name="number" required><br> <br>
   Nuvaziuotas atstumas metrais:<br>
   <input type="number" name="distance" required><br> <br>
   Sugaistas laikas sekundemis:<br>
   <input type="number" name="time" required><br>
   <br> 
    <div class="form-actions">
        <button type="submit" class="btn btn-danger" name="done">Add</button>
        <a class="btn" href="index.php">Back</a>
    </div>
</form>



<?php
try
{
    $con = new PDO('mysql:host=localhost;dbname=Auto1', 'root', 'mysql');

    if(isset($_POST['done']))
    {
        $date = $_POST["date"];
        $number = $_POST["number"];
        $distance = $_POST["distance"];
        $time = $_POST["time"];

        $insert = $con->prepare('INSERT INTO radars (date, number, distance, time) 
                                    VALUES (:date, :number, :distance, :time)');

        $insert->bindParam(':date', $date);
        $insert->bindParam(':number', $number);
        $insert->bindParam(':distance', $distance);
        $insert->bindParam(':time', $time);

        $insert->execute();

        header('Location: index.php');
    }
}
catch(PDOException $e)
{
    die('klaida');
}


