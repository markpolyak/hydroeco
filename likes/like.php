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
        $TargetID = $_POST['TargetID'];
        $isLike = $_POST['isLike'];

        
        if($isLike == 1)
        {
            $query = $db->query($cnn, "INSERT INTO likes VALUES ('$UserID', '$TargetID')");
            
            $query = $db->query($db->connection(), "SELECT * FROM targets WHERE TargetID = '$TargetID'");
            $row = mysqli_fetch_array($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM users, targets WHERE targets.UserID = users.UserID and  targets.TargetID = '$TargetID'");
            $row1 = mysqli_fetch_array($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM comments WHERE TargetID = '$TargetID'");
            $countComments = mysqli_num_rows($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM likes WHERE TargetID = '$TargetID'");
            $countLikes = mysqli_num_rows($query);
            
            $query1 = $db->query($db->connection(), "SELECT * FROM likes WHERE UserID = '$UserID' and TargetID = '$TargetID'");
            $isLiked = mysqli_num_rows($query1);
            
            $status = array(
                "User" => array(
                    "UserID" => $row1['UserID'],
                    "UserLogin" => $row1['UserLogin'],
                    "UserAvatar" => $row1['UserAvatar']
                ),
                "Target" => array(
                    "TargetID" => $row['TargetID'],
                    "SphereID" => $row['SphereID'],
                    "ConfirmationID" => $row['ConfirmationID'],
                    "TargetTitle" => $row['TargetTitle'],
                    "TargetDescription" => $row['TargetDescription'],
                    "TargetStartDate" => $row['TargetStartDate'], 
                    "TargetEndDate" => $row['TargetEndDate'],
                    "TargetDone" => $row['TargetDone'],
                    "CountComments" => $countComments,
                    "CountLikes" => $countLikes,
                    "isLiked" => $isLiked
                )
            );
        }
        else
        {
            $query = $db->query($cnn, "DELETE FROM likes WHERE UserID = '$UserID' and TargetID = '$TargetID'");
            
            $query = $db->query($db->connection(), "SELECT * FROM targets WHERE TargetID = '$TargetID'");
            $row = mysqli_fetch_array($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM users, targets WHERE targets.UserID = users.UserID and  targets.TargetID = '$TargetID'");
            $row1 = mysqli_fetch_array($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM comments WHERE TargetID = '$TargetID'");
            $countComments = mysqli_num_rows($query);
            
            $query = $db->query($db->connection(), "SELECT * FROM likes WHERE TargetID = '$TargetID'");
            $countLikes = mysqli_num_rows($query);
            
            $query1 = $db->query($db->connection(), "SELECT * FROM likes WHERE UserID = '$UserID' and TargetID = '$TargetID'");
            $isLiked = mysqli_num_rows($query1);
            
            $status = array(
                "User" => array(
                    "UserID" => $row1['UserID'],
                    "UserLogin" => $row1['UserLogin'],
                    "UserAvatar" => $row1['UserAvatar']
                ),
                "Target" => array(
                    "TargetID" => $row['TargetID'],
                    "SphereID" => $row['SphereID'],
                    "ConfirmationID" => $row['ConfirmationID'],
                    "TargetTitle" => $row['TargetTitle'],
                    "TargetDescription" => $row['TargetDescription'],
                    "TargetStartDate" => $row['TargetStartDate'], 
                    "TargetEndDate" => $row['TargetEndDate'],
                    "TargetDone" => $row['TargetDone'],
                    "CountComments" => $countComments,
                    "CountLikes" => $countLikes,
                    "isLiked" => $isLiked
                )
            );
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