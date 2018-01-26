<?php
require_once './vendor/autoload.php';
use editablemessageboard\EditableMessageBoard;
date_default_timezone_set('America/Louisville');
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

session_start();
$userID = null;
$loggedIn = false;
$client = new Google_Client();
$client->setAuthConfig('clientsecret.json');
$client->setAccessType("offline");        // offline access
$client->setIncludeGrantedScopes(true);   // incremental auth
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
$client->setRedirectUri('http://localhost/EditableMessageBoard/index.php');

$mysqli = new mysqli("127.0.0.1", "editablemessageboard", "password", "EditableMessageBoard");
if ($mysqli->connect_errno) 
{
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$emb = new EditableMessageBoard($mysqli,$client);
$stmt = null;

//handle case where already logged in
if (isset($_SESSION['userid']))
{
        $userID = $_SESSION['userid'];
        $loggedIn = true;
}
//handle case where OAuth response sent
else if (isset($_GET['code']))
{
	$emb->processAuthToken($_GET['code']);
        $userID = $_SESSION['userid'];
        $loggedIn = true;
}

//handle edit request
if (isset($_POST['message']))
{
	$message = $_POST['message'];
	$emb->addMessage($userID,$message);
}

$messages = $emb->getMessages();

echo $twig->render("index.html", array("messages" => $messages,"loggedin" => $loggedIn, "userid" => $userID,"authurl"=>filter_var($client->createAuthUrl(), FILTER_SANITIZE_URL)));

