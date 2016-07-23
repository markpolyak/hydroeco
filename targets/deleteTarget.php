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
        
        $TargetID = $_POST['TargetID'];
        
        $query = $db->query($cnn, "DELETE targets FROM targets WHERE TargetID = '$TargetID'");
        if(mysqli_affected_rows($cnn) > 0)
        {
            
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" => 200, "Message" => "Цель была удалена");
            }
            else if('en')
            {
                $status = array("Request" => 200, "Message" => "Target was deleted");
            }
            echo json_encode($status);
        }
        else
        {
            http_response_code(300);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                 $status = array("Request" => 300, "Error" => "Цель не была удалена");
            }
            else if('en')
            {
                 $status = array("Request" => 300, "Error" => "Target wasn`t deleted");
            }
            echo json_encode($status);
        }
        mysqli_close($cnn);
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