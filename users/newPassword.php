<?php
include("../system/status.php");
include("../system/db.php");
header('Content-type: application/json');
session_start();

if(isset($_SESSION['Code']) and isset($_SESSION['UserID']))
{
    $UserPassword = md5($_POST['UserPassword']);
    $UserID = $_SESSION['UserID'];
    $Code = $_POST['Code'];
    
    $db = new MysqliDB;
    $cnn = $db->connection();
    
    if($_SESSION['Code'] == $Code)
    {
        $query = $db->query($cnn, "UPDATE users SET UserPassword = '$UserPassword' WHERE UserID = '$UserID'");
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
            unset($_SESSION['Code']);
            unset($_SESSION['UserID']);
        }
        else
        {
            http_response_code(409);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" => 409, "Error" => "Пароль не был изменён");
            }
            else if('en')
            {
                $status = array("Request" => 409, "Error" => "Password wasn`t changed");
            }
        }
    }
    else
    {
        http_response_code(409);
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 409, "Error" => "Некорректный код");
        }
        else if('en')
        {
            $status = array("Request" => 409, "Error" => "Incorrect code");
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