<?php
include("language.php");
class Status
{
    function AutorizationError()
    {
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 401, "Error" => "Некорректный логин или пароль");
        }
        else if('en')
        {
            $status = array("Request" => 401, "Error" => "Incorrect login or password");
        }
        
        http_response_code(401);
        echo json_encode($status);
    }
    
    function DataError()
    {
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 406, "Error" => "Нету данных");
        }
        else if('en')
        {
            $status = array("Request" => 406, "Error" => "No data");
        }
        
        http_response_code(406);
        echo json_encode($status);
    }
    
    function SessionExists()
    {
        $lang = new Language;
        if($lang->getLanguage() == 'ru')
        {
            $status = array("Request" => 402, "Error" => "Сессия уже существует");
        }
        else if('en')
        {
            $status = array("Request" => 402, "Error" => "Session already exists");
        }
        
        http_response_code(402);
        echo json_encode($status);
    }

}


?>