<?php
	require "connect.php";
	$table = $_POST['table'];
    $mes_id = $_POST['mes_id'];

	if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']=='admin' && trim($table)!=''
	        && trim($mes_id)!='') {
    	$req1 = $mysql->prepare("SElECT*FROM forum_names WHERE visiable_name = ?");
    	$req1->bind_param("s", $table);
        $req1->execute();
        $tableName = ($req1->get_result()->fetch_assoc())['forum_name'];
        $req1->close();
        
        $req2 = $mysql->prepare("DELETE FROM $tableName WHERE id = ?");
    	$req2->bind_param("i", $mes_id);
        $req2->execute();
        $req2->close();
	}
	header('Location: /myForum');
?>