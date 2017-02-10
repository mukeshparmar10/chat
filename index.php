<?php
	session_start();
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chat</title>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
var user_session = "<?php echo session_id();?>";
function receiveMsg()
{
	if($("#chat_session").val()!="")
	{
		var session = $("#chat_session").val();
		
		$.post("http://<?php echo $_SERVER['HTTP_HOST'];?>/Chat/receive.php",{session:session,user_session:user_session},function(data){
			if(data)
			{
				var receive_msg=JSON.parse(data);
				if(receive_msg[0]!=user_session)
				{
					var msg = '<div class="message"><span class="friend">Friend :</span><br>' + receive_msg[1] + '</div>';
					$("#all_msg").append(msg);
				}
			}
		});
	}
	setTimeout("receiveMsg()",5000);
}

receiveMsg();
function sendMsg()
{
	if($("#chat_session").val()=="")
	{
		$("#chat_session").focus();
		return false;
	}
	else
	{
		var session = $("#chat_session").val();
	}
	
	if($("#send_msg").val()=="")
	{
		$("#send_msg").focus();
		return false;
	}
	else
	{
		var msg = '<div class="message"><span class="you">You :</span><br>' + $("#send_msg").val() + '</div>';
		var send_msg = $("#send_msg").val();
		$("#all_msg").append(msg);
		$("#send_msg").val("");
		$.post("http://<?php echo $_SERVER['HTTP_HOST'];?>/Chat/send.php",{msg:send_msg,session:session,user_session:user_session},function(data){
		});
	}
}

function sendMsgEnter(event)
{
	var x = event.which || event.keyCode;
	if(x==13)
	{
		sendMsg();
	}
}
</script>
<style>
#all_msg{
	border:solid 1px #000;
	height:500px;
	width:500px;
	overflow:scroll;
	padding:5px;
	background-color:#F9F9F9;
}

#send_msg{
	width:78%;
	border:solid 1px #999999;
	height:30px;
}

#btnSend{
	width:20%;
	height:30px;
}

.message{
	margin:10px;
	padding:7px;
	box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12) !important;
}

.you{
	font-weight:bold;
	color:#006600;
}

.friend{
	font-weight:bold;
	color:#0000FF;
}
</style>
</head>
<body>
<table width="500px">
<tr>
	<td>Chat Session : <input id="chat_session" type="text" maxlength="10" /></td>
</tr>
<tr>
	<td id="all_msg" valign="top" align="left"></td>
</tr>
<tr>
	<td>
    	<input id="send_msg" type="text" onkeypress="sendMsgEnter(event)" />
        <input id="btnSend" type="button" value="Send" onclick="sendMsg()" />
    </td>
</tr>
</table>
</body>
</html>