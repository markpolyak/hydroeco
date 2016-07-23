<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
include("../system/queries.php");
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
        $Offset = $_GET['Offset'];
        $Limit = $_GET['Limit'];
        $isActive = $_GET['isActive'];
        $UserID = $_GET['UserID'];
        $filterBy = $_GET['filterBy'];
        $date = array();
        $i = 0;
        $count = 0;
        
        $db = new MysqliDB;
        $q = new Query;
        
        if($isActive)
        {
            switch($filterBy)
            {
                case 0:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate DESC");
                    break;
                }
                case 1:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 1 and TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate DESC");
                    break;
                }
                
                case 2:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 2 and TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate DESC");
                    break;
                }
            }
            
        }
        else
        {
            switch($filterBy)
            {
                case 0:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0) ORDER BY TargetEndDate DESC");
                    break;
                }
                case 1:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 1 and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
                
                case 2:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 2 and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
            }
            
        } 
        
        while($row = mysqli_fetch_array($query))
        {
            if($Offset == $i)
            {
                if($count != $Limit)
                {
                    $query1 = $db->query($db->connection(), "SELECT * FROM users WHERE UserID = " . $row['UserID']);
                    $row1 = mysqli_fetch_array($query1);
                    
                    $data = array(
                        'Target' => array(
                            'TargetID' => $row['TargetID'], 
                            'TargetTitle' => $row['TargetTitle'], 
                            'TargetDescription' => $row['TargetDescription'], 
                            'TargetStartDate' => $row['TargetStartDate'], 
                            'TargetEndDate' => $row['TargetEndDate'],
                            'SphereID' => $row['SphereID'], 
                            'ConfirmationID' => $row['ConfirmationID'], 
                            'TargetDone' => $row['TargetDone'], 
                            'TargetConfirmationData' => $row['TargetConfirmationData'],
                            'CountLikes' => $q->getLikes($db, $row['TargetID']),
                            'CountComments' => $q->getComments($db, $row['TargetID']),
                            'isLiked' => $q->isLiked($db, $row['TargetID'], $UserID)
                            ),
                        'User' => array(
                            'UserID' => $row1['UserID'],
                            'UserLogin' => $row1['UserLogin'],
                            'UserAvatar' => $row1['UserAvatar']
                        )
                    );
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
                 $status = array('Request' => 400, 'Message' => 'Нет данных');
            }
            else if('en')
            {
                 $status = array('Request' => 400, 'Message' => 'No Data');
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
