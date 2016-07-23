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
        
        $CommentID = $_POST['CommentID'];
        $UserID = $_POST['UserID'];
        $TargetID = $_POST['TargetID'];
        
        $query = $db->query($cnn, "SELECT UserID FROM targets WHERE TargetID  = '$TargetID'");
        $row = mysqli_fetch_array($query);
        
        if($UserID == $row['UserID'])
        {
            $query = $db->query($db->connection(), "DELETE FROM comments WHERE CommentID = '$CommentID'");
            
            $query1 = $db->query($db->connection(), "SELECT * FROM users, targets WHERE TargetID = '$TargetID' and users.UserID = '$UserID'");
            $row1 = mysqli_fetch_array($query1);
            
            $query2 = $db->query($db->connection(), "SELECT * FROM comments WHERE TargetID = '$TargetID'");
            $countComments = mysqli_num_rows($query2);
            
            $query3 = $db->query($db->connection(), "SELECT * FROM likes WHERE TargetID = '$TargetID'");
            $countLikes = mysqli_num_rows($query3);
            
            
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array(
                    "Request" => 200,
                    "Message" => "Comment был удалён"
                );
            }
            else if('en')
            {
                $status = array(
                    "Request" => 200,
                    "Message" => "Comment was deleted"
                );
            } 
            
        }
        else
        {
            $query = $db->query($db->connection(), "SELECT UserID FROM comments WHERE CommentID = '$CommentID'");
            $row1 = mysqli_fetch_array($query);
            if($UserID = $row1['UserID'])
            {
                $query = $db->query($db->connection(), "DELETE FROM comments WHERE CommentID = '$CommentID'");
                
                $query2 = $db->query($db->connection(), "SELECT * FROM users, targets WHERE TargetID = '$TargetID' and users.UserID = '$UserID'");
                $row2 = mysqli_fetch_array($query2);
                
                $query4 = $db->query($db->connection(), "SELECT * FROM comments WHERE TargetID = '$TargetID'");
                $countComments = mysqli_num_rows($query4);
                
                $query5 = $db->query($db->connection(), "SELECT * FROM likes WHERE TargetID = '$TargetID'");
                $countLikes = mysqli_num_rows($query5);
                
                $lang = new Language;
                if($lang->getLanguage() == 'ru')
                {
                    $status = array(
                        "Request" => 200,
                        "Message" => "Comment был удалён"
                    );
                }
                else if('en')
                {
                    $status = array(
                        "Request" => 200,
                        "Message" => "Comment was deleted"
                    );
                }
            }
            else
            {
                http_response_code(409);
                $lang = new Language;
                if($lang->getLanguage() == 'ru')
                {
                    $status = array(
                        "Request" => 409,
                        "Error" => "Вы не можете удалить этот комментарий"
                    );
                }
                else if('en')
                {
                    $status = array(
                        "Request" => 409,
                        "Error" => "You cant delete this comment"
                    );
                }  
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