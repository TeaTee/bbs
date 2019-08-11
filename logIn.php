<?php
ob_start();	//記録開始
session_start();	//セッション開始
if( isset($_SESSION['user']) != "") {
	header("Location: index.php");
	exit();
}
include_once 'dbconnect.php';

if(isset($_POST['login'])):
	// POSTされた情報をDBに格納する
	try{
		$query = "SELECT * FROM users WHERE email = :email";
		$stmt = $dbh->prepare($query);

	  $eMail = $_POST['eMail'];
	  $Password = $_POST['Password'];
		$stmt->bindValue(':email', $eMail);
		$result = $stmt->execute();
		if(!$result){
	    echo "<div class='alert' role='alert'>エラーが発生しました。</div>";
		}

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$db_hashed_pwd = $row['password'];
			$user_id = $row['id'];
		}
		if(password_verify($Password, $db_hashed_pwd)):
	    $_SESSION['user'] = $user_id;
	    header("Location: index.php");
	    exit();
		else{
	    echo "<div class='alert' role='alert'>メールアドレスまたはパスワードが間違っています。</div>";
	  }
	}catch(PDOException $e) {
		echo "ログインエラー：".$e->getMessage();
	}

}

endif;
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>ログインページ</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div id="header-wrapper"></div>
		<div class="main-wrapper">
			<div class="container">
				<form method="post" id ="login_form">
					<h1>ログインフォーム</h1>
					<div class="form-group">
						<label for="e-mail">メールアドレス</label>
						<input type="text" name="eMail" id="e-mail">
						<p class="error message1" id="message1"></p>
					</div>
					<div class="form-group">
						<label for="password">パスワード</label>
						<input type="password" name="Password" id="password">
						<p class="error message2" id="message2"></p>
					</div>
					<button class="login" type="submit" name="login">ログイン</button>
					<a href="signUp.php">新規登録はこちら</a>
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="js/submit.js"></script>
	</body>
</html>
