<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');

session_start();

$lang = new Language;

if(!isset($_GET['UserID']))
{
    $status = new Status;
    $status->DataError();
}
else
{    
    if(equalSessions(getSession()))
    {
        $db = new MysqliDB;
        $UserID = $_GET['UserID'];
        $query = $db->query($db->connection(), "SELECT UserID, UserLogin, UserAvatar FROM users WHERE  UserID in (SELECT FollowerID FROM followers WHERE UserID = '$UserID')"); 
        
        $date = array();
        
        while($row = mysqli_fetch_array($query))
        {
            $data = array(
                "UserID" => $row['UserID'], 
                "UserLogin" => $row['UserLogin'], 
                "UserAvatar" => $row['UserAvatar']
            );
            array_push($date, $data);
        }
        echo json_encode($date);
        mysqli_close($db->connection());
    }
    else
    {
        $status = new Status;
        $status->AutorizationError();
    }
}
?>
