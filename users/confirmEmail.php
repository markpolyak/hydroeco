<?php
header('Content-type: application/json');
include("../system/db.php");
include("../sessions/checkSession.php");
include("../sessions/startSession.php");
include("../system/status.php");

session_start();



if(isset($_POST['Code']) && isset($_POST['UserID']))
{
    $Code = $_POST['Code'];
    $UserID = $_POST['UserID'];
    
    if($_SESSION['Code'] == $Code)
    {
        $db = new MysqliDB;
        $query = $db->query($db->connection(), "INSERT INTO users (UserLogin, UserPassword, UserEmail, UserDateRegistration) VALUES ((SELECT unconfirmedusers.UserLogin FROM unconfirmedusers WHERE unconfirmedusers.UserID = '$UserID'), (SELECT unconfirmedusers.UserPassword FROM unconfirmedusers WHERE unconfirmedusers.UserID = '$UserID'), (SELECT unconfirmedusers.UserEmail FROM unconfirmedusers WHERE unconfirmedusers.UserID = '$UserID'), (SELECT unconfirmedusers.UserDateRegistration FROM unconfirmedusers WHERE unconfirmedusers.UserID = '$UserID'))");
        
        $query1 = $db->query($db->connection(), "SELECT * FROM unconfirmedusers WHERE UserID = '$UserID'");
        $UserData = mysqli_fetch_array($query1);
        $UserLogin = $UserData['UserLogin'];
        $query2 = $db->query($db->connection(), "SELECT * FROM users WHERE UserLogin = '$UserLogin'");
        $row = mysqli_fetch_array($query2);
        generateSessionID($row['UserID']);
        
        $query = $db->query($db->connection(), "DELETE FROM unconfirmedusers WHERE UserID = '$UserID'");
        
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 200, "Message" => "Ваш аккаунт был активирован", 'UserID' => $row['UserID']);
        }
        else if('en')
        {
            $status = array("Request" => 200, "Message" => "Your account was activated", 'UserID' => $row['UserID']);
        }
        unset($_SESSION['Code']);
    }
    else
    {
        http_response_code(409);
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 409, "Error" => "Вы ввели неправильный код");
        }
        else if('en')
        {
            $status = array("Request" => 409, "Error" => "You write incorrect code");
        }
        
    }
    echo json_encode($status);
}
?>