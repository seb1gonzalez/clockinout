<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

$conn = mysqli_connect('ctis.utep.edu', 'ctis', '19691963', 'clockinout');

$toReturn = array();

//ipad is 129.108.202.162, as well as other in utep secure

function fetchAll($r){
    $temp = array();
    while($row = mysqli_fetch_assoc($r)){
        $temp[] = $row;
    }
    return $temp;
}

$query = "select * from exterior_logs join employees where exterior_logs.id = pin";
$result = mysqli_query($conn, $query);
$result = fetchAll($result);

$toReturn = $result;

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();
?>
