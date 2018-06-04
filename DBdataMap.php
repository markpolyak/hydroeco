<?php

  /*
   *  Фетчим данные и и кидаем в массив 
   */

  //Открываем соединение с БД postgresql

  require_once 'DBConnect.php'; 

  $conn = pg_connect("host = $host dbname = $dbname user =  $name password = $password") 

      or die('Could not connect: ' . pg_last_error());

  if(!$conn) echo " Что-то пошло не так, проверь соединение с БД ";

  
  $query = "select distinct latitude, longitude, water_area_name, id_station, station_name from vw_samples"; 

  $result = pg_query($query) or die(pg_last_error());
  
  $rows = array();


  // Добавляем в массив данные из бд
  while ($arrayRow = pg_fetch_object($result)) {
    $rows[] = $arrayRow;
  }


  $jsonString = json_encode($rows);

  pg_close($conn);
?>
