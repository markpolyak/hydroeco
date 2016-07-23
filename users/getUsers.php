<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');


if(!isset($_GET['Limit']) || !isset($_GET['Offset']))
{
    $status = new Status;
    $status->DataError();
}
else
{ 
    if(equalSessions(getSession()))
    {
        $db = new MysqliDB;
        $query = $db->query($db->connection(), "SELECT UserID, UserLogin, UserAvatar FROM users");
        
        $date = array();
        $i = 0;
        $count = 0;
        $Offset = $_GET['Offset'];
        $Limit = $_GET['Limit'];
        
        while($row = mysqli_fetch_array($query))
        {
            if($Offset == $i)
            {
                if($count != $Limit)
                {
                    $data = array("UserID" => $row['UserID'], "UserLogin" => $row['UserLogin'], "UserAvatar" => $row['UserAvatar']);
                    array_push($date, $data);
                    $count++;
                }
                else
                {
                    break;
                }
                
            }
            else
            {
                $i++;
                continue;
            }
        }
        
        if($Offset > $i)
        {
            http_response_code(400);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                 $date = array('Request' => 400, 'Error' => 'Нет данных');
            }
            else if('en')
            {
                 $date = array('Request' => 400, 'Error' => 'No Data');
            }
        }
        
        $json_responce = json_encode($date);
        echo $json_responce;
        
        mysqli_close($db->connection());
    }
    else
    {
        $status = new Status;
        $status->AutorizationError();
    }
}
?>
