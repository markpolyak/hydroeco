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
        $TargetID = $_POST['TargetID'];
        
        $uploaddir = 'targetsVideoConfirmation/';
        $uploadfile = $_FILES['video']['name'];
        
        $images = array(".avi", ".AVI", ".wmv", ".WMV", ".mov", ".MOV", ".mkv", ".MKV", ".3gp", ".3GP", ".mp4", ".MP4");
        $ext = substr($uploadfile, strpos($uploadfile, '.'), strlen($uploadfile));
        
        
        
        if(in_array($ext, $images))
        {      
            if (move_uploaded_file($_FILES['video']['tmp_name'], $uploaddir . $uploadfile))
            {
                $query = $db->query($db->connection(), "UPDATE targets SET TargetConfirmationData = '$uploadfile', TargetDone = 1, TargetDoneDate = date(NOW()) WHERE TargetID = '$TargetID'");
                                
                $lang = new Language;
                if($lang->getLanguage() == 'ru')
                {
                    $status = array("VideoLink" => $uploadfile, "Request" => 200, "Message" => "Подтверждение было добавлено");
                }
                else if('en')
                {
                    $status = array("VideoLink" => $uploadfile, "Request" => 200, "Message" => "Confirmation was added");
                } 
                echo json_encode($status);
            }
            else 
            {
                http_response_code(406);
                $lang = new Language;
                if($lang->getLanguage() == 'ru')
                {
                    $status = array("Request" => 406, "Error" => "Ошибка при загрузке файла");
                }
                else if('en')
                {
                    $status = array("Request" => 406, "Error" => "Error in upload file");
                }
                
                echo json_encode($status);
            }
            mysqli_close($db->connection());
        }
        else
        {
            http_response_code(406);
            $lang = new Language;
            if($lang->getLanguage() == 'ru')
            {
                $status = array("Request" => 406, "Error" => "Неподдерживаемое расширение файла");
            }
            else if('en')
            {
                $status = array("Request" => 406, "Error" => "Unsupported extension");
            }
            
            echo json_encode($status);
        }
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