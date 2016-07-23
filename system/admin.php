<html>
    <head>
        <title>AdminPage</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <?php
    include("status.php");
    include("db.php");
    session_start();
    $db = new MysqliDB;

    if(isset($_POST['submit'])){
        $UserLogin = $_POST['UserLogin'];
        $UserPassword = md5($_POST['UserPassword']);
        $query = $db->query($db->connection(), "SELECT * FROM users WHERE UserLogin = '$UserLogin' and UserPassword = '$UserPassword'");
        if(mysqli_num_rows($query) == 1)    {
            $_SESSION['admin'] = 1;
        }
        else
        {
            $status = new Status;
            $status->AutorizationError();
        }
    }
    if(isset($_POST['deleteUser'])){
        $UserID = $_POST['UserID'];
        $db->query($db->connection(), "DELETE FROM comments WHERE UserID = '$UserID'");
        $db->query($db->connection(), "DELETE FROM followers WHERE FollowerID = '$UserID' or UserID = '$UserID'");
        $db->query($db->connection(), "DELETE FROM likes WHERE UserID = '$UserID'");
        $db->query($db->connection(), "DELETE FROM sessions WHERE UserID = '$UserID'");
        $db->query($db->connection(), "DELETE FROM targets WHERE UserID = '$UserID'");
        $db->query($db->connection(), "DELETE FROM users WHERE UserID = '$UserID'");
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }

    if(isset($_POST['updateUser'])){
        $UserID = $_POST['UserID'];
        $UserLogin = $_POST['UserLogin'];
        $UserEmail = $_POST['UserEmail'];
        $UserFirstName = $_POST['UserFirstName'];
        $UserSecondName = $_POST['UserSecondName'];
        $db->query($db->connection(), "UPDATE users SET UserLogin = '$UserLogin', UserFirstName = '$UserFirstName', UserSecondName = '$UserSecondName', UserEmail = '$UserEmail' WHERE UserID = '$UserID'");
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }

    if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1){
        ?>

        <form action="admin.php" method="POST">
            <label for="UserLogin">Login: </label>
            <input type="text" name="UserLogin"/><br>

            <label for="UserPassword">Password: </label>
            <input type="password" name="UserPassword"/><br>

            <input type="submit" name="submit">
        </form>

    <?php
    }
    else
    {?>
        <div class="users">
            <label>UserID</label>
            <label>UserLogin</label>
            <label>UserFirstName</label>
            <label>UserSecondName</label>
            <label>UserDateRegistration</label>
            <label>UserEmail</label>
            <label>CountLikes</label>
            <label>CountSessions</label>
            <label>CountComments</label><br>

        <?php
            $getUsers = $db->query($db->connection(), 'SELECT * FROM users');
            while($row = mysqli_fetch_array($getUsers))    {
                $countLikes = mysqli_num_rows($db->query($db->connection(), "SELECT * FROM likes WHERE UserID =" . $row['UserID']));
                $countSessions = mysqli_num_rows($db->query($db->connection(), "SELECT * FROM sessions WHERE UserID =" . $row['UserID']));
                $countComments = mysqli_num_rows($db->query($db->connection(), "SELECT * FROM comments WHERE UserID =" . $row['UserID']));
                ?>

            <form action="admin.php" method="POST">
                <input name="UserID" readonly style="border: none; width: 50px; margin: 10px 0 0 90px; text-align: center" type="text" value="<?php echo $row['UserID']; ?>">
                <input name="UserLogin" style="width: 100px; margin: 10px 0 0 80px; text-align: center" type="text" value="<?php echo $row['UserLogin']; ?>">
                <input name="UserFirstName" style="width: 100px; margin: 10px 0 0 70px; text-align: center" type="text" value="<?php echo $row['UserFirstName']; ?>">
                <input name="UserSecondName" style="width: 100px; margin: 10px 0 0 85px; text-align: center" type="text" value="<?php echo $row['UserSecondName']; ?>">
                <input name="UserDateRegistration" readonly style="border: none; width: 80px; margin: 10px 0 0 140px; text-align: center" type="text" value="<?php echo $row['UserDateRegistration']; ?>">
                <input name="UserEmail" style="width: 150px; margin: 10px 0 0 80px; text-align: center" type="text" value="<?php echo $row['UserEmail']; ?>">
                <input readonly style="border:none; width: 150px; margin: 10px 0 0 10px; text-align: center" type="text" value="<?php echo $countLikes; ?>">
                <input readonly style="border:none; width: 150px; margin: 10px 0 0 10px; text-align: center" type="text" value="<?php echo $countSessions; ?>">
                <input readonly style="border:none; width: 150px; margin: 10px 0 0 50px; text-align: center" type="text" value="<?php echo $countComments; ?>">
                <input type="submit" name="deleteUser" value="-">
                <input type="submit" name="updateUser" value="+">
            </form>
                <?php
            }
            ?>
        </div>
    <?php
    }
    ?>
</html>