<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'clockinout');

//$toReturn = array();

//ipad is 129.108.202.162, as well as other in utep secure

//getters
//ip
//id


//insert to db
//done

header('Content-Type: application/json');
//echo json_encode($toReturn);
$conn->close();
?>