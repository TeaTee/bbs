<?php
//データベースから投稿情報を取得する関数
//投稿番号と，$postと$idsのアドレスを受け取る
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

//投稿削除+画像削除　関数
function deletePosts($post_id){
    global $dbh, $count;
    try {
        $query = "SELECT imgName FROM posts WHERE id = :post_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(':post_id', $_GET['post_id']);
        $result = $stmt->execute();

        foreach ($stmt as $row) {
            if($row['imgName']!=="") unlink(dirname(__FILE__).'/img/'.$row['imgName']);
        }

        $query = "DELETE FROM posts WHERE id = :post_id AND user_id = :user_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(':post_id', $_GET['post_id']);
        $stmt->bindValue(':user_id', $_SESSION['user']);
        $stmt->execute();

    }catch(PDOException $e) {
        echo '投稿削除エラー：' . $e->getMessage();
    }
}


?>
