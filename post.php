<?php
session_start();
include_once 'dbconnect.php';
date_default_timezone_set('Asia/Tokyo');
define('DIR', dirname(__FILE__).'/img/');
//CSRF対策
function setToken()	{
	$token = sha1(uniqid(mt_rand(), true));
	$_SESSION['token'] = $token;
}
function checkToken(){
	if(empty($_SESSION['token']) || ($_SESSION['token'] !== $_POST['token'])) {
		echo "不正なPOSTが行われました！";
		exit;
	}
}
$user_id = 0;
if(isset($_SESSION['user'])){
	$user_id = $_SESSION['user'];
}


if(($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['message']))){
	checkToken();
	$message = trim($_POST['message']);
	$posted_at = $_POST['posted_at'];
	$imgName = "";
	// echo $_FILES['imageFile']['name'];
	//画像ファイルがあった場合
	if(!empty($_FILES['imageFile']['name'])){

		$imageFile = $_FILES['imageFile']['name'];
		//アップされた画像の拡張子を抜き出す
		$ext=substr($imageFile,-3);
		//拡張子を調べて画像のアップ
		if($ext!=="jpg" && $ext!=="gif" && $ext!=="png"){
			$er["image"]="拡張子がjpgとgifとpngのみアップできます";
		}else if(preg_match("/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[一-龠]+|[ａ-ｚＡ-Ｚ０-９]/u", $imageFile)){
			$er["name"]="半角英数字のファイルのみアップロードできます。";
		}
		if(empty ($er)){
			$imgName = $posted_at.$imageFile;
			//ファイルの保存先
			$dir = DIR.$imgName;
			//アップロードが正しく完了したかチェック
			if(move_uploaded_file($_FILES['imageFile']['tmp_name'], $dir)){
				echo '画像のアップロード完了';
			}else{
				echo 'アップロード失敗';
			}
		}else {
			foreach ($er as $e) {
				echo $e;
			}
		}
	}
	$comment_id = 0;
	if(isset($_GET['num'])){
		$comment_id = $_GET['num'];
	}
	try {
		$query = "INSERT INTO posts(user_id, message, imgName, posted_at, comment_id) VALUES(:user_id, :message, :imgName, :posted_at, :comment_id)";
		$stmt = $dbh->prepare($query);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->bindValue(':message', $message, PDO::PARAM_STR);
		$stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
		$stmt->bindValue(':posted_at', $posted_at, PDO::PARAM_STR);
		$stmt->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
		$stmt->execute();
		// header("Location: index.php");
	}catch(PDOException $e) {
		echo '投稿エラー：'.$e->getMessage();
	}

}else {
	setToken();
	// echo 'トークンをセットしました';
}

require_once 'view/post_view.php';
?>
