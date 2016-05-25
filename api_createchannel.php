<?php

/**
	@author:xdavidhu
	@website:ckdeveloper.tk
*/

//Require the Planet Teamspeak's TS3 PHP Framework
require_once("TS3API/libraries/TeamSpeak3/TeamSpeak3.php");

if(!isset($_GET["channelname"]) && !isset($_GET["channelpass"]) && !isset($_GET["channeluser"])){
    echo "please post/get!";
    exit;
}

//Initializing the variables

$ip = $_SERVER["REMOTE_ADDR"];
$channelName = $_GET["channelname"];
$channelPassword = $_GET["channelpass"];
$channelUser = $_GET["channeluser"];

/* Fill these -> */ $queryUser = "";
                    $queryPass = "";
                    $serverIP = "";

//Connecting to the TeamSpeak server
try {
    $ts3 = TeamSpeak3::factory("serverquery://$queryUser:$queryPass@$serverIP:10011/?server_port=9987");
} catch(Exception $e){
    echo 'CONNECTION_ERROR';
    exit;
}

//Creating the channel
try {
    $top_cid = $ts3->channelCreate(array(
        "channel_name" => $channelName,
        "channel_topic" => "Channel created by: " . $channelUser,
        "channel_codec" => TeamSpeak3::CODEC_OPUS_VOICE,
        "channel_password" => $channelPassword,
        "channel_flag_permanent" => TRUE
    ));
} catch(Exception $e){
    echo 'CHANNEL_ERROR';
    exit;
}

//Creating privilage key for channel admin
try {
    $privilegeKey = $ts3->channelGroupGetByName('Channel Admin')->privilegeKeyCreate($top_cid, 'Token for channel group');
} catch(Exception $e){
    echo 'PRIVILEGE_ERROR';
    exit;
}

echo $privilegeKey;

?>