<?php
	require "connect.php";
    $table = $_POST['table'];
    $login = $_SESSION['logged_user'];
    $mes = $_POST['message'];

	if(isset($login) && trim($table)!='' && trim($mes)!='' && strlen($mes)<=200) {
    	$req = $mysql->prepare("SElECT*FROM forum_names WHERE visiable_name = ?");
    	$req->bind_param("s", $table);
        $req->execute();
        $tableName = ($req->get_result()->fetch_assoc())['forum_name'];
        $req->close();

	    $stmt = $mysql->prepare("INSERT INTO $tableName (date, login, text) VALUES (current_timestamp(),?,?)");
        $stmt->bind_param("ss",$login,$mes);
        $stmt->execute();
        $stmt->close();
	}
	header('Location: /myForum');
?>