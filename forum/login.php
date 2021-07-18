<?php
    require "connect.php";
	#можно было бы вынести общую часть в отдельный файл, но их и так уже многовато
    if(isset($_POST['login_subm'])){
        unset($_POST['login_subm']);
        unset($_POST['error']);
        $login = $_POST['login'];
    	$password = $_POST['password'];
    	$password = md5($password);

		if(trim($password)==''){
	        $_POST['error']='Пароль не должен быть пустым!';
	    }
    	if(trim($login)==''){
	        $_POST['error']='Логин не должен быть пустым!';
    	}
	    if(mb_strlen($login)>30){
	        $_POST['error']='Логин должен быть <= 30 символов!';
	    }
    	if(!isset($_POST['error'])){
        	$stmt = $mysql->prepare("SELECT * FROM users WHERE login= ? AND password= ?");
            $stmt->bind_param("ss", $login, $password);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
            
            $user=$res->fetch_assoc();
            if(!$user){
                $_POST['error']='Нет такого пользователя!';
            }
            else{
                $_SESSION['logged_user']=$login;
                header('Location: /myForum');
            }
    	}
    }
?>
<head>
	<link rel="stylesheet" href="forum/auth.css">
	<script src="forum/auth.js"></script>
	<meta charset="utf-8">
	<title>Сайт правды</title>
</head>
<body onload="start()">
    <div style="height: 255px" class="main">
        <form method="post">
            <p class="name">Авторизация</p>
            <button class="exit_button" type="button" onClick='location.href="/myForum"'>X</button>
            <div>
                <p class="text">Логин:</p>
                <input required type="text" name="login" value="<?php echo @$_POST['login']?>" maxlength="30"></input>
            </div>
            <div>
                <p class="text">Пароль:</p>
                <input required type="password" name="password" value="<?php echo @$_POST['password']?>"></input>
            </div>
            <p class="error_label">
				<?php if(isset($_POST['error'])){
					echo $_POST['error'];
				} else {
					echo 'Тарелки можно перетягивать)';
				}?>
			</p>
            <button required type="submit" class="submit_button" name="login_subm">Войти</buttom>
        </form>
    </div>
</body>