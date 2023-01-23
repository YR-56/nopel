<?php

session_start();
require_once("/login_function/dbconnect.php");


$id = $_POST["id"];
$title = $_POST["title"];
$honbun = $_POST["honbun"];
$summary = $_POST["summary"];

//データベース接続
$dbh = db_connect();

try {

//SQL文の準備
$statement = $dbh->prepare("UPDATE nopel_posts SET title = :title, honbun = :honbun, summary = :summary WHERE id = :id");

$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->bindParam(':title', $title, PDO::PARAM_STR);
$statement->bindParam(':honbun', $honbun, PDO::PARAM_STR);
$statement->bindParam(':summary', $summary, PDO::PARAM_STR);



$statement->execute();

$novel = $statement->fetchall();

} catch (PDOException $e){
    exit('データベース接続失敗.' . $e->getMessage());
}

?>

<!doctype html>
<html>

<head>
<title>編集完了</title>
<meta http-equiv="content-Type" content="text/html; charset=UTF-8">


</head>
<body>

<h1>編集完了</h1>
<a href="mypage.php">ホームページへ戻る</a>
<body>
</html>


</body>


</html>