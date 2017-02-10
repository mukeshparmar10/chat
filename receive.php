<?php
	if(isset($_REQUEST['session']) && isset($_REQUEST['user_session']))
	{
		$session = $_REQUEST['session'];
		$user_session = $_REQUEST['user_session'];
		
		require('db.php');
		$query = "SELECT * FROM chat WHERE Session like'$session' AND IsRead=0 AND UserSession NOT LIKE '$user_session'";
		$result = $con->query($query);
		if($result->num_rows>0)
		{
			while($row = $result->fetch_array())
			{
				$id = $row[0];
				$query = "UPDATE chat SET IsRead=1 WHERE ID=$id";
				$con->query($query);
				$reply = json_encode(array($row[2],$row[3]));
				echo $reply;
				break;
			}
		}
	}
	else
	{
		echo "Invalid access.";	
	}
?>