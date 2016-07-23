<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
include("../system/queries.php");
header('Content-type: application/json');


if(!isset($_GET['UserID']) || !isset($_GET['Offset']) || !isset($_GET['Limit']))
{
    $status = new Status;
    $status->DataError();
}
else
{    
    if(equalSessions(getSession()))
    {
        $UserID = $_GET['UserID'];
        $Offset = $_GET['Offset'];
        $Limit = $_GET['Limit'];
        $isActive = $_GET['isActive'];
        $filterBy = $_GET['filterBy'];
        $data = array();
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
                    $query = $db->query($db->connection(), "SELECT * FROM targets WHERE targets.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID') and targets.TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 UNION SELECT * FROM targets WHERE targets.UserID = '$UserID' and targets.TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate DESC");
                    break;
                }
                case 1:
                {
                    $query = $db->query($db->connection(), "SELECT * FROM targets WHERE SphereID = 1 and targets.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID') and targets.TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 UNION SELECT * FROM targets WHERE SphereID = 1 and  targets.UserID = '$UserID' and targets.TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate DESC");
                    break;
                }
                
                case 2:
                {
                    $query = $db->query($db->connection(), "SELECT * FROM targets WHERE SphereID = 2 and targets.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID') and targets.TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 UNION SELECT * FROM targets WHERE SphereID = 2 and targets.UserID = '$UserID' and targets.TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate DESC");
                    break;
                }
                
                case 3:
                {
                    $query = $db->query($db->connection(), "SELECT * FROM targets WHERE SphereID = 3 and targets.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID') and targets.TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 UNION SELECT * FROM targets WHERE SphereID = 3 and targets.UserID = '$UserID' and targets.TargetDone = 0 and (TargetEndDate - date(NOW())) > 0 ORDER BY TargetStartDate DESC");
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
                    $query = $db->query($db->connection(), "SELECT * FROM targets WHERE targets.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID') and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) UNION SELECT * FROM targets WHERE targets.UserID = '$UserID' and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
                case 1:
                {
                    $query = $db->query($db->connection(), "SELECT * FROM targets WHERE SphereID = 1 and targets.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID') and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) UNION SELECT * FROM targets WHERE SphereID = 1 and targets.UserID = '$UserID' and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
                
                case 2:
                {
                    $query = $db->query($db->connection(), "SELECT * FROM targets WHERE SphereID = 2 and targets.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID') and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) UNION SELECT * FROM targets WHERE SphereID = 2 and targets.UserID = '$UserID' and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
                
                case 3:
                {
                    $query = $db->query($db->connection(), "SELECT * FROM targets WHERE SphereID = 3 and targets.UserID in (SELECT followers.UserID FROM followers, users WHERE followers.UserID = users.UserID and followers.FollowerID = '$UserID') and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) UNION SELECT * FROM targets WHERE SphereID = 3 and targets.UserID = '$UserID' and (TargetDone = 1 or (TargetDone = 0 and TargetEndDate - date(NOW()) < 0)) ORDER BY TargetEndDate DESC");
                    break;
                }
            }
        }
        
        
        
        
        while($row = mysqli_fetch_array($query))
        {
            $User = $db->query($db->connection(), "SELECT UserID, UserAvatar, UserLogin FROM users WHERE UserID = " . $row['UserID']);
            $UserData = mysqli_fetch_array($User);
            
            if($Offset == $i)
            {
                if($count != $Limit)
                {
                    $array = array(
                        "Target" => array(
                            "TargetID" => $row['TargetID'],
                            "SphereID" => $row['SphereID'],
                            "ConfirmationID" => $row['ConfirmationID'],
                            "TargetTitle" => $row['TargetTitle'],
                            "TargetDescription" => $row['TargetDescription'],
                            "TargetStartDate" => $row['TargetStartDate'], 
                            "TargetEndDate" => $row['TargetEndDate'],
                            "TargetDone" => $row['TargetDone'],
                            "CountComments" => $q->getComments($db, $row['TargetID']),
                            "CountLikes" => $q->getLikes($db, $row['TargetID']),
                            "isLiked" => $q->isLiked($db, $row['TargetID'], $UserID)
                            ),
                        "User" => array(
                            "UserID" => $UserData['UserID'],
                            "UserAvatar" => $UserData['UserAvatar'],
                            "UserLogin" => $UserData['UserLogin']
                    ));
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
            
            
            array_push($data, $array);
        }
        
        echo json_encode($data);    
        
        mysqli_close($db->connection());
    }
    else
    {
        $status = new Status;
        $status->AutorizationError();
    }
}
?>
