<?php 
	require "connect.php";
	$temp = $mysql->query("SELECT * FROM forum_names");
	$array=array();
	while( $row = $temp->fetch_assoc()){
         $array[] = $row;
    }
?>
<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Сайт правды</title>
		<script src="forum/forum.js"></script>
		<script src="forum/cookie.js"></script>
		<link rel="stylesheet" href="common.css">
		<link rel="stylesheet" href="forum/forum.css">
	</head>
	<body onload="onLoad()" data-themeCount="<?=count($array)?>">
		<div class="wrapper">
			<div class="header">	
				<span class="head_element"><h1 class="head_text">Форум</h1></span>
				<span class="head_element"><img src="../pictures/write.svg" id="svg_pic"></img></span>
			</div>
			<?php require "../bar.html"; ?>
			<div class="content">
			    <?php if(isset($_SESSION['logged_user'])) : ?>
			        <p id="login_label">Пользователь: <?=htmlentities($_SESSION['logged_user'])?> <a href="forum/logout.php">Выйти</a></a>
			    <?php else : ?>
				    <p id="login_label">Чтобы писать сообщения на форуме <a href="login">войдите</a> / <a href="signup">зарегистрируйтесь</span></a>
			    <?php endif; ?>
			    
				<?php for($i=1;$i<=count($array);$i++): ?>
    				<div class="theme" onclick="open_theme(<?=$i?>)">
    					<div><span id="plus<?=$i?>">+</span>  <?=$array[$i-1]['description']?></div>
    				</div>
    				<div class="theme_container" id="theme<?=$i?>" style="display:none;">
    					<?php
    					    $table = $array[$i-1]['forum_name'];
    						$comments = $mysql->query("SELECT * FROM $table ORDER BY date");
    						foreach($comments as $comment): ?>
        					    <div class="comment">
            						<b><?=htmlentities($comment['login'])?></b>
            						<p class="date"><?=htmlentities($comment['date'])?> </p>
            						<p><?=htmlentities($comment['text'])?></p>
									<?php if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']=='admin') : ?>
									    <form class="del_form" method="post" action="forum/delMes.php">
									        <button class="del_button" name="mes_id" value="<?=$comment['id']?>">&times</button>
									        <input name="table" value="theme<?=$i?>" hidden></input>
									    </form>
			        				<?php endif; ?>
        						</div>
    					<?php endforeach; ?>
    					<?php if(isset($_SESSION['logged_user'])) : ?>
        				    <form method="post" action="forum/sendMes.php" id="form<?=$i?>">
        				        <input name="table" value="theme<?=$i?>" style="display:none;"></input>
        				        <input required name="message" placeholder="Введите ваше сообщение" class="input_mes" maxlength="200" oninput="mesChanged(this)"></input>
        				        <p class="dig">0</p><p class="dig">/200</p>
        				        <button type="submit" class="sub_but">Отправить</button>
        				    </form>
        				<?php endif; ?>
    				</div>
				<?php endfor;?>
				<?php
    				if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']=='admin') : ?>
				    <div class="add_cont">
				        <form method="post" action="forum/addNew.php">
				            <b style="margin-right:10px">Добавить тему:</b>
				            <input required name="desc" maxlength="30" placeholder="Название" id="name_inp"></input>
				            <button type="submit" style="margin-left:10px">Добавить!</button>
				        </form>
				    </div>
				<?php endif; ?>
			<div class="footer"></div>
		</div>
	</body>
</html>