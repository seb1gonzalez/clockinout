<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'clockinout');

$toReturn = array();

//ipad is 129.108.202.162, as well as other in utep secure

//getters
$id = $_GET['id'];//id
$ip = $_GET['ip'];//ip
$info = $_GET['info'];//info

//insert to db
//done

array_push($toReturn, $id);
array_push($toReturn, $ip);
array_push($toReturn, $info);


header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();
?>
