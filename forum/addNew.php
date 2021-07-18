<?php
	require "connect.php";
    $desc = $_POST['desc'];

	if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']=='admin' && trim($desc)!='' && mb_strlen($desc)<=30) {
	    $temp = $mysql->query("SELECT * FROM forum_names");
	    $array=array();
    	while( $row = $temp->fetch_assoc()){
             $array[] = $row;
        }
        $number=count($array)+1;
	    $name = 'theme'.$number;
	    $table ='table_for_theme'.$number;
	    
	    $stmt = $mysql->prepare("INSERT INTO forum_names (visiable_name, forum_name, description) VALUES (?,?,?)");
        $stmt->bind_param("sss",$name,$table, $desc);
        $stmt->execute();
        $stmt->close();
        
        $sql = "CREATE TABLE `$table` (
          `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          `date` timestamp NOT NULL DEFAULT current_timestamp(),
          `login` varchar(30) NOT NULL,
          `text` varchar(200) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        
        $mysql->query($sql);
	}
	header('Location: /myForum');
?>