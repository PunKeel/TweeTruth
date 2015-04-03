<?php
if(date('y-m-d') != '15-04-02'){
	echo '<h1>Invalid date :(</h1>';
	exit;
}

if(intval(date('H'))>=1){
	echo '<h1>Too late :(</h1>';
	exit;
}

$modif_ago = time() - filemtime('.tweet');
if($modif_ago < 60) {
	echo '<h1>Too fast, only one tweet per minute is allowed! :(</h1>';
	exit;
}

$msg = filter_input(INPUT_POST, 'message');

if(empty($msg) || strlen($msg)>130){
        echo '<h1>Euh, non ? :(</h1>';
        exit;
}

require_once('vendor/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;
$config = require_once('config.php');
$connection = new TwitterOAuth($config['CONSUMER_KEY'], $config['CONSUMER_SECRET'], $config['ACCESS_TOKEN'], $config['ACCESS_TOKEN_SECRET']);
$statues = $connection->post("statuses/update", array("status" => $msg));
if($connection->getLastHttpCode() == 200){
	echo '<h1>OK!</h1>';
	exit;
}
echo '<h1>An error occu<span color="red">red</span> :(</h1>';
