<!DOCTYPE html>
<html lang="en">
<head>
  <title>PAKEISTI DUOMENIS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<br>
PAKEISTI DUOMENIS: <br>
<br>
<?php

if($_SERVER['QUERY_STRING'] !== "")
    echo "<form action=\"update.php?" . $_SERVER['QUERY_STRING'] ."\", method=\"post\">";
else 
    echo "<form action=\"update.php\", method=\"post\">";

?>
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
        <button type="submit" class="btn btn-danger" name="done">Update</button>
        <a class="btn" href="index.php">Back</a>
    </div>
</form>



<?php
$id = explode("=", $_SERVER['QUERY_STRING'])[1];

try {
    $con = new PDO('mysql:host=localhost;dbname=Auto1', 'root', 'mysql');
    if (isset($_POST['done'])) {
        $date = $_POST['date'];
        $number = $_POST['number'];
        $distance = $_POST['distance'];
        $time = $_POST['time'];

        $select = $con->prepare("SELECT * FROM radars WHERE id = :id");
        $select->bindParam(':id', $id);
        $select->execute();


        $update = $con->prepare("UPDATE radars 
                                    SET date = :date, 
                                        number = :number,
                                        distance = :distance, 
                                        time = :time 
                                    WHERE id = :id");

        $update->bindParam(':id', $id);
        $update->bindParam(':date', $date);
        $update->bindParam(':number', $number);
        $update->bindParam(':distance', $distance);
        $update->bindParam(':time', $time);
        $update->execute();

        header('Location: index.php');

        if($update) {
            echo 'Data Updated';
        } else {
            echo 'ERROR Data Not Updated';
        }
    }
}
catch(PDOException $e){
    die('klaida');
}
