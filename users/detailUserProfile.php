<?php
include("../system/status.php");
include("../sessions/checkSession.php");
include("../system/db.php");
header('Content-type: application/json');

session_start();

if(equalSessions(getSession()))
{
    $UserID = $_GET['UserID'];
    $FollowingID = $_GET['FollowingID'];
    $isFollowing = 0;
    $db = new MysqliDB;
    
    if($UserID == $FollowingID)
    {
        $query = $db->query($db->connection(), "SELECT * FROM users WHERE UserID = '$UserID'");
        
        $row = mysqli_fetch_array($query);
         
        $CountFollowers = $db->query($db->connection(), "SELECT FollowerID FROM followers WHERE UserID = '$UserID'");
        $c1 = mysqli_num_rows($CountFollowers);
        
        $CountFollowings = $db->query($db->connection(), "SELECT UserID FROM followers WHERE FollowerID = '$UserID'");
        $c2 = mysqli_num_rows($CountFollowings);
        
        $CountTargets = $db->query($db->connection(), "SELECT TargetID FROM targets WHERE UserID = '$UserID'");
        $c3 = mysqli_num_rows($CountTargets);
    }
    else
    {
        $query = $db->query($db->connection(), "SELECT * FROM users WHERE UserID = '$FollowingID'");
        $query1 = $db->query($db->connection(), "SELECT * FROM followers WHERE UserID = '$FollowingID' and FollowerID = '$UserID'");
        if(mysqli_num_rows($query1) == 1)
        {
            $isFollowing = 1;
        }
        else
        {
            $isFollowing = 0;
        }
        $row = mysqli_fetch_array($query);
         
        $CountFollowers = $db->query($db->connection(), "SELECT FollowerID FROM followers WHERE UserID = '$FollowingID'");
        $c1 = mysqli_num_rows($CountFollowers);
        
        $CountFollowings = $db->query($db->connection(), "SELECT UserID FROM followers WHERE FollowerID = '$FollowingID'");
        $c2 = mysqli_num_rows($CountFollowings);
        
        $CountTargets = $db->query($db->connection(), "SELECT TargetID FROM targets WHERE UserID = '$FollowingID'");
        $c3 = mysqli_num_rows($CountTargets);
    }
    
    
    
    $data = array(
        "UserID" => $row['UserID'],
        "UserLogin" => $row['UserLogin'],
        "UserFirstName" => $row['UserFirstName'],
        "UserSecondName" => $row['UserSecondName'],
        "UserEmail" => $row['UserEmail'],
        "UserAvatar" => $row['UserAvatar'],
        "isFollowing" => $isFollowing,
        "CountFollowers" => $c1,
        "CountFollowings" => $c2, 
        "CountTargets" => $c3
    );
    echo json_encode($data);
    
    mysqli_close($db->connection());
}
else
{
    $status = new Status;
    $status->AutorizationError();
}

?>