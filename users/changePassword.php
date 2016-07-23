<?php
include("../system/status.php");
include("../sessions/checkSession.php");
include("../system/db.php");
header('Content-type: application/json');
session_start();

if(equalSessions(getSession()))
{
    $OldPassword = md5($_POST['OldPassword']);
    $NewPassword = md5($_POST['NewPassword']);
    $UserID = $_POST['UserID'];
    
    
    $db = new MysqliDB;
    $cnn = $db->connection();
    
    $query = $db->query($cnn, "UPDATE users SET UserPassword = '$NewPassword' WHERE UserPassword = '$OldPassword' and UserID = '$UserID'");
    if(mysqli_affected_rows($cnn) == 1)
    {
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 200, "Message" => "Пароль был успешно изменён");
        }
        else if('en')
        {
            $status = array("Request" => 200, "Message" => "Password was successfully changed");
        }
    }
    else
    {
        http_response_code(409);
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 409, "Error" => "Некорректный старый пароль");
        }
        else if('en')
        {
            $status = array("Request" => 409, "Error" => "Incorrect old password");
        }
    }
    echo json_encode($status);
}
else
{
    $status = new Status;
    $status->AutorizationError();
}

?>