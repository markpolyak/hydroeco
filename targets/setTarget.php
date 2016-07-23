<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');

if(!empty($_POST))
{
    if(equalSessions(getSession()))
    {
        $db = new MysqliDB;
        $cnn = $db->connection();
        
        $UserLogin = $_POST['UserLogin'];
        
        $SphereID = $_POST['SphereID'];
        $ConfirmationID = $_POST['ConfirmationID'];
        $TargetTitle = $_POST['TargetTitle'];
        $TargetDescription = $_POST['TargetDescription'];
        $TargetStartDate = $_POST['TargetStartDate'];
        $TargetEndDate = $_POST['TargetEndDate'];
        
        $query = $db->query($cnn, "INSERT INTO targets" .
             "(UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate)" .
             "VALUES ((SELECT UserID FROM users WHERE UserLogin = '$UserLogin'), '$SphereID', '$ConfirmationID', '$TargetTitle', '$TargetDescription', '$TargetStartDate', '$TargetEndDate')");
        
       if(mysqli_affected_rows($cnn) > 0)
        {
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                 $status = array("Request" => 200, "Message" => "Цель была добавлена");
            }
            else if('en')
            {
                 $status = array("Request" => 200, "Message" => "Target was added");
            }
            echo json_encode($status);
            
        }
        else
        {
            http_response_code(409);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                 $status = array("Request" => 409, "Error" => "Цель не была добавлена");
            }
            else if('en')
            {
                 $status = array("Request" => 409, "Error" => "Target wasn`t added");
            }
            echo json_encode($status);
        }
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