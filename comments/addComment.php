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
        
        $Comment = $_POST['Comment'];
        $UserID = $_POST['UserID'];
        $TargetID = $_POST['TargetID'];
        
        $query = $db->query($cnn, "INSERT INTO comments (UserID, TargetID, Comment, CommentDate) VALUES ('$UserID', '$TargetID', '$Comment', NOW())");
        
        
        
        if(mysqli_affected_rows($cnn) == 1)
        {
            $query = $db->query($db->connection(), "SELECT * FROM targets WHERE TargetID = '$TargetID'");
            $row = mysqli_fetch_array($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM users WHERE UserID = '$UserID'");
            $row1 = mysqli_fetch_array($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM comments WHERE TargetID = '$TargetID'");
            $row2 = mysqli_fetch_array($query);
            $countComments = mysqli_num_rows($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM likes WHERE TargetID = '$TargetID'");
            $countLikes = mysqli_num_rows($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM likes WHERE TargetID = '$TargetID' and UserID = '$UserID'");
            $isLiked = mysqli_num_rows($query);
            
            
            $status = array(
                "User" => array(
                    "UserID" => $row1['UserID'],
                    "UserLogin" => $row1['UserLogin'],
                    "UserAvatar" => $row1['UserAvatar']
                ),
                "Comment" => array(
                    "CommentID" => $row2['CommentID'],
                    "Comment" => $row2['Comment'],
                    "CommentDate" => $row2['CommentDate']
                ),
                "Target" => array(
                    "TargetID" => $row['TargetID'],
                    "CountComments" => $countComments,
                    "CountLikes" => $countLikes,
                    "isLiked" => $isLiked
                )
            );
        }
        else
        {
            http_response_code(409);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" =>409, "Error" => "Комментарий не был добавлен");
            }
            else if('en')
            {
                $status = array("Request" =>409, "Error" => "Comment wasn`t added");
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
else
{
    $status = new Status;
    $status->DataError();
}
?>