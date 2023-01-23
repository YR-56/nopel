<?php

//データベース接続
require_once("?????/www/nopel/login_function/dbconnect.php");

$dbh = db_connect();


$body = $_POST['body'];

$post_id = $_POST['post_id'];

var_dump($post_id);

//必須項目
if($body == ''){
    header("Location: question.php");
    exit();
}







try {
   

    $stmt = $dbh->prepare("INSERT INTO comments (body, date, post_id)
    VALUES (:body, now(), :post_id)");

    //プリペアードステートメントにパラメータを割り当てる
    
    $stmt->bindParam(':body', $body, PDO::PARAM_STR);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
   
    

    //クエリの実行

    $stmt->execute();

    //board.phpにもどる
    header('Location:comment.php?id='. $post_id);
    exit();
} catch (PDOException $e) {
    exit('エラー:' . $e->getMessage());

   
}




?>