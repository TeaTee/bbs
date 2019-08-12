<?php

//indexページの投稿表示用関数
function printPost($arr1, $arr2){
	for($i = 0; $i < count($arr1); $i++) {
		echo "<div class='pos pos".$arr2[$i]['post_id']."'>";
		foreach($arr1[$i] as $key => $value){
			// 写真がなければ、 次のループへ／あれば、表示
			if ($key === "投稿写真" && ($value === NULL || $value ==="")){

			}
			else if($key === "投稿写真"){
				echo "<img src='img/{$value}' alt='' width='100%'>";

			}else if($key === "投稿内容") {
				echo "<p><span class='heading pos_heading'>{$key}：</span>{$value}</p>";
			}else{
				echo "<p><span class='heading pos_heading'>{$key}：</span>{$value}</p>";
			}
		}
		echo "<a href='post.php?num={$arr2[$i]['post_id']}' class='create'><span class='far fa-comment-dots'></span>コメントする</a>";
		if(isset($_SESSION['user']) && $arr2[$i]['user_id'] === $_SESSION['user']){
				echo "<a href='index.php?post_id={$arr2[$i]['post_id']}' class='delete'><span class='fas fa-trash-alt'></span></a>";
		}
		echo "<div class='clear'></div>";
		echo "<div class='comment-wrapper' id='comment-{$arr2[$i]['post_id']}'></div>";
		echo "<button type='button' class='btn comment-display'>コメントを見る</button>";
		echo "<button type='button' class='btn comment-hidden'>コメントを閉じる</button>";
		echo "</div>";
	}
}

// コメント表示用関数
//$resに文字列としてhtmlタグを保存して、'comment_display.php'でjson形式に変換して返す
function printP(&$posts, &$ids, &$res){
	for($i = 0; $i < count($posts); $i++) {
		$res .= "<div class='cos cos".$ids[$i]['post_id']."'>";
		foreach($posts[$i] as $key => $value){
			// 写真がなければ、 次のループへ／あれば、表示
			if ($key === "投稿写真" && ($value === NULL || $value ==="")){

			}
			else if($key === "投稿写真"){
				$res .= "<img src='img/{$value}' alt='' width='100%'>";

			}else if($key === "投稿内容") {
				$res .= "<p><span class='heading pos_heading'>{$key}：</span>{$value}</p>";
			}else{
				$res .= "<p><span class='heading pos_heading'>{$key}：</span>{$value}</p>";
			}
		}
		$res .= "<a href='post.php?num={$ids[$i]['post_id']}' class='create'><span class='far fa-comment-dots'></span>コメントをかく</a>";
		// $res .=　$_SESSION['user'];
		if(isset($_SESSION['user']) && $ids[$i]['user_id'] === $_SESSION['user']){
				$res .= "<a href='index.php?post_id={$ids[$i]['post_id']}' class='delete'><span class='fas fa-trash-alt'></span>削除</a>";
			}
		$res .= "<div class='clear'></div>";
		$res .= "<div class='comment-wrapper' id='comment-{$ids[$i]['post_id']}'>";
    $coms = array();
    $idss = array();
    setArray($coms, $idss, $ids[$i]['post_id']);
    if(count($coms)>0) $res .= printP($coms, $idss, $res);
    $res .= "</div>";
		$res .= "</div>";
	}
}

?>
