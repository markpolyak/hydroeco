<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
include("../system/queries.php");
header('Content-type: application/json');


if(!isset($_GET['UserID']))
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
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE UserID = '$UserID' and TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate ASC");
                    break;
                }
                case 1:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 1 and UserID = '$UserID' and TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate ASC");
                    break;
                }
                
                case 2:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 2 and UserID = '$UserID' and TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate ASC");
                    break;
                }
                
                case 3:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 3 and UserID = '$UserID' and TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate ASC");
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
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE UserID = '$UserID' and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
                case 1:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 1 and UserID = '$UserID' and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
                
                case 2:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 2 and UserID = '$UserID' and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
                
                case 3:
                {
                    $query = $db->query($db->connection(), "SELECT TargetID, UserID, SphereID, ConfirmationID, TargetTitle, TargetDescription, TargetStartDate, TargetEndDate, TargetDone, TargetConfirmationData FROM targets WHERE SphereID = 3 and UserID = '$UserID' and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
            }
            
        }
        
        $query1 = $db->query($db->connection(), "SELECT * FROM users WHERE UserID = '$UserID'");
        $row1 = mysqli_fetch_array($query1);
        
        while($row = mysqli_fetch_array($query))
        {
            
                    
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
        }
        
        echo json_encode($date);
        
        mysqli_close($db->connection());
    }
    else
    {
        $status = new Status;
        $status->AutorizationError();
    }
}

function responce($UserID)
{
    
}

?>
