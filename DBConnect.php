<?php
  // DBConnect

  $dbname = 'mpolyakru_hbio';

  $name = 'mpolyakru_hbio';

  $host = 'pg.sweb.ru';

  $password = 'test1234';

  class DBConnect {

      var $conn;

  }

  function DBConnect(){

      $this->conn = pg_connect("host=$host port='5432'

              dbname=$dbname user=$user password=$password ") 

              or die("unable to connect database");

}



?>