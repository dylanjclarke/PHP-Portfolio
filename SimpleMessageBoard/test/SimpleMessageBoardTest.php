<?php
namespace simplemessageboard\test;
require "vendor/autoload.php";
use \simplemessageboard\SimpleMessageBoard;

class SimpleMessageBoardTest extends \PHPUnit_Framework_TestCase
{

    //test that a message is returned correctly if the database has one
    public function testReadMessages()
    {
	$row = array("id"=>"1","message"=>"Hello");
	$result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();
        $result->expects($this->at(0))->method('fetch_assoc')->will($this->returnValue($row));
        $result->expects($this->at(1))->method('fetch_assoc')->will($this->returnValue(false));
	$stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
	$stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
	$stmt->expects($this->once())->method('get_result')->will($this->returnValue($result));

	$connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
	$connector->expects($this->once())->method('prepare')->will($this->returnValue($stmt));

	$smb = new SimpleMessageBoard($connector);
	$messages = $smb->getMessages();
        $this->assertEquals($messages[0]["id"], "1");
	$this->assertEquals($messages[0]["text"], "Hello");
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

        $smb = new SimpleMessageBoard($connector);
        $messagelength = sizeof($smb->getMessages());
        $this->assertEquals($messagelength, 0);
    }

    //test that the correct statement is issued to add a message
    public function testAddMessage()
    {
        $stmt = $this->getMockBuilder('mysqli_stmt')->disableOriginalConstructor()->getMock();
        $stmt->expects($this->once())->method('execute')->will($this->returnValue(true));
        $stmt->expects($this->once())->method('bind_param')->with($this->equalTo("s"),$this->equalTo("Hello"))->will($this->returnValue(true));
        $connector = $this->getMockBuilder('mysqli')->disableOriginalConstructor()->getMock();
        $connector->expects($this->once())->method('prepare')->with($this->equalTo("INSERT INTO messages (message) VALUES (?)"))->will($this->returnValue($stmt));

        $smb = new SimpleMessageBoard($connector);
        $smb->addMessage("Hello");
    }

}
