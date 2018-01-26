<?php
require_once './vendor/autoload.php';
use simplemessageboard\SimpleMessageBoard;
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

$mysqli = new mysqli("127.0.0.1", "simplemessageboard", "password", "SimpleMessageBoard");
if ($mysqli->connect_errno) 
{
    	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$smb = new SimpleMessageBoard($mysqli);
if (isset($_POST['message']))
{
	$smb->addMessage($_POST['message']);
}
$messages = $smb->getMessages();

echo $twig->render("index.html", array("messages" => $messages));

