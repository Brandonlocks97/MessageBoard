<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Message Board</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php
		if(isset($_POST["submit"])){
			if(empty($_POST["subject"]) || empty($_POST["name"]) && empty($_POST["message"])) {
				echo "<p>Please enter all fields before posting message</p>";
			}
			else {
				$Subject = $_POST["subject"];
				$Name = $_POST["name"];
				$Message = $_POST["message"];
				
				stripcslashes($Subject);
				stripcslashes($Name);
				stripcslashes($Message);
				
				$Subject = str_replace("~", "-", $Subject);
				$Name = str_replace("~", "-", $Name);
				$Message = str_replace("~", "-", $Message);
				$Subject = str_replace("`", "'", $Subject);
				$Name = str_replace("`", "'", $Name);
				$Message = str_replace("`", "'", $Message);
				
				//Saves to file dependent on day
				$Date = getdate();
				$FileName = "MessageData/".$Date['month'] ."-". $Date['mday']."-".$Date['year'].".txt";
				//formats first message of the day
				if(file_exists($FileName) && filesize($FileName) != 0) {
					$FullMessage = "`".$Subject . "~" . $Name . "~" . $Message;
				}
				else {
					$FullMessage = $Subject . "~" . $Name . "~" . $Message;
				}
				$File = fopen($FileName, "ab");
				fwrite($File, $FullMessage);
				$FullMessage = "";
				
			}
		}
			
	?>
	
	<div class="form">
		<h1>Post a Message</h1>
		<form action="messageBoard.php" method="POST" style="float: left;">
			<P><span>Subject:</span></P>
			<input type="text" name="subject" value="">
			<p><span>Name:</span></p>
			<input type="text" name="name" value="">
			<p><span>Message</span></p>
			</br>
			<textarea name="message" id="" cols="80" rows="6" type="text" value=""></textarea>
			</br>
			<div>
			<input type="submit" name="submit" value="Submit Form" style="margin-right:25px">
			<input type="reset" name="reset" value="Reset Form">
			</div>
		</form>
	
		<div class= "Messages" style="float: right;">
		<?php
		$Date = getdate();
		$FileName = ("MessageData/".$Date['month'] ."-". $Date['mday']."-".$Date['year'].".txt");
		if(file_exists($FileName) && filesize($FileName) != 0) {
			$File = fopen($FileName, "r");
			$Messages =  fread($File, 10000);
			
			$FullMessage = explode("`", $Messages);
			
			foreach($FullMessage as $MessagePart) {
				$MessageArray = explode("~", $MessagePart);
				echo "<div class='message'>";
				echo $Date["hours"].":".$Date["minutes"].":".$Date["seconds"]; //only posts current date!!!!!!!!!
				echo "<p>Subject:" . $MessageArray['0']."</p>"."<br>"."<p>Name: ".$MessageArray['1']."</p>"."<br>"."<p>Message: ".$MessageArray['2']."</p>"."<br>";
				echo "<br>";
				echo "<hr></div>";
			}
			
			
		}
		else {
			echo "<p>No Messages Yet</p>";
			
		}
		?>
		</div>
	</div>
	
</body>
</html>