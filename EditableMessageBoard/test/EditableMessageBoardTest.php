<?php
namespace editablemessageboard\test;
require "vendor/autoload.php";
use \editablemessageboard\EditableMessageBoard;

class EditableMessageBoardTest extends \PHPUnit_Framework_TestCase
{

    //test that a message is returned correctly if the database has one
    public function testReadMessages()
    {
	$row = array("id"=>"1","message"=>"Hello","user_id"=>"2");
	$result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();
        $result->expects($this->at(0))->method('fetch_assoc')->will($this->returnValue($row));
        $result->expects($this->at(1))->method('fetch_assoc')->will($this->returnValue(false));
	$stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
	$stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
	$stmt->expects($this->once())->method('get_result')->will($this->returnValue($result));

	$connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
	$connector->expects($this->once())->method('prepare')->will($this->returnValue($stmt));

	$emb = new EditableMessageBoard($connector,null);
	$messages = $emb->getMessages();
        $this->assertEquals($messages[0]["id"], "1");
	$this->assertEquals($messages[0]["text"], "Hello");
       	$this->assertEquals($messages[0]["userid"], "2");
    }

    //test that an empty array is returned if the database has no messages
    public function testReadMessagesEmpty()
    {
        
        $result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();
        $result->expects($this->at(0))->method('fetch_assoc')->will($this->returnValue(false));
        $stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
        $stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('get_result')->will($this->returnValue($result));

        $connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
        $connector->expects($this->once())->method('prepare')->will($this->returnValue($stmt));

        $emb = new EditableMessageBoard($connector,null);
        $messagelength = sizeof($emb->getMessages());
        $this->assertEquals($messagelength, 0);
    }

    //test that the correct statement is issued to add a message
    public function testAddMessage()
    {
        $stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
        $stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('bind_param')->with($this->equalTo("si"),$this->equalTo("Hello"),$this->equalTo(1))->will($this->returnValue(true));
        $connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
        $connector->expects($this->once())->method('prepare')->with($this->equalTo("INSERT INTO messages (message,user_id) VALUES (?,?)"))->will($this->returnValue($stmt));

        $emb = new EditableMessageBoard($connector,null);
        $emb->addMessage(1,"Hello");
    }

    //test the message is returned correctly if it exists and belongs to this user
    public function testReadSingleMessage()
    {
        $row = array("message"=>"Hello","user_id"=>2);
        $result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();
        $result->expects($this->at(0))->method('fetch_assoc')->will($this->returnValue($row));
        $stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
        $stmt->expects($this->once())->method('bind_param')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('get_result')->will($this->returnValue($result));

        $connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
        $connector->expects($this->once())->method('prepare')->will($this->returnValue($stmt));

        $emb = new EditableMessageBoard($connector,null);
        $message = $emb->getSingleMessage(1,2);
        $this->assertEquals($message["correctUser"], true);
        $this->assertEquals($message["message"], "Hello");
    }
    //test that a missing message is handled correctly
    public function testReadSingleMessageAbsent()
    {
        $result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();
        $result->expects($this->at(0))->method('fetch_assoc')->will($this->returnValue(false));
        $stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
        $stmt->expects($this->once())->method('bind_param')->will($this->returnValue(true));
	$stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('get_result')->will($this->returnValue($result));

        $connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
        $connector->expects($this->once())->method('prepare')->will($this->returnValue($stmt));

        $emb = new EditableMessageBoard($connector,null);
        $message = $emb->getSingleMessage(1,2);
    }

    //test that an incorrect user id is handled correctly
    public function testReadSingleMessageIncorrectUser()
    {
        $row = array("message"=>"Hello","user_id"=>"5");
        $result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();
        $result->expects($this->at(0))->method('fetch_assoc')->will($this->returnValue($row));
        $stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
        $stmt->expects($this->once())->method('bind_param')->will($this->returnValue(true));        
	$stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('get_result')->will($this->returnValue($result));

        $connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
        $connector->expects($this->once())->method('prepare')->will($this->returnValue($stmt));

        $emb = new EditableMessageBoard($connector,null);
        $message = $emb->getSingleMessage(1,2);
        $this->assertEquals($message["correctUser"], false);
    }
   
   //test that correct SQL statements are issued to edit a message
   public function testEditMessage()
   {
        $row = array("user_id"=>"2");
        $result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();
        $result->expects($this->at(0))->method('fetch_assoc')->will($this->returnValue($row));
        $stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
        $stmt2 = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
	$stmt->expects($this->at(0))->method('bind_param')->will($this->returnValue(true));
        $stmt2->expects($this->at(0))->method('bind_param')->with($this->equalTo("si"),$this->equalTo("Hello"),$this->equalTo("1"))->will($this->returnValue(true));
	$stmt->expects($this->at(1))->method('execute')->will($this->returnValue(true));
	$stmt2->expects($this->at(1))->method('execute')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('get_result')->will($this->returnValue($result));

        $connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
        $connector->expects($this->at(0))->method('prepare')->will($this->returnValue($stmt));
        //make sure second prepared statement is the correct update
	$connector->expects($this->at(1))->method('prepare')->with($this->equalTo("UPDATE messages SET message = ? WHERE id = ?"))->will($this->returnValue($stmt2));
        
	$emb = new EditableMessageBoard($connector,null);
        $message = $emb->editMessage(2,1,"Hello");
        $this->assertEquals($message, true);
   }

   //test that message is not editted when the message does not belong to this user
   public function testEditMessageIncorrectUser()
   {
 
        $row = array("user_id"=>"5");
        $result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();
        $result->expects($this->at(0))->method('fetch_assoc')->will($this->returnValue($row));
        $stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
        $stmt->expects($this->once())->method('bind_param')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('get_result')->will($this->returnValue($result));
       
        $connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
    	//$this->once() ensures that no other statement is issued
        $connector->expects($this->once())->method('prepare')->will($this->returnValue($stmt));
        
	$emb = new EditableMessageBoard($connector,null);
        $message = $emb->editMessage(2,1,"Hello");
        $this->assertEquals($message, false); 
  }

	
}
