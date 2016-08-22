<?php
// Connect to MSSQL

$cnn = mysqli_connect('localhost', 'root', '', 'pigments') or die("Connection Error");

$stations = $_GET["stations"];
$start = $_GET["start"];
$end = $_GET["end"];


if ($stations)
{
	$s = explode(',', $stations);
    
	$q = "select samples.id_station, samples.date, samples.comment, samples.serial_number,  photosynthetic_pigments_samples.id_sample, station.id_water_area from samples LEFT JOIN station ON (samples.id_station = station.id_station) LEFT JOIN photosynthetic_pigments_samples ON (photosynthetic_pigments_samples.id_sample = samples.id_sample)  where samples.id_station in ('"
		.implode("','",$s) .
		"') and samples.date <= cast('$end' as datetime) and samples.date >= cast('$start' as datetime)";
	$result= mysqli_query ($cnn, $q);
	$rows = array();
	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r;
	}
	print json_encode($rows);
}
?>