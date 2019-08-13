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

require_once 'view/signUp_view.php';
?>
