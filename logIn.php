<?php
ob_start();	//記録開始
session_start();	//セッション開始
if( isset($_SESSION['user']) != "") {
	header("Location: index.php");
	exit();
}
include_once 'dbconnect.php';

if(isset($_POST['login'])){
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
		if(password_verify($Password, $db_hashed_pwd)){
	    $_SESSION['user'] = $user_id;
	    header("Location: index.php");
	    exit();
		}else{
	    echo "<div class='alert' role='alert'>メールアドレスまたはパスワードが間違っています。</div>";
	  }
	}catch(PDOException $e) {
		echo "ログインエラー：".$e->getMessage();
	}

}

require_once 'view/logIn_view.php';
?>
