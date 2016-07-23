<?php

function getSession()
{
    $header = getallheaders();
    return $header['Authorization'];
}

function equalSessions($clientSession)
{
    $db = new MysqliDB;
    
    $query = $db->query($db->connection(), "SELECT * FROM sessions WHERE SessionID = '$clientSession'");
    if(mysqli_num_rows($query) == 1)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}
?>