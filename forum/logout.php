<?php
	require "connect.php";
	unset($_SESSION['logged_user']);
    header('Location: /myForum');
?>