<?php
// Connect to MSSQL

$stations = $_GET["stations"];
$start = $_GET["start"];
$end = $_GET["end"];

$data = array('stations' => $stations, 'start' => $start, 'end' => $end);
$s = json_encode($data);
echo $s;

//if ($stations){
//	$s = explode(',', $stations);
//	$q = "select * from Samples where id_station in ('"
//		.implode("','",$s).
//		"') and date <= cast('$end' as datetime) and date >= cast('$start' as datetime)";
//	$result= mysqli_query ($link, $q);
//	$rows = array();
//	while($r = mysqli_fetch_assoc($result)) {
///		$rows[] = $r;
//	}
//	print json_encode($rows);
//}
?>