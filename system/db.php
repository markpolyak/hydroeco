<?php
class MysqliDB
{
    public function connection()
    {
        $db_host = 'mysql77.1gb.ru';
        $db_user = 'gb_testdbname';
        $db_pass = 'z337fc7avnm';
        $db_name = 'gb_testdbname';
        
        return mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    }
    
    function query($cnn, $mysqli_query)
    {
        return mysqli_query($cnn, $mysqli_query);
    }
}
?>