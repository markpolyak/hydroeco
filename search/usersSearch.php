<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');


if(!isset($_GET['SearchString']))
{
    $status = new Status;
    $status->DataError();
}
else
{    
    if(equalSessions(getSession()))
    {
        $db = new MysqliDB;
        $SearchString = $_GET['SearchString'];
        $date = array();
        
        $query = $db->query($db->connection(), "SELECT * FROM users WHERE UserLogin like '%$SearchString%' or UserFirstName like '%$SearchString%' or UserSecondName like '%$SearchString%'");

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
