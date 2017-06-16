<?php
if (isset($_POST['url'])) {
	if ($_POST['url']=='0123455') {
		session_start();
$_SESSION["login"]=1;
	header('Location: index.php');
	}
	
}
?>

<form method="post" action="login.php">
<input type="password" name="url"/>
</form>