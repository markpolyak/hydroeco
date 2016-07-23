<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/startSession.php");
include("../sessions/checkSession.php");

header('Content-type: application/json');
session_start();

if(!empty($_POST))
{
    if(!equalSessions(getSession()))
    {
        $UserLogin = $_POST['UserLogin'];
        $UserPassword = md5($_POST['UserPassword']);
            
            
        $db = new MysqliDB;
        $query = $db->query($db->connection(), "SELECT * FROM users WHERE UserLogin = '$UserLogin' and UserPassword = '$UserPassword'");
        
        if(mysqli_num_rows($query) > 0)
        {
            $row = mysqli_fetch_array($query); 
            $data = array(
                "UserID" => $row['UserID'],
                "UserLogin" => $row['UserLogin'], 
                "UserFirstName" => $row['UserFirstName'],
                "UserSecondName" => $row['UserSecondName'],
                "UserDateRegistration" => $row['UserDateRegistration'], 
                "UserAvatar" => $row['UserAvatar'], 
                "UserEmail" => $row['UserEmail']
            );
            generateSessionID($row['UserID']);
            echo json_encode($data);
        }
    }
    else
    {
        $status = new Status;
        $status->SessionExists();
    }
}
else
{
    $status = new Status;
    $status->DataError();
}

?>
