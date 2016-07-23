<?php

class Query
{
    function getLikes($db, $TargetID)
    {
        $query = $db->query($db->connection(), "SELECT * FROM likes WHERE TargetID = '$TargetID'");
        return mysqli_num_rows($query);
    }
    
    function getComments($db, $TargetID)
    {
        $query = $db->query($db->connection(), "SELECT * FROM comments WHERE TargetID = '$TargetID'");
        return mysqli_num_rows($query);
    }
    
    function isLiked($db, $TargetID, $UserID)
    {
        $query = $db->query($db->connection(), "SELECT * FROM likes WHERE TargetID = '$TargetID' and UserID = '$UserID'");
        return mysqli_num_rows($query);
    }
}

?>