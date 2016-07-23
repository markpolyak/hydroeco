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

if(isset($_POST['UserEmail']))
{
    $UserEmail = $_POST['UserEmail'];
    $_SESSION['Code'] = rand(1000, 9999);
    $message = "Your code is : " . $_SESSION['Code']; 
    _mail('myprogress@1gb.ru', $UserEmail, 'Activation', 'Your code is ' . $_SESSION['Code']);
    
    $lang = new Language;
    if($lang->getLanguage() == 'ru')
    {
         $status = array("Request" => 200, "Message" => "Код был выслан");
    }
    else if('en')
    {
          $status = array("Request" => 200, "Message" => "Code was sent");
    }
   
}
else
{
    http_response_code(409);
    $lang = new Language;
    if($lang->getLanguage() == 'ru')
    {
        $status = array("Request" => 409, "Error" => "Некорректный e-mail");
    }
    else if('en')
    {
        $status = array("Request" => 409, "Error" => "Incorrect e-mail");
    }
}

echo json_encode($status);

?>