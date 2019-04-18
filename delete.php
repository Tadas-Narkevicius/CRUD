<!DOCTYPE html>
<html lang="en">
<head>
    <title>IŠTRINTI DUOMENIS</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<?php

if($_SERVER['QUERY_STRING'] !== "")
    echo "<form action=\"delete.php?" . $_SERVER['QUERY_STRING'] ."\", method=\"post\">";
else 
    echo "<form action=\"delete.php\", method=\"post\">";

?>
<body>
    <div class="container">
     
        <div class="span10 offset1">
            <div class="row">
                <h3>Delete a data</h3>
            </div>
                
            <form class="form-horizontal" action="delete.php" method="post">  
                <p class="alert alert-error">Are you sure to delete ?</p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-danger"  name="done" >Yes</button>
                    <a class="btn" href="index.php">No</a>
                </div>
            </form>
        </div> 
                 
    </div> 
  </body>
</html>

<?php

$id = explode("=", $_SERVER['QUERY_STRING'])[1];

try{
    $con = new PDO('mysql:host=localhost;dbname=Auto1', 'root', 'mysql');
}

catch(PDOException $e){
    die('klaida');
}

if (isset ($_POST['done']))
{
    $insert = $con->prepare("DELETE FROM radars WHERE id=$id");

    $insert->execute();
    header("location:index.php");
}










