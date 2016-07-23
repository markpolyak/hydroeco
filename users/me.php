<?php
include("../system/status.php");
include("../sessions/checkSession.php");
include("../system/db.php");
header('Content-type: application/json');

session_start();

$header = getallheaders();

if(equalSessions(getSession()))
{
    $Session = $header['Authorization'];
    $db = new MysqliDB;
        
    $query = $db->query($db->connection(), "SELECT * FROM sessions, users WHERE SessionID = '$Session' and users.UserID = sessions.UserID");
    $row = mysqli_fetch_array($query);

    $data = array(
        "UserID" => $row['UserID'],
        "UserLogin" => $row['UserLogin'],
        "UserFirstName" => $row['UserFirstName'],
        "UserSecondName" => $row['UserSecondName'],
        "UserEmail" => $row['UserEmail'],
        "UserAvatar" => $row['UserAvatar']
    );
    echo json_encode($data);
    
    mysqli_close($db->connection());
}
else
{
    $status = new Status;
    $status->AutorizationError();
}

?>