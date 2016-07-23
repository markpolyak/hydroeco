<?php
header('Content-type: application/json');
include("../system/db.php");
include("../system/language.php");
include("../sessions/checkSession.php");

session_start();

if(equalSessions(getSession()))
{
    $session = getSession();
    $db = new MysqliDB;
    $query = $db->query($db->connection(), "DELETE FROM sessions WHERE SessionID = '$session'");
    session_destroy();

    $lang = new Language;
    if($lang->getLanguage() == 'ru')
    {
        $status = array('Request' => 200, 'Message' => 'Выход');
    }
    else if('en')
    {
        $status = array('Request' => 200, 'Message' => 'Logout');
    }
    echo json_encode($status);
    unset($_SESSION);
}
?>