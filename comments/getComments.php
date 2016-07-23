<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');

if(isset($_GET['TargetID']) && isset($_GET['Offset']) && isset($_GET['Limit']))
{
    if(equalSessions(getSession()))
    {
        $db = new MysqliDB;
        $cnn = $db->connection();
        
        $TargetID = $_GET['TargetID'];
        $Offset = $_GET['Offset'];
        $Limit = $_GET['Limit'];
        
        $i = 0;
        $count = 0;
        $query = $db->query($cnn, "SELECT CommentID, TargetID, CommentDate, Comment, users.UserID, users.UserLogin, users.UserAvatar FROM comments, users WHERE users.UserID = comments.UserID and comments.TargetID = '$TargetID'");
        $data = array();
        
       while($row = mysqli_fetch_array($query))
        {   
            if($Offset == $i)
            {
                if($count != $Limit)
                {
                    $s = new DateTime($row['CommentDate']);
                    
                    $array = array(
                        "Comment" => array(
                            "CommentID" => $row['CommentID'],
                            "TargetID" => $row['TargetID'],
                            "CommentDate" => $s->format('Y-m-d') . "T" . $s->format('H:i:s'). "Z",
                            "Comment" => $row['Comment']
                            ),
                        "User" => array(
                            "UserID" => $row['UserID'],
                            "UserAvatar" => $row['UserAvatar'],
                            "UserLogin" => $row['UserLogin']
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
else
{
    $status = new Status;
    $status->DataError();
}
?>