<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');


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
        
        $query = $db->query($db->connection(), "SELECT users.UserID, users.UserLogin, users.UserAvatar FROM users WHERE users.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID')"); 
        
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
