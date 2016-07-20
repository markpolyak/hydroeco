<?php
        
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
