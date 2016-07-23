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
        
        $UserID = $_POST['UserID'];
        $FollowingID = $_POST['FollowingID'];
        
        $query = $db->query($cnn, "DELETE FROM followers WHERE UserID = '$FollowingID' and FollowerID = '$UserID'");
        
        if(mysqli_affected_rows($cnn) > 0)
        {
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" => 200, "isFollowing" => 0, "Message" => "�������� ���� �������");
            }
            else if('en')
            {
                $status = array("Request" => 200, "isFollowing" => 0,"Message" => "Following was deleted");
            }
            echo json_encode($status);
        }
        else
        {
            http_response_code(300);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" => 300, "Error" => "�������� �� ���� �������");
            }
            else if('en')
            {
                $status = array("Request" => 300, "Error" => "Following wasn`t deleted");
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