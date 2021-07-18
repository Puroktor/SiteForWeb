<?php
    if(isset($_POST['signUp'])){
        unset($_POST['signUp']);
        unset($_POST['error']);
        $login = $_POST['login'];
    	$email = $_POST['email'];
    	$password = $_POST['password'];
    	
		if(trim($password)==''){
	        $_POST['error']='Пароль не должен быть пустым!';
	    }
	    if(trim($email)==''){
	        $_POST['error']='Email не должен быть пустым!';
	    }
    	if(trim($login)==''){
	        $_POST['error']='Логин не должен быть пустым!';
    	}
    	if(mb_strlen($email)>30){
	        $_POST['error']='Email должен быть <= 30 символов!';
	    }
	    if(mb_strlen($login)>30){
	        $_POST['error']='Логин должен быть <= 30 символов!';
	    }
	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
	        $_POST['error']='Неверный Email!';
	    }
	    if(!isset($_POST['error'])){
        	$password = md5($password);
        	require "connect.php"; 
            $stmt = $mysql->prepare("INSERT INTO users (login, email, password) VALUES (?,?,?)");
            $stmt->bind_param("sss", $login,$email,$password);
            $res = $stmt->execute();
            $stmt->close();
            
            if($res){
                $_SESSION['logged_user']=$login;
                header('Location: /myForum');
            }else{
                $_POST['error']='Такой пользователь уже есть!';
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
    <div class="main">
        <form method="post">
            <p class="name">Регистрация</p>
            <button class="exit_button" type="button" onClick='location.href="/myForum"'>X</button>
            <div>
                <p class="text">Логин:</p>
                <input required type="text" name="login" value="<?php echo @$_POST['login']?>" maxlength="30"></input>
            </div>
            <div>
                <p class="text">Email:</p>
                <input required type="email" name="email" value="<?php echo @$_POST['email']?>" maxlength="30"></input>
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
            <button type="submit" class="submit_button" name="signUp">Зарегестрироваться</buttom>
        </form>
    </div>
</body>