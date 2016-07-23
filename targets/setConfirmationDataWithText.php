<?php
include("../system/status.php");
include("../system/db.php");
header('Content-type: application/json');

if(!empty($_POST))
{
    if(equalSessions(getSession()))
    {
        $db = new MysqliDB;
        $cnn = $db->connection();
        $TargetID = $_POST['TargetID'];
        $Message = $_POST['Message'];
        
        $query = $db->query($cnn, "UPDATE targets SET TargetConfirmationData = '$Message', TargetDone = 1, TargetDoneDate = date(NOW()) WHERE TargetID = '$TargetID'");
        
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 200, "Message" => "Подтверждение было добавлено");
        }
        else if('en')
        {
            $status = array("Request" => 200, "Message" => "Confirmation was added");
        }
        echo json_encode($response);
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