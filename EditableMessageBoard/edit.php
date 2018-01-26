<?php
require_once './vendor/autoload.php';
use editablemessageboard\EditableMessageBoard;
date_default_timezone_set('America/Louisville');
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

session_start();
$userid = null;
$loggedin = false;

$mysqli = new mysqli("127.0.0.1", "editablemessageboard", "password", "EditableMessageBoard");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$stmt = null;

if (isset($_SESSION['userid']))
{
        $userID = $_SESSION['userid'];
        $loggedin = true;
	$emb = new EditableMessageBoard($mysqli,null);
	if (isset($_GET['messageid']))
	{
		$messageID = $_GET['messageid'];
		$messageArray = $emb->getSingleMessage($messageID,$userID);
			
		echo $twig->render("edit.html", array("message" => $messageArray['message'],"correctuser" => $messageArray['correctUser'], "messageid" => $messageID));
  					
	}
	else if (isset($_POST['messageid']))
	{
		$messageID = $_POST['messageid'];
		$message = $_POST['message'];
		$emb->editMessage($userID,$messageID,$message);
		header("Location: index.php");
	}
}






