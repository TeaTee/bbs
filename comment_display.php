<?php
require_once 'dbconnect.php';

$post_id = filter_input(INPUT_GET, 'post_id');
header('Content-type:application/json; character=utf-8');
session_start();

//データベースから取得した値を配列に代入する
function setArray(&$posts, &$ids, $post_id){
	global $dbh;
  $query = "SELECT posts.id AS 'post_id', posts.user_id AS 'user_id', message, username, imgName, posted_at FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE comment_id = :post_id ORDER BY posted_at DESC";
  $stmt = $dbh->prepare($query);
  $stmt->bindValue(':post_id', preg_replace("/[^0-9]/", "", $post_id));
  $stmt->execute();

  foreach ($stmt as $row){
    if($row["username"] === NULL) $row["username"] = "名無しさん";
    $arr1 = array(
      "投稿者名" => $row["username"],
      "投稿内容" => $row["message"],
      "投稿写真" => $row["imgName"],
      "投稿時間" => $row["posted_at"]
    );
    $posts[] = $arr1;

    $arr2 = array(
      "user_id" => $row["user_id"],
      "post_id"=> $row["post_id"]
    );
    $ids[] = $arr2;
  }
}

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
$result = "";
$comments = array();
$ids = array();
setArray($comments, $ids, $post_id);
$result .= printP($comments, $ids, $result);

echo json_encode($result);
// echo json_encode("{}");
?>
