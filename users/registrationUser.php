<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/startSession.php");
header('Content-type: application/json');

session_start();

function _mail ($from, $to, $subj, $what)
{
mail($to, $subj, $what,
"From: $from
Reply-To: $from
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit"
);
}

if(!empty($_POST))
{   
    $UserLogin = $_POST['UserLogin'];
    $UserPassword = $_POST['UserPassword'];
    $UserEmail = $_POST['UserEmail'];

        
    $db = new MysqliDB;
        
    $UserPassword = md5($UserPassword);
    $UserDateRegistration = date("Y-m-d");
        
    ///////////CheckEmail
    $CheckEmail = $db->query($db->connection(), "SELECT * FROM users WHERE UserEmail = '$UserEmail'");
        
    if(mysqli_num_rows($CheckEmail) != 0)
    {
        http_response_code(409);
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 409, "Error" => "Данный e-mail уже существует");
        }
        else if('en')
        {
            $data = array("Request" => 409, "Error" => "This email already exists");  
        }     
        echo json_encode($data);
    }
    else
    {
        //////////CheckLogin
        $CheckLogin = $db->query($db->connection(), "SELECT * FROM users WHERE UserLogin = '$UserLogin'");
            
        if(mysqli_num_rows($CheckLogin) != 0)
        {   
            http_response_code(409);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" => 409, "Error" => "Данный логин уже существует");
            }
            else if('en')
            {
                $status = array("Request" => 409, "Error" => "This login already exists"); 
            }  
            echo json_encode($data);
        }
        else
        {
            $query = $db->query($db->connection(), "DELETE FROM unconfirmedusers WHERE UserLogin = '$UserLogin'");
            $query = $db->query($db->connection(), "INSERT INTO unconfirmedusers (UserLogin, UserPassword, UserEmail, UserDateRegistration) VALUES ('$UserLogin', '$UserPassword', '$UserEmail', '$UserDateRegistration')");   
                  
            $query = $db->query($db->connection(), "SELECT * FROM unconfirmedusers WHERE UserLogin = '$UserLogin'");
            $row = mysqli_fetch_array($query);
            
            $_SESSION['Code'] = rand(1000, 9999);
            $message = "Your code is : " . $_SESSION['Code']; 
            _mail('myprogress@1gb.ru', $UserEmail, 'Activation', 'Your code is ' . $_SESSION['Code']);
            $data = array("Request" => 200, "UserID" => $row['UserID'], "Code" => $_SESSION['Code']);
            echo json_encode($data);
        }
    }
}
else
{
    $status = new Status;
    $status->DataError();
}
?>
