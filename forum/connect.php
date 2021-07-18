<?php
	$mysql = new mysqli('localhost','id16263019_goose_pusher','F0R-R4M=}V]4@8|k');
	$mysql->query("CREATE DATABASE IF NOT EXISTS id16263019_my_bd");
	$mysql->select_db("id16263019_my_bd");
	
	if(!$mysql->query("SELECT * FROM users WHERE id=1 ")){
        $mysql->query("CREATE TABLE `users` (
          `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          `login` varchar(30) NOT NULL,
          `email` varchar(30) NOT NULL,
          `password` varchar(32) NOT NULL,
          UNIQUE (`login`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        $pass = md5('admin');
	    $mysql->query("INSERT INTO users (login, email, password) VALUES ('admin','admin@gmail.com','$pass')");
	}
	
    $mysql->query("CREATE TABLE IF NOT EXISTS `forum_names` (
          `visiable_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
          `forum_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
          `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
    
	session_start();