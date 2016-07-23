<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');


if(empty($_POST))
{
    $status = new Status;
    $status->DataError();
}
else
{    
    if(equalSessions(getSession()))
    {
        $UserID = $_POST['UserID'];
        $FollowingID = $_POST['FollowingID'];
        $db = new MysqliDB;
        $cnn = $db->connection();
        $query = $db->query($cnn, "INSERT INTO followers VALUES ('$FollowingID', '$UserID')");
        
        if(mysqli_affected_rows($cnn) > 0)
        {
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" => 200, "Message" => "Подписка было добавлена", "isFollowing" => 1);
            }
            else if('en')
            {
                $status = array("Request" => 200, "Message" => "Subscription was added", "isFollowing" => 1);
            }
            
        }
        else
        {
            http_response_code(300);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" => 300, "Error" => "Подписка не была добавлена");
            }
            else if('en')
            {
                $status = array("Request" => 300, "Error" => "Subscription wasn`t added");
            }
        }
        
        echo json_encode($status);
        mysqli_close($db->connection());
    }
    else
    {
        $status = new Status;
        $status->AutorizationError();
    }
}

function responce($UserID, $FollowerID)
{
    
}
?>
