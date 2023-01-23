<?php
require_once("/home/manzaisaga/www/nopel/login_function/dbconnect.php");

$db = db_connect();

session_start();

//データの受け取り

$id = $_GET['id'];

//もし$idがからであった場合、mypage.phpにリダイレクトさせる
if(empty($id)) {
    header("Location: /mypage/mypage.php");
    exit;
}

$db = db_connect();

try {

    $statement = $db->prepare("DELETE FROM nopel_posts WHERE id = ?");
    $statement->bindParam(1, $id, PDO::PARAM_INT);
    $statement->execute();


} catch (PDOException $e) {
    exit('エラー:' . $e->getMessage());
}

header('Location: /mypage/mypage.php')

?>