<?php
include("../system/status.php");
include("../sessions/checkSession.php");
include("../system/db.php");
header('Content-type: application/json');
session_start();

if(equalSessions(getSession()))
{
    $db = new MysqliDB;
    $UserID = $_POST['UserID'];
    $lang = new Language;   
    
    $db->query($db->connection(), "DELETE FROM comments WHERE UserID = '$UserID'");
    $db->query($db->connection(), "DELETE FROM followers WHERE FollowerID = '$UserID' or UserID = '$UserID'");
    $db->query($db->connection(), "DELETE FROM likes WHERE UserID = '$UserID'");
    $db->query($db->connection(), "DELETE FROM sessions WHERE UserID = '$UserID'");
    $db->query($db->connection(), "DELETE FROM targets WHERE UserID = '$UserID'");
    $db->query($db->connection(), "DELETE FROM users WHERE UserID = '$UserID'");
    
    
    if($lang->getLanguage() == 'ru')
    {
        $status = array("Request" => 200, "Message" => "Аккаунт успешно удалён");
    }
    else if('en')
    {
        $status = array("Request" => 200, "Message" => "Account was deleted");
    }
    echo json_encode($status);
    unset($_SESSION);
    mysqli_close($db->connection());
}
else
{
    $status = new Status;
    $status->AutorizationError();
}

?>