<?php
// Подтягиваем параметры параметры подключения
require_once 'DBConnect.php'; 

// Подключаемся по параметрам к бд

$conn = pg_connect("host = $host dbname = $dbname user =  $name password = $password") 
  or die('Could not connect: ' . pg_last_error());

if(!$conn) echo " Что-то пошло не так, проверь соединение с БД ";

// Формируем запрос
// Так как это заглушка, я не надеюсь на то, что я составил этот запрос правильно, не ругайте, ребят :D

if ($_GET['start']) {
  if ($_GET['start'] != "undefined" && $_GET['end'] != "undefined") {
    // $query = "select distinct latitude, longitude, water_area_name, id_station, station_name from vw_samples"; 
    $query = "select distinct latitude, longitude, water_area_name, id_station, station_name from vw_samples where sample_date between '" .$_GET['start']."'::timestamp and '" .$_GET['end']. "'::timestamp"; //::timestamp
  } else {
    $query = "select distinct latitude, longitude, water_area_name, id_station, station_name from vw_samples"; 
  }
  
} else if ($_GET['areas']) {
  $query = "select * from view_stations";
} else if ($_GET['diagram']) {
  // $query = "select id_phyto, id_station, total_species from view_new_phytos1 where id_station in (" .$_GET['diagram'].")";
  $query = "select view_new_phytos1.id_station, view_new_phytos1.id_phyto, view_new_phytos1.water_area_name, view_new_phytos1.station_name, view_new_phytos3.group_name, view_new_phytos3.number, view_new_phytos3.biomass, view_new_phytos3.total_species_in_group, view_new_phytos3.total_percent, view_new_phytos3.biomass_percent from view_new_phytos1, view_new_phytos3 where view_new_phytos1.id_phyto = view_new_phytos3.id_phyto";
}





$result = pg_query($query) or die(pg_last_error());

$rows = array();


// Добавляем в массив данные из бд
while ($arrayRow = pg_fetch_object($result)) {
  $rows[] = $arrayRow;
}


$jsonString = json_encode($rows);
// echo json_encode($_GET['start']);
// echo json_encode(array($_GET['end']));
echo $jsonString;
pg_close($conn);

?>

