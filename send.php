<?php
	if(isset($_REQUEST['msg']) && isset($_REQUEST['session']) && isset($_REQUEST['user_session']))
	{
		$msg = $_REQUEST['msg'];
		$session = $_REQUEST['session'];
		$user_session = $_REQUEST['user_session'];
		
		require('db.php');
		$query = "INSERT INTO chat(Session,UserSession,Message) VALUES('$session','$user_session','$msg')";
		$con->query($query);
	}
	else
	{
		echo "Invalid access.";
	}
?>