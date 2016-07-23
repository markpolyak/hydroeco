<?php

$client_id = '5553137';
$client_secret = 'gRfQ2pTGd7QHjhUMaN1K';
$redirect_uri = 'http://testtest-su.1gb.ru/auth/vk';

$url = 'http://oauth.vk.com/authorize';

$params = array(
    'client_id'     => $client_id,
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code'
);


    if (isset($_GET['code']))
    {

        $token = json_decode(file_get_contents("https://oauth.vk.com/access_token?client_id=" . $client_id . "&client_secret=" . $client_secret . "&code=" . $_GET['code'] . "&redirect_uri=" . $redirect_uri), true);
        if(isset($token['access_token']))
        {
            $params1 = array(
                'uids'         => $token['user_id'],
                'fields'       => 'first_name,last_name,photo_big',
                'access_token' => $token['access_token']
            );
            
            $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params1))), true);
            //print_r($userInfo);
            
            echo $userInfo['response']['0']['first_name'] . '<br />';
            echo $userInfo['response']['0']['last_name'] . '<br />';
            echo $userInfo['response']['0']['photo_big'];
        }
    }
else
{
    echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a></p>';
}

//$url = " . ;


//echo '<a href="' . $url . '">url</a>';




?>