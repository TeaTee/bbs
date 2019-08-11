<?php
session_start();

// logout.php?logoutにアクセスしたユーザーをログアウトする
if(isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['user']);
  header("Location: index.php");
  exit();
}

?>
<!DOCTYPE HTML>
<html lang="ja">
	<head>
		<meta charset="utf-8" />
		<title>ログアウト</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="col-xs-6 col-xs-offset-3">
			<form class="" action="index.html" method="post">
				<h1>本当にログアウトしますか？</h1>
				<a class="btn" href="logOut.php?logout">ログアウトする</a>
				<a class="btn" href="index.php">キャンセルする</a>
			</form>
		</div>
	</body>
</html>
