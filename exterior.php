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

//getters
$id = $_GET['id'];
$ip = $_GET['ip'];
$info = $_GET['info'];

$id = (int) $id;
$ip = (string) $ip;
$info = (string) $info;

$query = "insert into exterior_logs (id, ip, info) values($id, '$ip', '$info')";
$toReturn['query'] = $query;
$result = mysqli_query($conn, $query);
$toReturn['result'] = $result;

//get most recent date = $d
$query = "select exterior_logs.date from exterior_logs order by date desc limit 1";
$result = mysqli_query($conn, $query);
$result = fetchAll($result);
$d = $result[0]['date'];

$query = "update exterior_logs set exterior_logs.date = date_sub(exterior_logs.date, interval 1 second) where id = $id and exterior_logs.date = '$d'";
$toReturn['query'] = $query;
$result = mysqli_query($conn, $query);
$toReturn['result'] = $result;

$query = "update logs set logs.exterior = 1 where logs.time = '$d'";
$toReturn['query'] = $query;
$result = mysqli_query($conn, $query);
$toReturn['result'] = $result;

header('Content-Type: application/json');
echo json_encode($toReturn);
$conn->close();
?>
