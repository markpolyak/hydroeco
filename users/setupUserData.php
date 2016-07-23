<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');

session_start();

if(!empty($_POST))
{
    if(equalSessions(getSession()))
    {
        $db = new MysqliDB;
        $UserFirstName = $_POST['UserFirstName'];
        $UserSecondName = $_POST['UserSecondName'];
        $UserLogin = $_POST['UserLogin'];
        
        $query = $db->query($db->connection(), "UPDATE users SET UserFirstName = '$UserFirstName', UserSecondName = '$UserSecondName' WHERE UserLogin = '$UserLogin'");
        
        $Data = $db->query($db->connection(), "SELECT * FROM users WHERE UserLogin = '$UserLogin'");
        $row = mysqli_fetch_array($Data);
        
        $resp = array(
            "UserID" => $row['UserID'],
            "UserFirstName" => $row['UserFirstName'],
            "UserSecondName" => $row['UserSecondName'],
            "UserDateRegistration" => $row['UserDateRegistration'], 
            "UserAvatar" => $row['UserAvatar'], 
            "UserEmail" => $row['UserEmail'], 
            "UserLogin" => $row['UserLogin']
        );
        echo json_encode($resp);
        mysqli_close($db->connection());
    }
    else
    {
        $status = new Status;
        $status->AutorizationError();
    }  
}
else
{
    $status = new Status;
    $status->DataError();
}
?>