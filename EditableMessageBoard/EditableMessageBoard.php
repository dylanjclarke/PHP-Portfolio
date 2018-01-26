<?php
namespace editablemessageboard;
include "vendor/autoload.php";
class EditableMessageBoard
{

	private $mysqli;
	private $client;

	public function __construct($connection,$googleClient)
	{
		$this->mysqli = $connection;		
		$this->client = $googleClient;
	}

	public function processAuthToken($token)
	{

		$stmt = null;
		//process authorisation token and set userid in session
		$this->client->authenticate($token);
		$access_token = $this->client->getAccessToken();
		$Oauth2 = new \Google_Service_Oauth2($this->client);
		$googleid = $Oauth2->userinfo->get()->getId();

		//check if there's a user id matching this
  		if (!($stmt = $this->mysqli->prepare("SELECT local_id FROM users WHERE oauth_id = ?"))) 
		{
			return false;
		}
		if (!$stmt->bind_param("s", $googleid))
		{
			return false;
		}
		if (!$stmt->execute()) 
		{
    			return false;
		}
		$result = $stmt->get_result();
		//case where we've already seen this user before
    		if ($row = $result->fetch_assoc()) 
   		{
   		 	$userid = $row['local_id'];
			$_SESSION['userid'] = $userid;
			return true;
  		}
		//case where we haven't seen this user before
		//add them to the database
		else
		{
   			if (!($stmt = $this->mysqli->prepare("INSERT INTO users (oauth_id) VALUES (?)"))) 
			{
				return false;
			}
			if (!$stmt->bind_param("s", $googleid)) 
			{
				return false;
			}

			if (!$stmt->execute()) 
			{
				return false;
			}
			if (!($stmt = $this->mysqli->prepare("SELECT local_id FROM users WHERE oauth_id = ?"))) 
			{
				return false;
			}
			if (!$stmt->bind_param("s", $googleid)) 
			{ 
				return false;
			}		

			if (!$stmt->execute()) 
			{
				return false;
			}

			$result = $stmt->get_result();
    			if ($row = $result->fetch_assoc())
   			{			 
     				$userid = $row['local_id'];
     				$_SESSION['userid'] = $userid;
     				return true;  
  			}
		}
	}


	public function addMessage($userID,$message)
	{
  		$stmt = null;
   		if (!($stmt = $this->mysqli->prepare("INSERT INTO messages (message,user_id) VALUES (?,?)"))) 
		{
			return false;
		}
		if (!$stmt->bind_param("si", $message,$userID)) 
		{
			return false;
		}

		if (!$stmt->execute()) 
		{
			return false;
		}
		return true;
	}


	public function getMessages()
	{
		if (!($stmt = $this->mysqli->prepare("SELECT * FROM messages"))) 
		{
			return false;
		}

		if (!$stmt->execute()) 
		{
			return false;
		}
		$messages = array();
		$result = $stmt->get_result();
    		while ($row = $result->fetch_assoc()) 
		{
			array_push($messages,array ("id" => $row['id'], "text" => $row['message'],"userid" =>$row['user_id']));
		}
		return $messages;
	}
	public function getSingleMessage($messageID,$userID)
	{
             	if (!($stmt = $this->mysqli->prepare("SELECT message,user_id FROM messages WHERE id = ?"))) 
		{
			return false;
                }
                if (!$stmt->bind_param("i", $messageID)) 
		{
			return false;
                }

                if (!$stmt->execute()) 
		{
			return false;	
                }
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc())
                {
                        $correct_user = false;
                        $message = "";
                        if ($userID == $row['user_id'])
                        {
                                $correct_user = true;
                                $message = $row['message'];
                        }
                        return array("message" => $message,"correctUser" => $correct_user);
                }
	}
	public function editMessage($userID,$messageID,$message)
	{
		if (!($stmt = $this->mysqli->prepare("SELECT user_id FROM messages WHERE id = ?"))) 
		{
                	 return false;
                }
                if (!$stmt->bind_param("i", $messageID)) 
		{
                        return false;
                }

                if (!$stmt->execute()) 
		{
			return false;
                }

                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc())
                {
                        if ($userID == $row['user_id'])
                        {
				
                                if (!($stmt = $this->mysqli->prepare("UPDATE messages SET message = ? WHERE id = ?"))) 
				{
					return false;
                                }
                                if (!$stmt->bind_param("si", $message,$messageID)) 
				{
                              		return false;
				}
                                if (!$stmt->execute()) 
				{
                                	return false;
				}
				return true;
                        }
                       return false;
                }
		return false;
	}
}

