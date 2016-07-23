<?php

function generateSessionID($UserID)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789"; 
    $code = ""; 
    $clen = strlen($chars) - 1;   
    while (strlen($code) < 64)
    { 
      $code .= $chars[mt_rand(0, $clen)];   
    }
    $_SESSION['SessionID'] = $code;
    
    $db = new MysqliDB;
    
    $query = $db->query($db->connection(), "INSERT INTO sessions VALUES ('$UserID', '$code')");
    return 0;
}
?>