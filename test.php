<?php
        /**
 * $db_host = 'mysql77.1gb.ru';
 *         $db_user = 'gb_testdbname';
 *         $db_pass = 'z337fc7avnm';
 *         $db_name = 'gb_testdbname';
 *         
 *         $cnn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
 */
        
        include("system/db.php");
        
        $db = new MysqliDB;
        $cnn = $db->connection();

        
        $query1 = $db->query($cnn, "SELECT * FROM followers WHERE UserID = 64 and FollowerID = 51");

        if(mysqli_num_rows($query1) == 1)
        {
            $isFollowing = 1;
        }
        else
        {
            $ifFollowing = 0;
        }
        
        echo $isFollowing;

?>