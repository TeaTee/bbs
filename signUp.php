<?php
	session_start();
	if(isset($_SESSION['user']) && $_SESSION['user'] !== "") {
	  header("Location: index.php");
		exit();
	}
	// DBとの接続
	include_once 'dbconnect.php';
	$m = "";

	if(isset($_POST['signUp'])) {
		$eMail = filter_input(INPUT_POST, 'eMail');
		$userName = filter_input(INPUT_POST, 'userName');
		$Password = filter_input(INPUT_POST, 'Password');
		$Password = password_hash($Password, PASSWORD_DEFAULT);
		try {
			$query = "SELECT count(*) FROM users WHERE email = '{$eMail}'";
			$stmt = $dbh->query($query);
			if($stmt->fetchColumn() > 0 ){
				$m = "このメールアドレスはすでに登録されています。";
			}else {
				// POSTされた情報をDBに格納する
				$query = "INSERT INTO users(username, email, Password) VALUES(:userName, :email, :password)";
				$stmt = $dbh->prepare($query);

				$stmt->bindValue(':userName', $userName);
				$stmt->bindValue(':email', $eMail);
				$stmt->bindValue(':password', $Password);
				if($stmt->execute()) {
					$m = "登録完了しました";
				}else {
					$m = "エラーが発生しました。";
				}
			}
		}catch(PDOException $e) {
			echo '登録エラー：'.$e->getMessage();
		}
	}
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>新規登録ページ</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="top-wrapper">
			<div class="container">
				<a href="index.php">掲示板</a>
				<a href="logIn.php">ログイン</a>
				<div class="clear"></div>
			</div>
		</div>
		<div class="main-wrapper">
			<div class="container">
				<form method="post" id="signup_form">
					<div class="error">
						<?php echo $m; ?>
					</div>
					<h1>新規登録フォーム</h1>
					<div class="form-group">
						<label for="user">ユーザー名</label>
						<input type="text" name="userName" id="user">
						<p class="error message1" id="message0"></p>
					</div>
					<div class="form-group">
						<label for="e-mail">メールアドレス</label>
						<input type="text" name="eMail" id="e-mail">
						<p class="error message1" id="message1"></p>
					</div>
					<div class="form-group">
						<label for="password">パスワード</label>
						<input type="password" name="Password" id="password">
						<p class="error message1" id="message2"></p>
					</div>
					<button type="submit" name="signUp">登録</button>
					<a href="logIn.php">ログインはこちら</a>
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="js/submit.js"></script>
	</body>
</html>
