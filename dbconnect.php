<?php
	require_once('./core/config.php');
	try {
		$dbh = new PDO(dsn, db_user, db_pass);
	} catch (PDOException $e) { //例外処理の記述がない場合データベースの接続情報が丸見えになる
		exit('データベースに接続できません。'.$e->getMessage());
	}
?>
