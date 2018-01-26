<?php
namespace simplemessageboard;
require_once './vendor/autoload.php';

class SimpleMessageBoard
{

	private $mysqli;

	public function __construct($connection)
	{
		$this->mysqli = $connection;		
	}

	public function addMessage ($message)
	{
  		$stmt = null;
		if (!($stmt = $this->mysqli->prepare("INSERT INTO messages (message) VALUES (?)"))) 
		{
			return false;
		}
		else if (!$stmt->bind_param("s", $message)) 
		{
			return false;
		}

		else if (!$stmt->execute()) 
		{
			return false;
		}
		return true;

	}

	public function getMessages()
	{
		$stmt = null;
		$messages = array();
		if (!($stmt = $this->mysqli->prepare("SELECT * FROM messages"))) 
		{
			return $messages;
		}

		if (!$stmt->execute()) 
		{
			return $messages;
		}

		$result = $stmt->get_result();
    		while ($row = $result->fetch_assoc()) 
		{
			array_push($messages,array ("id" => $row['id'], "text" => $row['message']));
		}
		return $messages;
	}
}
