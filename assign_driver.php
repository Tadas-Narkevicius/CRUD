<!DOCTYPE html>
<html lang="en">
<head>
    <title>PRIDETI VAIRIUOTOJĄ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $con = new PDO('mysql:host=localhost;dbname=Auto1', 'root', 'mysql');

        if(isset($_POST['vairuotojo_id'])){
            $selected_driver = $_POST['vairuotojo_id']; 
        }

        $radar_event_id = explode("=", $_SERVER['QUERY_STRING'])[1];

        if($radar_event_id !== ""){
            $update = $con->prepare('UPDATE radars ' . 
                                    'SET driver_Id = ' . $selected_driver . ' ' .
                                    'WHERE id = ' . $radar_event_id . ';');
            $update->execute();
            header("Location: index.php");
            exit;

        }
    } catch(PDOException $e){
        die('klaida');
    }

} else { 
       
    try {
        $con = new PDO('mysql:host=localhost;dbname=Auto1', 'root', 'mysql');
        $all_drivers = $con->prepare('SELECT * FROM drivers;');
        $all_drivers->execute();

        echo "<form action=\"assign_driver.php?" . $_SERVER['QUERY_STRING'] ."\", method=\"post\">"; 
            echo "<table style=\"text-align: center\" border=\"1\" text-align: \"center\" >";
            echo "<tr>\n\t<th>Driver ID</th>\n\t<th>Name</th><th>City</th><th>Pasirinkti</th>\n</tr>";

            while ($row = $all_drivers->fetchAll()) {
                foreach($row as $driver){
                    echo "<tr>\n\t" . 
                            "<td style=\"text-align:center\">" . $driver['driver_Id'] . "</td>\n\t" .
                            "<td style=\"text-align:center\">" . $driver['name'] . "</td>\n\t" .
                            "<td style=\"text-align:center\">" . $driver['city'] . "</td>\n\t" .
                            "<td style=\"text-align:center\">" . 
                            "<input type=\"radio\" name=\"vairuotojo_id\" value=\"" . $driver['driver_Id'] . "\"/>" . "</td>\n" .
                        "</tr>";
                }
            }
            echo "</table>";
            echo "<br>";
            echo "<button class=\"btn btn-danger\" type=\"submit\" value=\"Selected_Values\" name=\"Priskirti\">Siųsti</button>";
        echo "</form>";

    } catch(PDOException $e){
        die('klaida');
    }
}
echo "The query string is: ".$_SERVER['QUERY_STRING'];
?>

<br>
<a class="btn btn-primary" href='index.php' role="button">Gryžti atgal.</a>


