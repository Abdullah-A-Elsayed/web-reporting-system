<?php
session_start();
if (isset($_SESSION['id'])) {
	unset($_SESSION['id']);
	$_SESSION = [];
	session_destroy();
	if ( isset( $_COOKIE[session_name()] ) ){
		echo "cookie";
		setcookie( session_name(),"",0);
	}
}
header("Location: ../");
exit();

?>