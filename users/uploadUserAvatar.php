<?php
include("../system/status.php");
include("../system/db.php");
include("../sessions/checkSession.php");
header('Content-type: application/json');
session_start();



if(!empty($_POST))
{
    if(equalSessions(getSession()))
    {
        $db = new MysqliDB;
    
        $uploaddir = 'userAvatars/';
        $uploadfile = $_FILES['image']['name'];
        $UserLogin = $_POST['UserLogin'];
        
        $images = array(".jpg", ".png", ".jpeg", ".bmp", ".JPG", ".PNG", ".JPEG", ".BMP");
        $ext = substr($uploadfile, strpos($uploadfile, '.'), strlen($uploadfile));
        
        
        
        if(in_array($ext, $images))
        {
            while(file_exists($uploaddir . $uploadfile))
            {
                $uploadfile = 'a' . $uploadfile;
            }
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir . $uploadfile))
            {
                $image = 'http://testtest-su.1gb.ru/users/userAvatars/' . $uploadfile;
                $query = $db->query($db->connection(), "UPDATE users SET UserAvatar = '$image' WHERE UserLogin = '$UserLogin'");
                $query1 = $db->query($db->connection(), "SELECT * FROM users WHERE UserLogin = '$UserLogin'");
                $row = mysqli_fetch_array($query1);
                
                
                
                $data = array(
                    "UserID" => $row['UserID'],
                    "UserLogin" => $row['UserLogin'],
                    "UserEmail" => $row['UserEmail'],
                    "UserAvatar" => $row['UserAvatar'],
                    "UserFirstName" => $row['UserFirstName'],
                    "UserSecondName" => $row['UserSecondName']
                );
                echo json_encode($data);
                mysqli_close($db->connection());
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