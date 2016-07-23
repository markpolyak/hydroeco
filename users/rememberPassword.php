<?php
include("../system/status.php");
include("../system/db.php");
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

if(isset($_POST['UserLogin']))
{
    $UserLogin = $_POST['UserLogin'];
    
    $db = new MysqliDB;
    $cnn = $db->connection();
    
    $query = $db->query($cnn, "SELECT UserEmail, UserID FROM users WHERE UserLogin = '$UserLogin'");
    if(mysqli_num_rows($query) == 1)
    {
        $row = mysqli_fetch_array($query);
        $UserEmail = $row['UserEmail'];
        
        $_SESSION['Code'] = rand(1000, 9999);
        $_SESSION['UserID'] = $row['UserID'];
        $message = "Your code is : " . $_SESSION['Code']; 
        _mail('myprogress@1gb.ru', $UserEmail, 'Activation', 'Your code is ' . $_SESSION['Code']);
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 200, "Message" => "Код был выслан на ваш e-mail");
        }
        else if('en')
        {
            $status = array("Request" => 200, "Message" => "Code was sent to you email");
        }
    }
    else
    {
        http_response_code(409);
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 409, "Error" => "Неправильный код");
        }
        else if('en')
        {
            $status = array("Request" => 409, "Error" => "Incorrect login");
        }
    }
    echo json_encode($status);
}
else
{
    $status = new Status;
    $status->AutorizationError();
}

?>